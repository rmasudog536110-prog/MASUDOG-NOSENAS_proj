@extends('skeleton.layout')

@section('title', 'Payment Checkout')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm" style="max-width: 700px; margin: 0 auto; background-color: var(--card); color: var(--foreground); border-radius: var(--radius);">
        <div class="card-body">
            <h2 class="mb-4 text-center" style="color: var(--primary);">Complete Your Payment</h2>

            {{-- Flash message --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Subscription Summary --}}
            <div class="mb-4">
                <h4>Subscription Details</h4>
                <p><strong>Plan:</strong> {{ $subscription->plan->name }}</p>
                <p><strong>Price:</strong> ₱{{ number_format($subscription->plan->price, 2) }}</p>
                <p><strong>Description:</strong> {{ $subscription->plan->description }}</p>
            </div>

            {{-- Payment Form --}}
            <form method="POST" action="{{ route('payment.process', $subscription->id) }}" enctype="multipart/form-data">
                @csrf

                {{-- Payment Method --}}
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Select Payment Method</label>
                    <select id="payment_method" name="payment_method" class="form-select" required onchange="togglePaymentInstructions()">
                        <option value="">-- Choose Method --</option>
                        <option value="gcash">GCash</option>
                        <option value="paymaya">PayMaya</option>
                        <option value="credit_card">Credit Card</option>
                        <option value="bank_transfer">Bank Transfer</option>
                    </select>
                </div>

                {{-- Dynamic Instructions --}}
                <div id="payment_instructions" class="p-3 mb-3" style="display: none; background-color: var(--accent); border-radius: var(--radius);">
                    <h6 id="instruction_title" class="fw-bold mb-2"></h6>
                    <p id="instruction_text" class="mb-0 text-muted"></p>
                </div>

                {{-- Transaction Reference --}}
                <div class="mb-3">
                    <label for="transaction_id" class="form-label">Transaction ID / Reference Number</label>
                    <input 
                        type="text" 
                        id="transaction_id" 
                        name="transaction_reference" 
                        class="form-control" 
                        placeholder="Enter your transaction ID from the payment receipt" 
                        required
                    >
                </div>

                {{-- Proof Upload --}}
                <div class="mb-3">
                    <label for="proof" class="form-label">Upload Proof of Payment</label>
                    <input 
                        type="file" 
                        id="proof" 
                        name="proof" 
                        class="form-control" 
                        accept="image/*,.pdf"
                    >
                    <small class="text-muted">Accepted formats: JPG, PNG, or PDF</small>
                </div>

                {{-- Amount Display --}}
                <div class="mb-3">
                    <label class="form-label">Amount to Pay</label>
                    <input 
                        type="text" 
                        class="form-control" 
                        value="₱{{ number_format($subscription->plan->price, 2) }}" 
                        readonly
                    >
                </div>

                {{-- Submit Button --}}
                <button type="submit" class="btn w-100" style="background-color: var(--primary); color: var(--foreground);">Confirm Payment</button>
            </form>

            <div class="text-center mt-4">
                <a href="{{ route('index') }}" class="text-decoration-none" style="color: var(--primary);">Cancel and return to dashboard</a>
            </div>
        </div>
    </div>
</div>

<script>
function togglePaymentInstructions() {
    const method = document.getElementById('payment_method').value;
    const container = document.getElementById('payment_instructions');
    const title = document.getElementById('instruction_title');
    const text = document.getElementById('instruction_text');

    if (!method) {
        container.style.display = 'none';
        return;
    }

    container.style.display = 'block';

    switch(method) {
        case 'gcash':
            title.textContent = 'GCash Payment Instructions';
            text.textContent = 'Send the exact amount to our GCash number: 0928-459-4158. After sending, enter your GCash reference number below.';
            break;
        case 'paymaya':
            title.textContent = 'PayMaya Payment Instructions';
            text.textContent = 'Pay via PayMaya using our merchant name: FitClub PH. Enter your PayMaya transaction ID after completing the payment.';
            break;
        case 'credit_card':
            title.textContent = 'Credit Card Payment';
            text.textContent = 'You will be redirected to our secure credit card processor after confirming.';
            break;
        case 'bank_transfer':
            title.textContent = 'Bank Transfer Instructions';
            text.textContent = 'Transfer the amount to: BDO Account #1234-5678-90, Name: FitClub PH. Upload your deposit slip for verification.';
            break;
    }
}
</script>
@endsection
