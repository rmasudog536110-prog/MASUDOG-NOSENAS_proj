<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SubscriptionPaymentController extends Controller
{
    public function showPaymentForm($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        return view('subscriptions.payment-form', compact('plan'));
    }

    public function submitPayment(Request $request, $planId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $plan = SubscriptionPlan::findOrFail($planId);

        // Store payment proof
        $paymentProofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Create subscription with pending status
        $subscription = UserSubscription::create([
            'user_id' => Auth::id(),
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration_days),
            'status' => 'pending',
            'payment_proof' => $paymentProofPath,
            'payment_status' => 'pending',
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Payment proof submitted successfully! Please wait for admin approval.');
    }

    public function approvePayment($subscriptionId)
    {
        $subscription = UserSubscription::findOrFail($subscriptionId);
        
        $subscription->update([
            'payment_status' => 'approved',
            'status' => 'active',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Subscription approved successfully!');
    }

    public function rejectPayment(Request $request, $subscriptionId)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $subscription = UserSubscription::findOrFail($subscriptionId);
        
        $subscription->update([
            'payment_status' => 'rejected',
            'status' => 'cancelled',
            'admin_notes' => $request->admin_notes,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        return back()->with('success', 'Subscription rejected.');
    }
}
