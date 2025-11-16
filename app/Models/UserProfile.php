<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfile extends Model
{
    use HasFactory;

    /**
     * The table associated with the model (optional if table name is user_profiles)
     */
    protected $table = 'user_profile';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'profile_picture',
        'date_of_birth',
        'gender',
        'bio',
        'height',
        'weight',
        'fitness_goal',
        'experience_level',
        'email_notifications',
        'sms_notifications',
        'last_login_at',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'last_login_at' => 'datetime',
        'email_notifications' => 'boolean',
        'sms_notifications' => 'boolean',
        'height' => 'decimal:2',
        'weight' => 'decimal:2',
    ];

    /**
     * Get the user that owns this profile
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
