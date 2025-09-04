<?php

namespace App\Http\Controllers\PublicUser;

use App\Models\Umkm;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UmkmSector;

class UmkmControllerPublic extends Controller
{
    //
    function index()
    {
        $umkm = Umkm::orderBy('id', 'desc')->paginate(6)->withQueryString();
        $markerUmkm = Umkm::all();
 
        $data = [
            'title' => 'UMKM Desa Pemali',
            'umkms' => $umkm,
            'markerUmkm' => $markerUmkm,
        ];

        return view('public-user.umkm.index', $data);
    }

    function details($slug)
    {
        $othersUmkms = Umkm::limit(4)->get();
        $detailumkm = Umkm::where('slug', $slug)->firstOrFail();
        $umkmSector = UmkmSector::get();
        $previewComments = $detailumkm->umkm_comments()->with('user')->latest()->take(3)->get();
        $allComments = $detailumkm->umkm_comments()->with('user')->latest()->get();
        $totalComments = $allComments->count();
 
        $data = [
            'title' => 'Detail Umkm',
            'umkms' => $othersUmkms,
            'detailumkm' => $detailumkm,
            'umkmSector' => $umkmSector,
            'previewComments' => $previewComments,
            'allComments' => $allComments,
            'totalComments' => $totalComments,
        ];

        return view('public-user.umkm.detail', $data);
    }
}
