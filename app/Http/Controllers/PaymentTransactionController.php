<?php

    namespace App\Http\Controllers;

    use App\Models\PaymentTransaction;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class PaymentTransactionController extends Controller
    {
        /**
         * Display the payment history for the authenticated user.
         */
        public function index()
        {
            $transactions = Auth::user()->transactions()
                ->with('subscription.plan')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('payment.history', compact('transactions'));
        }

    public function show($subscription_id)
    {
        $subscription = \App\Models\UserSubscription::with('plan')
            ->where('id', $subscription_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('payment.payment', compact('subscription'));
    }


    public function process(Request $request, $subscription_id)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'transaction_reference' => 'required|string|max:255',
        ]);

        $subscription = \App\Models\UserSubscription::with('plan')
            ->where('id', $subscription_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();


        PaymentTransaction::create([
            'user_id' => Auth::id(),
            'subscription_id' => $subscription->id,
            'transaction_reference' => $request->transaction_reference,
            'payment_method' => $request->payment_method,
            'amount' => $subscription->plan->price,
            'currency' => 'PHP',
            'status' => 'completed', 
            'payment_details' => [
                'method' => $request->payment_method,
                'reference' => $request->transaction_reference,
            ],
        ]);

        $startDate =now();
        $endDate = now()->addMonth();

    
        $subscription->update([
            'is_active' => true,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        return redirect()->route('dashboard')->with('success', 'Payment successful! Your subscription is now active.');
    }

        
    }
