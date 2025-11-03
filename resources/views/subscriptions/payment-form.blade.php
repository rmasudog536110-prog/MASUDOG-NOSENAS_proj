@extends('skeleton.layout')

@section('title', 'Submit Payment - FitClub')

@push('styles')
    <style>
        .payment-container {
            max-width: 800px;
            margin: 3rem auto;
            padding: 0 1rem;
        }

        .payment-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.3);
            border-radius: 1rem;
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .payment-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #ffc107, var(--primary));
        }

        .payment-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .payment-header h1 {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .payment-header p {
            color: var(--muted-foreground);
            font-size: 1.125rem;
        }

        .plan-summary {
            background: rgba(255, 102, 0, 0.1);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .plan-summary h3 {
            color: var(--foreground);
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .plan-detail {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 102, 0, 0.1);
        }

        .plan-detail:last-child {
            border-bottom: none;
        }

        .plan-detail-label {
            color: var(--muted-foreground);
        }

        .plan-detail-value {
            color: var(--foreground);
            font-weight: 600;
        }

        .payment-instructions {
            background: rgba(255, 102, 0, 0.05);
            border-left: 4px solid var(--primary);
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 0.5rem;
        }

        .payment-instructions h4 {
            color: var(--foreground);
            margin-bottom: 1rem;
        }

        .payment-instructions ol {
            color: var(--muted-foreground);
            padding-left: 1.5rem;
        }

        .payment-instructions li {
            margin-bottom: 0.5rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            color: var(--foreground);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 102, 0, 0.05);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.5rem;
            color: var(--foreground);
            font-size: 1rem;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
        }

        .file-upload-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-input {
            position: absolute;
            left: -9999px;
        }

        .file-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1rem;
            background: rgba(255, 102, 0, 0.1);
            border: 2px dashed rgba(255, 102, 0, 0.3);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--foreground);
        }

        .file-upload-label:hover {
            background: rgba(255, 102, 0, 0.2);
            border-color: var(--primary);
        }

        .file-name {
            margin-top: 0.5rem;
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .btn-submit {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(135deg, var(--primary) 0%, #ff8533 100%);
            border: none;
            border-radius: 0.5rem;
            color: white;
            font-size: 1.125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.4);
        }

        .btn-cancel {
            width: 100%;
            padding: 1rem;
            background: transparent;
            border: 1px solid rgba(255, 102, 0, 0.3);
            border-radius: 0.5rem;
            color: var(--foreground);
            font-size: 1.125rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .btn-cancel:hover {
            background: rgba(255, 102, 0, 0.1);
        }
    </style>
@endpush

@section('content')
@include('index.header')

<div class="payment-container">
    <div class="payment-card">
        <div class="payment-header">
            <h1>💳 Submit Payment</h1>
            <p>Upload your payment proof for verification</p>
        </div>

        <!-- Plan Summary -->
        <div class="plan-summary">
            <h3>{{ $plan->name }}</h3>
            <div class="plan-detail">
                <span class="plan-detail-label">Duration</span>
                <span class="plan-detail-value">{{ $plan->duration_days }} days</span>
            </div>
            <div class="plan-detail">
                <span class="plan-detail-label">Price</span>
                <span class="plan-detail-value">₱{{ number_format($plan->price, 2) }}</span>
            </div>
        </div>

        <!-- Payment Instructions -->
        <div class="payment-instructions">
            <h4>📋 Payment Instructions</h4>
            <ol>
                <li>Transfer the amount to our payment account</li>
                <li>Take a screenshot or photo of the payment receipt</li>
                <li>Upload the payment proof below</li>
                <li>Wait for admin approval (usually within 24 hours)</li>
                <li>You'll receive a notification once approved</li>
            </ol>
        </div>

        <!-- Payment Form -->
        <form action="{{ route('subscription.payment.submit', $plan->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Payment Proof (Screenshot/Photo)</label>
                <div class="file-upload-wrapper">
                    <input type="file" 
                           name="payment_proof" 
                           id="payment_proof" 
                           class="file-upload-input" 
                           accept="image/*"
                           required
                           onchange="updateFileName(this)">
                    <label for="payment_proof" class="file-upload-label">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Click to upload payment proof</span>
                    </label>
                </div>
                <div id="file-name" class="file-name"></div>
                @error('payment_proof')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Submit Payment Proof
            </button>
        </form>

        <a href="{{ route('dashboard') }}" class="btn-cancel">
            <i class="fa-solid fa-arrow-left"></i> Cancel
        </a>
    </div>
</div>

@include('index.footer')

<script>
    function updateFileName(input) {
        const fileName = input.files[0]?.name;
        const fileNameDisplay = document.getElementById('file-name');
        if (fileName) {
            fileNameDisplay.textContent = `Selected: ${fileName}`;
            fileNameDisplay.style.color = 'var(--primary)';
        }
    }
</script>
@endsection
