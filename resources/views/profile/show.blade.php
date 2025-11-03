@extends('skeleton.layout')

@section('title', 'My Profile - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .profile-header {
            text-align: center;
            padding: 2rem 0;
            border-bottom: 1px solid rgba(255, 102, 0, 0.2);
            margin-bottom: 2rem;
        }

        .profile-picture-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 1.5rem;
        }

        .profile-picture {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--primary);
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
        }

        .profile-picture-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: white;
            border: 4px solid var(--primary);
        }

        .profile-name {
            font-size: 2rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .profile-email {
            color: var(--muted-foreground);
            font-size: 1.1rem;
        }

        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 2rem;
        }

        .profile-section {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            padding: 2rem;
        }

        .profile-section h3 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.2);
        }

        .profile-info-item {
            display: flex;
            justify-content: space-between;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 102, 0, 0.1);
        }

        .profile-info-item:last-child {
            border-bottom: none;
        }

        .profile-info-label {
            font-weight: 600;
            color: var(--muted-foreground);
        }

        .profile-info-value {
            color: var(--foreground);
            text-align: right;
        }

        .profile-bio {
            background: var(--muted);
            padding: 1rem;
            border-radius: 0.5rem;
            color: var(--foreground);
            line-height: 1.6;
            font-style: italic;
        }

        .profile-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .badge {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .badge-success {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .badge-warning {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .badge-danger {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .stat-box {
            text-align: center;
            padding: 1rem;
            background: var(--muted);
            border-radius: 0.5rem;
            border: 1px solid rgba(255, 102, 0, 0.1);
        }

        .stat-box-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary);
        }

        .stat-box-label {
            font-size: 0.875rem;
            color: var(--muted-foreground);
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .profile-grid {
                grid-template-columns: 1fr;
            }

            .profile-actions {
                flex-direction: column;
            }

            .profile-actions .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@section('content')

@include('index.header')

<section class="content-section">
    <div class="container">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="flash-message success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture-container">
                @if(Auth::user()->profile_picture)
                    <img src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                         alt="Profile Picture" 
                         class="profile-picture">
                @else
                    <div class="profile-picture-placeholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @endif
            </div>

            <h1 class="profile-name">{{ Auth::user()->name }}</h1>
            <p class="profile-email">{{ Auth::user()->email }}</p>

            @if(Auth::user()->bio)
                <div class="profile-bio" style="max-width: 600px; margin: 1.5rem auto 0;">
                    {{ Auth::user()->bio }}
                </div>
            @endif
        </div>

        <!-- Profile Actions -->
        <div class="profile-actions">
            <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                <i class="fa-solid fa-edit"></i> Edit Profile
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-outline">
                <i class="fa-solid fa-dashboard"></i> Back to Dashboard
            </a>
        </div>

        <!-- Profile Information Grid -->
        <div class="profile-grid">
            <!-- Personal Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-user"></i> Personal Information</h3>

                <div class="profile-info-item">
                    <span class="profile-info-label">Full Name</span>
                    <span class="profile-info-value">{{ Auth::user()->name }}</span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">Email</span>
                    <span class="profile-info-value">{{ Auth::user()->email }}</span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">Phone</span>
                    <span class="profile-info-value">{{ Auth::user()->phone_number ?? 'Not provided' }}</span>
                </div>

                @if(Auth::user()->date_of_birth)
                    <div class="profile-info-item">
                        <span class="profile-info-label">Date of Birth</span>
                        <span class="profile-info-value">{{ Auth::user()->date_of_birth->format('F j, Y') }}</span>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">Age</span>
                        <span class="profile-info-value">{{ Auth::user()->getAge() }} years</span>
                    </div>
                @endif

                @if(Auth::user()->gender)
                    <div class="profile-info-item">
                        <span class="profile-info-label">Gender</span>
                        <span class="profile-info-value">{{ ucfirst(str_replace('_', ' ', Auth::user()->gender)) }}</span>
                    </div>
                @endif

                <div class="profile-info-item">
                    <span class="profile-info-label">Member Since</span>
                    <span class="profile-info-value">{{ Auth::user()->created_at->format('F Y') }}</span>
                </div>
            </div>

            <!-- Fitness Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-dumbbell"></i> Fitness Profile</h3>

                @if(Auth::user()->height || Auth::user()->weight)
                    <div class="stats-grid">
                        @if(Auth::user()->height)
                            <div class="stat-box">
                                <div class="stat-box-value">{{ Auth::user()->height }}</div>
                                <div class="stat-box-label">Height (cm)</div>
                            </div>
                        @endif

                        @if(Auth::user()->weight)
                            <div class="stat-box">
                                <div class="stat-box-value">{{ Auth::user()->weight }}</div>
                                <div class="stat-box-label">Weight (kg)</div>
                            </div>
                        @endif

                        @if(Auth::user()->getBMI())
                            <div class="stat-box">
                                <div class="stat-box-value">{{ Auth::user()->getBMI() }}</div>
                                <div class="stat-box-label">BMI</div>
                            </div>
                        @endif
                    </div>

                    @if(Auth::user()->getBMICategory())
                        <div style="margin-top: 1rem; text-align: center;">
                            <span class="badge 
                                @if(Auth::user()->getBMICategory() === 'Normal') badge-success
                                @elseif(in_array(Auth::user()->getBMICategory(), ['Underweight', 'Overweight'])) badge-warning
                                @else badge-danger
                                @endif">
                                BMI Category: {{ Auth::user()->getBMICategory() }}
                            </span>
                        </div>
                    @endif
                @else
                    <p style="text-align: center; color: var(--muted-foreground); padding: 2rem 0;">
                        No fitness data yet. <a href="{{ route('profile.edit') }}" style="color: var(--primary);">Add your measurements</a>
                    </p>
                @endif

                @if(Auth::user()->fitness_goal)
                    <div class="profile-info-item" style="margin-top: 1.5rem;">
                        <span class="profile-info-label">Fitness Goal</span>
                        <span class="profile-info-value">{{ Auth::user()->fitness_goal }}</span>
                    </div>
                @endif

                @if(Auth::user()->experience_level)
                    <div class="profile-info-item">
                        <span class="profile-info-label">Experience Level</span>
                        <span class="profile-info-value">{{ ucfirst(Auth::user()->experience_level) }}</span>
                    </div>
                @endif
            </div>

            <!-- Activity Stats -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-chart-line"></i> Activity Stats</h3>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-box-value">{{ Auth::user()->workoutLogs()->count() }}</div>
                        <div class="stat-box-label">Total Workouts</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">{{ Auth::user()->bodyMeasurements()->count() }}</div>
                        <div class="stat-box-label">Measurements</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">{{ Auth::user()->subscriptions()->count() }}</div>
                        <div class="stat-box-label">Subscriptions</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">{{ Auth::user()->created_at->diffInDays(now()) }}</div>
                        <div class="stat-box-label">Days Member</div>
                    </div>
                </div>

                @if(Auth::user()->last_login_at)
                    <div class="profile-info-item" style="margin-top: 1.5rem;">
                        <span class="profile-info-label">Last Login</span>
                        <span class="profile-info-value">{{ Auth::user()->last_login_at->diffForHumans() }}</span>
                    </div>
                @endif
            </div>

            <!-- Notification Settings -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-bell"></i> Notification Preferences</h3>

                <div class="profile-info-item">
                    <span class="profile-info-label">Email Notifications</span>
                    <span class="profile-info-value">
                        @if(Auth::user()->email_notifications)
                            <span class="badge badge-success">Enabled</span>
                        @else
                            <span class="badge badge-danger">Disabled</span>
                        @endif
                    </span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">SMS Notifications</span>
                    <span class="profile-info-value">
                        @if(Auth::user()->sms_notifications)
                            <span class="badge badge-success">Enabled</span>
                        @else
                            <span class="badge badge-danger">Disabled</span>
                        @endif
                    </span>
                </div>

                <div style="margin-top: 1.5rem; text-align: center;">
                    <a href="{{ route('profile.edit') }}#notifications" class="btn btn-outline btn-sm">
                        <i class="fa-solid fa-cog"></i> Manage Notifications
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@include('index.footer')

@endsection
