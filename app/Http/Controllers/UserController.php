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
                // Redirect to payment proof upload form instead of creating subscription
                return redirect()
                    ->route('subscription.payment.form', ['plan' => $plan->id])
                    ->with('success', 'Please upload your payment proof to activate your subscription.');
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
        
        // Redirect based on user role
        if (Auth::user()->hasAdminAccess()) {
            return redirect()->route('admin.dashboard');
        }
        
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
