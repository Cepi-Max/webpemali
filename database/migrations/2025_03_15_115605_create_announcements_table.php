<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Menjalankan migrasi untuk membuat tabel pengumuman.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId('author_id')->constrained(
                table: 'users',
                indexName: 'announcement_author_id' 
            )->onDelete('cascade');
            $table->string('title'); 
            $table->longText('content'); 
            $table->string('image')->nullable(); 
            $table->timestamp('published_at')->nullable(); 
            $table->enum('status', ['draft', 'published'])->default('draft'); 
            $table->integer('seen')->default(0);;
            $table->timestamps(); 
        });
    }

    /**
     * Membatalkan migrasi (rollback).
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('announcements');
    }
}
