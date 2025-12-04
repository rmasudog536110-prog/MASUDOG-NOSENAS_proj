@extends('skeleton.layout')

@section('title', $exercise['name'] . ' - Exercise Details | FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/programs.css') }}">
@endpush

@section('content')
@include('index.header')

<section class="py-5 bg-light">
    <div class="container">
        <a href="{{ url('exercises') }}" class="btn btn-outline-primary mb-4">
            <i class="fas fa-arrow-left me-2"></i> Back to All Exercises
        </a>

        <!-- Exercise Header -->
        <div class="card shadow-lg mb-5">
            <div class="card-body p-5 text-center">
                <span class="detail-icon display-2 mb-3">{{ $exercise['icon'] }}</span>
                <h1 class="display-5 fw-bold mb-2">{{ $exercise['name'] }}</h1>
                <p class="lead text-muted">{{ $exercise['difficulty'] }} Difficulty</p>
            </div>
        </div>

        <!-- Overview -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Overview</h3>
                <p>{{ $exercise['description'] }}</p>
            </div>
        </div>

        <!-- Exercise Facts -->
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-3">
                <i class="fas fa-fire fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Difficulty</h6>
                <p class="text-muted">{{ $exercise['difficulty'] }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fas fa-dumbbell fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Equipment</h6>
                <p class="text-muted">{{ $exercise['equipment'] }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fas fa-tag fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Category</h6>
                <p class="text-muted">{{ $exercise['category'] }}</p>
            </div>
        </div>

        <!-- Instructions -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h3 class="fw-bold mb-3">Instructions</h3>
                <ol>
                    @foreach($exercise['instructions'] as $instruction)
                        <li>{{ $instruction }}</li>
                    @endforeach
                </ol>
            </div>
        </div>

        <!-- Default Values -->
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-3">
                <i class="fas fa-layer-group fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Default Sets</h6>
                <p class="text-muted">{{ $exercise['defaultSets'] }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fas fa-redo fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Default Reps</h6>
                <p class="text-muted">{{ $exercise['defaultReps'] }}</p>
            </div>
            <div class="col-md-4 mb-3">
                <i class="fas fa-clock fa-2x mb-2"></i>
                <h6 class="fw-bold mb-0">Duration</h6>
                <p class="text-muted">{{ $exercise['defaultDuration'] }} seconds</p>
            </div>
        </div>
    </div>
</section>
@endsection
