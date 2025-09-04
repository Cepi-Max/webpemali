<?php

namespace App\Http\Controllers;

use App\Models\PublikasiDesaCantik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Imagick;

class PublikasiDesaCantikController extends Controller
{
    //
    function index()
    {
        $publikasiDesaCantik = PublikasiDesaCantik::filter(request(['search']))->latest()
            ->paginate(6)
            ->withQueryString();

        $data = [
            'title' => 'Publikasi Desa Cantik Desa Pemali',
            'publikasiDesaCantiks' => $publikasiDesaCantik,
        ];

        return view('admin.publikasi-desa-cantik.index', $data);
    }

    public function desaCantikForm($slug = null)
    {
        $publikasiDesaCantikBySlug = $slug ? PublikasiDesaCantik::where('slug', $slug)->firstOrFail() : null;
        $data = [
            'title' => $publikasiDesaCantikBySlug ? 'Form Ubah Publikasi Desa Cantik' : 'Form Tambah Publikasi Desa Cantik',
            'publikasiDesaCantikBySlug' => $publikasiDesaCantikBySlug
        ];

        return view('admin.publikasi-desa-cantik.form', $data);
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required',
            'jadwal_rilis' => 'required', 
            'status_rilis' => 'required', 
            'file_publikasi' => 'required|file|mimes:pdf|max:10240', 
        ],[
            'judul.required' => 'Judul harus diisi.',
            'jadwal_rilis.required' => 'Jadwal rilis harus diisi.', 
            'status_rilis.required' => 'Status rilis harus diisi.', 
            'file_publikasi.required' => 'File publikasi harus diisi.', 
        ]);

        $slug = Str::slug($request->input('judul'));
        $existingSlugCount = PublikasiDesaCantik::where('slug', 'LIKE', "{$slug}%")->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        $fileName = 'default.pdf';
        $thumbnailFileName = null;

        if ($request->hasFile('file_publikasi') && $request->file('file_publikasi')->isValid()) {
            $file = $request->file('file_publikasi');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $file->storeAs('pdf/desa-cantik', $fileName, 'public');

            // ✅ Generate cover dari halaman pertama PDF
            $pathToPdf = storage_path("app/public/pdf/desa-cantik/{$fileName}");
            $thumbnailPath = storage_path("app/public/pdf/desa-cantik/thumbnails/");
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 0755, true);
            }

            $thumbnailFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $thumbnailFullPath = $thumbnailPath . $thumbnailFileName;
            // use Imagick;
            $imagick = new Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($pathToPdf . '[0]');
            $imagick->setImageFormat('jpeg');
            $imagick->writeImage($thumbnailFullPath);
            $imagick->clear();
            $imagick->destroy();
        }

        $user_id = Auth::id();

        $publikasiDesaCantik = new PublikasiDesaCantik;
        $publikasiDesaCantik->slug = $slug;
        $publikasiDesaCantik->user_id = $user_id;
        $publikasiDesaCantik->judul = $validatedData['judul'];
        $publikasiDesaCantik->jadwal_rilis = $validatedData['jadwal_rilis'];
        $publikasiDesaCantik->status_rilis = $validatedData['status_rilis'];
        $publikasiDesaCantik->file_publikasi = $fileName;
        $publikasiDesaCantik->cover = $thumbnailFileName; // Simpan thumbnail ke kolom cover

        $publikasiDesaCantik->save();

        return redirect()->route('show.admin.desa-cantik.publikasi')->with('success', 'Publikasi Desa Cantik berhasil ditambahkan.');
    }


    public function update(Request $request, $slug)
    {
        // Validasi input
        $validatedData = $request->validate([
            'judul' => 'required',
            'jadwal_rilis' => 'required',
            'status_rilis' => 'required',
            'file_publikasi' => 'nullable|file|mimes:pdf|max:10240', // Mengizinkan file kosong
        ], [
            'judul.required' => 'Judul harus diisi.',
            'jadwal_rilis.required' => 'Jadwal rilis harus diisi.',
            'status_rilis.required' => 'Status rilis harus diisi.',
            'file_publikasi.mimes' => 'File harus berupa PDF.',
            'file_publikasi.max' => 'Ukuran file maksimal 10 MB.',
        ]);

        // Cari publikasi berdasarkan slug
        $publikasiDesaCantikBySlug = PublikasiDesaCantik::where('slug', $slug)->firstOrFail();

        // Proses file publikasi jika ada file baru
        if ($request->hasFile('file_publikasi') && $request->file('file_publikasi')->isValid()) {
            $file = $request->file('file_publikasi');
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'pdf/desa-cantik/' . $fileName;

            // Hapus file lama jika ada file baru
            if ($publikasiDesaCantikBySlug->file_publikasi && $publikasiDesaCantikBySlug->file_publikasi !== 'default.pdf') {
                // Hapus file PDF lama
                Storage::disk('public')->delete('pdf/desa-cantik/' . $publikasiDesaCantikBySlug->file_publikasi);
                // Hapus thumbnail lama jika ada
                $oldThumbnailPath = 'pdf/desa-cantik/thumbnails/' . pathinfo($publikasiDesaCantikBySlug->file_publikasi, PATHINFO_FILENAME) . '.jpg';
                if (Storage::disk('public')->exists($oldThumbnailPath)) {
                    Storage::disk('public')->delete($oldThumbnailPath);
                }
            }

            // Simpan file baru
            Storage::disk('public')->put($path, file_get_contents($file));
            $publikasiDesaCantikBySlug->file_publikasi = $fileName;

            // Generate Thumbnail (Cover) dari halaman pertama PDF
            $pathToPdf = storage_path("app/public/pdf/desa-cantik/{$fileName}");
            $thumbnailPath = storage_path("app/public/pdf/desa-cantik/thumbnails/");
            if (!file_exists($thumbnailPath)) {
                mkdir($thumbnailPath, 0755, true);
            }

            $thumbnailFileName = pathinfo($fileName, PATHINFO_FILENAME) . '.jpg';
            $thumbnailFullPath = $thumbnailPath . $thumbnailFileName;

            // Generate thumbnail menggunakan Imagick
            $imagick = new Imagick();
            $imagick->setResolution(150, 150);
            $imagick->readImage($pathToPdf . '[0]');
            $imagick->setImageFormat('jpeg');
            $imagick->writeImage($thumbnailFullPath);
            $imagick->clear();
            $imagick->destroy();
        } else {
            // Jika tidak ada file yang di-upload, biarkan file yang lama tetap ada
            $fileName = $publikasiDesaCantikBySlug->file_publikasi;
            $thumbnailFileName = $publikasiDesaCantikBySlug->cover;
        }

        // Update slug dengan memastikan tidak ada duplikat
        $slug = Str::slug($request->input('judul'));
        $existingSlugCount = PublikasiDesaCantik::where('slug', 'LIKE', "{$slug}%")
            ->where('id', '!=', $publikasiDesaCantikBySlug->id) // Pastikan tidak menghitung dirinya sendiri
            ->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        // Update data publikasi
        $publikasiDesaCantikBySlug->slug = $slug;
        $publikasiDesaCantikBySlug->judul = $validatedData['judul'];
        $publikasiDesaCantikBySlug->jadwal_rilis = $validatedData['jadwal_rilis'];
        $publikasiDesaCantikBySlug->status_rilis = $validatedData['status_rilis'];
        $publikasiDesaCantikBySlug->file_publikasi = $fileName;
        $publikasiDesaCantikBySlug->cover = $thumbnailFileName;

        // Simpan perubahan
        $publikasiDesaCantikBySlug->save();

        // Redirect ke halaman publikasi dengan pesan sukses
        return redirect()->route('show.admin.desa-cantik.publikasi')->with('success', 'Publikasi Desa Cantik berhasil diubah.');
    }

    public function delete($slug)
    {
        // Cari publikasi berdasarkan slug
        $publikasiDesaCantikBySlug = PublikasiDesaCantik::where('slug', $slug)->firstOrFail();

        // Hapus file PDF jika ada
        if (!empty($publikasiDesaCantikBySlug->file_publikasi) && $publikasiDesaCantikBySlug->file_publikasi !== 'default.pdf') {
            // Path file PDF
            $filePath = 'pdf/desa-cantik/' . $publikasiDesaCantikBySlug->file_publikasi;
            
            // Hapus file PDF dari storage
            Storage::disk('public')->delete($filePath);

            // Hapus file thumbnail terkait
            $thumbnailFileName = pathinfo($publikasiDesaCantikBySlug->file_publikasi, PATHINFO_FILENAME) . '.jpg';
            $thumbnailPath = 'pdf/desa-cantik/thumbnails/' . $thumbnailFileName;

            // Hapus thumbnail jika ada
            if (Storage::disk('public')->exists($thumbnailPath)) {
                Storage::disk('public')->delete($thumbnailPath);
            }
        }

        // Hapus data publikasi
        $publikasiDesaCantikBySlug->delete();

        // Redirect ke halaman publikasi dengan pesan sukses
        return redirect()->route('show.admin.desa-cantik.publikasi')
                        ->with('success', 'Publikasi Desa Cantik berhasil dihapus!');
    }

}
