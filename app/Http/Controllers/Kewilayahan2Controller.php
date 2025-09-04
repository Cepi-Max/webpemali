<?php

namespace App\Http\Controllers;

use App\Models\Kewilayahan2;
use Illuminate\Http\Request;

class Kewilayahan2Controller extends Controller
{
    public function index()
    {
        $kewilayahan2 = Kewilayahan2::filter(request(['search', 'category']))->latest()->paginate(6)->withQueryString();

        $data = [
            'title' => 'Daftar Kewilayahan',
            'kewilayahan2' => $kewilayahan2
        ];

        return view('admin.kewilayahan2.index', $data);
    }

    public function kewilayahanForm($id = null)
    {
        $kewilayahanById = $id ? Kewilayahan2::where('id', $id)->firstOrFail() : null;

        $data = [
            'title' => $kewilayahanById ? 'Form Ubah Kewilayahan' : 'Form Tambah Kewilayahan',
            'kewilayahanById' => $kewilayahanById,
        ];

        return view('admin.kewilayahan2.form', $data);
    }

   public function saveOrUpdate(Request $request)
    {
        // 1. Validasi input dari form
        $request->validate([
            'nama_dusun' => 'required|string|max:255',
            'koordinat' => 'required|string', // Validasi sebagai string dulu, karena dari form berupa JSON string
            'warna' => 'required|string|max:20',
        ]);

        // 2. Siapkan data untuk disimpan atau diupdate
        //    Tidak perlu json_decode jika Anda menggunakan Eloquent attribute casting pada model.
        //    Ini adalah praktik yang lebih baik.
        $data = [
            'nama_dusun' => $request->nama_dusun,
            'koordinat' => $request->koordinat, // Biarkan sebagai JSON string, biarkan model yang mengurusnya
            'warna' => $request->warna,
        ];

        // 3. Logika utama: Cek apakah $id ada (untuk update) atau tidak (untuk create)
        if ($request->id) {
            // --- PROSES UPDATE ---
            // Cari data berdasarkan ID. Gunakan findOrFail agar otomatis error 404 jika ID tidak ditemukan.
            $kewilayahan = Kewilayahan2::where('id', $request->id)->first();
            $kewilayahan->update($data);
            $message = 'Data kewilayahan berhasil diperbarui.';
        } else {
            // --- PROSES CREATE ---
            Kewilayahan2::create($data);
            $message = 'Data kewilayahan berhasil ditambahkan.';
        }

        // 4. Redirect kembali ke halaman daftar dengan pesan sukses
        return redirect()->route('show.admin.desa-cantik.pembagian-kewilayahan')->with('success', $message);
    }

    public function destroy($id)
    {
        // Cek apakah data ada
        $kewilayahan = Kewilayahan2::findOrFail($id);

        // Hapus data
        $kewilayahan->delete();

        // Redirect balik ke halaman daftar dengan pesan sukses
        return redirect()->route('show.admin.desa-cantik.pembagian-kewilayahan')
                        ->with('success', 'Data kewilayahan berhasil dihapus.');
    }


}
