<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Construction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\ConstructionDocumentation;
use App\Models\ConstructionFundSourceCategories;

class ConstructionController extends Controller
{
    public function index()
    {
        $constructions = Construction::filter(request(['search']))->latest()->paginate(6)->withQueryString();
        $data = [
            'title' => 'Daftar Pembangunan',
            'constructions' => $constructions
            
        ];

        // Mengirim data posts ke view 'index'
        return view('admin/construction/index', $data);
    }

    public function constructionForm($slug = null)
    {
        $constructionBySlug = $slug ? Construction::where('slug', $slug)->firstOrFail() : null;
        $fundSourceCategories = ConstructionFundSourceCategories::all();

        $data = [
            'title' => $constructionBySlug ? 'Form Ubah Pembangunan' : 'Form Tambah Pembangunan',
            'constructionBySlug' => $constructionBySlug,
            'fundSourceCategories' => $fundSourceCategories,
        ];

        return view('admin/construction/form', $data);
    }

    public function save(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'construction_implementer' => 'required',
            'construction_volume' => 'required',
            'construction_benefits' => 'required',
            'construction_time_period' => 'required',
            'construction_site' => 'required',
            'fiscal_year' => 'required',
            'information' => 'required',
            'total_budget' => 'required',
            // 'latitude' => 'required',
            // 'longitude' => 'required',
            // 'inovator' => 'required',
            // 'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'title.required' => 'Nama Pembangunan harus diisi.',
            'construction_implementer.required' => 'Pelaksana harus diisi',
            'construction_volume.required' => 'Volume harus diisi',
            'construction_benefits.required' => 'Manfaat harus diisi',
            'construction_time_period.required' => 'Jangka waktu harus diisi',
            'construction_site.required' => 'Tempat harus diisi',
            'fiscal_year.required' => 'Tahun anggaran harus diisi',
            'information.required' => 'Keterangan harus diisi',
            'total_budget.required' => 'Salah satu sumber biaya harus diisi',
            // 'latitude.required' => 'Latitude harus diisi',
            // 'longitude.required' => 'Longitude harus diisi',
            // 'inovator.required' => 'required',
            // 'image.image' => 'File harus berupa gambar.',
            // 'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);

        // Tangani Slug
        $slug = Str::slug($request->input('title'));
        $existingSlugCount = \App\Models\Construction::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        
         // Tangani file gambar
         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/construction/constructionImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

        $author_id = Auth::id();
        
        $construction = new Construction;
 
        $construction->slug = $slug;
        $construction->author_id = $author_id;
        $construction->title = $validatedData['title'];
        $construction->construction_implementer = $validatedData['construction_implementer'];
        $construction->construction_site = $validatedData['construction_site'];
        $construction->construction_volume = $validatedData['construction_volume'];
        $construction->construction_benefits = $validatedData['construction_benefits'];
        $construction->construction_time_period = $validatedData['construction_time_period'];
        $construction->construction_site = $validatedData['construction_site'];
        $construction->fiscal_year = $validatedData['fiscal_year'];
        $construction->information = $validatedData['information'];
        $construction->latitude = $request->input('latitude');
        $construction->longitude = $request->input('longitude');
        $construction->construction_traits = $request->input('construction_traits');
        $construction->fund_source_id = $request->input('fund_source_id');
        $construction->period_category = $request->input('period_category');
        $construction->government_cost = $request->input('government_cost');
        $construction->district_cost = $request->input('district_cost');
        $construction->province_cost = $request->input('province_cost');
        $construction->self_cost = $request->input('self_cost');
         // Bersihkan format rupiah di server
        $total_budget = str_replace(['Rp.', '.'], '', $validatedData['total_budget']);
        $construction->total_budget = $total_budget;
        $construction->image = $fileName;

        $construction->save();

        // Redirect dengan pesan sukses
        return redirect()->route('show.constructions')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $slug)
    {
        
        $validatedData = $request->validate([
            'title' => 'required',
            'construction_implementer' => 'required',
            'construction_volume' => 'required',
            'construction_benefits' => 'required',
            'construction_time_period' => 'required',
            'construction_site' => 'required',
            'fiscal_year' => 'required',
            'information' => 'required',
            'total_budget' => 'required',
            // 'latitude' => 'required',
            // 'longitude' => 'required',
            // 'inovator' => 'required',
            // 'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'title.required' => 'Nama Pembangunan harus diisi.',
            'construction_implementer.required' => 'Pelaksana harus diisi',
            'construction_volume.required' => 'Volume harus diisi',
            'construction_benefits.required' => 'Manfaat harus diisi',
            'construction_time_period.required' => 'Jangka waktu harus diisi',
            'construction_site.required' => 'Tempat harus diisi',
            'fiscal_year.required' => 'Tahun anggaran harus diisi',
            'information.required' => 'Keterangan harus diisi',
            'total_budget.required' => 'Salah satu sumber biaya harus diisi',
            // 'latitude.required' => 'Latitude harus diisi',
            // 'longitude.required' => 'Longitude harus diisi',
            // 'inovator.required' => 'required',
            // 'image.image' => 'File harus berupa gambar.',
            // 'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);


        $constructionBySlug = construction::where('slug', $slug)->firstOrFail();

        // Tangani Slug
        $slug = Str::slug($request->input('title'));
        $existingSlugCount = \App\Models\Construction::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        

        $author_id = Auth::id();
 
        $constructionBySlug->slug = $slug;
        $constructionBySlug->author_id = $author_id;
        $constructionBySlug->title = $validatedData['title'];
        $constructionBySlug->construction_implementer = $validatedData['construction_implementer'];
        $constructionBySlug->construction_site = $validatedData['construction_site'];
        $constructionBySlug->construction_volume = $validatedData['construction_volume'];
        $constructionBySlug->construction_benefits = $validatedData['construction_benefits'];
        $constructionBySlug->construction_time_period = $validatedData['construction_time_period'];
        $constructionBySlug->construction_site = $validatedData['construction_site'];
        $constructionBySlug->fiscal_year = $validatedData['fiscal_year'];
        $constructionBySlug->information = $validatedData['information'];
        $constructionBySlug->latitude = $request->input('latitude');
        $constructionBySlug->longitude = $request->input('longitude');
        $constructionBySlug->construction_traits = $request->input('construction_traits');
        $constructionBySlug->fund_source_id = $request->input('fund_source_id');
        $constructionBySlug->period_category = $request->input('period_category');
        $constructionBySlug->government_cost = $request->input('government_cost');
        $constructionBySlug->district_cost = $request->input('district_cost');
        $constructionBySlug->province_cost = $request->input('province_cost');
        $constructionBySlug->self_cost = $request->input('self_cost');

        // Bersihkan format rupiah di server
        $total_budget = str_replace(['Rp.', '.'], '', $validatedData['total_budget']);
        $constructionBySlug->total_budget = $total_budget;

        // Tangani file gambar
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Buat nama file unik
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/construction/constructionImg/' . $fileName;

            // Hapus gambar lama jika bukan default.png
            if ($constructionBySlug->image && $constructionBySlug->image !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/construction/constructionImg/' . $constructionBySlug->image);
            }

            // Simpan gambar baru
            Storage::disk('public')->put($path, file_get_contents($file));

            // Simpan nama file baru ke dalam database
            $constructionBySlug->image = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan gambar lama atau default.png
            $constructionBySlug->image = $constructionBySlug->image ?? 'default.png';
        }

        $constructionBySlug->save();


        // Redirect dengan pesan sukses
        return redirect()->route('show.constructions')->with('success', 'Data pembangunan berhasil diperbarui.');

    }

    public function delete($slug)
    {
        // Cari pembangunan berdasarkan slug
        $constructionBySlug = Construction::where('slug', $slug)->firstOrFail();

        // Ambil semua dokumentasi yang terkait
        $constructionDocumentation = ConstructionDocumentation::where('construction_id', $constructionBySlug->id)->get();
        
        // Hapus gambar pembangunan jika bukan default
        if (!empty($constructionBySlug->image) && $constructionBySlug->image !== 'default.png') {
            $filePath = 'images/publicImg/construction/constructionImg/' . $constructionBySlug->image;
            Storage::disk('public')->delete($filePath);
        }
        
        // Hapus semua gambar dokumentasi yang terkait
        foreach ($constructionDocumentation as $docImg) {
            if (!empty($docImg->image) && $docImg->image !== 'default.png') {
                $filePath = 'images/publicImg/construction/documentationImg/' . $docImg->image; // Perbaikan path
                Storage::disk('public')->delete($filePath);
            }
        }

        // Hapus semua dokumentasi terkait sebelum menghapus construction
        $constructionDocumentation->each->delete(); // Hapus semua dokumentasi
        
        // Hapus pembangunan
        $constructionBySlug->delete();

        return redirect()->route('show.constructions')
                        ->with('success', 'Data pembangunan berhasil dihapus');
    }

}
