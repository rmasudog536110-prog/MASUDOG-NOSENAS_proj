@extends('skeleton.layout')

@section('title', 'Exercise Library - FitClub')

@section('content')

@include('index.header')

    <!-- Flash Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <!-- Exercise Library Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    <i class="fas fa-book me-3 text-primary"></i>
                    Exercise Library
                </h1>
                <p class="lead text-muted">
                    Comprehensive collection of exercises for all fitness levels
                </p>
            </div>

            <!-- Search Bar -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <form action="{{ route('exercises') }}" method="GET" class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               name="search"
                               placeholder="Search exercises..."
                               value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>

            <!-- Filter Buttons -->
            @php
                $filter = request('category', 'all');
            @endphp
            <div class="d-flex justify-content-center mb-5 flex-wrap gap-2">
                <a href="{{ url('exercises') }}" 
                   class="btn {{ $filter === 'all' ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-th-large me-1"></i> All Exercises
                </a>
                <a href="{{ url('exercises?category=strength') }}" 
                   class="btn {{ $filter === 'strength' ? 'btn-info' : 'btn-outline-info' }}">
                    <i class="fas fa-dumbbell me-1"></i> Strength
                </a>
                <a href="{{ url('exercises?category=cardio') }}" 
                   class="btn {{ $filter === 'cardio' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="fas fa-heart me-1"></i> Cardio
                </a>
                <a href="{{ url('exercises?category=core') }}" 
                   class="btn {{ $filter === 'cardio' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="fas fa-heart me-1"></i> Core
                </a>
                <a href="{{ url('exercises?category=plyometrics') }}" 
                   class="btn {{ $filter === 'plyometrics' ? 'btn-success' : 'btn-outline-success' }}">
                    <i class="fas fa-leaf me-1"></i> Plyometrics
                </a>
                <a href="{{ url('exercises?category=functional') }}" 
                   class="btn {{ $filter === 'functional' ? 'btn-warning text-dark' : 'btn-outline-warning' }}">
                    <i class="fas fa-running me-1"></i> Functional
                </a>
            </div>

            <!-- Exercises Grid -->
            <div class="row g-3" id="exercisesGrid">
                @forelse ($exercises as $exercise)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="card h-100 shadow-sm exercise-card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-4 me-2">{!! $exercise->icon !!}</span>
                                    <h6 class="card-title fw-bold text-dark mb-0">{{ $exercise->name }}</h6>
                                </div>

                                <p class="card-text text-muted small mb-3">{{ $exercise->description }}</p>

                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    <span class="badge 
                                        @switch($exercise->category)
                                            @case('strength') bg-info @break
                                            @case('cardio') bg-danger @break
                                            @case('flexibility') bg-success @break
                                            @case('functional') bg-warning text-dark @break
                                            @default bg-primary
                                        @endswitch text-uppercase">
                                        {{ $exercise->category }}
                                    </span>

                                    <span class="badge 
                                        @switch($exercise->difficulty)
                                            @case('beginner') bg-success @break
                                            @case('intermediate') bg-warning text-dark @break
                                            @case('expert') bg-danger @break
                                            @default bg-primary
                                        @endswitch">
                                        {{ ucfirst($exercise->difficulty) }}
                                    </span>
                                </div>

                                <div class="text-muted small">
                                    <i class="fas fa-tools me-1"></i>
                                    {{ $exercise->equipment }}
                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="{{ route('exercises.show', $exercise->id) }}" 
                                   class="btn btn-outline-primary btn-sm w-100">
                                    <i class="fas fa-play me-1"></i> View Exercise
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No exercises found</h4>
                        <p class="text-muted">Try selecting a different filter or search term.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-4 d-flex justify-content-center">
                {{ $exercises->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.exercise-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-3px)';
                    this.style.transition = 'all 0.3s ease';
                    this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '';
                });
            });
        });
    </script>
@endsection