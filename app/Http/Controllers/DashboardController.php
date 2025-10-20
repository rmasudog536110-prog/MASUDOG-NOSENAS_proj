<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
public function index()
{
    $user = Auth::user();

    $userSubscription = $user->subscription; // Make sure this relationship exists
    $subscriptionStatus = $userSubscription ? $userSubscription->status : null;
    $subscriptionExpiry = $userSubscription ? Carbon::parse($userSubscription->end_date) : null;
    $daysLeft = $subscriptionExpiry ? $subscriptionExpiry->diffInDays(Carbon::now()) : 0;

    $workoutStats = [
        'total_workouts' => $user->workouts()->count(),
        'weekly_workouts' => $user->workouts()->where('created_at', '>=', now()->subWeek())->count(),
        'days_active' => $user->workouts()->distinct('date')->count('date')
    ];

    $recentActivities = $user->workouts()->latest()->take(5)->get()->toArray();
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
