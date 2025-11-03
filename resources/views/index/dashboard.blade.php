@extends('skeleton.layout')

@section('title', 'Dashboard - FitClub')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .dashboard-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .dashboard-welcome {
            background: linear-gradient(135deg, rgba(255, 102, 0, 0.1) 0%, rgba(26, 26, 26, 0.95) 100%);
            border: 1px solid rgba(255, 102, 0, 0.3);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .dashboard-welcome::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #ffc107, var(--primary));
        }

        .welcome-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            color: var(--muted-foreground);
            font-size: 1.125rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--primary);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
        }

        .stat-card:hover::before {
            opacity: 1;
        }

        .stat-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 2px 4px rgba(255, 102, 0, 0.3));
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .dashboard-section {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--foreground);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .subscription-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            border-radius: 2rem;
            font-weight: 600;
            font-size: 1rem;
        }

        .badge-active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .badge-expired {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .badge-none {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }

        .badge-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .subscription-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-top: 1.5rem;
        }

        .detail-item {
            padding: 1rem;
            background: rgba(255, 102, 0, 0.05);
            border-radius: 0.5rem;
        }

        .detail-label {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .detail-value {
            color: var(--foreground);
            font-size: 1.125rem;
            font-weight: 600;
        }

        .activity-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: rgba(255, 102, 0, 0.05);
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(255, 102, 0, 0.1);
            transform: translateX(5px);
        }

        .activity-icon {
            font-size: 1.5rem;
            margin-right: 1rem;
        }

        .activity-info {
            flex: 1;
        }

        .activity-name {
            color: var(--foreground);
            font-weight: 600;
            display: block;
            margin-bottom: 0.25rem;
        }

        .activity-meta {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .activity-date {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .quick-actions-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .action-card {
            background: linear-gradient(135deg, rgba(255, 102, 0, 0.1) 0%, rgba(26, 26, 26, 0.5) 100%);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 1.5rem;
            text-align: center;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.75rem;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
            border-color: rgba(255, 102, 0, 0.5);
        }

        .action-card-icon {
            font-size: 2.5rem;
            filter: drop-shadow(0 2px 4px rgba(255, 102, 0, 0.3));
        }

        .action-card-text {
            color: var(--foreground);
            font-weight: 600;
            font-size: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--muted-foreground);
        }

        .empty-state-icon {
            font-size: 4rem;
            opacity: 0.3;
            margin-bottom: 1rem;
        }

        .progress-bar-container {
            background: rgba(255, 102, 0, 0.1);
            border-radius: 1rem;
            height: 8px;
            overflow: hidden;
            margin-top: 0.5rem;
        }

        .progress-bar {
            background: linear-gradient(90deg, var(--primary), #ffc107);
            height: 100%;
            border-radius: 1rem;
            transition: width 0.3s ease;
        }
    </style>
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

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="dashboard-welcome">
            <h1 class="welcome-title">👋 Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="welcome-subtitle">Here's your fitness journey overview</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏋️</div>
                <div class="stat-value">{{ $workoutStats['total_workouts'] ?? 0 }}</div>
                <div class="stat-label">Total Workouts</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-value">{{ $workoutStats['weekly_workouts'] ?? 0 }}</div>
                <div class="stat-label">This Week</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🔥</div>
                <div class="stat-value">{{ $workoutStats['days_active'] ?? 0 }}</div>
                <div class="stat-label">Days Active</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-value">
                    @if($userSubscription)
                        {{ $daysLeft }}
                    @else
                        0
                    @endif
                </div>
                <div class="stat-label">Days Left</div>
            </div>
        </div>

        <!-- Subscription Status Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-credit-card"></i> Subscription Status
                </h2>

                <span class="subscription-badge badge-{{ 
                    $subscriptionStatus === 'active' ? 'active' : 
                    ($subscriptionStatus === 'expired' ? 'expired' : 
                    ($subscriptionStatus === 'pending' ? 'pending' : 
                    ($subscriptionStatus === 'rejected' ? 'expired' : 'none'))) 
                }}">
                    @if($subscriptionStatus === 'active')
                        <i class="fa-solid fa-check-circle"></i> Premium Active
                    @elseif($subscriptionStatus === 'pending')
                        <i class="fa-solid fa-clock"></i> Payment Pending Approval
                    @elseif($subscriptionStatus === 'rejected')
                        <i class="fa-solid fa-times-circle"></i> Payment Rejected
                    @elseif($subscriptionStatus === 'expired')
                        <i class="fa-solid fa-times-circle"></i> Expired
                    @else
                        <i class="fa-solid fa-info-circle"></i> No Subscription
                    @endif
                </span>
            </div>

            @if ($userSubscription)
                <div class="subscription-details">
                    <div class="detail-item">
                        <div class="detail-label">Plan</div>
                        <div class="detail-value">{{ $userSubscription->plan->name }}</div>
                    </div>

                    @if ($subscriptionExpiry)
                        <div class="detail-item">
                            <div class="detail-label">{{ $subscriptionStatus === 'expired' ? 'Expired On' : 'Expires On' }}</div>
                            <div class="detail-value">{{ $subscriptionExpiry->format('M j, Y') }}</div>
                        </div>

                        @if ($subscriptionStatus !== 'expired')
                            <div class="detail-item">
                                <div class="detail-label">Days Remaining</div>
                                <div class="detail-value">{{ $daysLeft }} days</div>
                            </div>
                        @endif
                    @endif

                    <div class="detail-item">
                        <div class="detail-label">Amount Paid</div>
                        <div class="detail-value">₱{{ number_format($userSubscription->plan->price ?? 0, 2) }}</div>
                    </div>
                </div>

                @if ($subscriptionStatus === 'pending')
                    <div style="background: rgba(255, 193, 7, 0.1); border-left: 4px solid #ffc107; padding: 1rem; border-radius: 0.5rem; margin-top: 1rem;">
                        <p style="color: var(--foreground); margin: 0;">
                            <i class="fa-solid fa-hourglass-half"></i> Your payment proof is being reviewed by our admin team. You'll be notified once approved.
                        </p>
                    </div>
                @elseif ($subscriptionStatus === 'rejected' && $userSubscription->admin_notes)
                    <div style="background: rgba(220, 53, 69, 0.1); border-left: 4px solid #dc3545; padding: 1rem; border-radius: 0.5rem; margin-top: 1rem;">
                        <p style="color: var(--foreground); margin: 0 0 0.5rem 0; font-weight: 600;">
                            <i class="fa-solid fa-exclamation-triangle"></i> Payment Rejected
                        </p>
                        <p style="color: var(--muted-foreground); margin: 0;">
                            <strong>Reason:</strong> {{ $userSubscription->admin_notes }}
                        </p>
                        <a href="{{ url('#subscription-plans') }}" class="btn btn-primary" style="margin-top: 1rem;">
                            <i class="fa-solid fa-redo"></i> Try Again
                        </a>
                    </div>
                @elseif ($subscriptionStatus !== 'expired' && $daysLeft > 0)
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ ($daysLeft / 30) * 100 }}%"></div>
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">💳</div>
                    <p>You don't have an active subscription.</p>
                    <a href="{{ url('#subscription-plans') }}" class="btn btn-primary" style="margin-top: 1rem;">
                        <i class="fa-solid fa-star"></i> Choose a Plan
                    </a>
                </div>
            @endif
        </div>

        <!-- Recent Activities Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-clock-rotate-left"></i> Recent Activities
                </h2>
                <div style="display: flex; gap: 0.5rem;">
                    <a href="{{ route('workout-logs.create') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus"></i> Log Workout
                    </a>
                    <a href="{{ route('workout-logs.index') }}" class="btn btn-outline btn-sm">View All</a>
                </div>
            </div>

            @if (!empty($recentActivities))
                @foreach ($recentActivities as $activity)
                    <div class="activity-item">
                        <span class="activity-icon">🏋️</span>
                        <div class="activity-info">
                            <span class="activity-name">
                                {{ $activity['exercise_name'] ?? $activity['program_title'] ?? 'Workout' }}
                            </span>
                            @if (!empty($activity['sets_completed']) || !empty($activity['reps_completed']))
                                <span class="activity-meta">
                                    @if (!empty($activity['sets_completed']))
                                        {{ $activity['sets_completed'] }} sets
                                    @endif
                                    @if (!empty($activity['reps_completed']))
                                        × {{ $activity['reps_completed'] }} reps
                                    @endif
                                    @if (!empty($activity['weight_used']))
                                        @ {{ $activity['weight_used'] }}kg
                                    @endif
                                </span>
                            @endif
                        </div>
                        <span class="activity-date">
                            {{ \Carbon\Carbon::parse($activity['workout_date'])->format('M j') }}
                        </span>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <p>No workout activities yet.</p>
                    @if (in_array($subscriptionStatus, ['active', 'trial']))
                        <a href="{{ route('programs') }}" class="btn btn-primary" style="margin-top: 1rem;">
                            <i class="fa-solid fa-play"></i> Start First Workout
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Quick Actions Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-bolt"></i> Quick Actions
                </h2>
            </div>

            <div class="quick-actions-grid">
                @if (in_array($subscriptionStatus, ['active', 'trial']))
                    <a href="{{ route('workout-logs.create') }}" class="action-card" style="background: linear-gradient(135deg, rgba(255, 102, 0, 0.2) 0%, rgba(26, 26, 26, 0.5) 100%); border-color: rgba(255, 102, 0, 0.4);">
                        <span class="action-card-icon">➕</span>
                        <span class="action-card-text">Log Workout</span>
                    </a>

                    <a href="{{ route('programs') }}" class="action-card">
                        <span class="action-card-icon">🏋️</span>
                        <span class="action-card-text">Training Programs</span>
                    </a>

                    <a href="{{ route('exercises') }}" class="action-card">
                        <span class="action-card-icon">💪</span>
                        <span class="action-card-text">Exercise Library</span>
                    </a>

                    <a href="{{ route('workout-logs.index') }}" class="action-card">
                        <span class="action-card-icon">📊</span>
                        <span class="action-card-text">My Workouts</span>
                    </a>
                @endif

                <a href="{{ route('profile.show') }}" class="action-card">
                    <span class="action-card-icon">👤</span>
                    <span class="action-card-text">Edit Profile</span>
                </a>

                @if (in_array($subscriptionStatus, ['expired', 'none']) || !$userSubscription)
                    <a href="{{ url('#subscription-plans') }}" class="action-card">
                        <span class="action-card-icon">⭐</span>
                        <span class="action-card-text">{{ $subscriptionStatus === 'expired' ? 'Renew Plan' : 'Choose a Plan' }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @include('index.footer')
@endsection
