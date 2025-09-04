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
        Schema::create('constructions', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->foreignId('author_id')->constrained(
                table: 'users',
                indexName: 'construction_author_id' 
            )->onDelete('cascade');
            $table->foreignId('fund_source_id')->constrained(
                table: 'construction_fund_source_categories',
                indexName: 'construction_fund_source_category' 
            );
            // $table->string('inovator');
            $table->integer('government_cost')->nullable(); //pemerintah
            $table->integer('district_cost')->nullable(); //kabupaten
            $table->integer('province_cost')->nullable();
            $table->integer('self_cost')->nullable();
            $table->integer('total_budget');
            $table->string('construction_site'); //lokasi
            $table->string('construction_implementer'); //pelaksana
            $table->string('construction_volume');
            $table->string('construction_time_period'); //estimasi waktu
            $table->string('period_category');
            $table->string('construction_traits'); //Sifat
            $table->string('construction_benefits');
            $table->string('information');
            $table->integer('fiscal_year'); //tahun anggaran
            $table->string('latitude');
            $table->string('longitude');
            $table->string('image');
            $table->integer('seen')->default(0);;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('constructions');
    }
};
