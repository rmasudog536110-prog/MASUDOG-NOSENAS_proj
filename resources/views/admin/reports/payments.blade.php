@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<h2>Payment Report</h2>

<div class="total-revenue">
    <h2>Total Revenue Report</h2>
    <h2>₱{{ number_format($revenue, 2) }}</h2>
</div>

<table class="table table-bordered">
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
            $membersCount = count($combined);
        @endphp

        @if($membersCount > 0)
            @foreach ($combined as $row)
                <tr>
                    <td>{{ $row['user']->name ?? 'N/A' }}</td>
                    <td>₱{{ number_format($row['latest_amount'] ?? 0, 2) }}</td>
                    <td>{{ ucfirst($row['payment_method'] ?? 'N/A') }}</td>
                    <td>{{ ucfirst($row['status'] ?? 'N/A') }}</td>
                    <td>{{ isset($row['date']) ? $row['date']->format('M d, Y') : 'N/A' }}</td>
                </tr>
            @endforeach
        @endif

        {{-- Fill empty rows if needed --}}
        @for ($i = $membersCount; $i < $totalRows; $i++)
            <tr class="empty-row">
                <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                    No payment records found
                </td>
            </tr>
        @endfor

    </tbody>
</table>

<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.payments_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>

@endsection