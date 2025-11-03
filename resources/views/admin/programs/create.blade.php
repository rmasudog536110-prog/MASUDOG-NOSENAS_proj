@extends('skeleton.layout')

@section('title', 'Create Program - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        body {
            overflow-y: auto !important;
            min-height: 100vh;
        }

        body::before {
            position: fixed !important;
            height: 100vh !important;
        }

        main {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        .form-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem 4rem 1rem;
            position: relative;
            z-index: 1;
        }

        .form-card {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 1rem;
            padding: 2.5rem;
        }

        .form-card h1 {
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
    </style>
@endpush

@section('content')

@include('index.header')

<div class="form-container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.programs.index') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Programs
        </a>
    </div>

    @if ($errors->any())
        <div class="flash-message error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="form-card">
        <h1><i class="fa-solid fa-plus-circle"></i> Create New Program</h1>
        <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
            Add a new training program to your gym
        </p>

        <form action="{{ route('admin.programs.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Program Title *</label>
                <input type="text" 
                       class="form-control" 
                       id="title" 
                       name="title" 
                       value="{{ old('title') }}" 
                       placeholder="e.g., Full Body Strength Training"
                       required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control" 
                          id="description" 
                          name="description" 
                          rows="5" 
                          placeholder="Describe the program, its benefits, and what participants can expect..."
                          required>{{ old('description') }}</textarea>
            </div>

            <div class="form-row">
                <div class="mb-3">
                    <label for="level" class="form-label">Difficulty Level *</label>
                    <select class="form-control" id="level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                        <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="duration_weeks" class="form-label">Duration (Weeks) *</label>
                    <input type="number" 
                           class="form-control" 
                           id="duration_weeks" 
                           name="duration_weeks" 
                           value="{{ old('duration_weeks', 8) }}" 
                           min="1"
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="mb-3">
                    <label for="workout_counts" class="form-label">Workouts Per Week *</label>
                    <input type="number" 
                           class="form-control" 
                           id="workout_counts" 
                           name="workout_counts" 
                           value="{{ old('workout_counts', 3) }}" 
                           min="1"
                           required>
                </div>

                <div class="mb-3">
                    <label for="equipment_required" class="form-label">Equipment Required</label>
                    <input type="text" 
                           class="form-control" 
                           id="equipment_required" 
                           name="equipment_required" 
                           value="{{ old('equipment_required') }}" 
                           placeholder="e.g., Dumbbells, Barbell, Bench">
                </div>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status *</label>
                <select class="form-control" id="is_active" name="is_active" required>
                    <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                </select>
                <small style="color: var(--muted-foreground);">
                    Only active programs will be visible to users
                </small>
            </div>

            <div style="display: flex; gap: 1rem; margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Create Program
                </button>
                <a href="{{ route('admin.programs.index') }}" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@include('index.footer')

@endsection
