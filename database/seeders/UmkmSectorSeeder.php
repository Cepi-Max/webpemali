<?php

namespace Database\Seeders;

use App\Models\UmkmSector;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UmkmSectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UmkmSector::create([
            'name' => 'Perdagangan',
            'slug' => 'perdagangan'
        ]);
        UmkmSector::create([
            'name' => 'Pertanian',
            'slug' => 'pertanian',
        ]);
        UmkmSector::create([
            'name' => 'Industri Pengolahan',
            'slug' => 'industri-pengolahan',
        ]);
    }
}
