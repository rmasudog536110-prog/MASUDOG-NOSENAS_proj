@extends('skeleton.layout')

@section('title', 'Workout Logs - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .workout-logs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .workout-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .workout-stat-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
        }

        .workout-stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 102, 0, 0.25);
        }

        .workout-stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
            display: block;
            margin-bottom: 0.5rem;
        }

        .workout-stat-label {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .workout-filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 0.5rem 1rem;
            background: var(--muted);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.5rem;
            color: var(--foreground);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--primary);
            color: #fff;
            border-color: var(--primary);
        }

        .workout-list {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .workout-item {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .workout-item:hover {
            transform: translateX(5px);
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
        }

        .workout-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .workout-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .workout-date {
            color: var(--muted-foreground);
            font-size: 0.875rem;
        }

        .workout-actions {
            display: flex;
            gap: 0.5rem;
        }

        .workout-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .workout-detail {
            display: flex;
            flex-direction: column;
        }

        .workout-detail-label {
            color: var(--muted-foreground);
            font-size: 0.75rem;
            text-transform: uppercase;
            margin-bottom: 0.25rem;
        }

        .workout-detail-value {
            color: var(--foreground);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .workout-notes {
            background: var(--muted);
            padding: 1rem;
            border-radius: 0.5rem;
            color: var(--foreground);
            font-style: italic;
            margin-top: 1rem;
        }

        .difficulty-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .difficulty-easy {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .difficulty-medium {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .difficulty-hard {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .rating-stars {
            color: #ffc107;
            font-size: 1rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
        }

        .empty-state-icon {
            font-size: 4rem;
            color: var(--muted-foreground);
            margin-bottom: 1rem;
        }

        .btn-icon {
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        @media (max-width: 768px) {
            .workout-logs-header {
                flex-direction: column;
                align-items: stretch;
            }

            .workout-header {
                flex-direction: column;
                gap: 1rem;
            }

            .workout-actions {
                justify-content: flex-start;
            }

            .workout-details {
                grid-template-columns: repeat(2, 1fr);
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

        <!-- Header -->
        <div class="workout-logs-header">
            <div>
                <h1>Workout Logs</h1>
                <p style="color: var(--muted-foreground);">Track your fitness journey</p>
            </div>
            <a href="{{ route('workout-logs.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Log New Workout
            </a>
        </div>

        <!-- Stats Overview -->
        <div class="workout-stats-grid">
            <div class="workout-stat-card">
                <span class="workout-stat-value">{{ $stats['total_workouts'] }}</span>
                <span class="workout-stat-label">Total Workouts</span>
            </div>
            <div class="workout-stat-card">
                <span class="workout-stat-value">{{ $stats['this_week'] }}</span>
                <span class="workout-stat-label">This Week</span>
            </div>
            <div class="workout-stat-card">
                <span class="workout-stat-value">{{ $stats['this_month'] }}</span>
                <span class="workout-stat-label">This Month</span>
            </div>
            <div class="workout-stat-card">
                <span class="workout-stat-value">{{ number_format($stats['total_calories']) }}</span>
                <span class="workout-stat-label">Total Calories Burned</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="workout-filters">
            <button class="filter-btn active" onclick="filterWorkouts('all')">All</button>
            <button class="filter-btn" onclick="filterWorkouts('week')">This Week</button>
            <button class="filter-btn" onclick="filterWorkouts('month')">This Month</button>
        </div>

        <!-- Workout List -->
        @if($workouts->count() > 0)
            <div class="workout-list">
                @foreach($workouts as $workout)
                    <div class="workout-item">
                        <div class="workout-header">
                            <div>
                                <h3 class="workout-title">
                                    @if($workout->exercise)
                                        {{ $workout->exercise->name }}
                                    @elseif($workout->trainingProgram)
                                        {{ $workout->trainingProgram->title }}
                                    @else
                                        Workout Session
                                    @endif
                                </h3>
                                <p class="workout-date">
                                    <i class="fa-solid fa-calendar"></i>
                                    {{ $workout->workout_date->format('F j, Y') }}
                                    ({{ $workout->workout_date->diffForHumans() }})
                                </p>
                            </div>
                            <div class="workout-actions">
                                <a href="{{ route('workout-logs.show', $workout) }}" 
                                   class="btn btn-outline btn-icon"
                                   title="View Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <a href="{{ route('workout-logs.edit', $workout) }}" 
                                   class="btn btn-outline btn-icon"
                                   title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </a>
                                <form action="{{ route('workout-logs.destroy', $workout) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this workout log?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-outline btn-icon"
                                            title="Delete"
                                            style="color: #dc3545; border-color: #dc3545;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div class="workout-details">
                            @if($workout->sets && $workout->reps)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Sets × Reps</span>
                                    <span class="workout-detail-value">{{ $workout->sets }} × {{ $workout->reps }}</span>
                                </div>
                            @endif

                            @if($workout->weight)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Weight</span>
                                    <span class="workout-detail-value">{{ $workout->weight }} kg</span>
                                </div>
                            @endif

                            @if($workout->duration_minutes)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Duration</span>
                                    <span class="workout-detail-value">{{ $workout->duration_minutes }} min</span>
                                </div>
                            @endif

                            @if($workout->distance)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Distance</span>
                                    <span class="workout-detail-value">{{ $workout->distance }} km</span>
                                </div>
                            @endif

                            @if($workout->calories_burned)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Calories</span>
                                    <span class="workout-detail-value">{{ $workout->calories_burned }} kcal</span>
                                </div>
                            @endif

                            @if($workout->difficulty)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Difficulty</span>
                                    <span class="difficulty-badge difficulty-{{ $workout->difficulty }}">
                                        {{ ucfirst($workout->difficulty) }}
                                    </span>
                                </div>
                            @endif

                            @if($workout->rating)
                                <div class="workout-detail">
                                    <span class="workout-detail-label">Rating</span>
                                    <span class="rating-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $workout->rating)
                                                <i class="fa-solid fa-star"></i>
                                            @else
                                                <i class="fa-regular fa-star"></i>
                                            @endif
                                        @endfor
                                    </span>
                                </div>
                            @endif
                        </div>

                        @if($workout->notes)
                            <div class="workout-notes">
                                <i class="fa-solid fa-note-sticky"></i> {{ $workout->notes }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div style="margin-top: 2rem;">
                {{ $workouts->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fa-solid fa-dumbbell"></i>
                </div>
                <h2>No Workouts Logged Yet</h2>
                <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
                    Start tracking your fitness journey by logging your first workout!
                </p>
                <a href="{{ route('workout-logs.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Log Your First Workout
                </a>
            </div>
        @endif
    </div>
</section>

@include('index.footer')

@endsection

@push('scripts')
<script>
    function filterWorkouts(period) {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        
        // Add active class to clicked button
        event.target.classList.add('active');
        
        // In a real implementation, you would filter the workouts
        // For now, we'll just reload with a query parameter
        const url = new URL(window.location.href);
        url.searchParams.set('filter', period);
        window.location.href = url.toString();
    }
</script>
@endpush
