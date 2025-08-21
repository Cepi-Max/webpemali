<?php

// app/Models/RatingPelayanan.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingPelayanan extends Model
{
    use HasFactory;

    protected $table = 'rating_pelayanan';

    protected $fillable = [
        'pengajuan_surat_id',
        'user_id',
        'rating',
        'komentar',
    ];

    public function pengajuan()
    {
        return $this->belongsTo(Surat::class, 'pengajuan_surat_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
