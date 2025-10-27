<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Carbon\Carbon;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Hash;
 

class UserController extends Controller
{
    
    public function showRegister(Request $request) {

        $selectedPlanId = $request->query('plan_id');
        $selectedPlan = null;

    if ($selectedPlanId) {
        $selectedPlan = SubscriptionPlan::find($selectedPlanId);
    }

        return view('auth.register', [
        'selectedPlan' => $selectedPlan,
        'selectedPlanId' => $selectedPlanId,
        ]);

    }
 
 
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|max:10|unique:users',
            'password' => 'required|min:6|confirmed',
            'plan_id' => ['nullable', 'integer'],
        ]);
 
 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            
        ]);

        Auth::login($user);

       if ($request->filled('plan_id')) {
    $plan = SubscriptionPlan::find($request->plan_id);
        

    if ($plan) {
       $subscription = UserSubscription::create([
            'user_id'              => $user->id,
            'plan_id'              => $plan->id,
            'start_date'           => Carbon::now(),
            'end_date'             => Carbon::now()->addDays($plan->duration_days),
            'is_active'            => true,
        ]); 

        return redirect()
                ->route('payment.payment', ['subscription_id' => $subscription->id])
                ->with('success', 'Please complete your payment to activate your subscription.');
    }
}
        return redirect('/dashboard')->with('success', 'Registered successfully.');
    }
 
 
    public function showLogin() {
        return view('auth.login');
    }
 
 
    public function login(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard'); 
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}

 
 
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/index');
    }

}
