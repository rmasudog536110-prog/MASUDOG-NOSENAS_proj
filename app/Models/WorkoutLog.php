<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutLog extends Model
{
    protected $fillable = [
        'user_id',
        'exercise_id',
        'training_program_id',
        'workout_date',
        'sets',
        'reps',
        'weight',
        'duration_minutes',
        'distance',
        'calories_burned',
        'notes',
        'difficulty',
        'rating',
    ];

    protected $casts = [
        'workout_date' => 'date',
        'weight' => 'decimal:2',
        'distance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function trainingProgram(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class);
    }

    /**
     * Get formatted workout summary
     */
    public function getSummary(): string
    {
        $parts = [];
        
        if ($this->exercise) {
            $parts[] = $this->exercise->name;
        }
        
        if ($this->sets && $this->reps) {
            $parts[] = "{$this->sets} sets × {$this->reps} reps";
        }
        
        if ($this->weight) {
            $parts[] = "{$this->weight}kg";
        }
        
        if ($this->duration_minutes) {
            $parts[] = "{$this->duration_minutes} min";
        }
        
        return implode(' • ', $parts) ?: 'Workout';
    }
}
