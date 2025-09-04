<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan ada user dulu untuk author_id
        $author = User::first() ?? User::factory()->create();

        Announcement::create([
            'slug'          => Str::slug('Pengumuman Pembangunan Jalan Baru'),
            'author_id'     => $author->id,
            'title'         => 'Pengumuman Pembangunan Jalan Baru',
            'content'       => 'Pembangunan jalan baru akan dimulai pada bulan depan. Mohon kerjasama masyarakat sekitar.',
            'image'         => 'default.png',
            'published_at'  => now(),
            'seen'          => 0,
            'status'        => 'published',
        ]);

        Announcement::create([
            'slug'          => Str::slug('Pengumuman Kegiatan Kerja Bakti'),
            'author_id'     => $author->id,
            'title'         => 'Pengumuman Kegiatan Kerja Bakti',
            'content'       => 'Seluruh warga diharapkan hadir pada kegiatan kerja bakti yang akan dilaksanakan hari Minggu.',
            'image'         => 'default.png',
            'published_at'  => now(),
            'seen'          => 0,
            'status'        => 'draft',
        ]);
    }
}
