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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id('id_jadwal');
            $table->foreignId('id_pembuat')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->foreignId('id_teman')->constrained('users', 'id_user')->cascadeOnDelete();
            $table->string('nama_jadwal', 20);
            $table->date('tanggal');
            $table->string('hari', 20);
            $table->time('waktu');
            $table->string('status_jadwal', 30)->default('pending');
            $table->string('foto_realtime', 255)->nullable();
            $table->string('status_validasi', 30)->default('belum');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwals');
    }
};