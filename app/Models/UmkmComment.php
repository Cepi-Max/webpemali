<?php

namespace App\Models;

use App\Models\Umkm;
use Illuminate\Database\Eloquent\Model;

// Comment.php
class UmkmComment extends Model
{
    protected $fillable = ['umkm_id', 'user_id', 'content'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function umkm() {
        return $this->belongsTo(Umkm::class);
    }
}

