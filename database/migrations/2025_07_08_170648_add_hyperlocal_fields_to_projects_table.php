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
        Schema::table('projects', function (Blueprint $table) {
            // Tambahkan setelah kolom 'skill_level'
            $table->string('job_type')->after('skill_level')->nullable(); // cth: Purnawaktu, Paruh Waktu
            $table->string('location_district')->after('job_type')->nullable(); // cth: Balikpapan Selatan
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['job_type', 'location_district']);
        });
    }
};
