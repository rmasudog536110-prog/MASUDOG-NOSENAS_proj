<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sign Up - FitClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <main class="content-section">
        <div class="container">
            <div class="form-container" style="max-width: 500px;">
                <h1 class="text-center" style="margin-bottom: 2rem;">Join FitClub</h1>

                
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

                <form method="POST" action="{{ route('register.submit') }}">
                    @csrf
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
                        <label for="phone_number">Phone Number (Optional)</label>
                        <div class="input-group">
                        <span class="input-group-text">+63</span>
                        <input
                            type="tel"
                            id="phone_number"
                            name="phone_number"
                            class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0.10);"
                            value="{{ old('phone') }}"
                            placeholder="9284594158"
                        >
                        </div>
                        @if ($errors->has('phone_number'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('phone_number') }}</div>
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
                        <p><small class="text-muted">Minimum 6 characters</small></p>
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

                    <div class="form-group mb-3">
                        <label for="plan_id">Choose a Subscription Plan</label>
                        <select
                            id="plan_id"
                            name="plan_id"
                            class="form-control {{ $errors->has('plan_id') ? 'is-invalid' : '' }}"
                        >
                            <option value="">-- Please Select a Plan --</option>
                            @foreach(\App\Models\SubscriptionPlan::all() as $plan)
                                <option value="{{ $plan->id }}"
                                {{ old('plan_id', $selectedPlanId ?? '') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->name }} — ₱{{ number_format($plan->price, 2) }}
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('plan_id'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('plan_id') }}</div>
                        @endif
                    </div>

                    @php
                        $buttonLabel = 'Create Account';
                    @endphp

                    <button type="submit" class="btn btn-primary btn-full mt-3">{{ $buttonLabel }}</button>
                </form>

                <div class="text-muted" style="margin-top: 2rem;">
                    <p><a href="{{ url('/login') }}">Already have an account? Login here</a></p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
