<?php

namespace App\Http\Controllers;

use App\Models\DashboardImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BannerImgController extends Controller
{
    /**
     * Menampilkan daftar semua gambar banner.
     * C => Create, R => Read, U => Update, D => Delete
     * Ini adalah bagian dari 'Read'.
     */
    function index()
    {
        $bannerImg = DashboardImage::all();

        $data = [
            'title' => 'Pengaturan Banner',
            'bannerImg' => $bannerImg,
        ];

        return view('admin/setting/index', $data);
    }

    /**
     * Menampilkan form untuk menambah atau mengedit banner.
     * Jika ada $id, ini untuk 'Update'. Jika tidak, ini untuk 'Create'.
     */
    function bannerSettingForm($id = null)
    {
        // Mengambil data banner berdasarkan id jika tersedia untuk form edit
        $bannerImgById = $id ? DashboardImage::findOrFail($id) : null;

        $data = [
            'title' => $id ? 'Edit Banner' : 'Tambah Banner',
            'bannerImgBySlug' => $bannerImgById
        ];

        return view('admin/setting/form', $data);
    }

    /**
     * Menyimpan data banner baru.
     * Ini adalah bagian dari 'Create'.
     */
    function bannerSettingSave(Request $request): RedirectResponse
    {
        // Validasi input
        // $request->validate([
        //     'bannerImg' => 'required|image|mimes:jpg,jpeg,png,svg,webp|max:2048',
        //     'link' => 'nullable|url'
        // ], [
        //     'bannerImg.required' => 'Gambar banner harus dimasukkan.',
        //     'bannerImg.image'    => 'File yang diunggah harus berupa gambar.',
        //     'bannerImg.mimes'    => 'Format gambar harus berupa: JPG, JPEG, PNG, SVG, atau WEBP.',
        //     'bannerImg.max'      => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
        //     'link.url'           => 'Format link tidak valid.'
        // ]);
    
        $fileName = 'default.png'; // Default filename
        if ($request->hasFile('bannerImg') && $request->file('bannerImg')->isValid()) {
            $file = $request->file('bannerImg'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/general/bannerImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         }       
    
        // Membuat record baru di database
        DashboardImage::create([
            'bannerImg' => $fileName,
            'link' => $request->input('link'),
        ]);
    
        return redirect()->route('show.settingBanner')->with('success', 'Data Berhasil Ditambahkan.');
    }

    /**
     * Memperbarui data banner yang ada.
     * Ini adalah bagian dari 'Update'.
     */
    function bannerSettingUpdate(Request $request, $id): RedirectResponse
    {
        // Validasi input
        // $request->validate([
        //     'bannerImg' => 'nullable|image|mimes:jpg,jpeg,png,svg,webp|max:2048', // Gambar tidak wajib diubah
        //     'link' => 'nullable|url'
        // ], [
        //     'bannerImg.image'    => 'File yang diunggah harus berupa gambar.',
        //     'bannerImg.mimes'    => 'Format gambar harus berupa: JPG, JPEG, PNG, SVG, atau WEBP.',
        //     'bannerImg.max'      => 'Ukuran gambar tidak boleh lebih dari 2 MB.',
        //     'link.url'           => 'Format link tidak valid.'
        // ]);
    
        // Cari data banner yang akan diupdate
        $banner = DashboardImage::findOrFail($id);
    
        $fileName = $banner->bannerImg; // Simpan nama file lama sebagai default

        // Cek jika ada file gambar baru yang diunggah
        if ($request->hasFile('bannerImg') && $request->file('bannerImg')->isValid()) {
            
            // Hapus gambar lama jika bukan gambar default
            if ($banner->bannerImg && $banner->bannerImg !== 'default.png') {
                Storage::disk('public')->delete('images/general/bannerImg/' . $banner->bannerImg);
            }

            // Simpan gambar baru
            $file = $request->file('bannerImg');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/general/bannerImg/' . $fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        }

        // Update data di database
        $banner->update([
            'bannerImg' => $fileName,
            'link' => $request->input('link'),
        ]);
    
        return redirect()->route('show.settingBanner')->with('success', 'Data Berhasil Diubah.');
    }

    /**
     * Menghapus data banner dari database dan file dari storage.
     * Ini adalah bagian dari 'Delete'.
     */
    public function bannerSettingDelete($id): RedirectResponse
    {
        // Cari data banner yang akan dihapus
        $banner = DashboardImage::findOrFail($id);

        // Hapus file gambar dari storage jika ada dan bukan gambar default
        if ($banner->bannerImg && $banner->bannerImg !== 'default.png') {
            Storage::disk('public')->delete('images/general/bannerImg/' . $banner->bannerImg);
        }

        // Hapus record dari database
        $banner->delete();

        return redirect()->route('show.settingBanner')->with('success', 'Data Berhasil Dihapus.');
    }
}
