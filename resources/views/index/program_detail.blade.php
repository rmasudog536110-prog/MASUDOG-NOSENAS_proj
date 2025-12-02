@extends('skeleton.layout')

{{-- Page Title --}}
@section('title', $program['title'] . ' - Program Details | FitClub')

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

<section class="program-detail-section py-5 bg-light">
    <div class="btn-back-container">
        <a href="{{ url('programs') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Back to All Programs
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card program-detail-card shadow-lg">
                <div class="card-body p-4 p-md-5">

                    <div class="text-center mb-4">
                        {{-- Program Icon --}}
                        <span class="detail-icon display-2 mb-3">{{ $program['icon'] }}</span>
                        {{-- Title --}}
                        <h1 class="display-5 fw-bold mb-2">{{ $program['title'] }}</h1>
                        {{-- Level --}}
                        <p class="lead text-muted">{{ ucfirst($program['level']) }} Level Program</p>
                    </div>

                    <hr class="my-4 detail-separator">

                    {{-- Decode description JSON --}}
                    @php
                        $descData = $program['description'];
                        if(is_string($descData)) {
                            $descData = json_decode($descData, true);
                        }
                        $overview = $program['description'];
                        if(isset($descData['overview'])) {
                            $overview = $descData['overview'];
                        } elseif(isset($descData['focus'])) {
                            $overview = $descData['focus'];
                        }
                    @endphp


                    {{-- Overview --}}
                    <div class="row mb-5">
                        <div class="col-12">
                            <h3 class="fw-bold mb-3 detail-heading">Overview</h3>
                            <p class="detail-description">{{ $overview }}</p>
                        </div>
                    </div>

                    {{-- Daily Workouts --}}

                        <div class="row mb-5">
                            <div class="col-12">
                                <h3 class="fw-bold mb-3 detail-heading">Daily Workouts</h3>
                                @foreach($descData as $day => $exercises)
                                    @if(is_array($exercises) && $day !== 'overview' && $day !== 'focus')
                                        <div class="mb-4">
                                            <h5 class="fw-bold">{{ $day }}</h5>
                                            <ul class="list-group list-group-flush">
                                                @foreach($exercises as $exercise)
                                                    <li class="list-group-item">{{ $exercise }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>

                    {{-- Program Facts --}}
                    <div class="row text-center mb-5 program-facts">
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-clock fa-2x detail-fact-icon mb-2"></i>
                            <h6 class="fw-bold mb-0">Duration</h6>
                            <p class="text-muted">{{ $program->duration_weeks ?? 0 }} Weeks</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-calendar-alt fa-2x detail-fact-icon mb-2"></i>
                            <h6 class="fw-bold mb-0">Workouts</h6>
                            <p class="text-muted">{{ $program->workout_counts ?? 0 }} Total</p>
                        </div>
                        <div class="col-md-4 mb-3">
                            <i class="fas fa-bolt fa-2x detail-fact-icon mb-2"></i>
                            <h6 class="fw-bold mb-0">Equipment</h6>
                            <p class="text-muted">{{ $program['equipment'] ?? 'Basic equipment' }}</p>
                        </div>
                    </div>

                    {{-- Enrollment Buttons --}}
                    <div class="text-center">
                        @if ($program['is_enrolled'])
                            <a href="{{ url('my-plan/' . $program['id']) }}" class="btn btn-success btn-lg detail-action-btn">
                                <i class="fas fa-chart-bar me-2"></i> View My Training Plan
                            </a>
                            <p class="text-success mt-2 fw-bold">
                                <i class="fas fa-check-circle me-1"></i> You are currently enrolled.
                            </p>
                        @else
                            <form action="{{ url('programs/' . $program['id'] . '/enroll') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-lg detail-action-btn">
                                    <i class="fas fa-play me-2"></i> Start This Program Now!
                                </button>
                            </form>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection
