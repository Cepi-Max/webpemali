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
        Schema::create('construction_documentations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construction_id')->constrained('constructions');
            $table->foreignId('author_id')->constrained('users')->onDelete('cascade');
            $table->string('percentage');
            $table->string('information');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('construction_documentations');
    }
};
