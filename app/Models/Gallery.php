<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gallery extends Model
{
    use HasUuids;
    use HasFactory;
    
    protected $fillable = ['id', 'title', 'information', 'image'];
    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('title', 'like', '%' . request('search') . '%')
        );

        $query->when($filter['admin'] ?? false, 
        fn($query, $author)=>
            $query->whereHas('author', fn($query)=>$query->where('name', $author))
        );
    }
}
