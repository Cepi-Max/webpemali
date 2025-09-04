<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Database\QueryException;
use App\Models\ConstructionFundSourceCategories;

class ConstructionFundSourceController extends Controller
{
    
    public function save(Request $request): RedirectResponse
    {
        // Tangani Slug
        $slug = Str::slug($request->input('name'));
        $existingSlugCount = \App\Models\ConstructionFundSourceCategories::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        $construction_fund_source = new ConstructionFundSourceCategories();

        $construction_fund_source->slug = $slug;
        $construction_fund_source->name = $request->input('name');

        $construction_fund_source->save();

    // Dapatkan referer dari header
    $referer = $request->headers->get('referer');

    // Redirect kembali ke referer dengan pesan sukses
    return redirect($referer)->with('success', 'Sumber dana berhasil ditambahkan.');
    }

    public function delete(Request $request, $slug)
    {
        try {
            // Cari sumber dana berdasarkan slug
            $constructionBySlug = ConstructionFundSourceCategories::where('slug', $slug)->firstOrFail();
    
            // Hapus sumber dana
            $constructionBySlug->delete();
    
            return redirect()->back()->with('success', 'Sumber dana berhasil dihapus.');
        } catch (QueryException $e) {
            // Jika terjadi error karena constraint foreign key
            return redirect()->back()->with('error', 'Gagal menghapus sumber dana karena masih digunakan di tabel lain.');
        } catch (\Exception $e) {
            // Menangani error lain
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
