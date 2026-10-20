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
        Schema::create('kuis', function (Blueprint $table) {
            $table->id('id_kuis');
            $table->foreignId('id_user')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_jadwal')->unique()->constrained('jadwals', 'id_jadwal')->cascadeOnDelete();
            $table->string('judul_kuis', 255);
            $table->json('data_soal');
            $table->json('jawaban_pengguna')->nullable();
            $table->integer('skor')->nullable();
            $table->string('status_pengerjaan', 30)->default('belum');
            $table->dateTime('tanggal_selesai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kuis');
    }
};