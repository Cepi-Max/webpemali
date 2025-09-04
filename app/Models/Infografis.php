<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Infografis extends Model
{
    //
    protected $table = 'infografis';
    protected $fillable = ['judul', 'deskripsi', 'file_infografis'];

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('judul', 'like', '%' . request('search') . '%')
        );
    }
}
