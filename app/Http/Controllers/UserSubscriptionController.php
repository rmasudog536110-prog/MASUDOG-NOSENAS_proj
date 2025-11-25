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

        // 1. Delete profile if it exists
        if ($user->profile) {
            $user->profile()->delete();
        }


        $user->subscriptions()->delete();
        $user->transactions()->delete();
        $user->workoutLogs()->delete();
        $user->progress()->delete();
        $user->workoutLogs()->delete();
        $user->bodyMeasurements()->delete();
        $user->instructorRequests()->delete();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();


        $user->delete();
    }

    return redirect()->route('index')
        ->with('success', 'Your registration and all information have been deleted.');
}



    }