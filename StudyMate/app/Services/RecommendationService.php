<?php

namespace App\Services;

use App\Models\User;

class RecommendationService
{
    /**
     * Bobot penilaian kemiripan (Total = 1.0 / 100%)
     * Urutan prioritas: provinsi, kota, prodi, lalu minat.
     */
    protected float $weightProvinsi = 0.40;
    protected float $weightKota     = 0.30;
    protected float $weightProdi    = 0.20;
    protected float $weightBidang   = 0.10;
    protected int $minimumScore = 10;

    /**
     * Hitung rekomendasi teman belajar untuk seorang user
     *
     * @param User $currentUser
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getRecommendations(User $currentUser, int $limit = 10)
    {
        // Ambil semua user lain yang profilnya sudah terisi
        $candidates = User::where('id_user', '!=', $currentUser->id_user)
            ->whereNotNull('prodi')
            ->whereNotNull('bidang_diminati')
            ->get();

        $scored = $candidates->map(function ($candidate) use ($currentUser) {
            /** @var User $candidate */
            $score = $this->calculateSimilarity($currentUser, $candidate);
            $candidate->similarity_score = round($score * 100); // 0 - 100%
            return $candidate;
        });

        // Jangan tampilkan kandidat yang kecocokannya terlalu rendah.
        return $scored
            ->filter(fn($user) => $user->similarity_score >= $this->minimumScore)
            ->sortByDesc('similarity_score')
            ->values()
            ->take($limit);
    }

    /**
     * Hitung total skor kemiripan antara dua user (0.0 - 1.0)
     */
    public function calculateSimilarity(User $userA, User $userB): float
    {
        $lokasiScores = $this->calculateLokasiSimilarity($userA->lokasi, $userB->lokasi);
        $scoreProvinsi = $lokasiScores['provinsi'];
        $scoreKota = $lokasiScores['kota'];

        $scoreProdi = $this->calculateProdiSimilarity($userA->prodi, $userB->prodi);

        $scoreBidang = $this->calculateJaccardSimilarity(
            $userA->bidang_diminati ?? [],
            $userB->bidang_diminati ?? []
        );

        $total = ($scoreProvinsi * $this->weightProvinsi)
               + ($scoreKota     * $this->weightKota)
               + ($scoreProdi    * $this->weightProdi)
               + ($scoreBidang   * $this->weightBidang);

        return min(1.0, max(0.0, round($total, 4)));
    }

    /**
     * Jaccard Similarity untuk Bidang Diminati (array)
     * Rumus: |A ∩ B| / |A ∪ B|
     */
    protected function calculateJaccardSimilarity($listA, $listB): float
    {
        $arrA = $this->normalizeArray($listA);
        $arrB = $this->normalizeArray($listB);

        if (empty($arrA) || empty($arrB)) {
            return 0.0;
        }

        $intersection = array_intersect($arrA, $arrB);
        $union = array_unique(array_merge($arrA, $arrB));

        if (count($union) === 0) {
            return 0.0;
        }

        return count($intersection) / count($union);
    }

    /**
     * Kemiripan Prodi (Exact Match)
     */
    protected function calculateProdiSimilarity(?string $prodiA, ?string $prodiB): float
    {
        if (!$prodiA || !$prodiB) return 0.0;
        return strcasecmp(trim($prodiA), trim($prodiB)) === 0 ? 1.0 : 0.0;
    }

    /**
     * Kemiripan Lokasi (Provinsi + Kota dipisah sesuai prioritas)
     */
    protected function calculateLokasiSimilarity($lokasiA, $lokasiB): array
    {
        if (is_string($lokasiA)) $lokasiA = json_decode($lokasiA, true);
        if (is_string($lokasiB)) $lokasiB = json_decode($lokasiB, true);

        if (!is_array($lokasiA) || !is_array($lokasiB)) {
            return ['provinsi' => 0.0, 'kota' => 0.0];
        }

        $provA = strtolower(trim($lokasiA['provinsi'] ?? ''));
        $provB = strtolower(trim($lokasiB['provinsi'] ?? ''));
        $kotaA = strtolower(trim($lokasiA['kota'] ?? ''));
        $kotaB = strtolower(trim($lokasiB['kota'] ?? ''));

        $scoreProv = ($provA && $provB && $provA === $provB) ? 1.0 : 0.0;
        $scoreKota = ($kotaA && $kotaB && $kotaA === $kotaB) ? 1.0 : 0.0;

        return [
            'provinsi' => $scoreProv,
            'kota'     => $scoreKota,
        ];
    }

    /**
     * Kemiripan Gender (Preferensi sesama gender)
     */
    protected function calculateGenderSimilarity(?string $genderA, ?string $genderB): float
    {
        if (!$genderA || !$genderB) return 0.0;
        return strcasecmp(trim($genderA), trim($genderB)) === 0 ? 1.0 : 0.0;
    }

    /**
     * Normalisasi minat/array ke flat list string lowercase
     */
    protected function normalizeArray($data): array
    {
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            $data = is_array($decoded) ? $decoded : [$data];
        }

        if (!is_array($data)) return [];

        $flattened = [];

        $splitItems = function ($val): array {
            if (!is_string($val) || trim($val) === '') return [];
            $parts = preg_split('/\s*&\s*|\s*,\s*/', $val);
            $clean = [];
            foreach ($parts as $p) {
                $p = strtolower(trim($p));
                if ($p !== '') $clean[] = $p;
            }
            return $clean;
        };

        // Handle format {"predefined": [...], "custom": "..."}
        if (isset($data['predefined']) || array_key_exists('custom', $data)) {
            if (isset($data['predefined']) && is_array($data['predefined'])) {
                foreach ($data['predefined'] as $item) {
                    foreach ($splitItems($item) as $parsed) {
                        $flattened[] = $parsed;
                    }
                }
            }
            if (!empty($data['custom']) && is_string($data['custom'])) {
                foreach ($splitItems($data['custom']) as $parsed) {
                    $flattened[] = $parsed;
                }
            }
            return array_values(array_unique($flattened));
        }

        // Handle flat array
        foreach ($data as $item) {
            if (is_string($item) && trim($item) !== '') {
                foreach ($splitItems($item) as $parsed) {
                    $flattened[] = $parsed;
                }
            } elseif (is_array($item)) {
                $flattened = array_merge($flattened, $this->normalizeArray($item));
            }
        }

        return array_values(array_unique($flattened));
    }
}
