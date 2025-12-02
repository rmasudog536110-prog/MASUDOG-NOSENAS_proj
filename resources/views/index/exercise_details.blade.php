@extends('skeleton.layout')

@section('title', $program['title'] . ' - Program Details | FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/programs.css') }}">
@endpush

@section('content')
@include('index.header')

<section class="py-5 bg-light">
    <div class="container">
        <a href="{{ url('programs') }}" class="btn btn-outline-primary mb-4">
            <i class="fas fa-arrow-left me-2"></i> Back to All Programs
        </a>

        <!-- Program Header -->
        <div class="card shadow-lg mb-5">
            <div class="card-body p-5 text-center">
                <span class="detail-icon display-2 mb-3">{{ $program['icon'] }}</span>
                <h1 class="display-5 fw-bold mb-2">{{ $program['title'] }}</h1>
                <p class="lead text-muted">{{ $program['level'] }} Level Program</p>
            </div>
        </div>

        <!-- Overview -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Overview</h3>
                <p>{{ $program['description'] }}</p>
            </div>
        </div>

        <!-- Program Facts -->
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-3">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Duration</h6>
                <p class="text-muted">{{ $program['duration_weeks'] ?? 0 }} Weeks</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fas fa-calendar-alt fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Workouts</h6>
                <p class="text-muted">{{ $program['workout_counts'] ?? 0 }} Total</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fas fa-bolt fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Equipment</h6>
                <p class="text-muted">{{ $program['equipment'] ?? 'Basic equipment' }}</p>
            </div>
        </div>

        <!-- Enrollment -->
        <div class="text-center">
            @if($isEnrolled)
                <a href="{{ url('my-plan/' . $program['id']) }}" class="btn btn-success btn-lg mb-2">
                    <i class="fas fa-chart-bar me-2"></i> View My Training Plan
                </a>
                <p class="text-success fw-bold">
                    <i class="fas fa-check-circle me-1"></i> You are currently enrolled.
                </p>
            @else
                <form action="{{ url('programs/' . $program['id'] . '/enroll') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fas fa-play me-2"></i> Start This Program Now!
                    </button>
                </form>
            @endif
        </div>
    </div>
</section>
@endsection
