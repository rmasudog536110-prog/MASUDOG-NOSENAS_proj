@extends('skeleton.layout')

{{-- Page Title --}}
@section('title', ($program['title'] ?? 'Program') . ' - Program Details | FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/programs.css') }}">
@endpush

@section('content')

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if (session('info'))
    <div class="alert alert-info alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-info-circle me-2"></i>
            {{ session('info') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<section class="program-detail-section py-5 bg-light">
    <div class="container">
        <div class="btn-back-container mb-4">
            <a href="{{ route('programs.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Back to All Programs
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card program-detail-card shadow-lg">
                    <div class="card-body p-4 p-md-5">

                        <div class="text-center mb-4">
                            {{-- Program Icon --}}
                            @if(isset($program['icon']))
                            <span class="detail-icon display-2 mb-3">{{ $program['icon'] }}</span>
                            @endif
                            
                            {{-- Title --}}
                            <h1 class="display-5 fw-bold mb-2">{{ $program['title'] ?? 'Training Program' }}</h1>
                            
                            {{-- Level --}}
                            @if(isset($program['level']))
                            <p class="lead text-muted">{{ $program['level'] }} Level Program</p>
                            @endif
                            
                            {{-- Focus Area --}}
                            @if(isset($program['focus_area']))
                            <div class="badge bg-primary fs-6 mt-2">
                                <i class="fas fa-bullseye me-1"></i> {{ $program['focus_area'] }}
                            </div>
                            @endif
                        </div>

                        <hr class="my-4 detail-separator">

                        {{-- Overview Section --}}
                        @php
                            // Safely access program description data
                            $descriptionData = $program['description'] ?? [];
                            $overview = $descriptionData['overview'] ?? 
                                       $descriptionData['focus'] ?? 
                                       ($program['description'] ?? 'Professional training program designed to help you achieve your fitness goals.');
                        @endphp

                        @if(!empty($overview))
                        <div class="row mb-5">
                            <div class="col-12">
                                <h3 class="fw-bold mb-3 detail-heading">
                                    <i class="fas fa-info-circle me-2"></i> Overview
                                </h3>
                                <p class="detail-description">{{ $overview }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Daily Workouts Section --}}
                        @if(!empty($descriptionData) && is_array($descriptionData))
                            @php
                                // Count workout days (excluding overview and focus)
                                $workoutDays = array_filter($descriptionData, function($value, $key) {
                                    return $key !== 'overview' && 
                                           $key !== 'focus' && 
                                           is_array($value) && 
                                           !empty($value);
                                }, ARRAY_FILTER_USE_BOTH);
                            @endphp
                            
                            @if(count($workoutDays) > 0)
                            <div class="row mb-5">
                                <div class="col-12">
                                    <h3 class="fw-bold mb-3 detail-heading">
                                        <i class="fas fa-dumbbell me-2"></i> Weekly Schedule
                                    </h3>
                                    
                                    @foreach($descriptionData as $day => $exercises)
                                        @if($day !== 'overview' && $day !== 'focus' && is_array($exercises) && !empty($exercises))
                                            <div class="mb-4 workout-day-card">
                                                <div class="card">
                                                    <div class="card-header bg-light">
                                                        <h5 class="fw-bold mb-0 text-primary">
                                                            <i class="fas fa-calendar-day me-2"></i> {{ ucfirst($day) }}
                                                        </h5>
                                                    </div>
                                                    <div class="card-body">
                                                        <ul class="list-group list-group-flush">
                                                            @foreach($exercises as $index => $exercise)
                                                                <li class="list-group-item d-flex align-items-center">
                                                                    <span class="badge bg-secondary rounded-pill me-3">{{ $index + 1 }}</span>
                                                                    <span>{{ $exercise }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @else
                            <div class="row mb-5">
                                <div class="col-12">
                                    <h3 class="fw-bold mb-3 detail-heading">
                                        <i class="fas fa-dumbbell me-2"></i> Weekly Schedule
                                    </h3>
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle me-2"></i>
                                        Weekly workout details will be provided once you enroll in the program.
                                    </div>
                                </div>
                            </div>
                            @endif
                        @endif

                        {{-- Program Facts --}}
                        <div class="row text-center mb-5 program-facts">
                            <div class="col-md-3 mb-3">
                                <div class="fact-card p-3 rounded">
                                    <i class="fas fa-clock fa-2x detail-fact-icon mb-2 text-primary"></i>
                                    <h6 class="fw-bold mb-0">Duration</h6>
                                    <p class="text-muted mb-0">{{ $program['duration_weeks'] ?? 12 }} Weeks</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="fact-card p-3 rounded">
                                    <i class="fas fa-calendar-alt fa-2x detail-fact-icon mb-2 text-success"></i>
                                    <h6 class="fw-bold mb-0">Workouts</h6>
                                    <p class="text-muted mb-0">{{ $program['workout_counts'] ?? 36 }} Total</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="fact-card p-3 rounded">
                                    <i class="fas fa-dumbbell fa-2x detail-fact-icon mb-2 text-warning"></i>
                                    <h6 class="fw-bold mb-0">Equipment</h6>
                                    <p class="text-muted mb-0">{{ $program['equipment'] ?? 'Basic equipment' }}</p>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="fact-card p-3 rounded">
                                    <i class="fas fa-fire fa-2x detail-fact-icon mb-2 text-danger"></i>
                                    <h6 class="fw-bold mb-0">Level</h6>
                                    <p class="text-muted mb-0">{{ $program['level'] ?? 'All Levels' }}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Enrollment Buttons --}}
                        <div class="text-center mt-4">
                            @if ($isEnrolled)
                                <a href="{{ route('my-plan.show') }}" class="btn btn-success btn-lg detail-action-btn px-5">
                                    <i class="fas fa-chart-line me-2"></i> Continue Training Plan
                                </a>
                                <p class="text-success mt-3 fw-bold">
                                    <i class="fas fa-check-circle me-1"></i> You are currently enrolled in this program
                                </p>
                                <small class="text-muted d-block mt-1">
                                    Started on {{ auth()->user()->enrollments()->where('program_id', $program['id'])->first()->enrolled_at->format('M d, Y') ?? 'recently' }}
                                </small>
                            @else
                                @auth
                                <form action="{{ route('programs.enroll', $program['id']) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-lg detail-action-btn px-5">
                                        <i class="fas fa-play-circle me-2"></i> Start This Program Now!
                                    </button>
                                </form>
                                <p class="text-muted mt-3">
                                    <i class="fas fa-lock-open me-1"></i> One-click enrollment • Cancel anytime
                                </p>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-primary btn-lg detail-action-btn px-5">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login to Enroll
                                </a>
                                <p class="text-muted mt-3">
                                    <i class="fas fa-user-plus me-1"></i> 
                                    <a href="{{ route('register') }}" class="text-decoration-none">Create an account</a> to start this program
                                </p>
                                @endauth
                            @endif
                        </div>

                        {{-- Additional Information --}}
                        @if(isset($descriptionData['tips']) || isset($descriptionData['notes']))
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <h5 class="fw-bold mb-3">
                                            <i class="fas fa-lightbulb me-2 text-warning"></i> Program Tips
                                        </h5>
                                        @if(isset($descriptionData['tips']))
                                            @if(is_array($descriptionData['tips']))
                                                <ul class="mb-0">
                                                    @foreach($descriptionData['tips'] as $tip)
                                                        <li class="mb-2">{{ $tip }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <p class="mb-0">{{ $descriptionData['tips'] }}</p>
                                            @endif
                                        @endif
                                        
                                        @if(isset($descriptionData['notes']))
                                            <hr class="my-3">
                                            <h6 class="fw-bold">Additional Notes:</h6>
                                            <p class="mb-0">{{ $descriptionData['notes'] }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Add any JavaScript functionality here
    document.addEventListener('DOMContentLoaded', function() {
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                if(targetId !== '#') {
                    const targetElement = document.querySelector(targetId);
                    if(targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                }
            });
        });
        
        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    });
</script>
@endpush