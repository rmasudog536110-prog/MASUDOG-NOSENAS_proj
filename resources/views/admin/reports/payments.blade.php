@extends('skeleton.layout')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush

@section('content')
<h2>Payment Report</h2>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Member</th><th>Amount</th><th>Method</th><th>Status</th><th>Date</th>
        </tr>
    </thead>
    <tbody>

        @php
            $totalRows = 5  ;
            $membersCount = count($payments);
        @endphp

        @forelse ($payments as $pay)
        <tr>
            <td>{{ $pay->user->name }}</td>
            <td>₱{{ number_format($pay->amount, 2) }}</td>
            <td>{{ ucfirst($pay->payment_method) }}</td>
            <td>{{ ucfirst($pay->status) }}</td>
            <td>{{ $pay->created_at->format('M d, Y') }}</td>
        </tr>
        @empty
        @endforelse
            @for ($i = $membersCount; $i < $totalRows; $i++)
                    <tr class="empty-row">
                        <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                            No users yet
                        </td>
                    </tr>
            @endfor
    </tbody>
</table>
<div>
    <h2>Total Revenue Report</h2>

    <h2>₱{{ number_format($revenue, 2) }}</h2>
</div>


<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="{{ route('reports.payments_pdf') }}" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>

@endsection
