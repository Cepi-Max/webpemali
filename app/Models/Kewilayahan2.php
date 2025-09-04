<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Kewilayahan2 extends Model
{
    protected $table = 'kewilayahan2';
    protected $fillable = [
        'nama_dusun',
        'koordinat',
        'warna',
    ];

    // otomatis cast ke array saat dipanggil
    protected $casts = [
        'koordinat' => 'array',
    ];

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('nama_dusun', 'like', "%{$search}%")
        );
    }
}
