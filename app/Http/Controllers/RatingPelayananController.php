<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RatingPelayanan;
use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingPelayananController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'pengajuan_surat_id' => 'required|exists:surat,id',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
        ]);

        $pengajuan = Surat::find($request->pengajuan_surat_id);
        if ($pengajuan->rating) {
            return back()->with('error', 'Rating sudah diberikan!');
        }

        $user_id = Auth::id();

        RatingPelayanan::create([
            'pengajuan_surat_id' => $pengajuan->id,
            'user_id' => $user_id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return back()->with('success', 'Terima kasih atas penilaiannya!');
    }

}
