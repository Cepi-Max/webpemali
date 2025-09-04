<?php

namespace App\Http\Controllers;

use App\Models\KewilayahanKategori;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class KewilayahanKategoriController extends Controller
{
    //
    public function save(Request $request): RedirectResponse
    {
        $kewilayahanKategori = new KewilayahanKategori;
 
        $kewilayahanKategori->nama_kategori = $request->input('nama_kategori');
        $kewilayahanKategori->save();

        $referer = $request->headers->get('referer');

        return redirect($referer)->with('success', 'Kategori kewilayahan berhasil ditambahkan.');

    }

    public function destroy($id)
    {
        try {
            // Cari kategori kewilayahan berdasarkan id
            $kewilayahanKategoriById = KewilayahanKategori::where('id', $id)->firstOrFail();
    
            // Hapus kategori kewilayahan
            $kewilayahanKategoriById->delete();
    
            return redirect()->back()->with('success', 'Kategori kewilayahan berhasil dihapus.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Gagal menghapus kategori kewilayahan karena masih digunakan di tabel lain.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }

    }
}
