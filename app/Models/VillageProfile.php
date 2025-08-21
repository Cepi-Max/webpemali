<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VillageProfile extends Model
{
    protected $fillable = ['nama_desa', 'visi', 'misi', 'sejarah', 'batas_utara', 'batas_selatan', 'batas_timur', 'batas_barat', 'alamat', 'kode_pos', 'luas_desa', 'sejarah_image'];
    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    
}
