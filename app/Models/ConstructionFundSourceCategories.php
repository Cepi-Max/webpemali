<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConstructionFundSourceCategories extends Model
{
    use HasFactory;

    public function constructions(): HasMany
    {
        return $this->hasmany(Construction::class);
    }
}
