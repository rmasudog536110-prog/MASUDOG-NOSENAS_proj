<?php

namespace App\Http\Controllers;

use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PaymentTransaction;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
  
    public function activeMembers()
    {
        $active = UserSubscription::where('status', 'active')->count();
        $cancelled = UserSubscription::where('status', 'cancelled')->count();

        $members = User::whereHas('subscriptions', function ($q) {
            $q->whereIn('status', ['active', 'approved']);
        })->paginate(5);

        return view('admin.reports.active_members', compact('members','active', 'cancelled'));
    }


    public function activeMembersPDF()
    {
        $members = User::whereHas('subscriptions', function ($q) {
            $q->whereIn('status', ['active', 'approved']);
        })->get();

        $pdf = Pdf::loadView('admin.reports.active_members_pdf', compact('members'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('active_members_report.pdf');
    }

public function expiringSoon()
{
    $now = Carbon::now();
    $soon = Carbon::now()->addDays(7);

    try {
        $subscriptions = UserSubscription::where('status', 'active')
            ->whereBetween('end_date', [$now, $soon])
            ->with('user', 'plan')
            ->paginate(5);

        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->with('user', 'plan')
            ->paginate(5);

        // Debug: Check if data is being fetched
        \Log::info('Expiring Soon Report Data:', [
            'subscriptions_count' => $subscriptions->count(),
            'active_subscriptions_count' => $activeSubscriptions->count()
        ]);

        return view('admin.reports.expiring_soon', compact('subscriptions', 'activeSubscriptions'));

    } catch (\Exception $e) {
        \Log::error('Error in expiringSoon report: ' . $e->getMessage());
        
        // Return empty collections if there's an error
        $subscriptions = collect();
        $activeSubscriptions = collect();
        
        return view('admin.reports.expiring_soon', compact('subscriptions', 'activeSubscriptions'))
            ->withErrors(['error' => 'Error loading report data: ' . $e->getMessage()]);
    }
}

public function expiringSoonPDF()
{
    $now = Carbon::now();
    $soon = Carbon::now()->addDays(7);

    try {
        $subscriptions = UserSubscription::where('status', 'active')
            ->whereBetween('end_date', [$now, $soon])
            ->with('user', 'plan')
            ->get();

        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->with('user', 'plan')
            ->get();

        \Log::info('PDF Generation Data:', [
            'subscriptions_count' => $subscriptions->count(),
            'active_subscriptions_count' => $activeSubscriptions->count()
        ]);

        $pdf = Pdf::loadView('admin.reports.expiring_soon_pdf', compact('subscriptions', 'activeSubscriptions'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('expiring_soon_report_' . date('Y-m-d') . '.pdf');

    } catch (\Exception $e) {
        \Log::error('Error generating PDF: ' . $e->getMessage());
        
        // Return an error response
        return response()->json([
            'error' => 'Failed to generate PDF: ' . $e->getMessage()
        ], 500);
    }
}
    public function payments()
    {
        // Total revenue
        $revenue = PaymentTransaction::where('status', 'approved')->sum('amount');

        // Revenue per user
        $revenuePerUser = PaymentTransaction::where('status', 'approved')
            ->select('user_id', \DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('user_id')
            ->pluck('total_revenue', 'user_id');

        // Latest payment per user (PaymentTransaction)
        $latestPayments = PaymentTransaction::where('status', 'approved')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function ($payments) {
                return $payments->first(); // latest transaction per user
            });

        // COMBINE DATA
        $combined = $latestPayments->map(function ($payment) use ($revenuePerUser) {
            return [
                'user'           => $payment->user,
                'latest_amount'  => $payment->amount,
                'payment_method' => $payment->payment_method,
                'status'         => $payment->status,
                'date'           => $payment->created_at,
                'total_revenue'  => $revenuePerUser[$payment->user_id] ?? 0
            ];
        });

        return view('admin.reports.payments', compact(
            'combined',
            'revenue'
        ));
    }

    public function paymentsPDF()
    {
        // Total revenue
        $revenue = PaymentTransaction::where('status', 'approved')->sum('amount');

        // Revenue per user
        $revenuePerUser = PaymentTransaction::where('status', 'approved')
            ->select('user_id', \DB::raw('SUM(amount) as total_revenue'))
            ->groupBy('user_id')
            ->pluck('total_revenue', 'user_id');

        // Latest payment per user (PaymentTransaction)
        $latestPayments = PaymentTransaction::where('status', 'approved')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id')
            ->map(function ($payments) {
                return $payments->first(); // latest transaction per user
            });

        // COMBINE DATA
        $combined = $latestPayments->map(function ($payment) use ($revenuePerUser) {
            return [
                'user'           => $payment->user,
                'latest_amount'  => $payment->amount,
                'payment_method' => $payment->payment_method,
                'status'         => $payment->status,
                'date'           => $payment->created_at,
            ];
        });

        $pdf = Pdf::loadView('admin.reports.payments_pdf', [
            'combined' => $combined,
            'revenue'  => $revenue,
        ])->setPaper('A4', 'portrait');

        return $pdf->download('payments_report.pdf');
    }

    public function pendingPayments()
    {
        $pending = UserSubscription::where('status', 'pending')
            ->with('user')
            ->paginate(5);

        return view('admin.reports.pending_payments', compact('pending'));
    }

    public function pendingPaymentsPDF()
    {
        $pending = UserSubscription::where('status', 'pending')
            ->with('user')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pending_payments_pdf', compact('pending'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('pending_payments_report.pdf');
    }


    public function revenue()
    {
        $revenue = PaymentTransaction::where('status', 'approved')->sum('amount');
        $monthly = PaymentTransaction::where('status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->sum('amount');

        $transactions = UserSubscription::where('status', 'approved')
            ->with('user')
            ->paginate(15);

        return view('admin.reports.revenue_reports', compact('revenue', 'monthly', 'transactions'));
    }


    public function subscriptionStatus()
    {
        $active = UserSubscription::where('status', 'active')->count();
        $cancelled = UserSubscription::where('status', 'cancelled')->count();

        return view('admin.reports.subscription_status', compact('active', 'cancelled'));
    }


    public function full()
{
    return view('admin.reports.full_report', [
        'active_members' => User::whereHas('subscriptions', fn($q) => $q->where('status', 'active'))->get(),
        'expiring_soon' => UserSubscription::with('user')
            ->where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(7)])
            ->get(),
        'payments' => PaymentTransaction::with('user')
            ->where('status', 'approved')
            ->get(),
        'pending' => PaymentTransaction::with('user')
            ->where('status', 'pending')
            ->get(),
        'revenue' => PaymentTransaction::where('status', 'approved')->sum('amount'),
        'active_count' => UserSubscription::where('status', 'active')->count(),
        'cancelled_count' => UserSubscription::where('status', 'cancelled')->count(),
    ]);
}

public function fullReportPDF()
{
    $data = [
        'active_members' => User::whereHas('subscriptions', fn($q) => $q->where('status', 'active'))->get(),
        'expiring_soon' => UserSubscription::with('user')
            ->where('status', 'active')
            ->whereBetween('end_date', [now(), now()->addDays(7)])
            ->get(),
        'payments' => PaymentTransaction::with('user')
            ->where('status', 'approved')
            ->get(),
        'pending' => PaymentTransaction::with('user')
            ->where('status', 'pending')
            ->get(),
        'revenue' => PaymentTransaction::where('status', 'approved')->sum('amount'),
        'active_count' => UserSubscription::where('status', 'active')->count(),
        'cancelled_count' => UserSubscription::where('status', 'cancelled')->count(),
    ];

    $pdf = Pdf::loadView('admin.reports.full_report_pdf', $data)
            ->setPaper('A4', 'portrait')
            ->setOption('defaultFont', 'sans-serif');

    return $pdf->download('full_gym_report_' . date('Y-m-d') . '.pdf');
}
}