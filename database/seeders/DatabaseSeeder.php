<?php

namespace Database\Seeders;

use App\Models\Announcement;
use App\Models\Article;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\ArticleCategory;
use App\Models\ConstructionFundSourceCategories;
use App\Models\Gallery;
use App\Models\Official;
use App\Models\Pelayanan\JenisSurat;
use App\Models\Pelayanan\SyaratDokumen;
use App\Models\Umkm;
use App\Models\UmkmSector;
use App\Models\User;
use App\Models\VillageProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'number_phone' => '084766345332',
        ]);
        
        User::create([
            'name' => 'Administrator',
            'nik' => '087654345678',
            'email' => 'admin@desa.test',
            'number_phone' => '084766345332',
            'password' => bcrypt('password'),
            'role' => 'admin'
        ]);


        $this->call(ArticleCategorySeeder::class);
        $this->call(UmkmSectorSeeder::class);
        $this->call(UmkmCertificationSeeder::class);
        $this->call(ArticleCategorySeeder::class);
        $this->call(ConstructionFundSourceCategorySeeder::class);
        $this->call(ConstructionFundSourceCategorySeeder::class);
        $this->call(KependudukanSeeder::class);
        $this->call(DashboardBannerSeeder::class);
        $this->call(VillageProfileSeeder::class);
        $this->call(AnnouncementSeeder::class);
        $this->call(OfficialSeeder::class);
        $this->call(PpidSeeder::class);
        $this->call([ConstructionSeeder::class]);
        $this->call([SocialMediaProfilesTableSeeder::class]);

        \App\Models\ConstructionFundSourceCategories::factory(5)->create();
        Umkm::factory(10)->recycle([
            UmkmSector::all(),
            User::all()
        ])->create();
        
        Article::factory(20)->recycle([
            ArticleCategory::all(),
            User::all()
            ])->create();

        Announcement::factory(20)->recycle([
            User::all()
            ])->create();

        Gallery::factory(50)->recycle([
            User::all()
            ])->create();

        // // Data syarat dokumen umum
        // $syarat = [
        //     'Fotocopy KK',
        //     'Fotocopy KTP',
        //     'Fotocopy Akta Kelahiran',
        //     'Materai 10000',
        //     'Dokumen Pendukung'
        // ];

        // $syaratIds = [];
        // foreach ($syarat as $nama) {
        //     $dok = SyaratDokumen::create(['nama' => $nama]);
        //     $syaratIds[$nama] = $dok->id;
        // }

        // // Surat Ahli Waris
        // $ahliWaris = JenisSurat::create([
        //     'slug' => 'Surat-Pernyataan-Ahli-Waris',
        //     'nama' => 'Surat Pernyataan Ahli Waris',
        //     'deskripsi' => 'Surat pernyataan tentang siapa saja ahli waris sah.'
        // ]);

        // DB::table('jenis_surat_syarat')->insert([
        //     ['jenis_surat_id' => $ahliWaris->id, 'syarat_dokumen_id' => $syaratIds['Fotocopy KK'], 'wajib' => true],
        //     ['jenis_surat_id' => $ahliWaris->id, 'syarat_dokumen_id' => $syaratIds['Fotocopy KTP'], 'wajib' => true],
        //     ['jenis_surat_id' => $ahliWaris->id, 'syarat_dokumen_id' => $syaratIds['Fotocopy Akta Kelahiran'], 'wajib' => true],
        //     ['jenis_surat_id' => $ahliWaris->id, 'syarat_dokumen_id' => $syaratIds['Materai 10000'], 'wajib' => true],
        // ]);

        // // Surat Tidak Mampu
        // $tidakMampu = JenisSurat::create([
        //     'slug' => 'Surat-Keterangan-Tidak-Mampu',
        //     'nama' => 'Surat Keterangan Tidak Mampu',
        //     'deskripsi' => 'Digunakan untuk keperluan bantuan sosial, pendidikan, dsb.'
        // ]);

        // DB::table('jenis_surat_syarat')->insert([
        //     ['jenis_surat_id' => $tidakMampu->id, 'syarat_dokumen_id' => $syaratIds['Fotocopy KK'], 'wajib' => true],
        //     ['jenis_surat_id' => $tidakMampu->id, 'syarat_dokumen_id' => $syaratIds['Fotocopy KTP'], 'wajib' => true],
        //     ['jenis_surat_id' => $tidakMampu->id, 'syarat_dokumen_id' => $syaratIds['Dokumen Pendukung'], 'wajib' => false],
        // ]);
        
    }
}
