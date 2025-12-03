<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Ensure $user is valid
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $userSubscription = UserSubscription::where('user_id', $user->id)
            ->with('plan')
            ->latest()
            ->first();

        if (!$userSubscription) {
            return view('index.dashboard', [
                'user' => $user,
                'subscriptionStatus' => 'none',
                'userSubscription' => null,
                'plan' => null,
                'payment' => null,
                'daysLeft' => 0,
                'subscriptionExpiry' => null,
                'workoutStats' => [
                    'total_workouts' => 0,
                    'weekly_workouts' => 0,
                    'days_active' => 0
                ],
                'recentActivities' => collect()
            ]);
        }

        $payment = PaymentTransaction::where('subscription_id', $userSubscription->id)
            ->latest()
            ->first();

        $paymentStatus = $payment?->status ?? 'none';

        $subscriptionExpiry = Carbon::parse($userSubscription->end_date);
        $daysLeft = max(0, now()->diffInDays($subscriptionExpiry, false));

        $subscriptionStatus = match ($paymentStatus) {
            'failed' => 'payment_failed',
            'approved', 'completed' => $subscriptionExpiry->isPast() ? 'expired' : 'active',
            'pending' => 'pending',
            default => 'null',
        };

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

        return view('index.dashboard', compact(
            'user',
            'userSubscription',
            'subscriptionStatus',
            'subscriptionExpiry',
            'daysLeft',
            'plan',
            'payment',
            'workoutStats',
            'recentActivities'
        ));
    }
}
