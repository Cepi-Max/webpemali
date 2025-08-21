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
        Schema::create('publikasi_desa_cantik', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId('user_id')
                  ->constrained('users') 
                  ->onDelete('cascade');
            $table->string('cover')->nullable();
            $table->string('judul');
            $table->date('jadwal_rilis');
            $table->string('status_rilis');
            $table->string('file_publikasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publikasi_desa_cantik');
    }
};
