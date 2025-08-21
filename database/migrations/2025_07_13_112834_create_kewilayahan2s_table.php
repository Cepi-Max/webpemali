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
        Schema::create('kewilayahan2', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dusun');
            $table->text('koordinat'); // Simpan array koordinat polygon dalam JSON
            $table->string('warna')->nullable(); // Optional: untuk memberi warna custom
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kewilayahan2');
    }
};
