<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Announcement extends Model
{

    use HasFactory;

    protected $fillable = ['slug', 'title', 'content', 'image', 'status', 'seen'];
    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function article_category(): BelongsTo
    {
        return $this->belongsTo(ArticleCategory::class);
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
