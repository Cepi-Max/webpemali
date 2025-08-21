<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;

class ArticleControllerPublic extends Controller
{
    function index()
    {
        $articles = Article::orderBy('id', 'desc')->paginate(8)->withQueryString();
        $articleCategories = ArticleCategory::get();
 
        $data = [
            'title' => 'Artikel Resmi Desa Pemali',
            'articles' => $articles,
            'articleCategories' => $articleCategories
        ];

        return view('public-user.article.index', $data);
    }

    function detail($slug)
    {
        $detailArticles = Article::where('slug', $slug)->firstOrFail();
        $popularArticle = Article::orderBy('seen', 'desc')->limit(2)->get();
        $latestArticles = Article::latest()->limit(3)->get();
        $articleCategories = ArticleCategory::get();

        $detailArticles->seen = $detailArticles->seen + 1;
        $detailArticles->save();
 
        $data = [
            'title' => 'Detail Artikel',
            'dA' => $detailArticles,
            'latestArticles' => $latestArticles,
            'popularArticle' => $popularArticle,
            'articleCategories' => $articleCategories
        ];

        return view('public-user.article.detail', $data);
    }
}
