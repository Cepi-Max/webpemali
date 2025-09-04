<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ppid extends Model
{
    //
    protected $table = 'ppid';
    protected $fillable = ['profil', 'visi', 'misi', 'gambar_depan_ppid', 'gambar_struktur_organisasi', 'regulasi_ppid', "file_regulasi", 'maklumat', 'alamat', 'kontak', 'status'];
}
