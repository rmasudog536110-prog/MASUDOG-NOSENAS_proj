<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 
use App\Models\UserProgress; 
use App\Models\UserSubscription;
use App\Models\WorkoutLog;
use App\Models\TrainingProgram;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Redirect admins and managers to admin dashboard
        if ($user->hasAdminAccess()) {
            return redirect()->route('admin.dashboard');
        }

        // Redirect instructors to instructor dashboard
        if ($user->isInstructor()) {
            return redirect()->route('instructor.dashboard');
        }

        // Get latest subscription
        $userSubscription = UserSubscription::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->first();

        // If subscription exists and payment is pending, show pending dashboard
        if ($userSubscription && $userSubscription->status === 'pending') {
            return view('index.pending_dashboard');
        }

        $subscriptionExpiry = $userSubscription ? $userSubscription->end_date : null;
        
        if ($userSubscription) {
            if ($userSubscription->status === 'rejected') {
                $subscriptionStatus = 'rejected';
                $daysLeft = 0;
            } 
            
            elseif ($userSubscription->status === 'approved') {
                if ($subscriptionExpiry && $subscriptionExpiry->isPast()) {
                    $subscriptionStatus = 'expired';
                    $daysLeft = 0;
                } else {
                    $subscriptionStatus = 'active';
                    $daysLeft = $subscriptionExpiry 
                        ? max(0, round(now()->diffInHours(\Carbon::parse($subscriptionExpiry)) / 24, 0))
                        : 0;
                }
            } else {
                $subscriptionStatus = 'none';
                $daysLeft = 0;
            }
        } else {
            $subscriptionStatus = 'none';
            $daysLeft = 0;
        }

        // Get workout statistics
        $workoutStats = [
            'total_workouts' => $user->workoutLogs()->count(),
            'weekly_workouts' => $user->workoutLogs()
                ->where('workout_date', '>=', now()->subWeek())
                ->count(),
            'days_active' => $user->workoutLogs()
                ->distinct('workout_date')
                ->count('workout_date')
        ];

        // Get recent activities
        $recentActivities = $user->workoutLogs()
            ->with(['exercise', 'trainingProgram'])
            ->latest('workout_date')
            ->take(5)
            ->get()
            ->map(function($log) {
                return [
                    'exercise_name' => $log->exercise->name ?? null,
                    'program_title' => $log->trainingProgram->title ?? null,
                    'sets_completed' => $log->sets,
                    'reps_completed' => $log->reps,
                    'weight_used' => $log->weight,
                    'workout_date' => $log->workout_date,
                    'duration_minutes' => $log->duration_minutes,
                ];
            })
            ->toArray();

        $subscriptionHistory = $user->subscriptions()->latest()->get()->toArray();

        return view('index.dashboard', compact(
            'userSubscription',
            'subscriptionStatus',
            'subscriptionExpiry',
            'daysLeft',
            'workoutStats',
            'recentActivities',
            'subscriptionHistory'
        ));
    }


}
