<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Carbon\Carbon; 
use App\Models\UserProgress; 
use App\Models\UserSubscription;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

    $userSubscription = UserSubscription::where('user_id', Auth::id())
        ->with('plan')
        ->latest()
        ->first();

        $subscriptionExpiry = $userSubscription ? $userSubscription->end_date : null;   
        $subscriptionStatus = $subscriptionExpiry->isPast() ? 'expired' : 'active';
        $daysLeft = round(now()->diffInHours($subscriptionExpiry) / 24, 0);
        
        $workoutStats = [
            'total_workouts' => $user->progress()->count(),
            'weekly_workouts' => $user->progress()->where('workout_date', '>=', now()->subWeek())->count(),
            'days_active' => $user->progress()->distinct('workout_date')->count('workout_date')
        ];


        $recentActivities = $user->progress()->latest()->take(5)->get()->toArray();
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
