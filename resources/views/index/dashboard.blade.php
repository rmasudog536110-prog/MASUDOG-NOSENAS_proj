@extends('skeleton.layout')

@section('title', 'Dashboard - FitClub')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
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

            @if (session('success'))
                <h1 class="welcome-title session-welcome">
                    👋 Welcome back, {{ Auth::user()->name }}!
                </h1>
            @endif

            @if(!empty($subtitle))
                <p class="welcome-subtitle">{{ $subtitle }}</p>
            @endif

            <h1 class="welcome-title main-title">
                FITCLUB <br> 
                <span>Results start here. Push yourself because no one else will.</span>
            </h1>
        </div>
    </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon">🏋️</div>
                <div class="stat-value count-display">{{ $workoutStats['total_workouts'] ?? 0 }}</div>
                <div class="stat-label">Total Workouts</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">📅</div>
                <div class="stat-value count-display">{{ $workoutStats['weekly_workouts'] ?? 0 }}</div>
                <div class="stat-label">This Week</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🔥</div>
                <div class="stat-value count-display">{{ $workoutStats['days_active'] ?? 0 }}</div>
                <div class="stat-label">Days Active</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⭐</div>
                <div class="stat-value count-display">
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
                                <div class="detail-value duration-display">{{ $daysLeft }} days</div>
                            </div>
                        @endif
                    @endif

                    <div class="detail-item">
                        <div class="detail-label">Amount Paid</div>
                        <div class="detail-value price-display">₱{{ number_format($userSubscription->plan->price ?? 0, 2) }}</div>
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
                    @php
                        $progressWidth = min(100, max(0, ($daysLeft / 30) * 100));
                    @endphp
                    <div class="progress-bar-container">
                        <div class="progress-bar" style="width: {{ $progressWidth }}%"></div>
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
                <div class="section-actions">
                    <a href="{{ route('customer.instructor-requests') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-plus" style="margin-right: 10px;"></i> Request Instructor
                    </a>
                    <a href="{{ route('workout-logs.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 10px;"></i> View All
                    </a>
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
                    
                    <!-- Instructor Request Button -->
                    <a href="#request-instructor-modal" class="action-card" data-bs-toggle="modal">
                        <span class="action-card-icon">👨‍🏫</span>
                        <span class="action-card-text">Request Instructor</span>
                    </a>
                @endif
            
                <a href="{{ route('profile.show') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-user" style="margin-right: 0.5rem;"></i>
                    Edit Profile
                </a>

                @if (in_array($subscriptionStatus, ['expired', 'none']) || !$userSubscription)
                    <a href="{{ url('#subscription-plans') }}" class="btn btn-primary btn-sm">
                        <span class="action-card-icon">⭐</span>
                        <span class="action-card-text">{{ $subscriptionStatus === 'expired' ? 'Renew Plan' : 'Choose a Plan' }}</span>
                    </a>
                @endif
            </div>
        </div>
    </div>

    @include('index.footer')

    <!-- Instructor Request Modal -->
    <div class="modal fade" id="request-instructor-modal" tabindex="-1" aria-labelledby="request-instructor-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: var(--card); border: 1px solid rgba(255, 102, 0, 0.2);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(255, 102, 0, 0.2);">
                    <h5 class="modal-title" id="request-instructor-modal-label" style="color: var(--primary);">
                        <i class="fa-solid fa-dumbbell"></i> Request Personal Instructor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('instructor.requests.store') }}" method="POST" id="instructor-request-form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="preferred_date" class="form-label" style="color: var(--foreground);">Preferred Date</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="preferred_date" 
                                       name="preferred_date" 
                                       min="{{ date('Y-m-d') }}"
                                       required
                                       style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground);">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="preferred_time" class="form-label" style="color: var(--foreground);">Preferred Time</label>
                                <input type="time" 
                                       class="form-control" 
                                       id="preferred_time" 
                                       name="preferred_time" 
                                       required
                                       style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground);">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exercise_type" class="form-label" style="color: var(--foreground);">Exercise Type</label>
                            <select class="form-select" 
                                    id="exercise_type" 
                                    name="exercise_type" 
                                    required
                                    style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground);">
                                <option value="">Select Exercise Type</option>
                                <option value="strength">💪 Strength Training</option>
                                <option value="cardio">🏃 Cardio</option>
                                <option value="yoga">🧘 Yoga</option>
                                <option value="pilates">🤸 Pilates</option>
                                <option value="crossfit">⚡ CrossFit</option>
                                <option value="bodybuilding">🏋️ Bodybuilding</option>
                                <option value="rehabilitation">🏥 Rehabilitation</option>
                                <option value="weight_loss">📉 Weight Loss</option>
                                <option value="flexibility">🤸‍♂️ Flexibility</option>
                                <option value="functional">🔧 Functional Training</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="goals" class="form-label" style="color: var(--foreground);">Your Goals & Requirements</label>
                            <textarea class="form-control" 
                                      id="goals" 
                                      name="goals" 
                                      rows="4" 
                                      placeholder="Tell us about your fitness goals, experience level, injuries, equipment preferences, etc."
                                      style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground); resize: vertical;"
                                      required></textarea>
                        </div>
                        
                        <div class="alert alert-info" style="background: rgba(255, 102, 0, 0.1); border: 1px solid rgba(255, 102, 0, 0.3); color: var(--foreground);">
                            <i class="fa-solid fa-info-circle"></i>
                            <strong>How it works:</strong> Our instructors will review your request and get back to you with scheduling options and recommendations.
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(255, 102, 0, 0.2);">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" style="color: var(--muted-foreground);">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-paper-plane"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
