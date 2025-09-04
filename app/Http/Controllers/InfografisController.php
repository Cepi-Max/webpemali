<?php

namespace App\Http\Controllers;

use App\Models\Infografis;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InfografisController extends Controller
{
    public function index()
    {
        $infografis = Infografis::filter(request(['search']))->latest()->paginate(6)->withQueryString();
        $data = [
            'title' => 'Daftar Infografis Desa Cantik',
            'infografis' => $infografis,
        ];

        return view('admin.infografis-desa-cantik.index', $data);
    }

    // public function create()
    // {
    //     $data = [
    //         'title' => 'Tambah Galeri',
    //     ];

    //     return view('admin/gallery/create', $data);
    // }

    public function infografisForm($id = null)
    {
        $infografisById = $id ? Infografis::where('id', $id)->firstOrFail() : null;
        $data = [
            'title' => $infografisById ? 'Form Ubah Infografis' : 'Form Tambah Infografis',
            'infografisById' => $infografisById
        ];

        return view('admin/infografis-desa-cantik/form', $data);
    }

    public function save(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'file_infografis' => 'nullable|image|max:2560'
        ], [
            'judul.required' => 'Form harus diisi.',
            'deskripsi.required' => 'Form harus diisi.',
            'file_infografis.image' => 'File harus berupa gambar.',
            'file_infografis.max' => 'Ukuran gambar tidak boleh melebihi 2,5 MB.'
        ]);

        if($request->hasFile('file_infografis') && $request->file('file_infografis')->isValid())
        {
            $file = $request->file('file_infografis'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/infografis/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        } else {
            $fileName = 'default.png';
        }


        $infografis = New Infografis;

        $infografis->id;
        $infografis->judul = $validatedData['judul'];
        $infografis->deskripsi = $validatedData['deskripsi'];
        $infografis->file_infografis = $fileName;

        $infografis->save();

        return redirect()->route('show.admin.desa-cantik.infografis')->with('success', 'Data Infografis Berhasil Ditambahkan!');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'deskripsi' => 'required',
            'file_infografis' => 'nullable|image|max:2560'
        ], [
            'judul.required' => 'Form harus diisi.',
            'deskripsi.required' => 'Form harus diisi.',
            'file_infografis.image' => 'File harus berupa gambar.',
            'file_infografis.max' => 'Ukuran gambar tidak boleh melebihi 2,5 MB.'
        ]);


        $infografisBySlug = Infografis::where('id', $id)->firstOrFail();

        if($request->hasFile('file_infografis') && $request->file('file_infografis')->isValid())
        {
            $file = $request->file('file_infografis'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/infografis/'.$fileName;

            if ($infografisBySlug->file_infografis && $infografisBySlug->file_infografis !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/infografis/' . $infografisBySlug->file_infografis);
            }

            Storage::disk('public')->put($path, file_get_contents($file));
            $infografisBySlug->file_infografis = $fileName;
        } else {
            $infografisBySlug->file_infografis = $infografisBySlug->file_infografis ?? 'default.png';
        }

        $infografisBySlug->judul = $validatedData['judul'];
        $infografisBySlug->deskripsi = $validatedData['deskripsi'];

        $infografisBySlug->save();

        return redirect()->route('show.admin.desa-cantik.infografis')->with('success', 'Data Infografis Berhasil Ditambahkan!');
    }

    public function delete($id)
    {
            $infografisBySlug = Infografis::where('id', $id)->firstOrFail();


            if (!empty($infografisBySlug->file_infografis) && $infografisBySlug->file_infografis !== 'default.png') {
                $filePath = 'images/publicImg/infografis/' . $infografisBySlug->file_infografis;
                Storage::disk('public')->delete($filePath);
            }

            $infografisBySlug->delete();

        return redirect()->route('show.admin.desa-cantik.infografis')->with('success', 'Data infografis berhasil dihapus!');
    }



}
