<?php

namespace App\Http\Controllers;

use App\Models\Umkm;
use App\Models\UmkmSector;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\UmkmCertificate;
use App\Models\UmkmCertification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class UmkmController extends Controller
{
    public function index()
    {
        $umkm = Umkm::filter(request(['search', 'umkm_sector']))->latest()->paginate(4)->withQueryString();

        $data = [
            'title' => 'Daftar Umkm',
            'umkm_umkm' => $umkm
            
        ];

        return view('admin/umkm/index', $data);
    }

    public function umkmForm($slug = null)
    {
        $umkmBySlug = $slug ? Umkm::where('slug', $slug)->firstOrFail() : null;
        $umkmSector = UmkmSector::all();
        $umkmCertificationCategory = UmkmCertification::all();

        $umkmCertificate = $umkmBySlug 
            ? UmkmCertificate::where('umkm_id', $umkmBySlug->id)->pluck('certificate_id')->toArray() 
            : [];


        $data = [
            'title' => $umkmBySlug ? 'Form Ubah Data UMKM' : 'Form Tambah Data UMKM',
            'umkmSector' => $umkmSector,
            'umkmCertificationCategory' => $umkmCertificationCategory,
            'umkmCertificate' => $umkmCertificate,
            'umkmBySlug' => $umkmBySlug,
        ];

        return view('admin/umkm/form', $data);
    }


    public function save(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'certificate_id' => ['nullable', 'array'],
            'certificate_id.*' => 'exists:umkm_certification,id',
            'umkm_name' => 'required',
            'owner_name' => 'required',
            'description' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required',
            'number_phone' => 'required',
            'sector_id' => 'required',
            'product_price' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'umkm_name.required' => 'Form harus diisi.',
            'owner_name.required' => 'Form harus diisi.',
            'description.required' => 'Form harus diisi.',
            'gender.required' => 'Form harus diisi.',
            'address.required' => 'Form harus diisi.',
            'email.required' => 'Form harus diisi.',
            'number_phone.required' => 'Form harus diisi.',
            'sector_id.required' => 'Form harus diisi.',
            'product_price.required' => 'Form harus diisi.',
            'latitude.required' => 'Form harus diisi.',
            'longitude.required' => 'Form harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);

        // Tangani Slug
        $slug = Str::slug($request->input('umkm_name'));
        $existingSlugCount = \App\Models\Umkm::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        
         // Tangani file gambar
         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/umkm/umkmImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

        $author_id = Auth::id();
        
        $umkm = new Umkm;
 
        $umkm->slug = $slug;
        $umkm->author_id = $author_id;
        $umkm->sector_id = $validatedData['sector_id'];
        $umkm->umkm_name = $validatedData['umkm_name'];
        $umkm->description = $validatedData['description'];
        $umkm->owner_name = $validatedData['owner_name'];
        $umkm->gender = $validatedData['gender'];
        $umkm->address = $validatedData['address'];
        $umkm->email = $validatedData['email'];
        $umkm->number_phone = $validatedData['number_phone'];
        $umkm->product_price = $validatedData['product_price'];
        $umkm->latitude = $validatedData['latitude'];
        $umkm->longitude = $validatedData['longitude'];
        $umkm->image = $fileName;
        $umkm->save();

        $umkm->certifications()->attach($validatedData['certificate_id'] ?? []);

        return redirect()->route('show.umkm')->with('success', 'Data Berhasil Ditambahkan.');
    }


    public function update(Request $request, $slug)
    {

        
        $validatedData = $request->validate([
            'certificate_id' => ['nullable', 'array'], 
            'certificate_id.*' => 'exists:umkm_certification,id', 
            'umkm_name' => 'required',
            'owner_name' => 'required',
            'description' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'email' => 'required',
            'number_phone' => 'required',
            'product_price' => 'required',
            'sector_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'nullable|image|max:2560',
        ], [
            'umkm_name.required' => 'Form harus diisi.',
            'owner_name.required' => 'Form harus diisi.',
            'description.required' => 'Form harus diisi.',
            'gender.required' => 'Form harus diisi.',
            'address.required' => 'Form harus diisi.',
            'email.required' => 'Form harus diisi.',
            'number_phone.required' => 'Form harus diisi.',
            'product_price.required' => 'Form harus diisi.',
            'sector_id.required' => 'Form harus diisi.',
            'latitude.required' => 'Form harus diisi.',
            'longitude.required' => 'Form harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);

        $umkmBySlug = Umkm::where('slug', $slug)->firstOrFail();

        $author_id = Auth::id();
 
        $slug = Str::slug($request->input('umkm_name'));

        $umkmBySlug->slug = $slug;

        $umkmBySlug->author_id = $author_id;
        $umkmBySlug->sector_id = $validatedData['sector_id'];
        $umkmBySlug->umkm_name = $validatedData['umkm_name'];
        $umkmBySlug->description = $validatedData['description'];
        $umkmBySlug->owner_name = $validatedData['owner_name'];
        $umkmBySlug->gender = $validatedData['gender'];
        $umkmBySlug->address = $validatedData['address'];
        $umkmBySlug->email = $validatedData['email'];
        $umkmBySlug->number_phone = $validatedData['number_phone'];
        $umkmBySlug->product_price = $validatedData['product_price'];
        $umkmBySlug->latitude = $validatedData['latitude'];
        $umkmBySlug->longitude = $validatedData['longitude'];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/umkm/umkmImg/' . $fileName;

            if ($umkmBySlug->image && $umkmBySlug->image !== 'default.png' && $umkmBySlug->image !== 'default.jpg') {
                Storage::disk('public')->delete('images/publicImg/umkm/umkmImg/' . $umkmBySlug->image);
            }

            Storage::disk('public')->put($path, file_get_contents($file));

            $umkmBySlug->image = $fileName;
        } else {
            $umkmBySlug->image = $umkmBySlug->image ?? 'default.png';
        }
 
        $umkmBySlug->save();
        $umkmBySlug->certifications()->sync($validatedData['certificate_id'] ?? []);


        return redirect()->route('show.umkm')->with('success', 'Data UMKM berhasil diperbarui!');
    }

    public function delete($slug)
    {
            $umkmBySlug = Umkm::where('slug', $slug)->firstOrFail();

            if (!empty($umkmBySlug->image) && $umkmBySlug->image !== 'default.png' && $umkmBySlug->image !== 'default.jpg') {
                $filePath = 'images/publicImg/umkm/umkmImg/' . $umkmBySlug->image;
                Storage::disk('public')->delete($filePath);
            }

            $umkmBySlug->delete();

        return redirect()->route('show.umkm')->with('success', 'Umkm berhasil dihapus!');
    }



}