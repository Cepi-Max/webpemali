<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UmkmSector extends Model
{
    use HasFactory;
    protected $table = 'umkm_sector';
    protected $fillable = ['name', 'slug'];

    public function umkm_sector(): HasMany
    {
        return $this->hasmany(Umkm::class);
    }
}
