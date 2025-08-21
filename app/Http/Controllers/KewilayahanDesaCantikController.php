<?php

namespace App\Http\Controllers;

use App\Models\KewilayahanDesaCantik;
use App\Models\KewilayahanKategori;
use Illuminate\Http\Request;

class KewilayahanDesaCantikController extends Controller
{
    //
    public function index()
    {
        $kewilayahan = KewilayahanDesaCantik::filter(request(['search', 'category']))->latest()->paginate(6)->withQueryString();

        $data = [
            'title' => 'Daftar Fasilitas',
            'kewilayahan' => $kewilayahan
        ];

        return view('admin.kewilayahan-desa-cantik.index', $data);
    }

    public function kewilayahanForm($id = null)
    {
        $kewilayahanById = $id ? KewilayahanDesaCantik::where('id', $id)->firstOrFail() : null;
        $kategori = KewilayahanKategori::all();

        $data = [
            'title' => $kewilayahanById ? 'Form Ubah Fasilitas' : 'Form Tambah Fasilitas',
            'kewilayahan_kategori' => $kategori,
            'kewilayahanById' => $kewilayahanById,
        ];

        return view('admin.kewilayahan-desa-cantik.form', $data);
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'nama_fasilitas' => 'required',
            'kewilayahan_kategori_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas harus diisi.',
            'kewilayahan_kategori_id.required' => 'Kategori fasilitas harus diisi.',
            'latitude.required' => 'Latitude harus diisi.',
            'longitude.required' => 'Longitude harus diisi.',
        ]);

        $kewilayahanDesaCantik = new KewilayahanDesaCantik;

        $kewilayahanDesaCantik->nama_fasilitas = $validatedData['nama_fasilitas'];

        $kewilayahanDesaCantik->kewilayahan_kategori_id = $validatedData['kewilayahan_kategori_id'];
        $kewilayahanDesaCantik->latitude = $validatedData['latitude'];
        $kewilayahanDesaCantik->longitude = $validatedData['longitude'];

        $kewilayahanDesaCantik->save();

        return redirect()->route('show.admin.desa-cantik.kewilayahan')->with('success', 'Data Berhasil Ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama_fasilitas' => 'required',
            'kewilayahan_kategori_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ], [
            'nama_fasilitas.required' => 'Nama fasilitas harus diisi.',
            'kewilayahan_kategori_id.required' => 'Kategori fasilitas harus diisi.',
            'latitude.required' => 'Latitude harus diisi.',
            'longitude.required' => 'Longitude harus diisi.',
        ]);

        $kewilayahanDesaCantikById = KewilayahanDesaCantik::where('id', $id)->firstOrFail();

        $kewilayahanDesaCantikById->nama_fasilitas = $validatedData['nama_fasilitas'];

        $kewilayahanDesaCantikById->kewilayahan_kategori_id = $validatedData['kewilayahan_kategori_id'];
        $kewilayahanDesaCantikById->latitude = $validatedData['latitude'];
        $kewilayahanDesaCantikById->longitude = $validatedData['longitude'];

        $kewilayahanDesaCantikById->save();

        return redirect()->route('show.admin.desa-cantik.kewilayahan')->with('success', 'Data Berhasil Diperbarui.');
    }

    public function delete($id)
    {
        $kewilayahanDesaCantikById = KewilayahanDesaCantik::where('id', $id)->firstOrFail();

        $kewilayahanDesaCantikById->delete();

        return redirect()->route('show.admin.desa-cantik.kewilayahan')->with('success', 'Data Berhasil Dihapus.');
    }
}
