<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\UmkmSector;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UmkmSectorController extends Controller
{
    public function save(Request $request): RedirectResponse
    {
        $validated = [
            'name' => ['required', 'max:8']
        ];
        $slug = Str::slug($request->input('name'));
        $existingSlugCount = \App\Models\UmkmSector::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        
        $UmkmSector = new UmkmSector;
 
        $UmkmSector->slug = $slug;
        $UmkmSector->name = $request->input('name');

        $UmkmSector->save();

        $referer = $request->headers->get('referer');

        return redirect()->back()->with('success', 'Kategori sektor usaha berhasil ditambahkan.');

    }

    public function update(Request $request, $slug): RedirectResponse
    {
        $validated = [
            'name' => ['required', 'max:8']
        ];
        $slug1 = Str::slug($request->input('name'));
        $existingSlugCount = \App\Models\UmkmSector::where('slug', 'LIKE', "{$slug1}%")->count();
        
        if ($existingSlugCount > 0) {
            $slug1 .= '-' . ($existingSlugCount + 1);
        }
        
        $UmkmSector = UmkmSector::where('slug', $slug)->firstOrFail();
        $UmkmSector->slug = $slug1;
        $UmkmSector->name = $request->input('name');
        
        $UmkmSector->save();

        return redirect()->back()->with('success', 'Kategori sektor usaha berhasil diubah.');

    }

    public function destroy(Request $request, $slug): RedirectResponse
    {
        try {
            $sector = UmkmSector::where('slug', $slug)->firstOrFail();

            if (Umkm::where('sector_id', $sector->id)->exists()) {
                return redirect()->back()->with('error', 'Sektor usaha masih digunakan dan tidak bisa dihapus.');
            }

            $sector->delete();

            return redirect()->back()->with('success', 'Kategori sektor usaha berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan dalam database.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


}
