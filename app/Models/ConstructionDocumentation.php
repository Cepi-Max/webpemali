<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConstructionDocumentation extends Model
{
    protected $fillable = ['slug', 'percentage', 'information', 'image', 'construction_id', 'author_id'];
    protected $with = ['author', 'construction'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function construction(): BelongsTo
    {
        return $this->belongsTo(Construction::class);
    }
}
