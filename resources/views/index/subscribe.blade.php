@extends('skeleton.layout')

@section('title', 'Subscribe - ' . e($plan['name']) . ' Plan - FitClub')

@section('content')

@include('index.header')

    <main class="content-section py-5">
        <div class="container">
            <div class="subscription-container mx-auto" style="max-width: 700px;">
                <h1 class="text-center mb-5">Complete Your Subscription</h1>

                <!-- Selected Plan Info -->
                <div class="selected-plan mb-4">
                    <h2>{{ $plan['name'] }} Plan</h2>
                    <div class="plan-price mb-3">
                        <span class="price">₱{{ number_format($plan['price'], 0) }}</span>
                        <span class="duration">
                            @if ($plan['duration_days'] == 7)
                                7 days
                            @elseif ($plan['duration_days'] == 30)
                                per month
                            @elseif ($plan['duration_days'] == 90)
                                3 months
                            @elseif ($plan['duration_days'] == 365)
                                per year
                            @endif
                        </span>
                    </div>
                    <p>{{ $plan['description'] }}</p>

                    <div class="plan-features">
                        <h4>What's included:</h4>
                        <ul>
                            @foreach (json_decode($plan['features'], true) as $feature)
                                <li>{{ $feature }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Error Messages -->
                @if (!empty($errors['general']))
                    <div class="alert alert-danger">{{ $errors['general'] }}</div>
                @endif

                @if (!empty($errors['payment']))
                    <div class="alert alert-danger">{{ $errors['payment'] }}</div>
                @endif

                <!-- Payment Form -->
                <form method="POST" action="" class="payment-form">
                    @csrf
                    @if (!$plan['is_trial'])
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="form-select" required>
                                <option value="">Select Payment Method</option>
                                <option value="gcash" {{ old('payment_method') === 'gcash' ? 'selected' : '' }}>GCash</option>
                                <option value="paymaya" {{ old('payment_method') === 'paymaya' ? 'selected' : '' }}>PayMaya</option>
                                <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>Credit/Debit Card</option>
                                <option value="bank" {{ old('payment_method') === 'bank' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>
                            @if (!empty($errors['payment_method']))
                                <div class="form-error text-danger mt-1">{{ $errors['payment_method'] }}</div>
                            @endif
                        </div>

                        <div class="card-details" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="card_number" class="form-label">Card Number</label>
                                <input type="text" id="card_number" name="card_number"
                                       class="form-control" placeholder="1234 5678 9012 3456"
                                       maxlength="19">
                                @if (!empty($errors['card_number']))
                                    <div class="form-error text-danger mt-1">{{ $errors['card_number'] }}</div>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiry" class="form-label">Expiry Date</label>
                                    <input type="text" id="expiry" name="expiry"
                                           class="form-control" placeholder="MM/YY" maxlength="5">
                                    @if (!empty($errors['expiry']))
                                        <div class="form-error text-danger mt-1">{{ $errors['expiry'] }}</div>
                                    @endif
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" id="cvv" name="cvv"
                                           class="form-control" placeholder="123" maxlength="4">
                                    @if (!empty($errors['cvv']))
                                        <div class="form-error text-danger mt-1">{{ $errors['cvv'] }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control"
                               value="{{ old('full_name', $currentUser['name'] ?? '') }}" required>
                        @if (!empty($errors['full_name']))
                            <div class="form-error text-danger mt-1">{{ $errors['full_name'] }}</div>
                        @endif
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                               value="{{ old('email', $currentUser['email'] ?? '') }}" required>
                        @if (!empty($errors['email']))
                            <div class="form-error text-danger mt-1">{{ $errors['email'] }}</div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        @if ($plan['is_trial'])
                            Start Free Trial
                        @else
                            Complete Payment - ₱{{ number_format($plan['price'], 0) }}
                        @endif
                    </button>
                </form>

                <div class="security-note mt-4">
                    <p><strong>🔒 Secure Payment:</strong> Your payment information is encrypted and secure.
                        We use industry-standard security measures to protect your data.
                    </p>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const paymentMethodSelect = document.getElementById('payment_method');
                const cardDetails = document.querySelector('.card-details');
                const form = document.querySelector('.payment-form');
                const submitBtn = form.querySelector('button[type="submit"]');

                if (paymentMethodSelect) {
                    paymentMethodSelect.addEventListener('change', function () {
                        if (this.value === 'card') {
                            cardDetails.style.display = 'block';
                            cardDetails.querySelectorAll('input').forEach(input => input.required = true);
                        } else {
                            cardDetails.style.display = 'none';
                            cardDetails.querySelectorAll('input').forEach(input => input.required = false);
                        }
                    });
                    paymentMethodSelect.dispatchEvent(new Event('change'));
                }

                // Card number formatting
                const cardNumberInput = document.getElementById('card_number');
                if (cardNumberInput) {
                    cardNumberInput.addEventListener('input', function () {
                        let value = this.value.replace(/\s/g, '').replace(/[^0-9]/g, '');
                        this.value = value.match(/.{1,4}/g)?.join(' ') ?? value;
                    });
                }

                // Expiry formatting
                const expiryInput = document.getElementById('expiry');
                if (expiryInput) {
                    expiryInput.addEventListener('input', function () {
                        let value = this.value.replace(/\D/g, '');
                        if (value.length >= 2) value = value.slice(0, 2) + '/' + value.slice(2, 4);
                        this.value = value;
                    });
                }

                // CVV numeric only
                const cvvInput = document.getElementById('cvv');
                if (cvvInput) {
                    cvvInput.addEventListener('input', function () {
                        this.value = this.value.replace(/\D/g, '');
                    });
                }

                // Disable button on submit
                form.addEventListener('submit', function () {
                    submitBtn.textContent = 'Processing...';
                    submitBtn.disabled = true;
                });
            });
        </script>
    @endpush
@endsection
