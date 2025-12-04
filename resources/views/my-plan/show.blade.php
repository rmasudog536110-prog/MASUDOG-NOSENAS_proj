@extends('skeleton.layout')

@section('title', 'My Training Plan - ' . ($program['title'] ?? 'Program'))

@push('styles')
<link rel="stylesheet" href="css/programs.css">
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

<div class="container-fluid px-0">
    <!-- Plan Header -->
    <div class="plan-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="{{ route('programs.index') }}" class="text-primary-50">All Programs</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">My Training Plan</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center mb-3">
                        <div class="display-4 me-3">{{ $program['icon'] ?? '🏋️' }}</div>
                        <div>
                            <h1 class="display-6 fw-bold mb-1">{{ $program['title'] ?? 'My Training Plan' }}</h1>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-dark text-light">{{ $program['level'] }} Level</span>
                                <span class="badge bg-dark text-light">{{ $program['focus_area'] }}</span>
                                <span class="badge bg-dark text-light">{{ $program['duration_weeks'] }} Weeks</span>
                            </div>
                        </div>
                    </div>
                    <p class="lead mb-0">{{ $program['overview'] }}</p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="btn-group">
                        <a href="{{ route('programs.show', $program['id']) }}" class="btn btn-light">
                            <i class="fas fa-info-circle me-1"></i> Program Details
                        </a>
                        <form action="{{ route('my-plan.unenroll', $program['id']) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to mark this program as completed?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-light ms-2">
                                <i class="fas fa-flag-checkered me-1"></i> Mark Complete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Progress Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">
                            <i class="fas fa-chart-line me-2 text-primary"></i> Your Progress
                        </h4>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: {{ $progressPercentage }}%">
                                {{ round($progressPercentage, 1) }}%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span>{{ $completedCount }} of {{ $totalDays }} days completed</span>
                            <span>{{ round($progressPercentage, 1) }}% Complete</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-white">{{ $currentDay }}</div>
                                    <div class="text-muted small">Current Day</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-white">{{ $completedCount }}</div>
                                    <div class="text-muted small">Completed</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-white">{{ $totalDays - $completedCount }}</div>
                                    <div class="text-muted small">Remaining</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Workout Schedule -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i> Workout Schedule
                            </h4>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">Current</span>
                                <span class="badge bg-success">Completed</span>
                                <span class="badge bg-secondary">Upcoming</span>
                            </div>
                        </div>
                        
                        @if(count($workoutSchedule) > 0)
                            @foreach($workoutSchedule as $day)
                                <div class="day-card {{ $day['completed'] ? 'completed' : '' }} {{ $day['is_current'] ? 'current' : '' }}">
                                    <div class="day-header">
                                        <div>
                                            <h5 class="fw-bold mb-1">
                                                Day {{ $day['day_number'] }}: {{ $day['day_name'] }}
                                                @if($day['is_current'])
                                                    <span class="badge bg-primary day-badge ms-2">Today</span>
                                                @endif
                                            </h5>
                                            <p class="text-muted mb-0 small">
                                                {{ count($day['exercises']) }} exercises • 
                                                @if($day['completed'])
                                                    <span class="text-success">Completed</span>
                                                @elseif($day['is_current'])
                                                    <span class="text-primary">In Progress</span>
                                                @else
                                                    <span class="text-muted">Upcoming</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div>
                                            @if($day['completed'])
                                                <span class="badge bg-success day-badge">
                                                    <i class="fas fa-check me-1"></i> Done
                                                </span>
                                            @elseif($day['is_current'])
                                                <form action="{{ route('my-plan.complete-day') }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="program_id" value="{{ $program['id'] }}">
                                                    <input type="hidden" name="day_name" value="{{ strtolower($day['day_name']) }}">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check me-1"></i> Mark Complete
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <div class="day-body">
                                        @foreach($day['exercises'] as $index => $exercise)
                                            <div class="exercise-item">
                                                <div class="exercise-number">{{ $index + 1 }}</div>
                                                <div class="flex-grow-1">{{ $exercise }}</div>
                                                @if($day['is_current'] && !$day['completed'])
                                                    <button class="btn btn-outline-primary btn-sm" onclick="markExerciseComplete(this)">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No workout schedule available for this program.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="plan-actions">
                    <!-- Stats Cards -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-white">
                                <i class="fas fa-chart-bar me-2 text-primary"></i> Program Stats
                            </h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-primary bg-opacity-10 text-primary mx-auto">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                        <h4 class="fw-bold">{{ $totalDays }}</h4>
                                        <p class="text-muted small mb-0">Total Days</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-success bg-opacity-10 text-success mx-auto">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h4 class="fw-bold">{{ $completedCount }}</h4>
                                        <p class="text-muted small mb-0">Completed</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-info bg-opacity-10 text-info mx-auto">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h4 class="fw-bold">{{ $totalDays - $completedCount }}</h4>
                                        <p class="text-muted small mb-0">Remaining</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-warning bg-opacity-10 text-warning mx-auto">
                                            <i class="fas fa-fire"></i>
                                        </div>
                                        <h4 class="fw-bold">{{ $currentDay }}</h4>
                                        <p class="text-muted small mb-0">Current Day</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Info -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-white">
                                <i class="fas fa-info-circle me-2 text-primary"></i> Program Details
                            </h5>
                            <ul">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Level</span>
                                    <span class="fw-bold text-white">{{ $program['level'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Duration</span>
                                    <span class="fw-bold text-white">{{ $program['duration_weeks'] }} weeks</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Workouts</span>
                                    <span class="fw-bold text-white">{{ $totalDays }} days</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Equipment</span>
                                    <span class="fw-bold text-white">{{ $program['equipment'] }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Enrolled</span>
                                    <span class="fw-bold text-white">{{ $enrolledDate }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Last Activity</span>
                                    <span class="fw-bold text-white">{{ $enrollment->last_activity ? $enrollment->last_activity->diffForHumans() : 'Never' }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-white">
                                <i class="fas fa-bolt me-2 text-warning"></i> Quick Actions
                            </h5>
                            <div class="d-grid gap-2">
                                <a href="{{ route('programs.show', $program['id']) }}" class="btn btn-outline-primary">
                                    <i class="fas fa-redo me-1"></i> View Program Details
                                </a>
                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateProgressModal">
                                    <i class="fas fa-percentage me-1"></i> Update Progress
                                </button>
                                <form action="{{ route('my-plan.unenroll', $program['id']) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to mark this program as completed?')">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-flag-checkered me-1"></i> Mark as Complete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Your current progress is <strong>{{ round($progressPercentage, 1) }}%</strong>.</p>
                <form action="{{ route('my-plan.complete-day') }}" method="POST">
                    @csrf
                    <input type="hidden" name="program_id" value="{{ $program['id'] }}">
                    <div class="mb-3">
                        <label for="progressInput" class="form-label">Or manually set progress percentage:</label>
                        <div class="input-group">
                            <input type="number" name="progress" class="form-control" 
                                   id="progressInput" min="0" max="100" 
                                   value="{{ round($progressPercentage, 0) }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Progress</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function markExerciseComplete(button) {
        const exerciseItem = button.closest('.exercise-item');
        const checkIcon = button.querySelector('i');
        
        // Toggle state
        if (checkIcon.classList.contains('fa-check')) {
            checkIcon.classList.remove('fa-check');
            checkIcon.classList.add('fa-times');
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-outline-success');
            exerciseItem.style.textDecoration = 'line-through';
            exerciseItem.style.opacity = '0.7';
        } else {
            checkIcon.classList.remove('fa-times');
            checkIcon.classList.add('fa-check');
            button.classList.remove('btn-outline-success');
            button.classList.add('btn-outline-primary');
            exerciseItem.style.textDecoration = 'none';
            exerciseItem.style.opacity = '1';
        }
    }
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 5000);
</script>
@endpush