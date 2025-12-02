@extends('skeleton.layout')

@section('title', 'Training Programs - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/programs.css') }}">
@endpush

@section('content')

@include('index.header')

<!-- Flash Messages -->
@if ($successMessage ?? false)
    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-check-circle me-2"></i>
            {{ $successMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

@if ($errorMessage ?? false)
    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ $errorMessage }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
@endif

<!-- Programs Section -->
<section class="py-5 bg-light">
    <div class="container">

        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary);">
                <i class="fas fa-dumbbell me-3"></i>
                Training Programs
            </h1>
            <p class="lead" style="color: var(--muted-foreground);">
                Professional programs designed for every fitness level
            </p>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex justify-content-center mb-5 flex-wrap gap-2">

            <a href="{{ url('programs?level=all') }}"
            class="btn {{ ($level === 'all') ? 'btn-primary' : 'btn-outline-primary' }}">
                <i class="fas fa-bullseye me-1"></i> All Levels
            </a>

            <a href="{{ url('programs?level=beginner') }}"
            class="btn {{ ($level === 'beginner') ? 'btn-success' : 'btn-outline-success' }}">
                <i class="fas fa-seedling me-1"></i> Beginner
            </a>

            <a href="{{ url('programs?level=intermediate') }}"
            class="btn {{ ($level === 'intermediate') ? 'btn-warning' : 'btn-outline-warning' }}">
                <i class="fas fa-chart-line me-1"></i> Intermediate
            </a>

            <a href="{{ url('programs?level=expert') }}"
            class="btn {{ ($level === 'expert') ? 'btn-danger' : 'btn-outline-danger' }}">
                <i class="fas fa-star me-1"></i> Expert
            </a>


        </div>

        <!-- Programs Grid -->
        <div class="row g-4">
           @forelse ($filteredPrograms as $program)
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm program-card">

                            <div class="card-body">

                                <!-- Icon + Title -->
                                <div class="d-flex align-items-center mb-3">
                                    <span class="fs-2 me-3">{{ $program['icon'] }}</span>
                                    <h5 class="fw-bold mb-0">{{ $program['title'] }}</h5>
                                </div>

                                <!-- Description -->
                                <p class="text-muted mb-4">
                                    {{ $program['description'] }}
                                </p>

                                <!-- Program Details -->
                                <div class="mb-4">
                                    <div class="row g-2">
                                        <div class="col-12 mt-2">
                                            <small class="text-muted">Equipment:</small>
                                            <div class="fw-medium">{{ $program['equipment'] }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Difficulty Badge + View Button -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="badge 
                                        @switch($program['level'])
                                            @case('beginner') bg-success @break
                                            @case('intermediate') bg-warning text-dark @break
                                            @case('expert') bg-danger @break
                                            @default bg-primary
                                        @endswitch
                                        px-3 py-2">
                                        {{ ucfirst($program['level']) }}
                                    </span>

                                    <button class="btn btn-primary btn-sm"
                                        onclick="viewProgram({{ $program['id'] }})">
                                        <i class="fas fa-eye me-1"></i> View Program
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No programs found</h4>
                        <p class="text-muted">Try selecting a different level filter.</p>
                    </div>
             @endforelse
        </div>

    </div>
</section>

@push('scripts')
<script>
    function viewProgram(id) {
        window.location.href = '{{ url("programs") }}/' + id;
    }

    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.program-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.transition = '0.3s ease';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    });
</script>
@endpush

@endsection
