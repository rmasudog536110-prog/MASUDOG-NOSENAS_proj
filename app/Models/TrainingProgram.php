<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TrainingProgram extends Model
{

    protected $fillable = [
        'title',
        'description',
        'level',
        'duration_weeks',
        'workout_counts',
        'equipment_required',
        'is_active',
    ];


    protected $casts = [
        'description' => 'array',
        'is_active' => 'boolean',
    ];

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class, 'program_id');
    }
}
