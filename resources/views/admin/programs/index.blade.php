@extends('skeleton.layout')

@section('title', 'Manage Programs - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .programs-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-box {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 1.5rem;
            text-align: center;
        }

        .stat-box h3 {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-box .value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .programs-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 1.5rem;
        }

        .program-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.7rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
        }

        .program-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 1rem;
        }

        .program-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.5rem;
        }

        .program-level {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .level-beginner {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .level-intermediate {
            background: rgba(255, 193, 7, 0.2);
            color: #ffc107;
        }

        .level-advanced {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .program-details {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            margin-bottom: 1rem;
        }

        .program-details div {
            margin-bottom: 0.5rem;
        }

        .program-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-inactive {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
        }
    </style>
@endpush

@section('content')

@include('admin.admin_header')

<section class="content-section">
    <div class="container">
        <div class="programs-header">
            <div>
                <h1>Manage Training Programs</h1>
                <p style="color: var(--muted-foreground);">Create and manage all training programs</p>
            </div>
            <div style="display: flex; gap: 1rem;">
                <a href="{{ route('admin.programs.create') }}" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add New Program
                </a>
                <a href="{{ route('admin.admin_dashboard') }}" class="btn btn-outline">
                    <i class="fa-solid fa-arrow-left"></i> Back
                </a>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="flash-message success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats -->
        <div class="stats-grid">
            <div class="stat-box">
                <h3>Total Programs</h3>
                <div class="value">{{ $stats['total'] }}</div>
            </div>
            <div class="stat-box">
                <h3>Active Programs</h3>
                <div class="value">{{ $stats['active'] }}</div>
            </div>
            <div class="stat-box">
                <h3>Inactive Programs</h3>
                <div class="value">{{ $stats['inactive'] }}</div>
            </div>
        </div>

        <!-- Programs Grid -->
        <div class="programs-grid">
            @forelse($programs as $program)
                <div class="program-card">
                    <div class="program-header">
                        <div>
                            <h3 class="program-title">{{ $program->title }}</h3>
                            <span class="program-level level-{{ $program->level }}">
                                {{ ucfirst($program->level) }}
                            </span>
                        </div>
                        <span class="status-badge status-{{ $program->is_active ? 'active' : 'inactive' }}">
                            {{ $program->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>

                    <div class="program-details">
                        <div>
                            <i class="fa-solid fa-calendar"></i>
                            <strong>Duration:</strong> {{ $program->duration_weeks }} weeks
                        </div>
                        <div>
                            <i class="fa-solid fa-dumbbell"></i>
                            <strong>Workouts:</strong> {{ $program->workout_counts }} per week
                        </div>
                        @if($program->equipment_required)
                            <div>
                                <i class="fa-solid fa-tools"></i>
                                <strong>Equipment:</strong> {{ $program->equipment_required }}
                            </div>
                        @endif
                    </div>

                    <div class="program-actions">
                        <a href="{{ route('admin.programs.edit', $program) }}" 
                           class="btn btn-outline btn-sm">
                            <i class="fa-solid fa-edit"></i> Edit
                        </a>

                        <form action="{{ route('admin.programs.toggle', $program) }}" 
                              method="POST" 
                              style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-outline btn-sm">
                                <i class="fa-solid fa-{{ $program->is_active ? 'ban' : 'check' }}"></i>
                                {{ $program->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>

                        <form action="{{ route('admin.programs.destroy', $program) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to delete this program?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="btn btn-outline btn-sm"
                                    style="color: #dc3545; border-color: #dc3545;">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem; color: var(--muted-foreground);">
                    <i class="fa-solid fa-dumbbell" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>No programs yet. Create your first program!</p>
                    <a href="{{ route('admin.programs.create') }}" class="btn btn-primary" style="margin-top: 1rem;">
                        <i class="fa-solid fa-plus"></i> Add New Program
                    </a>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($programs->hasPages())
            <div style="margin-top: 2rem;">
                {{ $programs->links() }}
            </div>
        @endif
    </div>
</section>

@include('index.footer')

@endsection
