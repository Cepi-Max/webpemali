<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Construction;

class ConstructionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed 10 data constructions
        Construction::factory()->count(20)->create();
    }
}
