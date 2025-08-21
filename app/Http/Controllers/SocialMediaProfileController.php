<?php

namespace App\Http\Controllers;

use App\Models\SocialMediaProfile;
use Illuminate\Http\Request;

class SocialMediaProfileController extends Controller
{

    // view/index utama ada di Providers/AppServiceProvider.php


    public function create()
    {
        return view('admin.social-media.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'facebook' => 'nullable|url',
            'x' => 'nullable|url',
            'instagram' => 'nullable|url',
            'whatsapp' => 'nullable|url',
        ]);

        $existing = \App\Models\SocialMediaProfile::first();

        if ($existing) {
            // Update data yang sudah ada
            $existing->update($request->all());
            return redirect()->route('social-media.index')->with('success', 'Profil sosial media berhasil diperbarui.');
        } else {
            // Belum ada, simpan data baru
            \App\Models\SocialMediaProfile::create($request->all());
            return redirect()->route('social-media')->with('success', 'Profil sosial media berhasil ditambahkan.');
        }
    }

}
