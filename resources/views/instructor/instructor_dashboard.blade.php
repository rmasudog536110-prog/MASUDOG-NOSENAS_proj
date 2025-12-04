@extends('skeleton.layout')

@section('title', 'Instructor Dashboard - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .instructor-header {
            background: linear-gradient(135deg, #ff6600 0%, #e65c00 100%);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .instructor-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #fff, rgba(255,255,255,0.3), #fff);
        }

        .instructor-header h1 {
            margin: 0 0 0.5rem 0;
            color: white;
            font-size: 2.5rem;
        }

        .instructor-header .subtitle {
            color: rgba(255,255,255,0.9);
            font-size: 1.1rem;
        }

        .instructor-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .instructor-stat-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.3);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .instructor-stat-card::before {
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

        .instructor-stat-card:hover::before {
            opacity: 1;
        }

        .instructor-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
        }

        .stat-card-pending {
            border-color: rgba(255, 193, 7, 0.5);
        }

        .stat-card-completed {
            border-color: rgba(40, 167, 69, 0.5);
        }

        .stat-label {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-card-pending .stat-value {
            color: #ffc107;
        }

        .stat-card-completed .stat-value {
            color: #28a745;
        }

        .chart-container {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .session-list {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .session-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.1);
            transition: all 0.3s ease;
        }

        .session-item:last-child {
            border-bottom: none;
        }

        .session-item:hover {
            background: rgba(255, 102, 0, 0.05);
        }

        .session-info {
            flex: 1;
        }

        .session-customer {
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .session-details {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .session-time {
            text-align: right;
            color: var(--primary);
            font-weight: 600;
        }

        .request-status {
            margin-left: 1rem;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .badge-pending {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .badge-active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .badge-expired {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
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
            color: var(--primary);
            font-size: 2rem;
            font-weight: 700;
            text-align: center;
            margin: 0 0 1rem 0;
        }

        .welcome-subtitle {
            color: var(--muted-foreground);
            font-size: 1.125rem;
            text-align: center;
        }

        .section-title {
            color: var(--primary);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.5rem;
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            color: var(--foreground);
            text-decoration: none;
            transition: all var(--transition-speed) ease;
            font-weight: 500;
        }

        .action-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
        }

        .progress-ring {
            width: 120px;
            height: 120px;
            margin: 0 auto 1rem;
            position: relative;
        }

        .progress-ring-circle {
            stroke: rgba(255, 102, 0, 0.2);
            stroke-width: 8;
            fill: transparent;
            r: 48;
            cx: 60;
            cy: 60;
        }

        .progress-ring-circle-progress {
            stroke: var(--primary);
            stroke-width: 8;
            fill: transparent;
            r: 48;
            cx: 60;
            cy: 60;
            stroke-dasharray: 301.59;
            stroke-dashoffset: 301.59;
            transition: stroke-dashoffset 0.3s ease;
            transform: rotate(-90deg);
            transform-origin: 50% 50%;
        }

        .progress-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-weight: 700;
            color: var(--primary);
            font-size: 1.5rem;
        }

        @media (max-width: 768px) {
            .instructor-header h1 {
                font-size: 2rem;
            }
            
            .session-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
            
            .session-time {
                text-align: left;
            }
        }
    </style>
@endpush

@section('content')

@include('index.header')

<section class="content-section">
    <div class="container">
        <!-- Welcome Section -->
        <div class="dashboard-welcome">
            <h1 class="welcome-title">👋 Welcome back, {{ Auth::user()->name }}!</h1>
            <p class="welcome-subtitle">Ready to help your clients achieve their fitness goals?</p>
        </div>

        <!-- Flash Messages -->
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

        <!-- Instructor Header -->
        <div class="instructor-header">
            <h1><i class="fas fa-dumbbell"></i> Instructor Dashboard</h1>
            <p class="subtitle">Manage your sessions and help clients reach their fitness goals</p>
        </div>

        <!-- Stats Grid -->
        <div class="instructor-stats">
            <div class="instructor-stat-card">
                <div class="stat-label">Total Requests</div>
                <div class="stat-value count-display">{{ $stats['total_requests'] }}</div>
            </div>

            <div class="instructor-stat-card stat-card-pending">
                <div class="stat-label">⏳ Pending</div>
                <div class="stat-value count-display">{{ $stats['pending_requests'] }}</div>
            </div>

            <div class="instructor-stat-card stat-card-completed">
                <div class="stat-label">✅ Accepted</div>
                <div class="stat-value count-display">{{ $stats['accepted_requests'] }}</div>
            </div>

            <div class="instructor-stat-card stat-card-completed">
                <div class="stat-label">🎯 Completed</div>
                <div class="stat-value count-display">{{ $stats['completed_sessions'] }}</div>
            </div>

            <div class="instructor-stat-card">
                <div class="stat-label">📅 This Month</div>
                <div class="stat-value count-display">{{ $stats['this_month_sessions'] }}</div>
            </div>

            <div class="instructor-stat-card">
                <div class="stat-label">📊 Success Rate</div>
                <div class="progress-ring">
                    <svg class="progress-ring" width="120" height="120">
                        <circle class="progress-ring-circle" cx="60" cy="60" r="48"></circle>
                        <circle class="progress-ring-circle-progress" 
                                cx="60" 
                                cy="60" 
                                r="48"
                                data-progress="{{ $completionRate }}"></circle>
                    </svg>
                    <div class="progress-text">{{ $completionRate }}%</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="fa-solid fa-bolt"></i> Quick Actions
            </h2>
            <div class="quick-actions">
                <a href="{{ route('instructor.requests') }}" class="action-btn">
                    <i class="fa-solid fa-list"></i>
                    View All Requests
                </a>
                <a href="{{ route('instructor.requests', ['status' => 'pending']) }}" class="action-btn">
                    <i class="fa-solid fa-clock"></i>
                    Pending Requests ({{ $stats['pending_requests'] }})
                </a>
                <a href="#schedule-modal" class="action-btn" data-bs-toggle="modal">
                    <i class="fa-solid fa-calendar-plus"></i>
                    Schedule Session
                </a>
                <a href="{{ route('profile.show') }}" class="action-btn">
                    <i class="fa-solid fa-user"></i>
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Today's Sessions -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-calendar-day"></i> Today's Sessions
                </h2>

                @if($todaySessions->count() > 0)
                    <div class="session-list">
                        @foreach($todaySessions as $session)
                            <div class="session-item">
                                <div class="session-info">
                                    <div class="session-customer">{{ $session->customer->name }}</div>
                                    <div class="session-details">
                                        @if($session->exercise_type)
                                            <i class="fa-solid fa-dumbbell"></i> {{ ucfirst($session->exercise_type) }}
                                        @endif
                                        @if($session->goals)
                                            <br><small>{{ Str::limit($session->goals, 50) }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="session-time">
                                    <div>{{ $session->scheduled_at->format('g:i A') }}</div>
                                    <div class="request-status">
                                        {!! $session->status_badge !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">📅</div>
                        <p>No sessions scheduled for today</p>
                    </div>
                @endif
            </div>

            <!-- Upcoming Sessions -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-calendar-week"></i> Upcoming Sessions
                </h2>

                @if($upcomingSessions->count() > 0)
                    <div class="session-list">
                        @foreach($upcomingSessions as $session)
                            <div class="session-item">
                                <div class="session-info">
                                    <div class="session-customer">{{ $session->customer->name }}</div>
                                    <div class="session-details">
                                        {{ $session->scheduled_at->format('M j, g:i A') }}
                                        @if($session->exercise_type)
                                            <br><i class="fa-solid fa-dumbbell"></i> {{ ucfirst($session->exercise_type) }}
                                        @endif
                                    </div>
                                </div>
                                <div class="request-status">
                                    {!! $session->status_badge !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">🔮</div>
                        <p>No upcoming sessions scheduled</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-clock-rotate-left"></i> Recent Requests
                </h2>
                <a href="{{ route('instructor.requests') }}" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-magnifying-glass" style="margin-right: 0.5rem;"></i>
                    View All
                </a>
            </div>

            @if($recentRequests->count() > 0)
                <div class="table-responsive">
                    <table style="width: 100%; background: var(--card); border-radius: var(--radius); overflow: hidden;">
                        <thead>
                            <tr style="background: rgba(255, 102, 0, 0.1);">
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Customer</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Preferred Date</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Exercise Type</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Status</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentRequests as $request)
                                <tr style="border-bottom: 1px solid rgba(255, 102, 0, 0.1);">
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 600;">{{ $request->customer->name }}</div>
                                        <div style="font-size: 0.875rem; color: var(--muted-foreground);">
                                            {{ $request->customer->email }}
                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        {{ $request->preferred_date_time }}
                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        @if($request->exercise_type)
                                            {{ ucfirst($request->exercise_type) }}
                                        @else
                                            <span style="color: var(--muted-foreground);">Not specified</span>
                                        @endif
                                    </td>
                                    <td style="padding: 1rem;">
                                        {!! $request->status_badge !!}
                                    </td>
                                    <td style="padding: 1rem;">
                                        <a href="{{ route('instructor.requests.show', $request) }}" 
                                           class="btn btn-outline btn-sm">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <p>No instructor requests yet</p>
                </div>
            @endif
        </div>
    </div>
</section>

@include('index.footer')

@endsection

@push('scripts')
<script>
    // Auto-update dashboard every 30 seconds for real-time updates
    setInterval(function() {
        // Optionally implement real-time updates here
        console.log('Dashboard auto-refresh');
    }, 30000);

    // Initialize progress rings
    function initProgressRings() {
        const circles = document.querySelectorAll('.progress-ring-circle-progress');
        circles.forEach(circle => {
            const progress = circle.getAttribute('data-progress') || 0;
            const circumference = 2 * Math.PI * 48; // 2 * π * radius (48)
            const offset = circumference - (progress / 100) * circumference;
            circle.style.strokeDasharray = circumference;
            circle.style.strokeDashoffset = offset;
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', initProgressRings);
</script>
@endpush