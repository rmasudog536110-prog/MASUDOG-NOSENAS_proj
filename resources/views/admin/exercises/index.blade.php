@extends('skeleton.layout')

@section('title', 'Manage Exercises - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/exercises.css') }}">
@endpush

@section('content')
@if (Auth::user() && Auth::user()->hasAdminAccess())
@include('admin.admin_header')
@else
@include('index.header')
@endif

<section class="admin-exercises-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-dumbbell me-2"></i> Manage Exercises
            </h1>
            <p>Create, edit, and manage your exercise library</p>
            <div class="header-actions">
                <a href="{{ route('admin.dashboard') }}" class="btn-back">
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
                                            @case('strength') bg-info @break
                                            @case('cardio') bg-danger @break
                                            @case('core') bg-success @break
                                            @case('plyometrics') bg-warning text-dark @break
                                            @case('functional') bg-secondary @break
                                            @default bg-primary
                                        @endswitch">
                                        {{ ucfirst($exercise->category) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="difficulty-badge 
                                        @switch($exercise->difficulty)
                                            @case('beginner') bg-success @break
                                            @case('intermediate') bg-warning text-dark @break
                                            @case('expert') bg-danger @break
                                        @endswitch">
                                        {{ ucfirst($exercise->difficulty) }}
                                    </span>
                                </td>
                                <td>{{ $exercise->equipment }}</td>
                                <td>
                                    @if($exercise->video_url)
                                        <a href="{{ $exercise->video_url }}" target="_blank" class="video-link">
                                            <i class="fab fa-youtube me-1"></i> View
                                        </a>
                                    @else
                                        <span style="color: var(--muted-foreground);">No video</span>
                                    @endif
                                </td>
                                <td>
                                    @if($exercise->is_active)
                                        <span class="status-badge status-active">Active</span>
                                    @else
                                        <span class="status-badge status-inactive">Inactive</span>
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

            <!-- Pagination -->
            @if($exercises->hasPages())
                <div style="padding: 1.5rem; border-top: 1px solid rgba(255, 102, 0, 0.1);">
                    {{ $exercises->links() }}
                </div>
            @endif
        </div>
    </div>
</section>

@include('index.footer')
@endsection
