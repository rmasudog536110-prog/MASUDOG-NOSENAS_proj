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
    /** ACTIVE MEMBERS REPORT */
    public function activeMembers()
    {
        $active = UserSubscription::where('status', 'active')->count();
        $cancelled = UserSubscription::where('status', 'cancelled')->count();

        $members = User::whereHas('subscriptions', function($q) {
            $q->where('status', 'active');
        })->get();

        return view('admin.reports.active_members', compact('members','active', 'cancelled'));
    }

public function activeMembersPDF()
{
    $members = User::whereHas('subscriptions', function($q) {
        $q->where('status', 'active');
    })->get();

    $pdf = Pdf::loadView('admin.reports.active_members_pdf', compact('members'));
    $pdf->setPaper('A4', 'portrait');

    // Optional: Add page numbers using DomPDF canvas
    $pdf->output(); // pre-render the PDF

    return $pdf->download('active_members_report.pdf');
}
    /** EXPIRING SOON REPORT */
    public function expiringSoon()
    {
        $now = Carbon::now();
        $soon = Carbon::now()->addDays(7); // next 7 days

        $subscriptions = UserSubscription::where('status', 'active')
            ->whereBetween('end_date', [$now, $soon])
            ->with('user', 'subscriptionPlan')
            ->get();

        return view('admin.reports.expiring_soon', compact('subscriptions'));
    }

    /** PAYMENT REPORT */
    public function payments()
    {
        $payments = UserSubscription::where('status', 'approved')
            ->with('user')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('admin.reports.payments', compact('payments'));
    }

    /** PENDING PAYMENT VERIFICATIONS */
    public function pendingPayments()
    {
        $pending = UserSubscription::where('status', 'pending')
            ->with('user')
            ->get();

        return view('admin.reports.pending_payments', compact('pending'));
    }

    /** REVENUE REPORT */
    public function revenue()
    {
        $revenue = PaymentTransaction::where('status', 'approved')->sum('amount');
        $monthly = PaymentTransaction::where('status', 'approved')
            ->whereMonth('updated_at', now()->month)
            ->sum('amount');

        $transactions = UserSubscription::where('status', 'approved')
            ->with('user')
            ->get();

        return view('admin.reports.revenue_reports', compact('revenue', 'monthly', 'transactions'));
    }

    /** ACTIVE VS CANCELLED SUBSCRIPTIONS */
    public function subscriptionStatus()
    {
        $active = UserSubscription::where('status', 'active')->count();
        $cancelled = UserSubscription::where('status', 'cancelled')->count();

        return view('admin.reports.subscription_status', compact('active', 'cancelled'));
    }

    /** FULL REPORT (ALL-IN-ONE) */
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
}
