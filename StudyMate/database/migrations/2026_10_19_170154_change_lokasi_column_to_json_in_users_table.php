<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Konversi data lama ke format JSON jika belum
        $users = \Illuminate\Support\Facades\DB::table('users')->get();
        foreach ($users as $u) {
            $current = $u->lokasi;
            if (!empty($current) && !str_starts_with(trim($current), '{')) {
                $parts = explode(', ', $current);
                $kota = $parts[0] ?? '';
                $provinsi = $parts[1] ?? '';
                \Illuminate\Support\Facades\DB::table('users')->where('id_user', $u->id_user)->update([
                    'lokasi' => json_encode(['provinsi' => $provinsi, 'kota' => $kota], JSON_UNESCAPED_UNICODE),
                ]);
            }
        }

        Schema::table('users', function (Blueprint $table) {
            $table->json('lokasi')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('lokasi', 255)->change();
        });
    }
};
