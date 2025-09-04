<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    protected $table = 'jenis_surat';
    protected $fillable = ['slug', 'nama', 'deskripsi'];

    public function syaratDokumen()
    {
        return $this->belongsToMany(SyaratDokumen::class, 'jenis_surat_syarat')
                    ->withPivot('wajib')->withTimestamps();
    }
}
