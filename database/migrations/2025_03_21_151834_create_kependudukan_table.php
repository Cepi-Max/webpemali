<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('kependudukan', function (Blueprint $table) {
            $table->id();

            $table->string('rt', 5);
            $table->string('dusun', 100);
            $table->string('alamat', 255);
            $table->string('no_kk', 20)->comment('Nomor Kartu Keluarga');
            $table->string('kepala_keluarga', 100);

            $table->string('nik', 20)->unique()->comment('Nomor Induk Kependudukan');
            $table->string('nama_lengkap', 100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('posisi_dalam_keluarga');

            $table->string('tempat_lahir', 100);
            $table->date('tanggal_lahir');
            $table->unsignedInteger('usia'); 

            $table->enum('status_pernikahan', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati', 'Janda/Duda']);
            $table->string('agama', 50);
            $table->string('golongan_darah', 3)->nullable();
            $table->string('pendidikan', 100);
            $table->string('pekerjaan', 100);

            $table->timestamps();
            $table->softDeletes(); 
            // Kependudukan::all(); Hanya data yang belum terhapus
            // Dan untuk melihat data yang terhapus:
            // Kependudukan::onlyTrashed()->get();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kependudukan');
    }
};
