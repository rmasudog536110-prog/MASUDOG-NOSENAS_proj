@extends('skeleton.layout')

@section('title', 'Create Program - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-program-form.css') }}">
@endpush

@section('content')

<div class="admin-program-container">
    <div class="form-card">

        <div class="back-to-programs">
            <a href="{{ route('admin.programs.index') }}" class="btn-outline">
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

        <h1><i class="fa-solid fa-plus-circle"></i> Create New Program</h1>
        <p>Add a new training program to your gym</p>

        <form action="{{ route('admin.programs.store') }}" method="POST">
            @csrf

            <!-- Program Details Section -->
            <div class="form-section">
                <div class="section-card">
                    <div class="section-title">
                        <i class="fa-solid fa-info-circle"></i>
                        Program Details
                    </div>
                    
                    <div class="form-group">
                        <label for="title" class="form-label">Program Title<span class="required">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               placeholder="e.g., Full Body Strength Training"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description<span class="required">*</span></label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="6" 
                                  placeholder="Describe the program, its benefits, and what participants can expect..."
                                  required>{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Scheduling Section -->
            <div class="form-section">
                <div class="section-card">
                    <div class="section-title">
                        <i class="fa-solid fa-calendar-alt"></i>
                        Scheduling
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="level" class="form-label">Difficulty Level<span class="required">*</span></label>
                            <select class="form-control" id="level" name="level" required>
                                <option value="">Select Level</option>
                                <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="duration_weeks" class="form-label">Duration (Weeks)<span class="required">*</span></label>
                            <input type="number" 
                                   class="form-control" 
                                   id="duration_weeks" 
                                   name="duration_weeks" 
                                   value="{{ old('duration_weeks', 8) }}" 
                                   min="1"
                                   required>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="workout_counts" class="form-label">Workouts Per Week<span class="required">*</span></label>
                            <input type="number" 
                                   class="form-control" 
                                   id="workout_counts" 
                                   name="workout_counts" 
                                   value="{{ old('workout_counts', 3) }}" 
                                   min="1"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="equipment_required" class="form-label">Equipment Required</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="equipment_required" 
                                   name="equipment_required" 
                                   value="{{ old('equipment_required') }}" 
                                   placeholder="e.g., Dumbbells, Barbell, Bench">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Requirements Section -->
            <div class="form-section">
                <div class="section-card">
                    <div class="section-title">
                        <i class="fa-solid fa-cog"></i>
                        Requirements
                    </div>
                    
                    <div class="form-group">
                        <label for="is_active" class="form-label">Status<span class="required">*</span></label>
                        <select class="form-control" id="is_active" name="is_active" required>
                            <option value="1" {{ old('is_active', '1') == '1' ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == '0' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <div class="form-help">
                            Only active programs will be visible to users
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
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


@endsection
