<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KewilayahanKategori extends Model
{
    //
    protected $table = 'kewilayahan_kategori';
    protected $fillable = ['nama_kategori'];

    function kewilayahan_desa_cantik()
    {
        return $this->hasMany(KewilayahanDesaCantik::class);
    }
}
