<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SyaratTipeSelectModel extends Model
{
    //
    protected $table ='syarat_tipe_select_options';
    protected $fillable = ['syarat_dokumen_id', 'opsi'];
}
