<?php

namespace App\Http\Controllers;

use DomDocument;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::filter(request(['search', 'category', 'admin', 'author']))->latest()->paginate(6)->withQueryString();

        // Mengambil semua data article dari database
        $data = [
            'title' => 'Daftar artikel',
            'articles' => $articles
            
        ];

        // Mengirim data posts ke view 'index'
        return view('admin/article/index', $data);
    }

    public function articleForm($slug = null)
    {
        $articleBySlug = $slug ? Article::where('slug', $slug)->firstOrFail() : null;
        $categories = ArticleCategory::all();

        $data = [
            'title' => $articleBySlug ? 'Form Ubah Artikel' : 'Form Tambah Artikel',
            'categories' => $categories,
            'articleBySlug' => $articleBySlug,
        ];

        return view('admin/article/form', $data);
    }


    public function save(Request $request): RedirectResponse
    {

        $validatedData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'inovator' => 'required',
            'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'title.required' => 'Judul harus diisi.',
            'body.required' => 'Isi artikel harus diisi.',
            'category.required' => 'Kategori artikel harus diisi.',
            'inovator.required' => 'Penulis harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);

    
        // Tangani Slug
        $slug = Str::slug($request->input('title'));
        $existingSlugCount = \App\Models\Article::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        
    
         if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image'); 
            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path   = 'images/publicImg/article/articleImg/'.$fileName;
            Storage::disk('public')->put($path, file_get_contents($file));
         } else {
             $fileName = 'default.png';
         }

        $author_id = Auth::id();
        
        $article = new Article;
 
        $slug = Str::slug($validatedData['title']);
        $existingSlugCount = \App\Models\Article::where('slug', 'LIKE', "{$slug}%")->count();

        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }
        $article->slug = $slug;

        $article->title = $validatedData['title'];

        $newBody = $this->processBodyImages($request->input('body'));
        $article->body = $newBody;
        $article->article_category_id = $request->input('category');
        $article->author_id = $author_id;
        $article->inovator = $validatedData['inovator'];
        $article->seen = 0;
        $article->image = $fileName;

        $article->save();

        return redirect()->route('show.articles')->with('success', 'Data Berhasil Ditambahkan.');
    }


    public function update(Request $request, $slug)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'category' => 'required',
            'inovator' => 'required',
            'image' => 'nullable|image|max:2560', // File harus berupa gambar dengan ukuran maksimal 2.5MB
        ], [
            'title.required' => 'Judul harus diisi.',
            'body.required' => 'Isi artikel harus diisi.',
            'category.required' => 'Kategori artikel harus diisi.',
            'inovator.required' => 'Penulis harus diisi.',
            'image.image' => 'File harus berupa gambar.',
            'image.max' => 'Ukuran gambar tidak boleh lebih dari 2,5 MB.',
        ]);

        
        $articleBySlug = Article::where('slug', $slug)->firstOrFail();

        $author_id = Auth::id();
 
        $slug = Str::slug($validatedData['title']);
        
        $articleBySlug->slug = $slug;

        $articleBySlug->title = $validatedData['title'];

        $oldBody = $articleBySlug->body;
        $oldImages = $this->extractImagesFromHtml($oldBody);

        // Proses body baru (Summernote body) dari request
        $newBody = $this->processBodyImages($request->body);

        // Ambil semua gambar dari body baru setelah di-proses
        $newImages = $this->extractImagesFromHtml($newBody);

        // Cari gambar lama yang sudah tidak dipakai di body baru
        $deletedImages = array_diff($oldImages, $newImages);
        foreach ($deletedImages as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
        }
        
        $articleBySlug->body =  $newBody;
        $articleBySlug->article_category_id = $request->input('category');
        $articleBySlug->author_id = $author_id;
        $articleBySlug->inovator = $validatedData['inovator'];
        $articleBySlug->seen = 0;

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');

            $fileName = now()->format('Y-m-d_H-i-s') . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            $path = 'images/publicImg/article/articleImg/' . $fileName;

            if ($articleBySlug->image && $articleBySlug->image !== 'default.png') {
                Storage::disk('public')->delete('images/publicImg/article/articleImg/' . $articleBySlug->image);
            }

            // Simpan gambar baru
            Storage::disk('public')->put($path, file_get_contents($file));

            // Simpan nama file baru ke dalam database
            $articleBySlug->image = $fileName;
        } else {
            // Jika tidak ada file baru, gunakan gambar lama atau default.png
            $articleBySlug->image = $articleBySlug->image ?? 'default.png';
        }
 
        $articleBySlug->save();

        return redirect()->route('show.articles')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function delete($slug)
    {
        // try {
            $articleBySlug = Article::where('slug', $slug)->firstOrFail();

            $bodyImages = $this->extractImagesFromHtml($articleBySlug->body) ?? [];

            foreach ($bodyImages as $imagePath) {
                if (Storage::disk('public')->exists($imagePath)) {
                    Storage::disk('public')->delete($imagePath);
                }
            }

            if (!empty($articleBySlug->image) && $articleBySlug->image !== 'default.png') {
                $filePath = 'images/publicImg/article/articleImg/' . $articleBySlug->image;
                Storage::disk('public')->delete($filePath);
            }

            $articleBySlug->delete();

        //     return response()->json(['message' => 'Artikel berhasil dihapus.'], 200);
        // } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        //     return response()->json(['message' => 'Artikel tidak ditemukan.'], 404);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Terjadi kesalahan saat menghapus artikel.'], 500);
        // }

        return redirect()->route('show.articles')->with('success', 'Artikel berhasil dihapus!');
    }


    // Fungsi Untuk Summernote
    private function processBodyImages($body)
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($body, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($dom->getElementsByTagName('img') as $key => $img) {
            $src = $img->getAttribute('src');

            // Kalau dia base64, proses simpan ke storage
            if (preg_match('/^data:image\/(\w+);base64,/', $src, $type)) {
                $data = substr($src, strpos($src, ',') + 1);
                $data = base64_decode($data);

                $extension = strtolower($type[1]) === 'jpeg' ? 'jpg' : strtolower($type[1]);
                $fileName = time() . $key . '.' . $extension;
                $path = 'images/publicImg/article/bodyImg/' . $fileName;

                Storage::disk('public')->put($path, $data);

                // Replace src-nya jadi link ke storage
                $img->setAttribute('src', asset('storage/' . $path));
            }
        }

        return $dom->saveHTML();
    }
    private function extractImagesFromHtml($html)
    {
        $images = [];
        $dom = new DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML($html, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        foreach ($dom->getElementsByTagName('img') as $img) {
            $src = $img->getAttribute('src');

            // Cek kalau dia pakai storage
            if (strpos($src, asset('storage/')) !== false) {
                // Ambil path relative storage pakai parse_url
                $path = parse_url($src, PHP_URL_PATH); // contoh hasil: /storage/images/publicImg/article/bodyImg/abc.png

                // Hapus "/storage/" di depannya supaya cocok sama Storage::disk('public')
                $relativePath = ltrim(str_replace('/storage/', '', $path), '/');

                $images[] = $relativePath;
            }
        }
        return $images;
    }


}
