<?php

// database/migrations/xxxx_xx_xx_create_jenis_surat_syarat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('jenis_surat_syarat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->foreignId('syarat_dokumen_id')->constrained('syarat_dokumen')->onDelete('cascade');
            $table->boolean('wajib')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('jenis_surat_syarat');
    }
};
