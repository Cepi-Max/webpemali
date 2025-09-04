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
        Schema::create('umkm', function (Blueprint $table) {
            $table->id();
            $table->char('slug');
            $table->foreignId('author_id')->constrained(
                table: 'users',
                indexName: 'umkm_author_id' 
            )->onDelete('cascade');
            $table->foreignId('sector_id')->constrained(
                table: 'umkm_sector',
                indexName: 'umkm_sector_id' 
            )->onDelete('restrict');
            $table->string('umkm_name');
            $table->longText('description');
            $table->string('owner_name');
            $table->string('gender');
            $table->longText('address');
            $table->string('email');
            $table->integer('product_price');
            $table->string('number_phone');
            $table->decimal('latitude', 10, 6);
            $table->decimal('longitude', 10, 6);
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('umkm');
    }
};
