@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<div class="report-page">
    <div class="report-header">
        <h1>Expiring Soon</h1>
        <p class="report-meta">Upcoming expirations in next 7 days</p>
    </div>

    <div class="report-card">
        <div class="report-section">
            <h2>Expiring Soon</h2>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Plan</th>
                        <th>Expires At</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalRows = 5;
                        $subscriptions = $subscriptions ?? collect();
                        $membersCount = $subscriptions->count();
                    @endphp

                    @forelse ($subscriptions as $i => $sub)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $sub->user->name ?? 'N/A' }}</td>
                            <td>{{ $sub->plan->name ?? 'N/A' }}</td>
                            <td>{{ optional($sub->end_date)->format('M d, Y') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="4">No expiring subscriptions</td>
                        </tr>
                    @endforelse

                    @if($membersCount && $membersCount < $totalRows)
                        @for ($i = $membersCount; $i < $totalRows; $i++)
                            <tr class="empty-row">
                                <td colspan="4">—</td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Active Subscriptions</h2>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Ends At</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $activeRows = 5;
                        $activeSubscriptions = $activeSubscriptions ?? collect();
                        $activeCount = $activeSubscriptions->count();
                    @endphp

                    @forelse ($activeSubscriptions as $i => $active)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $active->user->name ?? 'N/A' }}</td>
                            <td>{{ $active->user->email ?? 'N/A' }}</td>
                            <td>{{ $active->plan->name ?? 'N/A' }}</td>
                            <td>{{ optional($active->end_date)->format('M d, Y') ?? 'N/A' }}</td>
                        </tr>
                    @empty
                        <tr class="empty-row">
                            <td colspan="5">No active subscriptions</td>
                        </tr>
                    @endforelse

                    @if($activeCount && $activeCount < $activeRows)
                        @for ($i = $activeCount; $i < $activeRows; $i++)
                            <tr class="empty-row">
                                <td colspan="5">—</td>
                            </tr>
                        @endfor
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="report-footer">
        <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.expiring_soon_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
@endsection