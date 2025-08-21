<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    
    
    public function index()
    {
        $announcements = Announcement::filter(request(['search', 'admin']))->latest()->paginate(6)->withQueryString();

        $data = [
            'title' => 'Daftar Pengumuman',
            'announcements' => $announcements
            
        ];

        return view('admin/announcement/index', $data);
    }

    public function announcementForm($slug = null)
    {
        $announcementBySlug = $slug ? Announcement::where('slug', $slug)->firstOrFail() : null;

        $data = [
            'title' => $announcementBySlug ? 'Form Ubah Pengumuman' : 'Form Tambah Pengumuman',
            'announcementBySlug' => $announcementBySlug,
        ];

        return view('admin/announcement/form', $data);
    }


    public function save(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2560', 
        ], [
            'title.required' => 'Judul harus diisi.',
            'content.required' => 'Isi pengumuman harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);

        $slug = Str::slug($request->input('title'));
        $existingSlugCount = \App\Models\Announcement::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        
         // Tangani file gambar
         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/announcement/announcementImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

        $author_id = Auth::id();
        
        $announcement = new Announcement();
 
        $announcement->slug = $slug;
        $announcement->title = $validatedData['title'];
        $announcement->content =  $request->input('content');
        $announcement->author_id = $author_id;
        $announcement->seen = 0;
        $announcement->image = $fileName;

        $announcement->save();

        return redirect()->route('show.announcements')->with('success', 'Data Berhasil Ditambahkan.');
    }


    public function update(Request $request, $slug)
    {

        
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|image|max:2560',
        ], [
            'title.required' => 'Judul harus diisi.',
            'content.required' => 'Isi pengumuman harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);


        $announcementBySlug = Announcement::where('slug', $slug)->firstOrFail();

        $author_id = Auth::id();
 
        $slug = Str::slug($validatedData['title']);
        $existingSlugCount = \App\Models\Announcement::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        $announcementBySlug->slug = $slug;
        $announcementBySlug->title = $validatedData['title'];
        $announcementBySlug->content =  $request->input('content');
        $announcementBySlug->author_id = $author_id;

        // Tangani file gambar
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/announcement/announcementImg/' . $fileName;

            if ($announcementBySlug->image && $announcementBySlug->image !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/announcement/announcementImg/' . $announcementBySlug->image);
            }

            Storage::disk('public')->put($path, file_get_contents($file));

            $announcementBySlug->image = $fileName;
        } else {
            $announcementBySlug->image = $announcementBySlug->image ?? 'default.png';
        }
 
        $announcementBySlug->save();

        return redirect()->route('show.announcements')->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function delete($slug)
    {
            $announcementBySlug = Announcement::where('slug', $slug)->firstOrFail();

            if (!empty($announcementBySlug->image) && $announcementBySlug->image !== 'default.png') {
                $filePath = 'images/publicImg/announcement/announcementImg/' . $announcementBySlug->image;
                Storage::disk('public')->delete($filePath);
            }

            $announcementBySlug->delete();

        return redirect()->route('show.announcements')->with('success', 'Pengumuman berhasil dihapus.');
    }



}
