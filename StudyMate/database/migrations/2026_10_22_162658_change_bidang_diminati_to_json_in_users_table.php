<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Convert existing string values to JSON structure
        DB::table('users')->whereNotNull('bidang_diminati')->update([
            'bidang_diminati' => DB::raw("JSON_OBJECT('predefined', JSON_ARRAY(bidang_diminati), 'custom', NULL)")
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->json('bidang_diminati')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert JSON back to simple string (take first predefined if exists)
        DB::table('users')->whereNotNull('bidang_diminati')->update([
            'bidang_diminati' => DB::raw("JSON_UNQUOTE(JSON_EXTRACT(bidang_diminati, '$.predefined[0]'))")
        ]);

        Schema::table('users', function (Blueprint $table) {
            $table->string('bidang_diminati', 255)->change();
        });
    }
};
