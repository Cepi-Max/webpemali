<?php

namespace App\Http\Controllers;

use App\Models\Official;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class OfficialController extends Controller
{
    public function index()
    {
        $officials = Official::filter(request(['search']))->latest()->paginate(4)->withQueryString();
        $data = [
            'title' => 'Daftar Aparatur',
            'officials' => $officials
            
        ];
        return view('admin/official/index', $data);
    }

    public function details($slug)
    {
        $official = Official::where('slug', $slug)->firstOrFail();
        $data = [
            'title' => 'Detail Aparatur',
            'official' => $official
            
        ];
        return view('admin/official/details', $data);
    }

    public function officialForm($slug = null)
    {
        $officialBySlug = $slug ? Official::where('slug', $slug)->firstOrFail() : null;
        $data = [
            'title' => $officialBySlug ? 'Form Ubah Aparatur' : 'Form Tambah Aparatur',
            'officialBySlug' => $officialBySlug
        ];

        return view('admin/official/form', $data);
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required', 
            'gender' => 'required', 
            'place_of_birth' => 'required', 
            'date_of_birth' => 'required', 
            'position' => 'required', 
            'phone_number' => 'required', 
            'image' => 'nullable|image|max:2560'
           ],[
            'name.required' => 'Nama harus diisi.',
            'address.required' => 'Alamat harus diisi.', 
            'gender.required' => 'Jenis kelamin harus diisi.', 
            'place_of_birth.required' => 'Tempat lahir harus diisi.', 
            'date_of_birth.required' => 'Tanggal lahir harus diisi.', 
            'position.required' => 'Jabatan harus diisi.', 
            'phone_number.required' => 'Nomor Telepon harus diisi.', 
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh melebihi 2,5 MB.'
           ]
       );
   
           // Tangani Slug
           $slug = Str::slug($request->input('name'));
           $existingSlugCount = \App\Models\Official::where('slug', 'LIKE', "{$slug}%")->count();
   
           if ($existingSlugCount > 0) {
               $slug .= '-' . ($existingSlugCount + 1);
           }
   
            // Tangani file gambar
           if(request()->hasFile('image') && request()->file('image')->isValid()){
                $file = $request->file('image'); 
                $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $path   = 'images/publicImg/official/officialImg/'.$fileName;
                Storage::disk('public')->put($path, file_get_contents($file));
           } else {
               $fileName = 'default.png';
           }
   
           $author_id = Auth::id();
   
           $official = New Official;
   
           $official->slug = $slug;
           $official->author_id = $author_id;
           $official->name = $validatedData['name'];
           $official->address = $validatedData['address'];
           $official->gender = $validatedData['gender'];
           $official->place_of_birth = $validatedData['place_of_birth'];
           $official->date_of_birth = $validatedData['date_of_birth'];
           $official->position = $validatedData['position'];
           $official->phone_number = $validatedData['phone_number'];
           $official->image = $fileName;
   
           $official->save();
   
           return redirect()->route('show.officials')->with('success', 'Aparat berhasil ditambahkan.');
    }

    public function edit($slug)
    {
        $official = Official::where('slug', $slug)->firstOrFail();
        $data = [
            'title' => 'Tambah Aparatur',
            'official' => $official
        ];

        return view('admin/official/edit', $data);
    }

    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required', 
            'gender' => 'required', 
            'place_of_birth' => 'required', 
            'date_of_birth' => 'required', 
            'position' => 'required', 
            'phone_number' => 'required', 
            'image' => 'nullable|image|max:2560'
           ],[
            'name.required' => 'Nama harus diisi.',
            'address.required' => 'Alamat harus diisi.', 
            'gender.required' => 'Jenis kelamin harus diisi.', 
            'place_of_birth.required' => 'Tempat lahir harus diisi.', 
            'date_of_birth.required' => 'Tanggal lahir harus diisi.', 
            'position.required' => 'Jabatan harus diisi.', 
            'phone_number.required' => 'Nomor Telepon harus diisi.', 
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh melebihi 2,5 MB.'
           ]
       );
             
   
           $author_id = Auth::id();
           $officialBySlug = Official::where('slug', $slug)->firstOrFail();
   
           // Tangani Slug
           $slug = Str::slug($request->input('name'));
           $existingSlugCount = \App\Models\Official::where('slug', 'LIKE', "{$slug}%")->count();
   
           if ($existingSlugCount > 0) {
               $slug .= '-' . ($existingSlugCount + 1);
           }
           $officialBySlug->slug = $slug;
           $officialBySlug->author_id = $author_id;
           $officialBySlug->name = $validatedData['name'];
           $officialBySlug->address = $validatedData['address'];
           $officialBySlug->gender = $validatedData['gender'];
           $officialBySlug->place_of_birth = $validatedData['place_of_birth'];
           $officialBySlug->date_of_birth = $validatedData['date_of_birth'];
           $officialBySlug->position = $validatedData['position'];
           $officialBySlug->phone_number = $validatedData['phone_number'];

            // Tangani file gambar
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            // Buat nama file unik
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/official/officialImg/' . $fileName;

            // Hapus gambar lama jika bukan default.png
            if ($officialBySlug->image && $officialBySlug->image !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/official/officialImg/' . $officialBySlug->image);
            }

            // Simpan gambar baru
            Storage::disk('public')->put($path, file_get_contents($file));

            // Simpan nama file baru ke dalam database
            $officialBySlug->image = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan gambar lama atau default.png
            $officialBySlug->image = $officialBySlug->image ?? 'default.png';
        }
   
           $officialBySlug->save();
   
           return redirect()->route("show.officials")->with('success', 'Aparat berhasil diubah.');
    }

    public function delete($slug)
    {
         $officialBySlug = Official::where('slug', $slug)->firstOrFail();

         if (!empty($officialBySlug->image) && $officialBySlug->image !== 'default.png') {
            $filePath = 'images/publicImg/official/officialImg/' . $officialBySlug->image;
            Storage::disk('public')->delete($filePath);
         }
 
         $officialBySlug->delete();
 
     return redirect()->route('show.officials')
                      ->with('success', 'Data aparatur berhasil dihapus!');
    }
}
