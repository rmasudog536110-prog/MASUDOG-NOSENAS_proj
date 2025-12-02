@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<h1>Full Gym Report</h1>

<h2>1. Active Members</h2>
@include('admin.reports.active_members', [
    'members' => $active_members,
    'active' => $active_count,
    'cancelled' => $cancelled_count
])

<h2>2. Expiring Soon (Next 7 Days)</h2>
@include('admin.reports.expiring_soon', [
    'subscriptions' => $expiring_soon
])

<h2>3. Payments</h2>
@include('admin.reports.payments', [
    'payments' => $payments
])

<h2>4. Pending Payment Verifications</h2>
@include('admin.reports.pending_payments', [
    'pending' => $pending
])

<h2>5. Total Revenue</h2>
<p><strong>₱{{ number_format($revenue, 2) }}</strong></p>

<h2>6. Active vs Cancelled Subscriptions</h2>
<p>Active: {{ $active_count }}</p>
<p>Cancelled: {{ $cancelled_count }}</p>

<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.full_report_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>
@endsection
