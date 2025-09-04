<?php

namespace App\Http\Controllers\PublicUser;

use App\Http\Controllers\Controller;
use App\Models\Ppid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpidControllerPublic extends Controller
{
    //
    function index()
    {
        $ppidData = Ppid::get();
 
        $data = [
            'title' => 'PPID Desa Pemali',
            'ppidData' => $ppidData,
        ];

        return view('public-user.ppid.index', $data);
    }

    public function previewRegulasi(Ppid $ppid)
    {
        $filePath = 'pdf/ppid/' . $ppid->file_regulasi;

        // Cek apakah file ada
        if (!$ppid->file_regulasi || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File regulasi tidak ditemukan.');
        }

        // Ambil file dari storage
        $file = Storage::disk('public')->get($filePath);
        $mimeType = Storage::disk('public')->mimeType($filePath);

        return response($file, 200)->header('Content-Type', $mimeType);
    }


    public function downloadRegulasi(Ppid $ppid)
    {
        $filePath = 'pdf/ppid/' . $ppid->file_regulasi;

        // Cek apakah file ada di storage
        if (!$ppid->file_regulasi || !Storage::disk('public')->exists($filePath)) {
            return back()->with('error', 'File regulasi tidak ditemukan.');
        }

        // Kasih nama file saat di-download (biar user lebih ngerti)
        $fileName = 'Regulasi_PPID_Desa_' . now()->format('YmdHis') . '.' . pathinfo($filePath, PATHINFO_EXTENSION);

        return Storage::disk('public')->download($filePath, $fileName);
    }
}
