<?php

namespace App\Models\Pelayanan;

use Illuminate\Database\Eloquent\Model;

class SyaratDokumen extends Model
{
    protected $table = 'syarat_dokumen';
    protected $fillable = ['nama'];
    

    public function syaratDokumen()
    {
        return $this->belongsToMany(SyaratDokumen::class, 'jenis_surat_syarat')
                    ->withPivot('wajib')
                    ->withTimestamps();
    }


    public function jenisSurat()
    {
        return $this->belongsToMany(JenisSurat::class, 'jenis_surat_syarat')
                    ->withPivot('wajib')
                    ->withTimestamps();
    }

}
