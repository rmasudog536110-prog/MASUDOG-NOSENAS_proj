@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
    <style>
    </style>
@endpush

@section('content')
<div class="full-report-container">
    <h1 class="full-report-title">Full Gym Report</h1>
    <p class="full-report-subtitle">Generated on: {{ now()->format('F d, Y h:i A') }}</p>
    
    <!-- Total Revenue Display -->
    <div class="total-revenue-display">
        <h2>Total Revenue: ₱{{ number_format($revenue, 2) }}</h2>
    </div>

    <!-- Main Report Table -->
    <div style="overflow-x: auto;">
        <table class="full-report-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member Name</th>
                    <th>Email</th>
                    <th>Subscription Status</th>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
           <tbody>
    @php
        $counter = 1;

        // Key active members by user ID
        $users = $active_members->keyBy('id');

        // Group approved payments by user ID
        $approvedPaymentsByUser = $payments->groupBy(fn($p) => $p->user_id);
    @endphp

    {{-- LOOP THROUGH ACTIVE MEMBERS --}}
    @foreach ($users as $user)
        @php
            $activeSub = $user->subscriptions->where('status', 'active')->first();
            $userPayments = $approvedPaymentsByUser[$user->id] ?? collect();
            $latestPayment = $userPayments->sortByDesc('created_at')->first();
        @endphp

        <tr>
            <td>{{ $counter++ }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td><span class="badge bg-success">{{$activeSub->status}}</span></td>
            <td>{{ $activeSub->plan->name ?? 'N/A' }}</td>
            <td>{{ $activeSub && $activeSub->start_date ? \Carbon\Carbon::parse($activeSub->start_date)->format('M d, Y') : 'N/A' }}</td>
            <td>{{ $activeSub && $activeSub->end_date ? \Carbon\Carbon::parse($activeSub->end_date)->format('M d, Y') : 'N/A' }}</td>

            @if($latestPayment)
                <td><span class="badge bg-success">Approved</span></td>
                <td>₱{{ number_format($latestPayment->amount ?? 0, 2) }}</td>
                <td>{{ $latestPayment->created_at ? \Carbon\Carbon::parse($latestPayment->created_at)->format('M d, Y') : 'N/A' }}</td>
            @else
                <td>-</td>
                <td>-</td>
                <td>-</td>
            @endif
        </tr>
    @endforeach

    {{-- PENDING PAYMENTS FOR USERS WITHOUT ACTIVE SUBS --}}
    @foreach ($pending as $payment)
        @if(!isset($users[$payment->user_id]))
            <tr>
                <td>{{ $counter++ }}</td>
                <td>{{ $payment->user->name ?? 'N/A' }}</td>
                <td>{{ $payment->user->email ?? 'N/A' }}</td>
                <td><span class="badge bg-warning">{{$payment->status}}</span></td>
                <td>₱{{ number_format($payment->amount ?? 0, 2) }}</td>
                <td>{{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') : 'N/A' }}</td>
            </tr>
        @endif
    @endforeach
</tbody>

        </table>
    </div>

    <!-- Action Buttons -->
    <div class="report-footer">
        <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.full_report_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
@endsection