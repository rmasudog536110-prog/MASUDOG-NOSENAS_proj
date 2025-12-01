@extends('skeleton.layout')

@section('title', 'My Profile - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
@endpush

@section('content')

@if (Auth::user() && Auth::user()->hasAdminAccess())
@include('admin.admin_header')
@else
@include('index.header')
@endif

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
                        <div class="stat-box-value">{{ Auth::user()->bodyMeasurements()->count() }}</div>
                        <div class="stat-box-label">Measurements</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">{{ Auth::user()->subscriptions()->count() }}</div>
                        <div class="stat-box-label">Subscriptions</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">{{ Auth::user()->instructorRequests()->count() }}</div>
                        <div class="stat-box-label">Instructor Requests</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">
                            {{ (int) \Carbon\Carbon::parse(Auth::user()->created_at)->diffInDays(\Carbon\Carbon::now()) }}
                        </div>

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


        </div>
    </div>
</section>

@include('index.footer')

@endsection
