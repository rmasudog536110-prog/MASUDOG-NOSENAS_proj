<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\UserProfile;
use App\Models\UserSubscription;
use App\Models\UserProgress;
use App\Models\PaymentTransaction;
use App\Models\WorkoutLog;
use App\Models\ProgramEnrollment;
use App\Models\BodyMeasurement;
use App\Models\InstructorRequest;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * Mass assignable attributes for the user table
     */
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'is_active',
    ];

    /**
     * Attributes hidden for serialization
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Attribute casting
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    /**
     * Relationships
     */

    // One-to-one: user profile
    public function profile(): HasOne
    {
        return $this->hasOne(UserProfile::class);
    }

    // One-to-many: subscriptions
    public function subscriptions(): HasMany
    {
        return $this->hasMany(UserSubscription::class);
    }

    public function progress(): HasMany
    {
        return $this->hasMany(UserProgress::class);
    }

    public function enrollments()
    {
        return $this->hasMany(ProgramEnrollment::class, 'user_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    public function workoutLogs(): HasMany
    {
        return $this->hasMany(WorkoutLog::class);
    }

    public function bodyMeasurements(): HasMany
    {
        return $this->hasMany(BodyMeasurement::class);
    }

    // Instructor-specific relationships
    public function instructorRequests(): HasMany
    {
        return $this->hasMany(InstructorRequest::class, 'instructor_id');
    }

    public function customerRequests(): HasMany
    {
        return $this->hasMany(InstructorRequest::class, 'customer_id');
    }

    /**
     * Helper methods
     */

    public function getAge(): ?int
    {
        return $this->profile && $this->profile->date_of_birth
            ? $this->profile->date_of_birth->age
            : null;
    }

    public function getBMI(): ?float
    {
        if ($this->profile && $this->profile->height && $this->profile->weight) {
            $heightInMeters = $this->profile->height / 100;
            return round($this->profile->weight / ($heightInMeters * $heightInMeters), 2);
        }
        return null;
    }

    public function getBMICategory(): ?string
    {
        $bmi = $this->getBMI();
        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }

    /**
     * Role check helpers
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isStaff(): bool
    {
        return in_array($this->role, ['staff', 'manager', 'admin']);
    }

    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    public function hasAdminAccess(): bool
    {
        return $this->role === 'admin';
    }

    
}
