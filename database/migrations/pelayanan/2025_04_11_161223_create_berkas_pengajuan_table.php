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
        Schema::create('berkas_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->foreignId('syarat_dokumen_id')->constrained('syarat_dokumen')->onDelete('cascade');
            $table->enum('status_validasi', ['valid', 'invalid'])->nullable();
            $table->text('catatan')->nullable(); // kalau tidak valid, bisa kasih alasan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas_pengajuan');
    }
};
