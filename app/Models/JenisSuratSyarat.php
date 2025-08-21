<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSuratSyarat extends Model
{
    protected $table = 'jenis_surat_syarat';
    protected $fillable = [
        'jenis_surat_id',
        'syarat_dokumen_id',
        'wajib',
    ];

    public function dokumen()
    {
        return $this->belongsTo(SyaratDokumen::class, 'syarat_dokumen_id');
    }

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }
    
}

