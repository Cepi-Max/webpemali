<?php

namespace App\Http\Controllers;

use App\Models\DashboardImageService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerImgServiceController extends Controller
{
    function index()
    {
        $bannerImg = DashboardImageService::all();

        $data = [
            'title' => 'Pengaturan Banner Pelayanan',
            'bannerImg' => $bannerImg,
        ];

        return view('admin/setting/index-banner-service', $data);
    }

    function bannerSettingForm($id = null)
    {
        $bannerImgBySlug = $id ? DashboardImageService::where('id', $id)->firstOrFail() : null;

        $data = [
            'title' => 'Pengaturan Banner Form',
            'bannerImgBySlug' => $bannerImgBySlug
        ];

        return view('admin/setting/form-banner-service', $data);
    }

    function bannerSettingSave(Request $request): RedirectResponse
    {
        $request->validate([
            'bannerImg' => 'required|image',
        ], [
            'bannerImg.required' => 'Gambar harus dimasukkan.',
            'bannerImg.image' => 'File harus berupa gambar.',
        ]);
    
        if ($request->hasFile('bannerImg') && $request->file('bannerImg')->isValid()) {
            $file = $request->file('bannerImg'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/general/bannerImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }          
    
         $bannerImage = new DashboardImageService;
         
         $bannerImage->bannerImg = $fileName;
         $bannerImage->link = $request->input('link');
         $bannerImage->save();
        //  dd($path);
    
        return redirect()->route('show.setting-banner-service')->with('success', 'Data Berhasil Ditambahkan.');
    }

    function bannerSettingUpdate(Request $request, $id): RedirectResponse
    {
        $request->validate([
            'bannerImg' => 'nullable|image|max:2560',
            'link' => 'nullable|string|max:255',
        ]);

        $bannerImage = DashboardImageService::findOrFail($id);

        if ($request->hasFile('bannerImg') && $request->file('bannerImg')->isValid()) {
            // Hapus gambar lama jika bukan default
            if ($bannerImage->bannerImg && $bannerImage->bannerImg !== 'default.png') {
                Storage::disk('public')->delete('images/general/bannerImg/' . $bannerImage->bannerImg);
            }

            $file = $request->file('bannerImg');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/general/bannerImg/' . $fileName;
            Storage::disk('public')->put($path, file_get_contents($file));

            $bannerImage->bannerImg = $fileName;
        }

        $bannerImage->link = $request->input('link') ?? $bannerImage->link;
        $bannerImage->save();

        return redirect()->route('show.setting-banner-service')->with('success', 'Data berhasil diperbarui.');
    }


    public function bannerSettingDelete($id): RedirectResponse
    {
        // Cari data banner yang akan dihapus
        $banner = DashboardImageService::findOrFail($id);

        // Hapus file gambar dari storage jika ada dan bukan gambar default
        if ($banner->bannerImg && $banner->bannerImg !== 'default.png') {
            Storage::disk('public')->delete('images/general/bannerImg/' . $banner->bannerImg);
        }

        // Hapus record dari database
        $banner->delete();

        return redirect()->route('show.setting-banner-service')->with('success', 'Data Berhasil Dihapus.');
    }
}
