<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class UserSubscriptionController extends Controller
{

    public function show()
    {
        $currentSubscription = Auth::user()->subscriptions()
            ->with('plan')
            ->where('status', 'active')
            ->latest('start_date')
            ->first();

        return view('subscriptions.show', compact('currentSubscription'));
    }
    public function cancel()
    {
        $subscription = Auth::user()->subscriptions()
            ->where('status', 'active')
            ->first();

        if ($subscription) {

            $subscription->status = 'cancelled';
            $subscription->save();
            
            return back()->with('success', 'Your subscription has been marked for cancellation and will expire on ' . $subscription->end_date->format('M d, Y') . '.');
        }

        return back()->with('error', 'No active subscription found to cancel.');
    }
}
