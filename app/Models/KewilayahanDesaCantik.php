<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class KewilayahanDesaCantik extends Model
{
    //
    protected $table = 'kewilayahan_desa_cantik';
    protected $fillable = ['nama_fasilitas', 'kewilayahan_kategori_id', 'latitude', 'longitude'];


    function kewilayahan_kategori()
    {
        return $this->belongsTo(KewilayahanKategori::class);
    }

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('nama_fasilitas', 'like', "%{$search}%")
        );

        $query->when($filter['kategori'] ?? false,
            fn($q, $catId) => $q->whereHas('kewilayahan_kategori', 
                fn($q2) => $q2->where('id', $catId)
            )
        );
    }
}
