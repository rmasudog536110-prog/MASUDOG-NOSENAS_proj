@extends('skeleton.layout')

@section('title', $program['title'] . ' - FitClub')

@section('content')

@include('index.header')

    <!-- Flash Messages -->
    @if ($successMessage)
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-check-circle me-2"></i>
                {{ $successMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if ($errorMessage)
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ $errorMessage }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Program Detail Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Back Button -->
            <a href="{{ route('programs') }}" class="btn btn-outline-primary mb-4">
                <i class="fas fa-arrow-left me-2"></i> Back to Programs
            </a>

            <!-- Program Header -->
            <div class="card shadow-lg mb-5">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="fs-1 me-4">{{ $program['icon'] }}</span>
                        <div>
                            <h1 class="display-5 fw-bold text-dark mb-2">
                                {{ $program['title'] }}
                            </h1>
                            <span class="badge 
                                @switch($program['level'])
                                    @case('beginner') bg-success @break
                                    @case('intermediate') bg-warning text-dark @break
                                    @case('expert') bg-danger @break
                                    @case('hardcore') bg-dark @break
                                    @default bg-primary
                                @endswitch
                                fs-6 px-3 py-2">
                                {{ ucfirst($program['level']) }}
                            </span>
                        </div>
                    </div>

                    <p class="lead text-muted mb-4">
                        {{ $program['description'] }}
                    </p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded text-center">
                                <div class="fs-3 fw-bold text-primary mb-1">
                                    {{ $program['duration'] }}
                                </div>
                                <div class="text-muted">Duration</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded text-center">
                                <div class="fs-3 fw-bold text-success mb-1">
                                    {{ $program['totalWorkouts'] }}
                                </div>
                                <div class="text-muted">Total Workouts</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded text-center">
                                <div class="text-muted mb-1">Equipment</div>
                                <div class="fw-medium text-dark">
                                    {{ $program['equipment'] }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workout Sessions -->
            <h2 class="mb-4 fw-bold">
                <i class="fas fa-dumbbell me-2 text-primary"></i>
                Workout Sessions
            </h2>

            @foreach ($program['workouts'] as $index => $workout)
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    Week {{ $index + 1 }}: {{ $workout['name'] }}
                                </h5>
                                <div class="d-flex gap-3 text-primary-light">
                                    <span><i class="fas fa-clock me-1"></i> {{ $workout['duration'] }} minutes</span>
                                    <span><i class="fas fa-dumbbell me-1"></i> {{ count($workout['exercises']) }} exercises</span>
                                </div>
                            </div>
                            <button class="btn btn-light btn-lg" onclick="startWorkout({{ $workout['id'] }})">
                                <i class="fas fa-play me-2"></i> Start Workout
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row g-3">
                            @foreach ($workout['exercises'] as $exerciseIndex => $exercise)
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold mb-1">
                                                {{ $exerciseIndex + 1 }}. {{ $exercise['name'] }}
                                            </h6>
                                            <button class="btn btn-sm btn-outline-primary"
                                                onclick="toggleExerciseDetails('{{ $workout['id'] }}_{{ $exerciseIndex }}')">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>

                                        <div class="d-flex gap-3 text-muted small mb-2">
                                            <span><i class="fas fa-chart-bar me-1"></i> {{ $exercise['sets'] }} sets</span>
                                            <span><i class="fas fa-sort-numeric-up me-1"></i> {{ $exercise['reps'] }} reps</span>
                                        </div>

                                        <p class="text-muted small mb-0">
                                            {{ $exercise['description'] }}
                                        </p>

                                        <!-- Collapsible details -->
                                        <div id="details_{{ $workout['id'] }}_{{ $exerciseIndex }}" class="mt-3" style="display: none;">
                                            <div class="bg-light rounded p-3">
                                                <h6 class="fw-bold mb-2">
                                                    <i class="fas fa-lightbulb me-1 text-warning"></i> Exercise Tips:
                                                </h6>
                                                <ul class="small mb-0">
                                                    <li>Focus on proper form over speed</li>
                                                    <li>Control the movement throughout</li>
                                                    <li>Breathe properly during execution</li>
                                                    <li>Rest adequately between sets</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function startWorkout(workoutId) {
        window.location.href = '/workout-timer/' + workoutId;
    }

    function toggleExerciseDetails(exerciseId) {
        const details = document.getElementById('details_' + exerciseId);
        if (details.style.display === 'none') {
            details.style.display = 'block';
            details.style.animation = 'fadeIn 0.3s ease-in';
        } else {
            details.style.display = 'none';
        }
    }

    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
</script>
@endpush
