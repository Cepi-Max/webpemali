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
        Schema::create('statistik_penduduks', function (Blueprint $table) {
            $table->id();
            $table->string('wilayah');
            $table->integer('jumlah_kepala_keluarga');
            $table->integer('jumlah_penduduk_laki_laki');
            $table->integer('jumlah_penduduk_perempuan');
            $table->integer('jumlah_penduduk');
            $table->string('periode'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistik_penduduks');
    }
};
