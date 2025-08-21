<?php

namespace Database\Seeders;

use App\Models\UmkmCertification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UmkmCertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UmkmCertification::create([
            'name' => 'IUMK',
            'slug' => 'iumk',
        ]);
        UmkmCertification::create([
            'name' => 'NIB',
            'slug' => 'nib',
        ]);
        UmkmCertification::create([
            'name' => 'NPWP',
            'slug' => 'npwp',
        ]);
        UmkmCertification::create([
            'name' => 'P-IRT',
            'slug' => 'p-irt',
        ]);
    }
}