<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ArticleCategory;
use Illuminate\Database\Seeder;

class ArticleCategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ArticleCategory::create([
            'name' => 'Internasional',
            'slug' => 'internasional',
            'color' => 'red'
        ]);
        ArticleCategory::create([
            'name' => 'Nasional Bersama',
            'slug' => 'nasional-bersama',
            'color' => 'yellow'
        ]);

        
    }
}
