<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'lokasi',
        'gender',
        'prodi',
        'bidang_diminati',
        'foto_profil',
        'streak',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'lokasi' => 'array',
            'bidang_diminati' => 'array',
        ];
    }

    // ========== HELPER ATTRIBUTES ==========

    /**
     * Mengembalikan list flat array string minat (predefined + custom)
     */
    public function getMinatListAttribute(): array
    {
        $raw = $this->bidang_diminati;
        if (is_string($raw)) {
            $raw = json_decode($raw, true);
        }

        if (!is_array($raw)) return [];

        $extractCleanItems = function ($item): array {
            if (!is_string($item) || trim($item) === '') {
                return [];
            }
            // Pecah jika masih ada format gabungan seperti "Database & SQL"
            $parts = preg_split('/\s*&\s*|\s*,\s*/', $item);
            $clean = [];
            foreach ($parts as $p) {
                $p = trim($p);
                if ($p !== '') {
                    $clean[] = $p;
                }
            }
            return $clean;
        };

        $list = [];
        if (isset($raw['predefined']) && is_array($raw['predefined'])) {
            foreach ($raw['predefined'] as $item) {
                foreach ($extractCleanItems($item) as $parsed) {
                    $list[] = $parsed;
                }
            }
        }

        if (!empty($raw['custom']) && is_string($raw['custom'])) {
            foreach ($extractCleanItems($raw['custom']) as $parsed) {
                $list[] = $parsed;
            }
        }

        // Jika bukan format predefined/custom tapi flat array
        if (empty($list) && !isset($raw['predefined']) && !array_key_exists('custom', $raw)) {
            foreach ($raw as $item) {
                foreach ($extractCleanItems($item) as $parsed) {
                    $list[] = $parsed;
                }
            }
        }

        return array_values(array_unique($list));
    }

    // ========== RELASI CHAT ==========

    public function sentChats()
    {
        return $this->hasMany(Chat::class, 'id_pengirim', 'id_user');
    }

    public function receivedChats()
    {
        return $this->hasMany(Chat::class, 'id_penerima', 'id_user');
    }
}
