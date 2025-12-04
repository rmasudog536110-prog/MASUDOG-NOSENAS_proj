@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<div class="report-page">
    <div class="report-header">
        <h1>Pending Payment Verifications</h1>
        <p class="report-meta">Awaiting admin approval</p>
    </div>

    <div class="report-card">
        <table class="reports-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalRows = 5;
                    $membersCount = $pending->count();
                @endphp

                @forelse ($pending as $subscription)
                    <tr>
                        <td>{{ $subscription->user->name }}</td>
                        <td>{{ $subscription->plan->name ?? 'N/A' }}</td>
                        <td>{{ optional($subscription->start_date)->format('M d, Y') }}</td>
                        <td>{{ optional($subscription->end_date)->format('M d, Y') }}</td>
                        <td>{{ $subscription->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="5">No pending payments found</td>
                    </tr>
                @endforelse

                @if($membersCount && $membersCount < $totalRows)
                    @for ($i = $membersCount; $i < $totalRows; $i++)
                        <tr class="empty-row">
                            <td colspan="5">—</td>
                        </tr>
                    @endfor
                @endif
            </tbody>
        </table>

        @if(method_exists($pending, 'hasPages') && $pending->hasPages())
            <div class="report-pagination">
                {{ $pending->links() }}
            </div>
        @endif
    </div>

    <div class="report-footer">
        <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.pending_payments_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
@endsection
