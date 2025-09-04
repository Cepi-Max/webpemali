<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialMediaProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('social_media_profiles')->insert([
            [
                'facebook' => 'https://facebook.com/johndoe',
                'x'        => 'https://x.com/johndoe',
                'instagram'=> 'https://instagram.com/johndoe',
                'whatsapp' => '6281234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'facebook' => 'https://facebook.com/janedoe',
                'x'        => 'https://x.com/janedoe',
                'instagram'=> 'https://instagram.com/janedoe',
                'whatsapp' => '6289876543210',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
