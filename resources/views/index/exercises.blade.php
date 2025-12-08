@extends('skeleton.layout')

@section('title', 'Exercise Library - FitClub')

@push('styles')
    <link rel="stylesheet" href="css/exercises.css">
@endpush

@section('content')

@if (Auth::user() && Auth::user()->hasAdminAccess())
    @include('admin.admin_header')
@else
    @include('index.header')
@endif

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
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary);">
                <i class="fas fa-book me-3"></i> Exercise Library
            </h1>
            <p class="lead" style="color: var(--muted-foreground);">
                Comprehensive collection of exercises for all fitness levels
            </p>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 col-md-10">
                <form action="{{ route('exercises.index') }}" method="GET" class="d-flex gap-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               id="searchInput"
                               class="form-control" 
                               name="search"
                               placeholder="Search exercises..."
                               value="{{ request('search') }}">
                        @if(request('search'))
                            <button class="btn btn-outline-secondary" type="button" id="clearSearchButton" title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        @endif
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Buttons -->
        @php
            $filter = request('category', 'all');
            $search = request('search');
            $difficulty = request('difficulty', 'all');
        @endphp

        <div class="filter-section mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <!-- Category Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-2"></i>
                                @if($filter === 'all')
                                    All Categories
                                @else
                                    @switch($filter)
                                        @case('warmup') Warmup @break
                                        @case('strength') Strength @break
                                        @case('cardio') Cardio @break
                                        @case('flexibility') Flexibility @break
                                        @case('core') Core @break
                                        @case('plyometrics') Plyometrics @break
                                        @case('functional') Functional @break
                                        @default All Categories
                                    @endswitch
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li><a class="dropdown-item {{ $filter === 'all' ? 'active' : '' }}" 
                                       href="{{ url('exercises' . ($search ? '?search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-th-large me-2"></i> All Exercises
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item {{ $filter === 'warmup' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=warmup' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-fire me-2 text-warning"></i> Warmup
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $filter === 'strength' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=strength' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-dumbbell me-2 text-info"></i> Strength
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $filter === 'cardio' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=cardio' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-heart me-2 text-danger"></i> Cardio
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $filter === 'flexibility' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=flexibility' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-spa me-2 text-success"></i> Flexibility
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $filter === 'core' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=core' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-circle-notch me-2 text-primary"></i> Core
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $filter === 'plyometrics' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=plyometrics' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-bolt me-2 text-warning"></i> Plyometrics
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $filter === 'functional' ? 'active' : '' }}" 
                                       href="{{ url('exercises?category=functional' . ($search ? '&search=' . urlencode($search) : '')) }}">
                                       <i class="fas fa-running me-2 text-secondary"></i> Functional
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Difficulty Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="difficultyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-signal me-2"></i>
                                @if($difficulty === 'all')
                                    All Difficulties
                                @else
                                    {{ ucfirst($difficulty) }}
                                @endif
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="difficultyDropdown">
                                <li><a class="dropdown-item {{ $difficulty === 'all' ? 'active' : '' }}" 
                                       href="{{ url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '') . 
                                            ($search ? ($filter !== 'all' ? '&' : '?') . 'search=' . urlencode($search) : '')
                                       ) }}">
                                       <i class="fas fa-bars me-2"></i> All Difficulties
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item {{ $difficulty === 'beginner' ? 'active' : '' }}" 
                                       href="{{ url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '?') . 
                                            'difficulty=beginner' . 
                                            ($search ? '&search=' . urlencode($search) : '')
                                       ) }}">
                                       <span class="badge bg-success me-2">B</span> Beginner
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $difficulty === 'intermediate' ? 'active' : '' }}" 
                                       href="{{ url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '?') . 
                                            'difficulty=intermediate' . 
                                            ($search ? '&search=' . urlencode($search) : '')
                                       ) }}">
                                       <span class="badge bg-warning text-dark me-2">I</span> Intermediate
                                    </a>
                                </li>
                                <li><a class="dropdown-item {{ $difficulty === 'expert' ? 'active' : '' }}" 
                                       href="{{ url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '?') . 
                                            'difficulty=expert' . 
                                            ($search ? '&search=' . urlencode($search) : '')
                                       ) }}">
                                       <span class="badge bg-danger me-2">H</span> Expert
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Active Filter Badges -->
                        @if($filter !== 'all' || $difficulty !== 'all')
                            <div class="ms-2">
                                @if($filter !== 'all')
                                    <span class="badge bg-primary me-1">
                                        @switch($filter)
                                            @case('warmup') Warmup @break
                                            @case('strength') Strength @break
                                            @case('cardio') Cardio @break
                                            @case('flexibility') Flexibility @break
                                            @case('core') Core @break
                                            @case('plyometrics') Plyometrics @break
                                            @case('functional') Functional @break
                                        @endswitch
                                        <a href="{{ url('exercises' . 
                                            ($difficulty !== 'all' ? '?difficulty=' . $difficulty : '') . 
                                            ($search ? ($difficulty !== 'all' ? '&' : '?') . 'search=' . urlencode($search) : '')
                                        ) }}" class="text-white ms-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif
                                @if($difficulty !== 'all')
                                    <span class="badge bg-secondary">
                                        {{ ucfirst($difficulty) }}
                                        <a href="{{ url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '') . 
                                            ($search ? ($filter !== 'all' ? '&' : '?') . 'search=' . urlencode($search) : '')
                                        ) }}" class="text-white ms-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <small class="text-muted">
                        <i class="fas fa-chart-bar me-1"></i>
                        Showing {{ count($exercises) }} exercises
                    </small>
                </div>
            </div>
        </div>

        <!-- Exercises Grid -->
        <div class="row g-3" id="exercisesGrid">
            @forelse ($exercises as $exercise)
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm exercise-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-4 me-2">{!! $exercise->icon !!}</span>
                                <h6 class="card-title fw-bold mb-0" style="color: var(--foreground);">{{ $exercise->name }}</h6>
                            </div>
                            <p class="card-text small mb-3" style="color: var(--muted-foreground);">{{ $exercise->description }}</p>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge 
                                    @switch($exercise->category)
                                        @case('warmup') bg-warning text-dark @break
                                        @case('strength') bg-info @break
                                        @case('cardio') bg-danger @break
                                        @case('flexibility') bg-success @break
                                        @case('functional') bg-secondary @break
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
                            <div class="small" style="color: var(--muted-foreground);">
                                <i class="fas fa-tools me-1"></i> {{ $exercise->equipment }}
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="{{ route('exercises.show', $exercise->id) }}" class="btn btn-outline-primary btn-sm w-100">
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

    // Clear search
    const clearButton = document.getElementById('clearSearchButton');
    const searchInput = document.getElementById('searchInput');
    if (clearButton && searchInput) {
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.form.submit();
        });
    }
});
</script>

@endsection
