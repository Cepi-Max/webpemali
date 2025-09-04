<?php

namespace Database\Seeders;

use App\Models\DashboardImage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DashboardBannerSeeder extends Seeder
{
    public function run(): void
    {
        DashboardImage::insert([
            [
                'bannerImg' => 'default.png',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            // Bisa duplikat array ini jika ingin insert banyak data default
        ]);
    }
}
