@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<h2>Pending Payment Verifications</h2>

@if($pending->isEmpty())
    <p>No pending payments found.</p>
@else
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @php
            $totalRows = 5;
            $membersCount = count($pending);
            @endphp
            @forelse ($pending as $pendings)
                <tr>
                    <td>{{ $pendings->user->name }}</td>
                    <td>{{ $pendings->subscriptionPlan->name ?? 'N/A' }}</td>
                    <td>{{ $pendings->start_date->format('M d, Y') }}</td>
                    <td>{{ $pendings->end_date->format('M d, Y') }}</td>
                    <td>{{ $pendings->created_at->format('M d, Y') }}</td>
                </tr>
                @empty
            @endforelse
            @for ($i = $membersCount; $i < $totalRows; $i++)
                <tr class="empty-row">
                    <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                        No users Expiring Soon
                    </td>
                </tr>
            @endfor
        </tbody>
    </table>
@endif

<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.pending_payments_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>
@endsection
