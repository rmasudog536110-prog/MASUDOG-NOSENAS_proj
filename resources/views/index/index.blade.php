@extends('skeleton.layout')

@section('title', 'FitClub - Premium Gym Membership')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')

@include('index.index_header')

<!-- Hero Section -->
<section class="hero" aria-label="Hero section">
    <div class="container">
        <div class="hero-content">
            <h1>Transform Your Body, Transform Your Life</h1>
            <p>
                Join thousands of members who have achieved their fitness goals
                with our premium training programs and expert guidance.
            </p>

            @guest
            <a href="#subscription-plans" class="btn btn-primary cta-btn">Start Your Free Trial</a>
            @else
            <a href="{{ route('user_dashboard') }}" class="btn btn-primary cta-btn">Go to Dashboard</a>
            @endguest
        </div>
    </div>
</section>

<!-- Subscription Plans -->
<section class="subscription-plans" id="subscription-plans" aria-labelledby="plans-heading">
    <div class="container">
        <h2 id="plans-heading">Choose Your Plan</h2>
        <div class="plans-grid">
            @foreach ($plans as $plan)
            <div class="plan-card
                        {{ $plan['name'] === 'Quarterly' ? 'popular' : '' }}
                        {{ $plan['is_trial'] ? 'trial-plan' : '' }}">

                @if ($plan['name'] === 'Pro Plan')
                <div class="plan-badge">Most Popular</div>
                @endif

                        <div class="plan-header">
                            <h3>{{ $plan['name'] }}</h3>
                            <div>
                                <span class="price">₱{{ number_format($plan['price'], 2) }}</span>
                            </div>
                            <span class="free-trial">7-Day Free Trial</span>
                        </div>

                <ul class="plan-features">
                    @foreach ($plan['features'] as $feature)
                    <li>{{ $feature }}</li>
                    @endforeach
                </ul>

                @auth
                @if ($userSubscription && $userSubscription->plan_id == $plan->id && $userSubscription->status == 'approved')
                <a href="{{ route('profile.show') }}" class="btn btn-outline" aria-label="View current active plan">
                    <i class="fa-solid fa-check"></i> Current Plan
                </a>
                @elseif ($userSubscription && $userSubscription->plan_id == $plan->id && $userSubscription->status == 'pending')
                <button class="btn btn-warning" onclick="cancelPayment({{ $userSubscription->id }})" aria-label="Cancel pending payment">
                    <i class="fa-solid fa-clock"></i> Cancel Payment
                </button>
                @elseif ($userSubscription && $userSubscription->status == 'approved')
                <a href="{{ route('profile.show') }}" class="btn btn-secondary" aria-label="View current subscription">
                    <i class="fa-solid fa-ban"></i> View Current Plan
                </a>
                @elseif ($userSubscription && $userSubscription->status == 'pending')
                <button class="btn btn-secondary" onclick="cancelPayment({{ $userSubscription->id }})" aria-label="Cancel payment pending for another plan">
                    <i class="fa-solid fa-hourglass-half"></i> Cancel Payment
                </button>
                @else
                <a href="{{ route('subscription.payment.form', $plan->id) }}"
                    class="btn {{ $plan->is_trial ? 'btn-outline' : 'btn-primary' }}"
                    aria-label="Subscribe to {{ $plan['name'] }} plan">
                    <i class="fa-solid fa-credit-card"></i> {{ $plan->is_trial ? 'Start Free Trial' : 'Subscribe Now' }}
                </a>
                @endif
                @else
                <a href="{{ route('register', ['plan' => $plan->id]) }}"
                    class="btn {{ $plan->is_trial ? 'btn-outline' : 'btn-primary' }}"
                    aria-label="Login to subscribe to {{ $plan['name'] }} plan">
                    <i class="fa-solid fa-sign-in-alt"></i> {{ $plan->is_trial ? 'Login to Start Trial' : 'Login to Subscribe' }}
                </a>
                @endauth
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Training Programs Preview -->
<section class="training-preview" aria-labelledby="programs-heading">
    <div class="container">
        <h2 id="programs-heading">Preview Our Training Programs</h2>
        <div class="programs-grid">
            <div class="program-card">
                <h3>Beginner Fitness</h3>
                <p>Perfect for those starting their fitness journey. Build foundation strength and learn proper form.</p>
                <div class="program-meta">
                    <span class="duration">4–6 weeks</span>
                    <span class="level">Beginner</span>
                </div>
            </div>

            <div class="program-card">
                <h3>Strength Builder</h3>
                <p>Intermediate program focused on building muscle mass and increasing overall strength.</p>
                <div class="program-meta">
                    <span class="duration">8–12 weeks</span>
                    <span class="level">Intermediate</span>
                </div>
            </div>

            <div class="program-card">
                <h3>Athletic Performance</h3>
                <p>Advanced training for serious athletes looking to maximize their performance potential.</p>
                <div class="program-meta">
                    <span class="duration">12+ weeks</span>
                    <span class="level">Expert</span>
                </div>
            </div>
        </div>

        @auth
        <div class="text-center mt-4">
            <a href="{{ route('programs.index') }}" class="btn btn-primary">View All Programs</a>
        </div>
        @else
        <div class="text-center mt-4">
            <a href="{{ route('register')}}" class="btn btn-primary">Sign Up to Access Programs</a>
        </div>
        @endauth
    </div>
</section>

<!-- Features Section -->
<section class="features" aria-labelledby="features-heading">
    <div class="container">
        <h2 id="features-heading">Why Choose FitClub?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🏋️</div>
                <h3>Expert Training</h3>
                <p>Access professional-grade training programs designed by certified fitness experts.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Mobile Access</h3>
                <p>Train anywhere with our mobile-optimized platform and offline workout capabilities.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Progress Tracking</h3>
                <p>Monitor your progress with detailed analytics and personalized recommendations.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Goal-Oriented</h3>
                <p>Customized workout plans tailored to your specific fitness goals and experience level.</p>
            </div>
        </div>
    </div>
</section>

@include('index.footer')

@push('scripts')
<script>
    function cancelPayment(subscriptionId) {
        if (confirm('Are you sure you want to cancel this pending payment? This action cannot be undone.')) {
            // Create form for cancellation
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/payment/cancel';

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Add subscription ID
            const subscriptionInput = document.createElement('input');
            subscriptionInput.type = 'hidden';
            subscriptionInput.name = 'subscription_id';
            subscriptionInput.value = subscriptionId;
            form.appendChild(subscriptionInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
@endpush