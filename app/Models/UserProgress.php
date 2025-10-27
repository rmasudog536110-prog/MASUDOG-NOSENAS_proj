<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProgress extends Model
{
    protected $table = 'user_progress';


    protected $fillable = [
        'user_id',
        'program_id',
        'exercise_id',
        'workout_date',
        'sets_completed',
        'reps_completed',
        'duration_minutes',
        'weight_used',
        'notes',
    ];


    protected $casts = [
        'workout_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }
}
