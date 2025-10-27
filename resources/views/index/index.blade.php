@extends('skeleton.layout')

@section('title', 'FitClub - Premium Gym Membership')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endpush

@section('content')

@include('index.header')

    <!-- Hero Section -->
    <section class="hero">
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
                    <a href="{{ route('dashboard') }}" class="btn btn-primary cta-btn">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Subscription Plans -->
    <section class="subscription-plans" id="subscription-plans">
        <div class="container">
            <h2>Choose Your Plan</h2>
            <div class="plans-grid">
                @foreach ($plans as $plan)
                    <div class="plan-card
                        {{ $plan['name'] === 'Quarterly' ? 'popular' : '' }}
                        {{ $plan['is_trial'] ? 'trial-plan' : '' }}">
                        
                        @if ($plan['name'] === 'Quarterly')
                            <div class="plan-badge">Most Popular</div>
                        @endif

                        <div class="plan-header">
                            <h3>{{ $plan['name'] }}</h3>
                            <div class="plan-price">
                                <span class="price">₱{{ number_format($plan['price'], 2) }}</span>
                                <span class="duration">
                                    @if ($plan['duration_days'] == 7)
                                        7 days
                                    @elseif ($plan['duration_days'] == 30)
                                        1 month
                                    @elseif ($plan['duration_days'] == 90)
                                        3 months
                                    @endif
                                </span>
                            </div>
                        </div>

                        <ul class="plan-features">
                            @foreach ($plan['features']  as $feature)
                                <li>{{ $feature }}</li> 
                            @endforeach
                        </ul>

                       @auth
                            @if ($userSubscription && $userSubscription->plan_id == $plan->id)
                                <button class="btn btn-outline" disabled>Current Plan</button>
                            @else
                                <a href="{{ route('register', ['plan_id' => $plan->id]) }}"
                                class="btn {{ $plan->is_trial ? 'btn-outline' : 'btn-primary' }}">
                                    {{ $plan->is_trial ? 'Start Free Trial' : 'Subscribe Now' }}
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register', ['plan_id' => $plan->id]) }}"
                            class="btn {{ $plan->is_trial ? 'btn-outline' : 'btn-primary' }}">
                                {{ $plan->is_trial ? 'Start Free Trial' : 'Subscribe Now' }}
                            </a>
                        @endauth
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Training Programs Preview -->
    <section class="training-preview">
        <div class="container">
            <h2>Preview Our Training Programs</h2>
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
                    <a href="{{ route('programs') }}" class="btn btn-primary">View All Programs</a>
                </div>
            @else
                <div class="text-center mt-4">
                    <a href="{{ route('register')}}" class="btn btn-primary">Sign Up to Access Programs</a>
                </div>
            @endauth
        </div>
    </section>  

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Why Choose FitClub?</h2>
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
@endsection
