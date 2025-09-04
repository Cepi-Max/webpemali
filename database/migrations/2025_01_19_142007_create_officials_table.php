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
        Schema::create('officials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('author_id')->constrained(
                table: 'users',
                indexName: 'official_author_id' 
            )->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('address');
            $table->string('gender');
            $table->string('place_of_birth');
            $table->string('date_of_birth');
            $table->string('position');
            $table->string('phone_number');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('officials');
    }
};
