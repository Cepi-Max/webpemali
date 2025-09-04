<?php

namespace App\Models\Pelayanan;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function dokumenSurat()
    {
        return $this->hasMany(DokumenSurat::class);
    }

    /**
     * Relasi ke model JenisSurat
     */
    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class);
    }

    /**
     * Relasi ke model User (atau Penduduk jika kamu pakai itu)
     */
    public function pemohon()
    {
        return $this->belongsTo(User::class, 'pemohon_id');
        // atau:
        // return $this->belongsTo(Penduduk::class, 'pemohon_id');
    }
}
