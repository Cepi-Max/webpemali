<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\JenisSuratSyarat;
use App\Models\SyaratDokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JenisSuratController extends Controller
{
    function index()
    {
        $jenisSurat = JenisSurat::get();

        $data = [
            'title' => 'Daftar Pilihan Pelayanan',
            'jenisSurat' => $jenisSurat,
        ];
        
        return view('admin-submission-letter.submission-option.index', $data);
    }

    public function form($id = null)
    {
        // Jika ID ada, berarti edit
        $jenisSurat = $id ? JenisSurat::findOrFail($id) : null;

        $syaratDokumen = SyaratDokumen::all();
        $selected = [];
        $wajib = [];

        if ($jenisSurat) {
            $selected = $jenisSurat->syaratDokumen()->pluck('syarat_dokumen_id')->toArray();
            $wajib = JenisSuratSyarat::where('jenis_surat_id', $jenisSurat->id)
                        ->where('wajib', true)
                        ->pluck('syarat_dokumen_id')->toArray();
        }

         $data = [
            'title' => 'Form Kelola Pilihan Pelayanan',
            'jenisSurat' => $jenisSurat,
            'syaratDokumen' => $syaratDokumen,
            'selected' => $selected,
            'wajib' => $wajib,
        ];

        return view('admin-submission-letter.submission-option.form', $data);
    }

    public function storeOrUpdate(Request $request, $id = null)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'syarat_id' => 'array',
            'syarat_id.*' => 'exists:syarat_dokumen,id',
            'wajib' => 'array',
        ]);
        
        // Cek apakah sedang edit atau buat baru
        $jenisSurat = $id ? JenisSurat::findOrFail($id) : new JenisSurat();
        
        $slug = Str::slug($request->input('nama'));

        if(!isset($id)){
            $existingSlugCount = JenisSurat::where('slug', 'LIKE', "{$slug}%")->count();
            if ($existingSlugCount > 0) {
                $slug .= '-' . ($existingSlugCount + 1);
            }
        }

        $jenisSurat->slug = $slug;
        $jenisSurat->nama = $request->input('nama');
        $jenisSurat->deskripsi = $request->input('deskripsi');
        $jenisSurat->save();

        // Sinkronisasi syarat dokumen
        $syaratIds = $request->input('syarat_id', []);
        $wajibIds = $request->input('wajib', []);

        // Buang semua syarat lama dulu (untuk update)
        JenisSuratSyarat::where('jenis_surat_id', $jenisSurat->id)->delete();

        // Tambahkan ulang syarat yang dipilih
        foreach ($syaratIds as $syaratId) {
            JenisSuratSyarat::create([
                'jenis_surat_id' => $jenisSurat->id,
                'syarat_dokumen_id' => $syaratId,
                'wajib' => isset($wajibIds[$syaratId]),
            ]);
        }

        return redirect()
            ->route('show.admin.submission_option', $jenisSurat->id)
            ->with('success', $id ? 'Jenis pelayanan berhasil diperbarui.' : 'Jenis pelayanan berhasil ditambahkan.');
    }

    public function destroy($id)
    {
        // 1. Cari data JenisSurat berdasarkan ID.
        // findOrFail akan otomatis menampilkan halaman 404 jika data tidak ditemukan.
        $jenisSurat = JenisSurat::findOrFail($id);

        // 2. Hapus semua data relasi di tabel pivot (JenisSuratSyarat).
        // Ini adalah langkah krusial untuk menghindari data sampah di database.
        // Jika Anda punya relasi Eloquent 'syarat', Anda juga bisa pakai: $jenisSurat->syarat()->detach();
        JenisSuratSyarat::where('jenis_surat_id', $jenisSurat->id)->delete();

        // 3. Setelah relasinya bersih, hapus data utama.
        $jenisSurat->delete();

        // 4. Arahkan kembali ke halaman index dengan pesan sukses.
        return redirect()
            ->route('show.admin.submission_option')
            ->with('success', 'Jenis pelayanan berhasil dihapus!');
    }



    // public function create()
    // {
    //     $syaratDokumen = SyaratDokumen::all();
        
    //     return view('admin.submission-option.create', compact('syaratDokumen'));
    // }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'deskripsi' => 'nullable|string',
    //     ]);

    //     JenisSurat::create([
    //         'nama' => $request->nama,
    //         'deskripsi' => $request->deskripsi,
    //     ]);

    //     return redirect()->route('show.admin.submission_option.index')->with('success', 'Jenis surat berhasil ditambahkan!');
    // }

    // public function edit($id)
    // {
    //     $jenisSurat = JenisSurat::findOrFail($id);
    //     $syaratDokumen = SyaratDokumen::all();

    //     // Ambil syarat yang sudah dipilih
    //     $selected = $jenisSurat->syaratDokumen()->pluck('syarat_dokumen_id')->toArray();
    //     $wajib = JenisSuratSyarat::where('jenis_surat_id', $id)
    //                 ->where('wajib', true)
    //                 ->pluck('syarat_dokumen_id')->toArray();
                    
    //     return view('admin.submission-option.edit', compact('jenisSurat', 'syaratDokumen', 'selected', 'wajib'));
    // }

    // public function update(Request $request, $id)
    // {
    //     $request->validate([
    //         'nama' => 'required|string|max:255',
    //         'deskripsi' => 'nullable|string',
    //     ]);

    //     $jenisSurat = JenisSurat::findOrFail($id);

    //     $jenisSurat->update([
    //         'nama' => $request->nama,
    //         'deskripsi' => $request->deskripsi,
    //     ]);

    //     return redirect()->route('show.admin.submission_option.index')->with('success', 'Jenis surat berhasil diperbarui!');
    // }

}
