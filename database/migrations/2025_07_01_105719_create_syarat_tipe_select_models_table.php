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
        Schema::create('syarat_tipe_select_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('syarat_dokumen_id')->constrained('syarat_dokumen')->onDelete('cascade');
            $table->string('opsi'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('syarat_tipe_select_models');
    }
};
