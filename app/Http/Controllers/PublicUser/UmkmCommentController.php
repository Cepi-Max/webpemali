<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Umkm;
use App\Models\UmkmComment;
use Illuminate\Http\Request;

class UmkmCommentController extends Controller
{
    // CommentController.php
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'umkm_id' => 'required|exists:umkm,id',  
            'content' => 'required|string', 
        ]);

        $umkm = Umkm::findOrFail($request->umkm_id);

        // Simpan komentar ke dalam database
        UmkmComment::create([
            'umkm_id' => $umkm->id,
            'user_id' => auth()->id(), 
            'content' => $request->content,
        ]);

        // Kembali ke halaman artikel yang dikomentari
        return back()->with('success', 'Komentar berhasil dikirim!');
    }

}
