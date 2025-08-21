<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Article;
use App\Models\DashboardImage;
use App\Models\Official;
use App\Models\Umkm;
use App\Models\VillageProfile;
use Illuminate\Http\Request;

class DashboardControllerPublic extends Controller
{
    function index()
    {
        $bannerImg = DashboardImage::all();
        $latestArticles = Article::latest()->limit(2)->get();
        $latestAnnouncements = Announcement::latest()->limit(2)->get();
        $popularArticle = Article::orderBy('seen', 'desc')->limit(2)->get();
        $latestUmkm = Umkm::latest()->limit(4)->get();
        $villageProfile = VillageProfile::get();
        $officials = Official::get();
        $data = [
            'title' => 'Beranda Website Resmi Desa Pemali',
            'bannerImg' => $bannerImg,
            'latestArticles' => $latestArticles,
            'latestAnnouncements' => $latestAnnouncements,
            'popularArticle' => $popularArticle,
            'latestUmkm' => $latestUmkm,
            'villageProfile' => $villageProfile,
            'officials' => $officials,
        ];

        return view('public-user.dashboard.index', $data);
    }
}
