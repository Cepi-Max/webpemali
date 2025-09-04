<?php

namespace App\Models\Pelayanan;

use Illuminate\Database\Eloquent\Model;

class BerkasPengajuan extends Model
{
    protected $table = 'berkas_pengajuan';
    protected $fillable = [
        'jenis_surat_id',
        'syarat_dokumen_id',
        'status_validasi',
        'catatan',
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

