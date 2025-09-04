<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ConstructionFundSourceCategories;
use Illuminate\Database\Seeder;

class ConstructionFundSourceCategorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ConstructionFundSourceCategories::create([
            'name' => 'Dana Swasta',
            'slug' => 'dana-swasta',
        ]);
        ConstructionFundSourceCategories::create([
            'name' => 'Dana Mandiri',
            'slug' => 'dana-mandiri',
        ]);

        
    }
}
