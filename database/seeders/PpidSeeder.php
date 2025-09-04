<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PpidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ppid')->insert([
            'profil' => 'Pejabat Pengelola Informasi dan Dokumentasi (PPID) Desa adalah unit yang bertanggung jawab dalam mengelola, menyimpan, menyediakan, dan/atau mendistribusikan informasi publik di tingkat desa. Kehadiran PPID Desa merupakan bentuk nyata komitmen pemerintah desa dalam mewujudkan keterbukaan informasi publik sesuai dengan amanat Undang-Undang Nomor 14 Tahun 2008 tentang Keterbukaan Informasi Publik.

            PPID Desa berperan sebagai penghubung antara pemerintah desa dan masyarakat dalam hal penyampaian informasi. Melalui PPID, masyarakat berhak mendapatkan informasi publik yang transparan, akurat, dan dapat dipertanggungjawabkan.',
            'visi' => '"Mewujudkan tata kelola pemerintahan desa yang terbuka, informatif, dan akuntabel."',
            'misi' => '<ul class="list-disc pl-5 text-gray-700 space-y-1">
            <li>Menyediakan layanan informasi yang mudah diakses.</li>
            <li>Mengelola dokumentasi dan arsip informasi secara baik.</li>
            <li>Mendorong partisipasi masyarakat melalui keterbukaan.</li>
        </ul>',
            // 'regulasi_ppid' => 'Regulasi PPID berpedoman pada UU No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik dan Peraturan Desa Nomor 3 Tahun 2024 tentang PPID.',
            'file_regulasi' => 'uploads/regulasi_ppid.pdf',
            'maklumat' => 'Dengan ini, PPID Desa menyatakan sanggup menyelenggarakan pelayanan informasi publik sesuai dengan ketentuan yang berlaku.',
            'alamat' => 'Jl. Raya Desa Contoh No. 123, Kecamatan Contoh, Kabupaten Contoh, Provinsi Contoh',
            'kontak' => '081234567890',
            'status' => 'aktif',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
