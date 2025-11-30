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
        @foreach ($payments as $pay)
        <tr>
            <td>{{ $pay->user->name }}</td>
            <td>₱{{ number_format($pay->amount, 2) }}</td>
            <td>{{ ucfirst($pay->payment_method) }}</td>
            <td>{{ ucfirst($pay->status) }}</td>
            <td>{{ $pay->created_at->format('M d, Y') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
