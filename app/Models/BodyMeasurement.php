<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BodyMeasurement extends Model
{
    protected $fillable = [
        'user_id',
        'measurement_date',
        'weight',
        'body_fat_percentage',
        'muscle_mass',
        'chest',
        'waist',
        'hips',
        'biceps_left',
        'biceps_right',
        'thigh_left',
        'thigh_right',
        'calf_left',
        'calf_right',
        'progress_photo',
        'notes',
    ];

    protected $casts = [
        'measurement_date' => 'date',
        'weight' => 'decimal:2',
        'body_fat_percentage' => 'decimal:2',
        'muscle_mass' => 'decimal:2',
        'chest' => 'decimal:2',
        'waist' => 'decimal:2',
        'hips' => 'decimal:2',
        'biceps_left' => 'decimal:2',
        'biceps_right' => 'decimal:2',
        'thigh_left' => 'decimal:2',
        'thigh_right' => 'decimal:2',
        'calf_left' => 'decimal:2',
        'calf_right' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get waist-to-hip ratio
     */
    public function getWaistToHipRatio(): ?float
    {
        if ($this->waist && $this->hips) {
            return round($this->waist / $this->hips, 2);
        }
        return null;
    }

    /**
     * Get total circumference change
     */
    public function getTotalCircumference(): ?float
    {
        $measurements = [
            $this->chest,
            $this->waist,
            $this->hips,
            $this->biceps_left,
            $this->biceps_right,
            $this->thigh_left,
            $this->thigh_right,
        ];

        $total = array_sum(array_filter($measurements));
        return $total > 0 ? round($total, 2) : null;
    }
}
