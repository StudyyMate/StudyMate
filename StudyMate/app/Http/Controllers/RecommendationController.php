<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\RecommendationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommendationController extends Controller
{
    protected RecommendationService $recommendationService;

    public function __construct(RecommendationService $recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    /**
     * Tampilkan halaman Dashboard dengan Rekomendasi Teman Belajar (Usecase 5)
     */
    public function dashboard()
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        // Ambil rekomendasi berdasarkan Content-Based Filtering
        $recommendations = $this->recommendationService->getRecommendations($currentUser, 6);

        // Ambil ranking streak tertinggi (Top 5)
        $topStreaks = User::whereNotNull('streak')
            ->orderByDesc('streak')
            ->take(5)
            ->get();

        return view('dashboard', compact('currentUser', 'recommendations', 'topStreaks'));
    }

    /**
     * Tampilkan halaman Cari Teman Belajar + Rekomendasi Teman Belajar (FR-04)
     */
    public function index()
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        // Ambil semua rekomendasi relevan agar tombol Load More bisa menampilkan
        // kandidat berikutnya dengan persentase kecocokan lebih rendah.
        $recommendations = $this->recommendationService->getRecommendations(
            $currentUser,
            User::count()
        )->take(10);

        $filterOptions = $this->getFilterOptions();

        return view('cari', compact('recommendations', 'filterOptions'));
    }

    /**
     * Opsi filter diambil dari profil user yang tersimpan agar selalu cocok
     * dengan data produksi/seeder.
     */
    private function getFilterOptions(): array
    {
        // Wilayah berasal dari API yang sama dengan form registrasi.
        // Prodi dan minat tetap diambil dari profil yang sudah tersimpan.
        $users = User::query()
            ->select(['prodi', 'bidang_diminati'])
            ->get();

        $prodis = $users->pluck('prodi')
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $interests = $users->flatMap(fn (User $user) => $user->minat_list)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return compact('prodis', 'interests');
    }

    /**
     * Proses Pencarian Teman Belajar berdasarkan kriteria (FR-04 / Usecase 4)
     */
    public function search(Request $request)
    {
        /** @var User $currentUser */
        $currentUser = Auth::user();

        $provinsi = $request->query('provinsi');
        $kota   = $request->query('kota');
        $gender = $request->query('gender');
        $prodi  = $request->query('prodi');
        $bidang = $request->query('bidang');

        // Query candidates exclude user login
        $query = User::where('id_user', '!=', $currentUser->id_user);

        if (!empty($gender)) {
            $query->where('gender', $gender);
        }

        if (!empty($prodi)) {
            $query->where('prodi', $prodi);
        }

        if (!empty($provinsi)) {
            $query->where('lokasi->provinsi', $provinsi);
        }

        if (!empty($kota)) {
            $query->where('lokasi->kota', $kota);
        }

        if (!empty($bidang)) {
            $query->where(function ($q) use ($bidang) {
                $q->whereJsonContains('bidang_diminati->predefined', $bidang)
                  ->orWhere('bidang_diminati->custom', $bidang)
                  ->orWhere('bidang_diminati', 'LIKE', '%' . $bidang . '%');
            });
        }

        $results = $query->get()->map(function ($candidate) use ($currentUser) {
            $score = $this->recommendationService->calculateSimilarity($currentUser, $candidate);
            $candidate->similarity_score = round($score * 100);
            return $candidate;
        })->sortByDesc('similarity_score')->values();

        $filters = array_filter([
            'provinsi' => $provinsi,
            'kota'   => $kota,
            'gender' => $gender,
            'prodi'  => $prodi,
            'bidang' => $bidang,
        ]);

        return view('hasil', compact('results', 'filters'));
    }
}
