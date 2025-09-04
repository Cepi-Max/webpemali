<?php

namespace App\Models;

use App\Models\UmkmCertification;
use App\Models\UmkmComment;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Umkm extends Model
{
    use HasFactory;
    protected $table = 'umkm';
    protected $fillable = ['slug', 'umkm_name', 'owner_name', 'gender', 'address', 'email', 'number_phone', 'latitude', 'longitude'];
    protected $with = ['author', 'umkm_sector', 'umkm_certification'];

    // Many-to-Many ke sertifikasi
    public function certifications()
    {
        return $this->belongsToMany(UmkmCertification::class, 'umkm_certificate', 'umkm_id', 'certificate_id');
    }
    
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function umkm_comments() {
        return $this->hasMany(UmkmComment::class);
    }
    
    public function umkm_sector(): BelongsTo
    {
        return $this->belongsTo(UmkmSector::class, 'sector_id');
    }

    public function umkm_certification(): BelongsTo
    {
        return $this->belongsTo(UmkmCertification::class);
    }

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('umkm_name', 'like', '%' . request('search') . '%')
        );

        $query->when($filter['umkm_sector'] ?? false, 
        fn($query, $umkm_sector)=>
            $query->whereHas('umkm_sector', fn($query)=>$query->where('slug', $umkm_sector))
        );
    }
}
