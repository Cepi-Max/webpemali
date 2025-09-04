<?php

namespace App\Http\Controllers;

use \Log;
use App\Models\Construction;
use App\Models\ConstructionDocumentation;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ConstructionDocumentationController extends Controller
{
    public function index($slug)
    {
       
        $construction = Construction::where('slug', $slug)->FirstOrFail();
        $documentations = ConstructionDocumentation::where('construction_id', $construction->id)
        ->paginate(6)
        ->withQueryString();

        $data = [
            'title' => 'Dokumentasi Pembangunan',
            'construction' => $construction,
            'documentations' => $documentations,
            
        ];



        return view('admin/construction/documentation/index', $data);
    }
    

    public function constructionDocumentationForm($slug, $id = null)
    {

        $construction = Construction::where('slug', $slug)->firstOrFail();

        $constructionDocumentationById = $id ? 
            ConstructionDocumentation::where('id', $id)
            ->where('construction_id', $construction->id)
            ->first() 
            : null;

        if ($id && !$constructionDocumentationById) {
            return redirect()->route('show.constructions.documentation.form', ['slug' => $slug])
            ->with('error', 'Dokumentasi tidak ditemukan!');
        }

        $data = [
            'title' => $constructionDocumentationById ? 'Form Ubah Dokumentasi' : 'Form Tambah Dokumentasi',
            'CDById' => $constructionDocumentationById,
            'construction' => $construction,
        ];

        return view('admin/construction/documentation/form', $data);
    }

    public function save(Request $request, $slug): RedirectResponse
    {

        $constructionBySlug = Construction::where('slug', $slug)->firstOrFail();
        
        $validatedData = $request->validate([
            'percentage' => 'required',
            'information' => 'required',
            'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'percentage.required' => 'Persentase Pembangunan harus diisi.',
            'information.required' => 'Keterangan Pembangunan harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);
        
        $author_id = Auth::id();
        $constructionDocumentation = New ConstructionDocumentation;
        
        $constructionDocumentation->author_id = $author_id;
        $constructionDocumentation->construction_id = $constructionBySlug->id;
        $constructionDocumentation->percentage = $validatedData['percentage'];
        $constructionDocumentation->information = $validatedData['information'];
        
        // Tangani file gambar
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/construction/documentationImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
        } else {
            $fileName = 'default.png';
        }
        $constructionDocumentation->image = $fileName;

        $constructionDocumentation->save();

        return redirect()->route('show.constructions.documentation', $constructionBySlug->slug)
                         ->with('success', 'Dokumentasi Berhasil Ditambah.');  

    }

    public function update(Request $request, $id)
    {
        
        $validatedData = $request->validate([
            'percentage' => 'required',
            'information' => 'required',
            'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'percentage.required' => 'Persentase Pembangunan harus diisi.',
            'information.required' => 'Keterangan Pembangunan harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);
        
        $author_id = Auth::id();
        $constructionDocumentation = ConstructionDocumentation::where('id', $id)->firstOrFail();
        
        
        
        $constructionDocumentation->author_id = $author_id;
        // $constructionDocumentation->construction_id = $constructionBySlug->id;
        $constructionDocumentation->percentage = $validatedData['percentage'];
        $constructionDocumentation->information = $validatedData['information'];
        

        // Tangani file gambar
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Buat nama file unik
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/construction/documentationImg/' . $fileName;

            // Hapus gambar lama jika bukan default.png
            if ($constructionDocumentation->image && $constructionDocumentation->image !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/construction/documentationImg/' . $constructionDocumentation->image);
            }

            // Simpan gambar baru
            Storage::disk('public')->put($path, file_get_contents($file));

            // Simpan nama file baru ke dalam database
            $constructionDocumentation->image = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan gambar lama atau default.png
            $constructionDocumentation->image = $constructionDocumentation->image ?? 'default.png';
        }

        $constructionDocumentation->save();

        $constructionBySlug = Construction::where('id', $constructionDocumentation->construction_id)->firstOrFail();
        return redirect()->route('show.constructions.documentation', $constructionBySlug->slug)
                         ->with('success', 'Dokumentasi Berhasil Diperbarui.');  

    }

    public function delete($id)
    {
        // Cari dokumentasi berdasarkan id
        $constructionDocumentation = ConstructionDocumentation::where('id', $id)->firstOrFail();
        $construction = Construction::where('id', $constructionDocumentation->construction_id)->firstOrFail();

        // Storage::delete('public/posts/'.basename($constructionBySlug->image));
        // Cek jika gambar ada dan bukan default
        if (!empty($constructionDocumentation->image) && $constructionDocumentation->image !== 'default.png') {
            $filePath = 'images/publicImg/construction/documentationImg/' . $constructionDocumentation->image;
            Storage::disk('public')->delete($filePath);
        }
        

        // Hapus pembangunan
        $constructionDocumentation->delete();

        return redirect()->route('show.constructions.documentation', $construction->slug)
                     ->with('success', 'Dokumentasi berhasil dihapus.');
    }
}
