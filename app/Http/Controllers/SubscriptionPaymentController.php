<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use App\Models\PaymentTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionPaymentController extends Controller
{
    /**
     * Show the payment form for a subscription plan
     */
    public function showPaymentForm($planId)
    {
        $plan = SubscriptionPlan::findOrFail($planId);
        return view('subscriptions.payment-form', compact('plan'));
    }

    /**
     * Submit payment proof and create subscription + transaction
     */
    public function submitPayment(Request $request, $planId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_method' => 'required|string',
            'transaction_reference' => 'required|string|max:255',
        ]);

        $plan = SubscriptionPlan::findOrFail($planId);

        // Store the payment proof
        $proofPath = $request->file('payment_proof')->store('payment_proofs', 'public');

        // Create subscription (pending)
        $subscription = UserSubscription::create([
            'user_id' => Auth::id(),
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addDays($plan->duration_days),
            'status' => 'pending',
        ]);

        // Create payment transaction
        PaymentTransaction::create([
            'user_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'transaction_reference' => $request->transaction_reference,
            'payment_method' => $request->payment_method,
            'amount' => $plan->price,
            'currency' => 'PHP',
            'status' => 'pending',
            'payment_details' => [
                'proof_path' => $proofPath,
            ],
        ]);

        return redirect()->route('pending_dashboard')
            ->with('success', 'Payment proof submitted successfully! Please wait for admin approval.');
    }

    /**
     * Admin approves the payment
     */
    public function approvePayment($subscriptionId)
    {
        $subscription = UserSubscription::findOrFail($subscriptionId);

        // Update subscription to active
        $subscription->update([
            'status' => 'approved',
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);

        // Update transaction status
        $subscription->payments()->latest()->first()->update([
            'status' => 'approved',
        ]);

        return back()->with('success', 'Subscription approved successfully!');
    }

    /**
     * Admin rejects the payment
     */
    public function rejectPayment(Request $request, $subscriptionId)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:500',
        ]);

        $subscription = UserSubscription::findOrFail($subscriptionId);

        // Update transaction status
        $subscription->payments()->latest()->first()->update([
            'status' => 'failed',
            'payment_details' => array_merge(
                $subscription->payments()->latest()->first()->payment_details ?? [],
                ['admin_notes' => $request->admin_notes]
            ),
        ]);

        // Optionally, cancel the subscription
        $subscription->update([
            'status' => 'cancelled' || 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return back()->with('success', 'Payment rejected.');
    }
}
