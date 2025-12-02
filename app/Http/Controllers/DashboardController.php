<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;
use App\Models\WorkoutLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $user = $user->role['customer'] ?? $user;

        $userSubscription = UserSubscription::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->first();

        if (!$userSubscription) {
            return view('index.dashboard', [
                'subscriptionStatus' => 'none',
                'userSubscription' => null,
                'plan' => null,
                'payment' => null,
                'daysLeft' => 0,
                'subscriptionExpiry' => null
            ]);
        }

        $payment = PaymentTransaction::where('subscription_id', $userSubscription->id)
            ->latest()
            ->first();

        $paymentStatus = $payment?->status ?? 'none';

        $subscriptionExpiry = Carbon::parse($userSubscription->end_date);
        $daysLeft = now()->diffInDays($subscriptionExpiry, false);
        if ($daysLeft < 0) $daysLeft = 0;

        $daysLeft = intval($daysLeft);

        $subscriptionStatus = 'null';

        if ($paymentStatus === 'failed') {
            $subscriptionStatus = 'payment_failed';
        } elseif ($paymentStatus === 'approved' || $paymentStatus === 'completed') {
            $subscriptionStatus = $subscriptionExpiry->isPast() ? 'expired' : 'active';
        } elseif ($paymentStatus === 'pending') {
            $subscriptionStatus = 'pending';
        } else {
            $subscriptionStatus = 'null';
        }

        $plan = $userSubscription->plan;

        $workoutStats = [
            'total_workouts' => $user->workoutLogs()->count(),
            'weekly_workouts' => $user->workoutLogs()
                ->where('workout_date', '>=', now()->subWeek())
                ->count(),
            'days_active' => $user->workoutLogs()
                ->distinct('workout_date')
                ->count('workout_date'),
        ];

        $recentActivities = $user->workoutLogs()
            ->with(['exercise', 'trainingProgram'])
            ->latest('workout_date')
            ->take(5)
            ->get();

        return view('index.dashboard', [
            'user' => $user,
            'userSubscription' => $userSubscription,
            'subscriptionStatus' => $subscriptionStatus,
            'subscriptionExpiry' => $subscriptionExpiry,
            'daysLeft' => $daysLeft,
            'plan' => $plan,
            'payment' => $payment,
            'workoutStats' => $workoutStats,
            'recentActivities' => $recentActivities
        ]);
    }
}
