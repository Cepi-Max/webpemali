<?php

namespace App\Http\Controllers;

use App\Models\Ppid;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class PpidController extends Controller
{
    public function index()
    {
        $ppid = Ppid::first(); 
        $data = [
            'title' => 'Admin Ppid Desa Pemali',
            'ppid' => $ppid
        ];
        return view('admin.ppid.index', $data);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'profil' => 'required',
            'visi' => 'required',
            'misi' => 'required',
            'regulasi_ppid' => 'nullable',
            'maklumat' => 'required',
            'alamat' => 'nullable',
            'kontak' => 'nullable',
            'status' => 'required|in:aktif,nonaktif',
            'gambar_struktur_organisasi' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'gambar_depan_ppid' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'file_regulasi' => 'nullable|mimes:pdf|max:2048',
        ]);

        $ppid = Ppid::where('id', $id)->firstOrFail();

        $ppid->profil = $request->input('profil');
        $ppid->visi = $request->input('visi');
        $ppid->misi = $request->input('misi');
        // Tangani gambar depan ppid
        if ($request->hasFile('gambar_depan_ppid') && $request->file('gambar_depan_ppid')->isValid()) {
            $file = $request->file('gambar_depan_ppid');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/ppid/ppidImg/' . $fileName;

            if ($ppid->gambar_depan_ppid && $ppid->gambar_depan_ppid !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/ppid/ppidImg/' . $ppid->gambar_depan_ppid);
            }

            Storage::disk('public')->put($path, file_get_contents($file));
            $ppid->gambar_depan_ppid = $fileName;
        }

        // Tangani gambar struktur organisasi
        if ($request->hasFile('gambar_struktur_organisasi') && $request->file('gambar_struktur_organisasi')->isValid()) {
            $file = $request->file('gambar_struktur_organisasi');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/ppid/ppidImg/' . $fileName;

            if ($ppid->gambar_struktur_organisasi && $ppid->gambar_struktur_organisasi !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/ppid/ppidImg/' . $ppid->gambar_struktur_organisasi);
            }

            Storage::disk('public')->put($path, file_get_contents($file));
            $ppid->gambar_struktur_organisasi = $fileName;
        }

        // $ppid->regulasi_ppid = $request->input('regulasi_ppid');

        // Tangani file regulasi
        if ($request->hasFile('file_regulasi') && $request->file('file_regulasi')->isValid()) {
            $file = $request->file('file_regulasi');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'pdf/ppid/' . $fileName;

            if ($ppid->file_regulasi && $ppid->file_regulasi !== 'default.pdf') {
                Storage::disk('public')->delete('pdf/ppid/' . $ppid->file_regulasi);
            }

            Storage::disk('public')->put($path, file_get_contents($file));
            $ppid->file_regulasi = $fileName;
        }

        $ppid->maklumat = $request->input('maklumat');
        $ppid->alamat = $request->input('alamat');
        $ppid->kontak = $request->input('kontak');
        $ppid->status = $request->input('status');
        $ppid->save();

        return redirect()->route('ppid.edit')->with('success', 'Data PPID berhasil diperbarui');
    }

    public function previewRegulasi(Ppid $ppid)
    {
        $filePath = 'pdf/ppid/' . $ppid->file_regulasi;

        // Cek apakah file ada
        if (!$ppid->file_regulasi || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File regulasi tidak ditemukan.');
        }

        // Ambil file dari storage
        $file = Storage::disk('public')->get($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);

        return response($file, 200)->header('Content-Type', $mimeType);
    }


    public function downloadRegulasi(Ppid $ppid)
    {
        $filePath = 'pdf/ppid/' . $ppid->file_regulasi;

        // Cek apakah file ada di storage
        if (!$ppid->file_regulasi || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File regulasi tidak ditemukan.');
        }

        // Kasih nama file saat di-download (biar user lebih ngerti)
        $fileName = 'Regulasi_PPID_Desa_' . now()->format('YmdHis') . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($filePath, $fileName);
    }
        
}
