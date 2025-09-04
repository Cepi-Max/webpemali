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
        Schema::create('ppid', function (Blueprint $table) {
            $table->id();
            $table->longText('profil');
            $table->longText('visi');
            $table->longText('misi');
            $table->string('gambar_depan_ppid')->nullable();
            $table->string('gambar_struktur_organisasi')->nullable();
            // $table->longText('regulasi_ppid')->nullable();
            $table->string('file_regulasi')->nullable(); // Tambahan file PDF jika ada
            $table->longText('maklumat');
            $table->text('alamat')->nullable();
            $table->string('kontak')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppid');
    }
};
