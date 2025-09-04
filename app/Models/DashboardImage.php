<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardImage extends Model
{
    protected $table = 'dashboard_image';
    protected $fillable = ['bannerImg', 'link'];
    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
