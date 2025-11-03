@extends('skeleton.layout')

@section('title', $program['title'] . ' - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .program-detail-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .program-hero {
            background: linear-gradient(135deg, rgba(255, 102, 0, 0.1) 0%, rgba(26, 26, 26, 0.95) 100%);
            border: 1px solid rgba(255, 102, 0, 0.3);
            border-radius: 1rem;
            padding: 3rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .program-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary), #ffc107, var(--primary));
        }

        .program-icon {
            font-size: 4rem;
            filter: drop-shadow(0 4px 8px rgba(255, 102, 0, 0.4));
            margin-bottom: 1rem;
        }

        .program-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 1rem;
        }

        .level-badge {
            display: inline-block;
            padding: 0.5rem 1.5rem;
            border-radius: 2rem;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 1px;
        }

        .level-beginner { background: rgba(40, 167, 69, 0.2); color: #28a745; }
        .level-intermediate { background: rgba(255, 193, 7, 0.2); color: #ffc107; }
        .level-advanced { background: rgba(220, 53, 69, 0.2); color: #dc3545; }
        .level-expert { background: rgba(220, 53, 69, 0.3); color: #ff4c4c; }
        .level-hardcore { background: rgba(52, 58, 64, 0.3); color: #b5b5b5; }

        .program-description {
            font-size: 1.125rem;
            line-height: 1.8;
            color: var(--muted-foreground);
            margin: 1.5rem 0;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin: 2rem 0;
        }

        .stat-box {
            background: rgba(255, 102, 0, 0.05);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
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

        .enrollment-section {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            margin: 2rem 0;
        }

        .enroll-btn {
            background: linear-gradient(135deg, var(--primary) 0%, #e65c00 100%);
            color: white;
            border: none;
            padding: 1rem 3rem;
            font-size: 1.125rem;
            font-weight: 600;
            border-radius: 0.7rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .enroll-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.4);
        }

        .enrolled-badge {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            padding: 1rem 2rem;
            border-radius: 0.7rem;
            font-size: 1.125rem;
            font-weight: 600;
            display: inline-block;
        }

        .info-section {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .info-section h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .benefit-item {
            display: flex;
            align-items: start;
            gap: 1rem;
        }

        .benefit-icon {
            font-size: 1.5rem;
            color: var(--primary);
            flex-shrink: 0;
        }

        .benefit-text h4 {
            color: var(--foreground);
            margin-bottom: 0.5rem;
            font-size: 1.125rem;
        }

        .benefit-text p {
            color: var(--muted-foreground);
            font-size: 0.95rem;
            margin: 0;
        }
    </style>
@endpush

@section('content')

@include('index.header')

<div class="program-detail-container">
    <!-- Back Button -->
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('programs') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Programs
        </a>
    </div>

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="flash-message success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="flash-message error">
            {{ session('error') }}
        </div>
    @endif

    @if (session('info'))
        <div class="flash-message" style="background: rgba(255, 193, 7, 0.15); border-color: rgba(255, 193, 7, 0.3); color: #ffc107;">
            {{ session('info') }}
        </div>
    @endif

    <!-- Program Hero Section -->
    <div class="program-hero">
        <div class="program-icon">{{ $program['icon'] }}</div>
        <h1 class="program-title">{{ $program['title'] }}</h1>
        <span class="level-badge level-{{ $program['level'] }}">
            {{ ucfirst($program['level']) }} Level
        </span>
        <p class="program-description">{{ $program['description'] }}</p>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-value">{{ $program['duration'] }}</div>
                <div class="stat-label">Program Duration</div>
            </div>
            <div class="stat-box">
                <div class="stat-value">{{ $program['workouts'] }}</div>
                <div class="stat-label">Workouts Per Week</div>
            </div>
            <div class="stat-box">
                <div class="stat-value"><i class="fa-solid fa-dumbbell"></i></div>
                <div class="stat-label">{{ $program['equipment'] }}</div>
            </div>
        </div>
    </div>

    <!-- Enrollment Section -->
    <div class="enrollment-section">
        @if($isEnrolled)
            <div class="enrolled-badge">
                <i class="fa-solid fa-check-circle"></i> You're Enrolled in This Program!
            </div>
            <p style="color: var(--muted-foreground); margin-top: 1rem;">
                Track your progress and complete workouts
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center; margin-top: 1.5rem; flex-wrap: wrap;">
                <a href="{{ route('workout-logs.create') }}" class="enroll-btn">
                    <i class="fa-solid fa-plus"></i> Log Workout
                </a>
                <a href="{{ route('workout-logs.index') }}" class="btn btn-outline" style="padding: 1rem 2rem; font-size: 1.125rem;">
                    <i class="fa-solid fa-list"></i> View My Workouts
                </a>
                <a href="{{ route('dashboard') }}" class="btn btn-outline" style="padding: 1rem 2rem; font-size: 1.125rem;">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
            </div>
        @else
            <h2 style="color: var(--foreground); margin-bottom: 1rem;">Ready to Start Your Journey?</h2>
            <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
                Enroll now and get access to structured workouts, progress tracking, and expert guidance!
            </p>
            <form action="{{ route('programs.enroll', $programModel) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="enroll-btn">
                    <i class="fa-solid fa-user-plus"></i>
                    Enroll in This Program
                </button>
            </form>
        @endif
    </div>

    <!-- Program Benefits -->
    <div class="info-section">
        <h2><i class="fa-solid fa-star"></i> What You'll Get</h2>
        <div class="benefits-grid">
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="benefit-text">
                    <h4>Structured Schedule</h4>
                    <p>Follow a proven {{ $program['duration'] }} program designed by fitness experts</p>
                </div>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-chart-line"></i></div>
                <div class="benefit-text">
                    <h4>Progress Tracking</h4>
                    <p>Monitor your improvements with detailed workout logs and statistics</p>
                </div>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-dumbbell"></i></div>
                <div class="benefit-text">
                    <h4>{{ $program['workouts'] }} Workouts</h4>
                    <p>Balanced training frequency for optimal results and recovery</p>
                </div>
            </div>
            <div class="benefit-item">
                <div class="benefit-icon"><i class="fa-solid fa-trophy"></i></div>
                <div class="benefit-text">
                    <h4>Achieve Your Goals</h4>
                    <p>Reach your fitness targets with progressive training methods</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Program Details -->
    <div class="info-section">
        <h2><i class="fa-solid fa-info-circle"></i> Program Details</h2>
        <div style="color: var(--muted-foreground); line-height: 1.8;">
            <p><strong style="color: var(--foreground);">Level:</strong> {{ ucfirst($program['level']) }} - Perfect for those with {{ $program['level'] }} experience</p>
            <p><strong style="color: var(--foreground);">Duration:</strong> {{ $program['duration'] }} of progressive training</p>
            <p><strong style="color: var(--foreground);">Frequency:</strong> {{ $program['workouts'] }} to maximize results</p>
            <p><strong style="color: var(--foreground);">Equipment:</strong> {{ $program['equipment'] }}</p>
            <p><strong style="color: var(--foreground);">Focus:</strong> Comprehensive fitness development with balanced training</p>
        </div>
    </div>

    <!-- Call to Action -->
    @if(!$isEnrolled)
        <div class="enrollment-section" style="background: linear-gradient(135deg, rgba(255, 102, 0, 0.1) 0%, rgba(26, 26, 26, 0.95) 100%);">
            <h2 style="color: var(--foreground); margin-bottom: 1rem;">Don't Wait - Start Today!</h2>
            <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
                Join thousands of members who have transformed their fitness with our programs
            </p>
            <form action="{{ route('programs.enroll', $programModel) }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="enroll-btn">
                    <i class="fa-solid fa-rocket"></i>
                    Start Your Transformation
                </button>
            </form>
        </div>
    @endif
</div>
@include('index.footer')

@endsection
