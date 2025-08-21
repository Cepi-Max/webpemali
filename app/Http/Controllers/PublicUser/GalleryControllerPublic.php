<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryControllerPublic extends Controller
{
    //
    public function index()
    {
        $galleries = Gallery::orderBy('id', 'desc')->paginate(12)->withQueryString();

        $data = [
            'title' => 'Galeri Desa',
            'galleries' => $galleries,
        ];
        
        return view('public-user.gallery.index', $data);
    }
}
