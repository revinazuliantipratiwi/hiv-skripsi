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
        Schema::create('hivs', function (Blueprint $table) {
            $table->id();
            $table->string('kecamatan', 100);
            $table->unsignedInteger('total_kasus');
            $table->unsignedInteger('tahun');
            $table->timestamps();

            // Jika hanya boleh 1 entri per kecamatan per tahun
            $table->unique(['kecamatan', 'tahun']);
            $table->index('tahun'); // Untuk query/filter cepat
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hivs');
    }
};
