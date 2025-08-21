<?php

namespace App\Models\Pelayanan;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DokumenSurat extends Model
{
    use HasFactory;

    protected $table = 'dokumen_surat';

    protected $fillable = [
        'surat_id',
        'syarat_dokumen_id',
        'file_path',
        'keterangan',
    ];

    /**
     * Relasi ke model Surat
     */
    public function surat()
    {
        return $this->belongsTo(Surat::class);
    }

    /**
     * Relasi ke model SyaratDokumen
     */
    public function syarat()
    {
        return $this->belongsTo(SyaratDokumen::class, 'syarat_dokumen_id');
    }

}
