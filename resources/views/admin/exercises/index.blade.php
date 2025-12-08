@extends('skeleton.layout')

@section('title', 'Manage Exercises - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/exercises.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-exercise-form.css') }}">
@endpush

@section('content')


@include('admin.admin_header')


<section class="admin-exercises-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-dumbbell me-2"></i> Manage Exercises
            </h1>
            <p>Create, edit, and manage your exercise library</p>
            <div class="header-actions">
                <a href="{{ route('admin.admin_dashboard') }}" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
                <a href="{{ route('admin.exercises.create') }}" class="btn-add-new">
                    <i class="fas fa-plus me-2"></i> Add New Exercise
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Exercises Table -->
        <div class="exercises-card">
            <!-- Search Bar inside table card -->
            <div class="table-search-bar">
                <form method="GET" action="{{ route('admin.exercises.index') }}" class="search-form-inline">
                    <div class="search-controls">
                        <!-- Search Input -->
                        <div class="search-input-wrapper">
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   class="search-input-inline" 
                                   value="{{ old('search', $search) }}"
                                   placeholder="Search exercises...">
                        </div>

                        <!-- Action Buttons -->
                        <div class="search-actions-inline">
                            <button type="submit" class="btn-search-inline">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.exercises.index') }}" class="btn-clear-inline">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-container">
            <div class="table-container">
                <table class="exercises-table">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Difficulty</th>
                            <th>Equipment</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($exercises as $exercise)
                            <tr>
                                <td>
                                    <span class="exercise-icon">{{ $exercise->icon ?? '💪' }}</span>
                                </td>
                                <td>
                                    <div class="exercise-name">{{ $exercise->name }}</div>
                                </td>
                                <td>
                                    <span class="category-badge 
                                        @switch($exercise->category)
                                            @case('strength') @break
                                            @case('cardio') @break
                                            @case('core')  @break
                                            @case('plyometrics') @break
                                            @case('functional')  @break
                                            @default
                                        @endswitch">
                                        {{ ucfirst($exercise->category) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="difficulty-badge 
                                        @switch($exercise->difficulty)
                                            @case('beginner')  @break
                                            @case('intermediate') @break
                                            @case('expert') @break
                                        @endswitch">
                                        {{ ucfirst($exercise->difficulty) }}
                                    </span>
                                </td>
                                <td>{{ $exercise->equipment }}</td>
                                <td>
                                    @if($exercise->video_url)
                                        <a href="{{ $exercise->video_url }}" target="_blank" class="video-link">
                                            <i class="fab fa-youtube me-1" style="padding: 10px"></i>
                                        </a>
                                    @else
                                        <span style="color: var(--muted-foreground);">No video</span>
                                    @endif
                                </td>
                                <td>
                                    @if($exercise->is_active)
                                        <span class="status-badge" style="color: #00FF00;">Active</span>
                                    @else
                                        <span class="status-badge" style="color: #FF0000">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.exercises.edit', $exercise) }}" 
                                           class="btn-action btn-edit"
                                           title="Edit Exercise">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.exercises.destroy', $exercise) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this exercise?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" title="Delete Exercise">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <div class="empty-state-text">No exercises found</div>
                                        <a href="{{ route('admin.exercises.create') }}" class="btn-add-new">
                                            <i class="fas fa-plus me-2"></i> Add First Exercise
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
                        @if($exercises->total() > $exercises->perPage())
            <div class="d-flex justify-content-between align-items-center p-3" style="border-top: 1px solid var(--table-border);">
                <div class="pagination">
                    Showing <strong>{{ $exercises->firstItem() }}</strong> to <strong>{{ $exercises->lastItem() }}</strong> of <strong>{{ $exercises->total() }}</strong> results
                </div>
                <div class="pagination">
                    {{ $exercises->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
    </div>
</section>

@include('index.footer')
@endsection
