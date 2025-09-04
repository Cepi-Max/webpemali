<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyaratDokumen extends Model
{
    protected $table = 'syarat_dokumen';
    protected $fillable = ['nama', 'tipe_input'];
    

    public function opsi()
    {
        return $this->hasMany(SyaratTipeSelectModel::class, 'syarat_dokumen_id');
    }

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
