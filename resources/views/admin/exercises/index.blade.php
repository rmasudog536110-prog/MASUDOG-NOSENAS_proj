@extends('skeleton.layout')

@section('title', 'Manage Exercises - Admin')

@push('styles')
<style>
    .admin-exercises-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        padding: 2rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, var(--primary) 0%, #ff8533 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
    }
    
    .page-header h1 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }
    
    .page-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0 0;
    }
    
    .header-actions {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }
    
    .btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-add-new {
        background: white;
        color: var(--primary);
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }
    
    .btn-add-new:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.3);
        color: var(--primary);
    }
    
    .exercises-card {
        background: var(--card);
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }
    
    .table-container {
        overflow-x: auto;
    }
    
    .exercises-table {
        width: 100%;
        margin: 0;
    }
    
    .exercises-table thead {
        background: rgba(255, 102, 0, 0.1);
    }
    
    .exercises-table thead th {
        padding: 1rem;
        font-weight: 700;
        color: var(--foreground);
        border: none;
        text-transform: uppercase;
        font-size: 0.875rem;
        letter-spacing: 0.5px;
    }
    
    .exercises-table tbody tr {
        border-bottom: 1px solid rgba(255, 102, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .exercises-table tbody tr:hover {
        background: rgba(255, 102, 0, 0.05);
        transform: scale(1.01);
    }
    
    .exercises-table tbody td {
        padding: 1rem;
        vertical-align: middle;
        color: var(--foreground);
    }
    
    .exercise-icon {
        font-size: 2rem;
        display: inline-block;
    }
    
    .exercise-name {
        font-weight: 600;
        color: var(--foreground);
        font-size: 1rem;
    }
    
    .category-badge, .difficulty-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
        display: inline-block;
    }
    
    .video-link {
        color: #ff0000;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    
    .video-link:hover {
        color: #cc0000;
        transform: scale(1.1);
    }
    
    .status-badge {
        padding: 0.375rem 0.875rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.875rem;
    }
    
    .status-active {
        background: rgba(40, 167, 69, 0.2);
        color: #28a745;
    }
    
    .status-inactive {
        background: rgba(108, 117, 125, 0.2);
        color: #6c757d;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .btn-action {
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .btn-edit {
        background: rgba(0, 123, 255, 0.2);
        color: #007bff;
    }
    
    .btn-edit:hover {
        background: #007bff;
        color: white;
        transform: translateY(-2px);
    }
    
    .btn-delete {
        background: rgba(220, 53, 69, 0.2);
        color: #dc3545;
    }
    
    .btn-delete:hover {
        background: #dc3545;
        color: white;
        transform: translateY(-2px);
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
    
    .empty-state-text {
        color: var(--muted-foreground);
        font-size: 1.125rem;
        margin-bottom: 2rem;
    }
</style>
@endpush

@section('content')
@include('index.header')

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
