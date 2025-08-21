<?php

namespace App\Http\Controllers;

use App\Models\VillageProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillageProfileController extends Controller
{
    public function index()
    {
        $villageProfiles = VillageProfile::first();

        // Mengambil semua data article dari database
        $data = [
            'title' => 'Profile Desa',
            'villageProfiles' => $villageProfiles,
            
        ];

        // Mengirim data posts ke view 'index'
        return view('admin/village-profile/index', $data);
    }

    public function save(Request $request)
    {

        $request->validate([
            'sejarah_image' => 'mimes:jpg,png',
        ], [
            'sejarah_image.mimes' => 'Gambar harus berformat jpg atau png.',
        ]);

        // Tangani file gambar
        if ($request->hasFile('sejarah_image') && $request->file('sejarah_image')->isValid()) {
            $file = $request->file('sejarah_image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/villageProfile/villageProfileImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

        $villageProfileById = new VillageProfile;

        $author_id = Auth::id();

        $villageProfileById->nama_desa = $request->input('nama_desa');
        $villageProfileById->visi = $request->input('visi');
        $villageProfileById->misi =  $request->input('misi');
        $villageProfileById->sejarah = $request->input('sejarah');
        $villageProfileById->sejarah_image = $fileName;
        $villageProfileById->batas_utara = $request->input('batas_utara');
        $villageProfileById->batas_selatan = $request->input('batas_selatan');
        $villageProfileById->batas_timur = $request->input('batas_timur');
        $villageProfileById->batas_barat = $request->input('batas_barat');
        $villageProfileById->alamat = $request->input('alamat');
        $villageProfileById->kode_pos = $request->input('kode_pos');
        $villageProfileById->luas_desa = $request->input('luas_desa');
        $villageProfileById->author_id = $author_id;

        $villageProfileById->save();

        return redirect()->route('profile_village.edit')->with('success', 'Profil Desa berhasil diperbarui!');
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'sejarah_image' =>'mimes:jpg,png',
        ], [
            'sejarah_image.mimes' => 'Gambar harus berformat jpg atau png.',
        ]);

        
        // Cari artikel berdasarkan id
        $villageProfileById = VillageProfile::where('id', $id)->firstOrFail();

        
        $author_id = Auth::id();
        
        $villageProfileById->nama_desa = $request->input('nama_desa');
        $villageProfileById->visi = $request->input('visi');
        $villageProfileById->misi =  $request->input('misi');
        $villageProfileById->sejarah = $request->input('sejarah');
        // Tangani file gambar
        if ($request->hasFile('sejarah_image') && $request->file('sejarah_image')->isValid()) {
            $file = $request->file('sejarah_image');

            // Buat nama file unik
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/villageProfile/villageProfileImg/' . $fileName;

            // Hapus gambar lama jika bukan default.png
            if ($villageProfileById->sejarah_image && $villageProfileById->sejarah_image !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/villageProfile/villageProfileImg/' . $villageProfileById->image);
            }

            // Simpan gambar baru
            Storage::disk('public')->put($path, file_get_contents($file));

            // Simpan nama file baru ke dalam database
            $villageProfileById->sejarah_image = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan gambar lama atau default.png
            $villageProfileById->sejarah_image = $villageProfileById->sejarah_image ?? 'default.png';
        }
        $villageProfileById->batas_utara = $request->input('batas_utara');
        $villageProfileById->batas_selatan = $request->input('batas_selatan');
        $villageProfileById->batas_timur = $request->input('batas_timur');
        $villageProfileById->batas_barat = $request->input('batas_barat');
        $villageProfileById->alamat = $request->input('alamat');
        $villageProfileById->kode_pos = $request->input('kode_pos');
        $villageProfileById->luas_desa = $request->input('luas_desa');
        $villageProfileById->author_id = $author_id;

        $villageProfileById->save();

        return redirect()->route('profile_village.edit')->with('success', 'Profil Desa berhasil diperbarui!');
    }
    
}
