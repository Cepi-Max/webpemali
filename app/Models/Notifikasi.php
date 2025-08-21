<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    //
    protected $table = 'notifikasis';
    protected $fillable = ['pengaju_id', 'pengajuan_surat_id', 'jenis_surat_id', 'pesan', 'dibaca'];
}
