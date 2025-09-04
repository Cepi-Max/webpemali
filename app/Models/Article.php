<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Article extends Model
{

    use HasFactory;

    protected $fillable = ['slug', 'title', 'body', 'image', 'inovator', 'seen'];
    protected $with = ['author', 'article_category'];

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
            $query->where('title', 'like', "%{$search}%")
        );

        $query->when($filter['category'] ?? false, 
        fn($query, $article_category)=>
            $query->whereHas('article_category', fn($query)=>$query->where('slug', $article_category))
        );

        $query->when($filter['admin'] ?? false, 
        fn($query, $author)=>
            $query->whereHas('author', fn($query)=>$query->where('name', $author))
        );

        $query->when($filter['author'] ?? false, 
            fn($query, $inovator) =>
                $query->where('inovator', $inovator)
        );
    }

}
