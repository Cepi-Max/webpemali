<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use App\Models\JenisSuratSyarat;
use App\Models\SyaratDokumen;
use Illuminate\Http\Request;

class JenisSuratSyaratController extends Controller
{
    public function index(Request $request)
    {
        
        $query = $request->input('query');
        if ($query) {
            $syaratDokumen = SyaratDokumen::where('nama', 'like', '%' . $query . '%')->get();
        } else {
            $syaratDokumen = SyaratDokumen::all();
        }

        $data = [
            'title' => 'Daftar Syarat Pelayanan',
            'syaratDokumen' => $syaratDokumen,
        ];

        return view('admin-submission-letter.submission-requirements.index', $data);
    }

    public function syaratForm($id = null)
    {
        $syaratDokumen = $id ? SyaratDokumen::findOrFail($id) : null;

        $data = [
            'title' => 'Form Syarat Dokumen',
            'syaratDokumen' => $syaratDokumen,
        ];

        return view('admin-submission-letter.submission-requirements.form', $data);
    }

    public function storeOrUpdate(Request $request, $id = null)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'tipe_input' => 'required',
    ]);

    if ($id) {
        $dokumen = SyaratDokumen::findOrFail($id);
        $dokumen->update([
            'nama' => $request->nama,
            'tipe_input' => $request->tipe_input,
        ]);

        // Hapus opsi lama (jika ada)
        if ($request->tipe_input === 'select') {
            $dokumen->opsi()->delete();
        }

        $pesan = 'Data berhasil diperbarui!';
    } else {
        $dokumen = SyaratDokumen::create([
            'nama' => $request->nama,
            'tipe_input' => $request->tipe_input,
        ]);
        $pesan = 'Data berhasil disimpan!';
    }

    // Kalau select, simpan opsi-nya
    if ($request->tipe_input === 'select' && $request->has('opsi')) {
        foreach ($request->opsi as $opsi) {
            $dokumen->opsi()->create([
                'opsi' => $opsi
            ]);
        }
    }

    return redirect()->route('show.admin.submission_requirements')->with('success', $pesan);
}


    public function destroy($id)
    {
        // 1. Cari dokumen berdasarkan ID.
        // findOrFail akan otomatis menampilkan halaman 404 jika data tidak ditemukan.
        $dokumen = SyaratDokumen::findOrFail($id);

        // 2. Hapus data dari database.
        $dokumen->delete();

        // 3. Arahkan kembali ke halaman index dengan pesan sukses.
        return redirect()->route('show.admin.submission_requirements')->with('success', 'Data berhasil dihapus!');
    }

}
