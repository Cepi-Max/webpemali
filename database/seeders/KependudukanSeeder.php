<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kependudukan;

class KependudukanSeeder extends Seeder
{
    public function run(): void
    {
        // Generate 50 data dummy menggunakan factory
        Kependudukan::factory()->count(10)->create();
    }
}
