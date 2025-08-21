<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotifikasiController extends Controller
{
    //
    public function index()
    {
        $notifikasi = Notifikasi::orderBy('created_at', 'desc')
                ->take(5)
                ->get();
         $data = [
            'title' => 'Semua Notifikasi',
            'notifikasi' => $notifikasi
         ];

        return view('admin-submission-letter.notifikasi.index', $data);
    }
}
