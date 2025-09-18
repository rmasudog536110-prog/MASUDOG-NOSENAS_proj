<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sign Up - FitClub</title>
    <link rel="stylesheet" href="{{ asset('css/HTML-CSS.styles.css') }}"> {{-- adjust filename if needed --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="content-section">
        <div class="container">
            <div class="form-container" style="max-width: 500px;">
                <h1 class="text-center" style="margin-bottom: 2rem;">Join FitClub</h1>

                {{-- selected plan info (works with arrays or Eloquent models) --}}
                @if(!empty($selectedPlan))
                    <div class="selected-plan-info" style="background-color: var(--accent); padding: 1rem; border-radius: var(--radius); margin-bottom: 2rem; text-align: center;">
                        <h3>Selected Plan: {{ data_get($selectedPlan, 'name') }}</h3>
                        <p>₱{{ number_format(data_get($selectedPlan, 'price', 0), 0) }} - {{ data_get($selectedPlan, 'description') }}</p>
                    </div>
                @endif

                {{-- general flash error --}}
                @if ($errors->has('general'))
                    <div class="flash-message error" style="margin-bottom: 1.5rem; padding: 1rem; border-radius: var(--radius);">
                        {{ $errors->first('general') }}
                    </div>
                @endif

                <form method="POST" action="{{ url('/register') }}">
                    @csrf

                    {{-- keep plan_id from old input or provided selectedPlanId --}}
                    <input type="hidden" name="plan_id" value="{{ old('plan_id', $selectedPlanId ?? '') }}">

                    <div class="form-group mb-3">
                        <label for="name">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                            value="{{ old('name') }}"
                            required
                        >
                        @if ($errors->has('name'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('name') }}</div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            required
                        >
                        @if ($errors->has('email'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">Phone Number (Optional)</label>
                        <input
                            type="tel"
                            id="phone"
                            name="phone"
                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            value="{{ old('phone') }}"
                            placeholder="+63 9284594158"
                        >
                        @if ($errors->has('phone'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('phone') }}</div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            required
                            minlength="6"
                        >
                        @if ($errors->has('password'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('password') }}</div>
                        @endif
                        <small class="text-muted">Minimum 6 characters</small>
                    </div>

                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        {{-- Laravel expects password_confirmation when using the "confirmed" rule --}}
                        <input
                            type="password"
                            id="confirm_password"
                            name="password_confirmation"
                            class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
                            required
                        >
                        @if ($errors->has('password_confirmation'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('password_confirmation') }}</div>
                        @endif
                    </div>

                    {{-- plan selector (if no pre-selected plan) --}}
                    @if (empty($selectedPlanId))
                        <div class="form-group mb-3">
                            <label for="plan_select">Choose a Plan (Optional)</label>
                            <select id="plan_select" name="plan_id" class="form-control">
                                <option value="">Select a plan later</option>
                                @foreach($plans ?? [] as $plan)
                                    @php
                                        $planId = data_get($plan, 'id');
                                        $selected = (string) old('plan_id', $selectedPlanId ?? '') === (string) $planId;
                                    @endphp
                                    <option value="{{ $planId }}" {{ $selected ? 'selected' : '' }}>
                                        {{ data_get($plan,'name') }} - ₱{{ number_format(data_get($plan,'price',0), 0) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    @php
                        $buttonLabel = isset($selectedPlanId) ? 'Create Account & Continue' : 'Create Account';
                    @endphp

                    <button type="submit" class="btn btn-primary btn-full mt-3">{{ $buttonLabel }}</button>
                </form>

                <div class="text-center" style="margin-top: 2rem;">
                    <p>Already have an account? <a href="{{ url('/login') }}" style="color: var(--primary); font-weight: var(--font-weight-medium);">Login here</a></p>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');

            // real-time password confirmation (HTML5 customValidity)
            function checkPasswordMatch() {
                if (confirmPassword.value && password.value !== confirmPassword.value) {
                    confirmPassword.setCustomValidity('Passwords do not match');
                } else {
                    confirmPassword.setCustomValidity('');
                }
            }

            password.addEventListener('input', checkPasswordMatch);
            confirmPassword.addEventListener('input', checkPasswordMatch);

            form.addEventListener('submit', function() {
                submitBtn.textContent = 'Creating Account...';
                submitBtn.disabled = true;
            });

            const initialBtnText = @json($buttonLabel);
            const hadErrors = @json($errors->any());

            if (hadErrors) {
                // restore button when server-side validation failed
                submitBtn.textContent = initialBtnText;
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
