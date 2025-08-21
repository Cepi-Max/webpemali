<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Construction extends Model
{
    use HasFactory;

    protected $fillable = ['slug', 'title', 'government_cost', 'district_cost', 'province_cost', 'self_cost', 'total_budget', 'construction_site', 'construction_implementer', 'construction_volume', 'construction_time_period', 'period_category', 'construction_traits', 'fiscal_year', 'construction_benefits', 'information',  'fund_source_id', 'latitude', 'longitude', 'image', 'slug'];
    protected $with = ['author', 'fund_source'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fund_source(): BelongsTo
    {
        return $this->belongsTo(ConstructionFundSourceCategories::class);
    }

    public function scopeFilter(Builder $query, array $filter): void
    {
        $query->when($filter['search'] ?? false, 
        fn($query, $search)=>
            $query->where('title', 'like', '%' . request('search') . '%')
        );
    }

    public function constructionsDocumentation(): HasMany
    {
        return $this->hasmany(ConstructionDocumentation::class);
    }

}
