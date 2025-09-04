<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DashboardImageService extends Model
{
    protected $table = 'dashboard_image_service';
    protected $fillable = ['bannerImg', 'link'];
    protected $with = ['author'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
