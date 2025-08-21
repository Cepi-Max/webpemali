<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UmkmCertification extends Model
{
    protected $table = 'umkm_certification';
    protected $fillable = ['name', 'slug'];

    // Many-to-Many ke UMKM
    public function umkms()
    {
        return $this->belongsToMany(Umkm::class, 'umkm_certificate', 'certificate_id', 'umkm_id');
    }
}
