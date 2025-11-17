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
    public function cancel(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Mark subscriptions as cancelled
            $user->subscriptions()
                ->where('payment_status', 'pending')
                ->update([
                    'payment_status' => 'cancelled',
                    'status' => 'cancelled'
                ]);

            // Optional: delete profile first if needed
            if ($user->profile) {
                $user->profile()->delete();
            }

            $user->subscriptions()->delete(); 
    
            $user->delete();

            // Logout
            Auth::logout();
        }

        return redirect()->route('index')->with('success', 'Your registration/payment has been cancelled.');
    }


    }