<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HistorySuratSelesai extends Model
{
     protected $fillable = [
        'surat_id',
        'file_path_selesai',
    ];

    /**
     * Relasi ke PengajuanSurat
     */
    public function pengajuan()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }
}
