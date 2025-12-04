@extends('skeleton.layout')

@section('title', 'Dashboard - FitClub')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')


@if ($userSubscription && $userSubscription->status === 'active')
@include('index.header')
@endif


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

@if ($userSubscription && $userSubscription->status === 'active')
    <!-- Quick Actions Section -->
    <div class="dashboard-container1">
            <h2 class="section-title">
                <i class="fa-solid fa-bolt"></i> Quick Actions
            </h2>

        <div class="quick-actions-grid">

            {{-- USER HAS ACTIVE SUBSCRIPTION --}}
            @if ($subscriptionStatus === 'active')

                <a href="{{ route('workout-logs.create') }}" class="action-card">
                    <span class="action-card-icon">➕</span>
                    <span class="action-card-text">Log Workout</span>
                </a>

                <a href="{{ route('programs.index') }}" class="action-card">
                    <span class="action-card-icon">🏋️</span>
                    <span class="action-card-text">Training Programs</span>
                </a>

                <a href="{{ route('exercises.index') }}" class="action-card">
                    <span class="action-card-icon">💪</span>
                    <span class="action-card-text">Exercise Library</span>
                </a>

                <a href="{{ route('workout-logs.index') }}" class="action-card">
                    <span class="action-card-icon">📊</span>
                    <span class="action-card-text">My Workouts</span>
                </a>

                <a href="#request-instructor-modal" data-bs-toggle="modal" class="action-card">
                    <span class="action-card-icon">👨‍🏫</span>
                    <span class="action-card-text">Request Instructor</span>
                </a>

                {{-- MODIFIED TO USE action-card CLASS --}}
                <a href="{{ route('profile.show') }}" class="action-card">
                    <span class="action-card-icon"><i class="fa-solid fa-user"></i></span>
                    <span class="action-card-text">Edit Profile</span>
                </a>

            @else
                {{-- This button remains as a standard button for clarity --}}
                <a href="{{ url('subscription') }}" class="btn btn-primary btn-sm">
                    <span class="action-card-icon">⭐</span>
                    <span class="action-card-text">
                        {{ $subscriptionStatus === 'expired' ? 'Renew Plan' : 'Choose a Plan' }}
                    </span>
                </a>
            @endif
        </div>
    </div>
@endif
        <!-- Subscription Status Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-credit-card"></i> Subscription Status
                </h2>
            </div>

            @if ($userSubscription)
                <div class="subscription-card">
                    <div class="subscription-header">
                        <div class="subscription-plan">
                            <div class="plan-icon">
                                @if ($userSubscription->plan->name === 'Pro Plan')
                                    <i class="fa-solid fa-crown"></i>
                                @elseif ($userSubscription->plan->name === 'Basic Plan')
                                    <i class="fa-solid fa-star"></i>
                                @else
                                    <i class="fa-solid fa-rocket"></i>
                                @endif
                            </div>
                            <div class="plan-info">
                                <h3 class="plan-name">{{ $userSubscription->plan->name }}</h3>
                                <div class="plan-price">₱{{ number_format($userSubscription->plan->price ?? 0, 2) }}</div>
                            </div>
                        </div>
                        <div class="subscription-status-badge">
                            @php
                                $statusClass = match($subscriptionStatus) {
                                    'active' => 'status-active',
                                    'expired' => 'status-expired',
                                    'pending' => 'status-pending',
                                    'rejected' => 'status-rejected',
                                    'cancelled' => 'status-cancelled',
                                    default => 'status-unknown'
                                };
                            @endphp
                            <span class="status-badge {{ $statusClass }}">
                                @if ($subscriptionStatus === 'active')
                                    <i class="fa-solid fa-check-circle"></i> Active
                                @elseif ($subscriptionStatus === 'expired')
                                    <i class="fa-solid fa-times-circle"></i> Expired
                                @elseif ($subscriptionStatus === 'pending')
                                    <i class="fa-solid fa-clock"></i> Pending
                                @elseif ($subscriptionStatus === 'rejected')
                                    <i class="fa-solid fa-exclamation-circle"></i> Rejected
                                @else
                                    <i class="fa-solid fa-question-circle"></i> {{ ucfirst($subscriptionStatus) }}
                                @endif
                            </span>
                        </div>
                    </div>

                    <div class="subscription-details-grid">
                        @if ($subscriptionExpiry)
                            <div class="detail-card">
                                <div class="detail-card-icon">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                </div>
                                <div class="detail-card-content">
                                    <div class="detail-card-label">{{ $subscriptionStatus === 'expired' ? 'Expired On' : 'Expires On' }}</div>
                                    <div class="detail-card-value">{{ $subscriptionExpiry->format('M j, Y') }}</div>
                                </div>
                            </div>

                            @if ($subscriptionStatus !== 'expired')
                                <div class="detail-card">
                                    <div class="detail-card-icon">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    </div>
                                    <div class="detail-card-content">
                                        <div class="detail-card-label">Days Remaining</div>
                                        <div class="detail-card-value">{{ $daysLeft }} days</div>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="detail-card">
                            <div class="detail-card-icon">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div class="detail-card-content">
                                <div class="detail-card-label">Amount Paid</div>
                                <div class="detail-card-value price-display">₱{{ number_format($userSubscription->plan->price ?? 0, 2) }}</div>
                            </div>
                        </div>

                        <div class="detail-card">
                            <div class="detail-card-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="detail-card-content">
                                <div class="detail-card-label">Started On</div>
                                <div class="detail-card-value">{{ \Carbon\Carbon::parse($userSubscription->start_date)->format('M j, Y') }}</div>
                            </div>
                        </div>
                    </div>

                    @if ($subscriptionStatus === 'pending')
                        <div class="subscription-alert alert-pending">
                            <i class="fa-solid fa-hourglass-half"></i>
                            <div class="alert-content">
                                <strong>Payment Verification:</strong> Your payment proof is being reviewed by our admin team. You'll be notified once approved.
                            </div>
                        </div>
                    @elseif ($subscriptionStatus === 'rejected' && $userSubscription->admin_notes)
                        <div class="subscription-alert alert-rejected">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <div class="alert-content">
                                <strong>Payment Rejected:</strong> {{ $userSubscription->admin_notes }}
                                <div class="alert-actions">
                                    <a href="{{ url('#subscription-plans') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-redo"></i> Try Again
                                    </a>
                                </div>
                            </div>
                        </div>
                    @elseif ($subscriptionStatus === 'expired')
                        <div class="subscription-alert alert-expired">
                            <i class="fa-solid fa-clock"></i>
                            <div class="alert-content">
                                <strong>Subscription Expired:</strong> Your subscription has expired. Renew to continue enjoying our services.
                                <div class="alert-actions">
                                    <a href="{{ url('#subscription-plans') }}" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-star"></i> Renew Plan
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3>No Active Subscription</h3>
                    <p>You don't have an active subscription. Choose a plan to unlock all features.</p>
                    <a href="{{ url('#subscription-plans') }}" class="btn btn-primary">
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
                @if ($subscriptionStatus === 'pending' || $subscriptionStatus === 'expired')
                    @auth
                        <div class="user-info">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-outline">Logout</button>
                            </form>
                        </div>
                     @endauth
                @else
                    <a href="{{ route('workout-logs.index') }}" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 10px;"></i> View All
                     </a>
                @endif
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
                        <a href="{{ route('programs.index') }}" class="btn btn-primary" style="margin-top: 1rem;">
                            <i class="fa-solid fa-play"></i> Start First Workout
                        </a>
                    @endif
                </div>
            @endif
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
