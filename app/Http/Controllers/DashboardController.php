<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserSubscription;
use App\Models\PaymentTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) abort(403, 'Unauthorized');

        $userSubscription = UserSubscription::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->first();

        $plan = $userSubscription?->plan;
        $payment = $userSubscription ? PaymentTransaction::where('subscription_id', $userSubscription->id)->latest()->first() : null;
        $paymentStatus = $payment?->status ?? 'none';

        $subscriptionExpiry = $userSubscription?->end_date ? Carbon::parse($userSubscription->end_date) : null;
        $daysLeft = $subscriptionExpiry ? max(0, now()->diffInDays($subscriptionExpiry, false)) : 0;

        $daysLeft = intval($daysLeft);

        $subscriptionStatus = match ($paymentStatus) {
            'failed' => 'payment_failed',
            'approved', 'completed' => $subscriptionExpiry && $subscriptionExpiry->isPast() ? 'expired' : 'active',
            'pending' => 'pending',
            default => 'none',
        };

        $workoutStats = [
            'total_workouts' => $user->workoutLogs()?->count() ?? 0,
            'weekly_workouts' => $user->workoutLogs()?->where('workout_date', '>=', now()->subWeek())->count() ?? 0,
            'days_active' => $user->workoutLogs()?->distinct('workout_date')->count('workout_date') ?? 0,
        ];

        $recentActivities = $user->workoutLogs()?->with(['exercise', 'trainingProgram'])->latest('workout_date')->take(5)->get() ?? collect();

        return view('index.user_dashboard', compact(
            'user', 'userSubscription', 'subscriptionStatus', 'subscriptionExpiry',
            'daysLeft', 'plan', 'payment', 'workoutStats', 'recentActivities'
        ));
    }
}
