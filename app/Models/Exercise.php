<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{

    protected $fillable = [
        'name',
        'description',
        'category',
        'difficulty',
        'equipment',
        'muscle_group',
        'instruction',
        'video_url',
        'img_url',
        'is_active',
        'icon',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }
}
