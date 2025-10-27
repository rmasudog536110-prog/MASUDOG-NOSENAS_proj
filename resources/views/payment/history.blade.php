@extends('skeleton.layouts')

@section('title', 'Payment History')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Payment History</h2>

    @if ($transactions->isEmpty())
        <div class="alert alert-info">You have no payment transactions yet.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->created_at->format('M d, Y h:i A') }}</td>
                            <td>{{ optional($transaction->subscription->plan)->name ?? 'N/A' }}</td>
                            <td>₱{{ number_format($transaction->amount, 2) }}</td>
                            <td>{{ ucfirst($transaction->payment_method) }}</td>
                            <td>
                                @if ($transaction->status === 'completed')
                                    <span class="badge bg-success">Completed</span>
                                @elseif ($transaction->status === 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Failed</span>
                                @endif
                            </td>
                            <td>{{ $transaction->transaction_reference }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $transactions->links() }}
        </div>
    @endif
</div>
@endsection
