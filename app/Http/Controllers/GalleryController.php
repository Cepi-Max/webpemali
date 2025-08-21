<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::filter(request(['search', 'admin']))->latest()->paginate(6)->withQueryString()->toArray();
        $data = [
            'title' => 'Daftar Galeri',
            'galleries' => $galleries,
        ];
        // dd($galleries);

        return view('admin/gallery/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Galeri',
        ];

        return view('admin/gallery/create', $data);
    }

    public function save(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'image' => 'nullable|image|max:2560'
        ], [
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh melebihi 2,5 MB.'
        ]);

        // Tangani Gambar
        if($request->hasFile('image') && $request->file('image')->isValid())
        {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/gallery/galleryImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        } else {
            $fileName = 'default.png';
        }

        $author_id = Auth::id();

        $gallery = New Gallery;

        $gallery->id;
        $gallery->author_id = $author_id;
        $gallery->title = $request->input('title');
        $gallery->image = $fileName;

        $gallery->save();

        return redirect()->route('show.galleries')->with('success', 'Galeri Berhasil Ditambahkan!');
    }

    public function deleteSelected(Request $request)
    {
    // dd('hello deleted');
        // Ambil ID yang dicentang
        $ids = $request->input('delete_ids');
        
        if ($ids && is_array($ids)) {
            // Ambil data galeri berdasarkan ID yang dipilih
            $galleries = Gallery::whereIn('id', $ids)->get();

            // Loop untuk menghapus gambar dari penyimpanan
            foreach ($galleries as $gallery) {
                if (!empty($gallery->image) && $gallery->image !== 'default.png') {
                    $filePath = 'images/publicImg/gallery/galleryImg/' . $gallery->image; // Perbaikan path
                    Storage::disk('public')->delete($filePath);
                }
            }

            // Hapus data dari database
            Gallery::whereIn('id', $ids)->delete();
            
            return redirect()->route('show.galleries')->with('success', 'Gambar yang dipilih berhasil dihapus.');
        } else {
            return redirect()->route('show.galleries')->with('message', 'Tidak ada data yang dipilih.');
        }
    }

}
