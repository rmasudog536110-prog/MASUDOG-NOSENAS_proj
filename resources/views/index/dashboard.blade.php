@extends('skeleton.layout')

@section('title', 'Dashboard - FitClub')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link 
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" 
        rel="stylesheet"
    >
@endpush

@section('content')

@include('index.header')

    {{-- Flash Messages --}}
    @if (session('success'))
        <div class="flash-message success">
            <div class="container">{{ session('success') }}</div>
        </div>
    @endif

    @if (session('error'))
        <div class="flash-message error">
            <div class="container">{{ session('error') }}</div>
        </div>
    @endif

    @if (session('warning'))
        <div class="flash-message warning">
            <div class="container">{{ session('warning') }}</div>
        </div>
    @endif

    <section class="content-section">
        <div class="container">

            <div class="dashboard-grid">
                {{-- Subscription Status --}}
                <div class="dashboard-card">
                    <h3>Subscription Status</h3>

                    <div class="subscription-info">
                        @if ($userSubscription)
                            <div class="subscription-plan">
                                <strong>Plan:</strong> {{ $userSubscription->plan->name }}
                            </div>

                            <div class="subscription-status {{ $subscriptionStatus }}">
                                <strong>Status:</strong>
                                @switch($subscriptionStatus)
                                    @case('trial')
                                        Free Trial Active
                                        @break
                                    @case('active')
                                        Premium Active
                                        @break
                                    @case('expired')
                                        Expired
                                        @break
                                    @default
                                        No Active Subscription
                                @endswitch
                            </div>

                            @if ($subscriptionExpiry)
                                <div class="subscription-expires">
                                    <strong>
                                        {{ $subscriptionStatus === 'expired' ? 'Expired on:' : 'Expires on:' }}
                                    </strong>
                                    {{ $subscriptionExpiry->format('F j, Y') }}

                                    @if ($subscriptionStatus !== 'expired')
                                        <br>
                                        <small>({{ $daysLeft }} days left)</small>
                                    @endif
                                </div>
                            @endif

                            <div class="subscription-amount">
                                <strong>Amount Paid:</strong> ₱{{ number_format($userSubscription->plan->price ?? 0, 2) }}
                            </div>
                        @else
                            <div class="no-subscription">
                                <p>You don't have an active subscription.</p>
                                <a 
                                    href="{{ url('#subscription-plans') }}" 
                                    class="btn btn-primary mt-3"
                                >
                                    Choose a Plan
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Progress Overview --}}
                <div class="dashboard-card">
                    <h3>Progress Overview</h3>

                    <div class="progress-stats">
                        <div class="stat">
                            <span class="stat-value">{{ $workoutStats['total_workouts'] ?? 0 }}</span>
                            <span class="stat-label">Total Workouts</span>
                        </div>

                        <div class="stat">
                            <span class="stat-value">{{ $workoutStats['weekly_workouts'] ?? 0 }}</span>
                            <span class="stat-label">This Week</span>
                        </div>

                        <div class="stat">
                            <span class="stat-value">{{ $workoutStats['days_active'] ?? 0 }}</span>
                            <span class="stat-label">Days Active</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        @if (in_array($subscriptionStatus, ['active', 'trial']))
                            <a href="{{ route('programs') }}" class="btn btn-primary btn-full">
                                Start New Workout
                            </a>
                        @else
                            <p class="text-center text-muted">
                                Subscribe to access workout programs
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Recent Activities --}}
                <div class="dashboard-card">
                    <h3>Recent Activities</h3>

                    <div class="activity-list">
                        @if (!empty($recentActivities))
                            @foreach ($recentActivities as $activity)
                                <div class="activity-item">
                                    <div class="activity-details">
                                        <span class="activity-name">
                                            {{ $activity['exercise_name'] ?? $activity['program_title'] ?? 'Workout' }}
                                        </span>

                                        @if (!empty($activity['sets_completed']) || !empty($activity['reps_completed']))
                                            <small class="activity-meta">
                                                @if (!empty($activity['sets_completed']))
                                                    {{ $activity['sets_completed'] }} sets
                                                @endif

                                                @if (!empty($activity['reps_completed']))
                                                    × {{ $activity['reps_completed'] }} reps
                                                @endif

                                                @if (!empty($activity['weight_used']))
                                                    @ {{ $activity['weight_used'] }}kg
                                                @endif
                                            </small>
                                        @endif
                                    </div>

                                    <span class="activity-date">
                                        {{ \Carbon\Carbon::parse($activity['workout_date'])->format('M j') }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div class="no-activities">
                                <p>No workout activities yet.</p>

                                @if (in_array($subscriptionStatus, ['active', 'trial']))
                                    <a 
                                        href="{{ route('programs') }}" 
                                        class="btn btn-outline mt-3"
                                    >
                                        Start First Workout
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Quick Actions --}}
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>

                    <div class="quick-actions">
                        @if (in_array($subscriptionStatus, ['active', 'trial']))
                            <a href="{{ route('programs') }}" class="action-btn">
                                <span class="action-icon">🏋️</span>
                                <span>Training Programs</span>
                            </a>

                            <a href="{{ route('exercises') }}" class="action-btn">
                                <span class="action-icon">💪</span>
                                <span>Exercise Library</span>
                            </a>
                        @endif
    
                      {{-- <a href="{{ route('profile') }}" class="action-btn">
                            <span class="action-icon">👤</span>
                            <span>Edit Profile</span>
                        </a>  --}}   

                        @if ($subscriptionStatus === 'expired' || !$userSubscription)
                            <a href="{{ url('#subscription-plans') }}" class="action-btn">
                                <span class="action-icon">⭐</span>
                                <span>Upgrade Plan</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('index.footer')
@endsection
