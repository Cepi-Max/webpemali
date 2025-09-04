<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Surat extends Model
{
    use HasFactory;

    protected $table = 'surat';

    protected $fillable = [
        'jenis_surat_id',
        'pemohon_id',
        'tanggal_pengajuan',
        'status',
    ];

     public function rating()
    {
        return $this->hasOne(RatingPelayanan::class, 'pengajuan_surat_id');
    }
    
    /**
     * Relasi ke model JenisSurat
     */
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    public function dokumenSurat()
    {
        return $this->hasMany(DokumenSurat::class);
    }


    /**
     * Relasi ke model User (atau Penduduk jika kamu pakai itu)
     */
    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
    }

}
