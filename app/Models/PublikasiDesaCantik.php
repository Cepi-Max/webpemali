<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class PublikasiDesaCantik extends Model
{
    protected $table = 'publikasi_desa_cantik';
    protected $fillable = ['slug', 'judul', 'user_id', 'cover', 'jadwal_rilis', 'status_rilis', 'file_publikasi'];
    protected $with = ['user'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('title', 'like', '%' . request('search') . '%')
        );
    }
}
