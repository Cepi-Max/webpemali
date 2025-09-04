<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Official extends Model
{
    use HasFactory;
    
    protected $fillable = ['slug', 'name', 'address', 'gender', 'place_of_birth', 'date_of_birth', 'position', 'phone_number', 'image'];
    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('position', 'like', "%{$search}%");
        });
        
        $query->when($filter['admin'] ?? false, 
        fn($query, $author)=>
            $query->whereHas('author', fn($query)=>$query->where('name', $author))
        );
    }
}
