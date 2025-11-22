<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstructorRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'instructor_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'preferred_date',
        'preferred_time',
        'exercise_type',
        'goals',
        'status',
        'instructor_notes',
        'scheduled_at',
        'completed_at',
        'created_by',
    ];

    protected $casts = [
        'preferred_date' => 'date',
        'preferred_time' => 'datetime:H:i',
        'scheduled_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the customer who made this request
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    /**
     * Get the assigned instructor
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    /**
     * Get the user who created this request
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get formatted status badge
     */
    public function getStatusBadgeAttribute(): string
    {
        $badges = [
            'pending' => '<span class="badge badge-pending">⏳ Pending</span>',
            'accepted' => '<span class="badge badge-active">✅ Accepted</span>',
            'declined' => '<span class="badge badge-expired">❌ Declined</span>',
            'completed' => '<span class="badge badge-active">🎯 Completed</span>',
            'cancelled' => '<span class="badge badge-expired">🚫 Cancelled</span>',
        ];

        return $badges[$this->status] ?? '<span class="badge badge-none">Unknown</span>';
    }

    /**
     * Get preferred date/time formatted
     */
    public function getPreferredDateTimeAttribute(): string
    {
        $date = $this->preferred_date?->format('M j, Y');
        $time = $this->preferred_time?->format('g:i A');
        
        if ($date && $time) {
            return "$date at $time";
        } elseif ($date) {
            return $date;
        } elseif ($time) {
            return $time;
        }
        
        return 'Not specified';
    }

    /**
     * Check if request is actionable (can be accepted/declined)
     */
    public function isActionable(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if request can be scheduled
     */
    public function canBeScheduled(): bool
    {
        return in_array($this->status, ['pending', 'accepted']);
    }
}