<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramEnrollment extends Model
{
    protected $fillable = [
        'user_id',
        'program_id',
        'enrolled_at',
        'completed_at',
        'status',
        'completed_days',
        'progress',
        'last_activity',
    ];

    protected $casts = [
        'completed_days' => 'array',
        'enrolled_at' => 'date',
        'completed_at' => 'date',
        'last_activity' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(TrainingProgram::class, 'program_id');
    }
}
