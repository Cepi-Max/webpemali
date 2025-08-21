<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Construction;
use App\Models\ConstructionDocumentation;
use App\Models\ConstructionFundSourceCategories;
use Illuminate\Http\Request;

class ConstructionControllerPublic extends Controller
{
    function index()
    {
        $constructions = Construction::filter(request(['search']))->latest()->paginate(8)->withQueryString();
 
        $data = [
            'title' => 'Pengumuman Resmi Desa Pemali',
            'constructions' => $constructions,
        ];

        return view('public-user.construction.index', $data);
    }

    function detail($slug)
    {
        $detailConstructions = Construction::where('slug', $slug)->firstOrFail();
        $documentations = ConstructionDocumentation::where('construction_id', $detailConstructions->id)->get();
        $fundSourceCategories = ConstructionFundSourceCategories::pluck('name', 'id')->toArray();

        // $latestConstructions = Construction::latest()->limit(3)->get();
        $popularConstructions = Construction::orderBy('seen', 'desc')->limit(3)->get();

        $detailConstructions->seen = $detailConstructions->seen + 1;
        $detailConstructions->save();
 
        $data = [
            'title' => 'Detail Pengumuman',
            'dC' => $detailConstructions,
            'documentations' => $documentations,
            'fundSourceCategories' => $fundSourceCategories,
            // 'latestConstructions' => $latestConstructions,
            'popularConstructions' => $popularConstructions,
        ];

        return view('public-user.construction.detail', $data);
    }
}
