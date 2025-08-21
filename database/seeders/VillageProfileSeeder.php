<?php

namespace Database\Seeders;

use App\Models\VillageProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class VillageProfileSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dulu untuk author_id
        $author = User::first() ?? User::factory()->create();

        VillageProfile::create([
            'author_id'     => $author->id,
            'nama_desa'     => 'Pemali',
            'visi'          => 'Menjadikan desa maju, mandiri, dan sejahtera.',
            'misi'          => '1. Meningkatkan perekonomian masyarakat.<br>2. Memperkuat infrastruktur.<br>3. Meningkatkan kualitas pendidikan.',
            'sejarah'       => 'Desa Pemali berdiri sejak tahun 1950, berawal dari sebuah dusun kecil...',
            'batas_utara'   => 'Desa Sejahtera',
            'batas_selatan' => 'Desa Makmur',
            'batas_timur'   => 'Hutan Lindung',
            'batas_barat'   => 'Sungai Besar',
            'alamat'        => 'Jl. Raya Utama No. 10, Desa Pemali',
            'kode_pos'      => 12345,
            'luas_desa'     => 15.5,
        ]);
    }
}
