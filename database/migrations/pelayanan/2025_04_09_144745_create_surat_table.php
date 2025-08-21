<?php

// database/migrations/xxxx_xx_xx_create_surat_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('surat', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat')->onDelete('cascade');
            $table->foreignId('pemohon_id')->constrained('users'); // atau 'penduduk'
            $table->date('tanggal_pengajuan');
            $table->enum('status', ['pending', 'diproses', 'ditolak', 'selesai'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('surat');
    }
};
