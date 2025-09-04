<?php

namespace App\Http\Controllers\PublicUser;

use App\Models\Official;
use Illuminate\Http\Request;
use App\Models\VillageProfile;
use App\Http\Controllers\Controller;

class ProfileControllerPublic extends Controller
{
    function index()
    {
        $villageProfile = VillageProfile::get();
        $officials = Official::get();
 
        $data = [
            'title' => 'Beranda Website Resmi Desa Pemali',
            'villageProfile' => $villageProfile,
            'officials' => $officials
        ];

        return view('public-user.profile.index', $data);
    }
}
