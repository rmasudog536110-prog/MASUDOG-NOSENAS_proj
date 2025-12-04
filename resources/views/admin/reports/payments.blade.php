@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<div class="report-page">
    <div class="report-header">
        <h1>Payments</h1>
        <p class="report-meta">Snapshot of latest approved transactions</p>
    </div>

    <div class="report-card">
        <div class="total-revenue-display">
            <h2>Total Revenue</h2>
            <h2>₱{{ number_format($revenue, 2) }}</h2>
        </div>

        <table class="reports-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalRows = 5;
                    $combined = $combined ?? collect();
                    $membersCount = $combined->count();
                @endphp

                @forelse ($combined as $row)
                    <tr>
                        <td>{{ $row['user']->name ?? 'N/A' }}</td>
                        <td>₱{{ number_format($row['latest_amount'] ?? 0, 2) }}</td>
                        <td>{{ ucfirst($row['payment_method'] ?? 'N/A') }}</td>
                        <td>{{ ucfirst($row['status'] ?? 'N/A') }}</td>
                        <td>{{ isset($row['date']) ? $row['date']->format('M d, Y') : 'N/A' }}</td>
                    </tr>
                @empty
                    <tr class="empty-row">
                        <td colspan="5">No payments found</td>
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
    </div>

    <div class="report-footer">
        <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.payments_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
@endsection