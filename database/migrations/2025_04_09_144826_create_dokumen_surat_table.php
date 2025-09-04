<?php

// database/migrations/xxxx_xx_xx_create_dokumen_surat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('dokumen_surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surat')->onDelete('cascade');
            $table->foreignId('syarat_dokumen_id')->constrained('syarat_dokumen')->onDelete('cascade');
            $table->string('file_path')->nullable();
            $table->enum('status_validasi', ['valid', 'invalid'])->nullable();
            $table->text('catatan')->nullable(); 
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('dokumen_surat');
    }
};
