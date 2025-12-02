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

        $subscriptions = UserSubscription::where('status', 'approved')
            ->whereBetween('end_date', [$now, $soon])
            ->with('user', 'plan')
            ->paginate(5);

        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->with('user', 'plan')
            ->paginate(5);


        return view('admin.reports.expiring_soon', compact('subscriptions', 'activeSubscriptions'));
    }

    public function expiringSoonPDF()
    {
        $now = Carbon::now();
        $soon = Carbon::now()->addDays(7);

        $subscriptions = UserSubscription::where('status', 'approved')
            ->whereBetween('end_date', [$now, $soon])
            ->with('user', 'plan')
            ->get();

        
        $activeSubscriptions = UserSubscription::where('status', 'active')
            ->with('user', 'plan')
            ->get();

        $pdf = Pdf::loadView('admin.reports.expiring_soon_pdf', compact('subscriptions', 'activeSubscriptions'))
                ->setPaper('A4', 'portrait');

        return $pdf->download('expiring_soon_report.pdf');
    }
    public function payments()
    {
        $payments = UserSubscription::where('status', 'approved')
            ->with('user', 'status')
            ->orderBy('updated_at', 'desc')
            ->paginate(10);
        
        $revenue = PaymentTransaction::where('status', 'approved')->sum('amount');

        $members = User::whereHas('subscriptions', function ($q) {
            $q->whereIn('status', ['active', 'approved']);
        })->paginate(5);

        return view('admin.reports.payments', compact('payments', 'revenue', 'members'));
    }


    public function paymentsPDF()
    {
        $payments = UserSubscription::where('status', 'approved')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        $revenue = PaymentTransaction::where('status', 'approved')->sum('amount');

        $pdf = Pdf::loadView('admin.reports.payments_pdf', compact('payments', 'revenue'))
                ->setPaper('A4', 'portrait');

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
            'active_members' => User::whereHas('subscriptions', fn($q)=>$q->where('status','active'))->get(),
            'expiring_soon' => UserSubscription::whereBetween('end_date', [now(), now()->addDays(7)])->get(),
            'payments' => UserSubscription::where('status','approved')->get(),
            'pending' => UserSubscription::where('status','pending')->get(),
            'revenue' => PaymentTransaction::where('status','approved')->sum('amount'),
            'active_count' => UserSubscription::where('status','active')->count(),
            'cancelled_count' => UserSubscription::where('status','cancelled')->count(),
        ]);
    }


    public function fullReportPDF()
    {
        $data = [
            'active_members' => User::whereHas('subscriptions', fn($q)=>$q->where('status','active'))->get(),
            'expiring_soon' => UserSubscription::whereBetween('end_date', [now(), now()->addDays(7)])->get(),
            'payments' => UserSubscription::where('status','approved')->get(),
            'pending' => UserSubscription::where('status','pending')->get(),
            'revenue' => PaymentTransaction::where('status','approved')->sum('amount'),
            'active_count' => UserSubscription::where('status','active')->count(),
            'cancelled_count' => UserSubscription::where('status','cancelled')->count(),
        ];

        $pdf = Pdf::loadView('admin.reports.full_report_pdf', $data)
                ->setPaper('A4', 'portrait');

        return $pdf->download('full_gym_report.pdf');
    }
}
