@extends('skeleton.layout')

@section('title', 'Add New Exercise - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-exercise-form.css') }}">
@endpush

@section('content')

<div class="admin-exercise-container">
    <div class="form-card">

        <div class="back-to-programs">
            <a href="{{ route('admin.exercises.index') }}" class="btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Exercises
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

        <h1><i class="fa-solid fa-plus-circle"></i> Add New Exercise</h1>
        <p>Create a new exercise for the library</p>

        <form action="{{ route('admin.exercises.store') }}" method="POST">
            @csrf

            <!-- Basic Information Section -->
            <div class="form-section">
                <div class="section-card">
                    <div class="section-title">
                        <i class="fa-solid fa-info-circle"></i>
                        Basic Information
                    </div>
                    
                    <div class="form-group">
                        <label for="name" class="form-label">Exercise Name<span class="required">*</span></label>
                        <input type="text" 
                               class="form-control" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               placeholder="e.g., Push-ups, Squats, Deadlifts"
                               required>
                    </div>

                    <div class="form-group">
                        <label for="description" class="form-label">Description<span class="required">*</span></label>
                        <textarea class="form-control" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="Brief description of the exercise and its benefits..."
                                  required>{{ old('description') }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Exercise Details Section -->
            <div class="form-section">
                <div class="section-card">
                    <div class="section-title">
                        <i class="fa-solid fa-cog"></i>
                        Exercise Details
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="category" class="form-label">Category<span class="required">*</span></label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Select Category</option>
                                <option value="warmup" {{ old('category') == 'warmup' ? 'selected' : '' }}>Warmup</option>
                                <option value="strength" {{ old('category') == 'strength' ? 'selected' : '' }}>Strength</option>
                                <option value="cardio" {{ old('category') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                <option value="flexibility" {{ old('category') == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                <option value="plyometrics" {{ old('category') == 'plyometrics' ? 'selected' : '' }}>Plyometrics</option>
                                <option value="functional" {{ old('category') == 'functional' ? 'selected' : '' }}>Functional</option>
                                <option value="core" {{ old('category') == 'core' ? 'selected' : '' }}>Core</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="difficulty" class="form-label">Difficulty<span class="required">*</span></label>
                            <select class="form-control" id="difficulty" name="difficulty" required>
                                <option value="">Select Difficulty</option>
                                <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="expert" {{ old('difficulty') == 'expert' ? 'selected' : '' }}>Expert</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="equipment" class="form-label">Equipment<span class="required">*</span></label>
                            <input type="text" 
                                   class="form-control" 
                                   id="equipment" 
                                   name="equipment" 
                                   value="{{ old('equipment') }}" 
                                   placeholder="e.g., Dumbbells, Barbell, Bodyweight"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="muscle_group" class="form-label">Muscle Group</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="muscle_group" 
                                   name="muscle_group" 
                                   value="{{ old('muscle_group') }}" 
                                   placeholder="e.g., Chest, Triceps, Shoulders">
                            <div class="form-help">
                                <i class="fa-solid fa-info-circle"></i>
                                Separate multiple muscle groups with commas
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Instructions Section -->
            <div class="form-section">
                <div class="section-card">
                    <div class="section-title">
                        <i class="fa-solid fa-list-ol"></i>
                        Instructions & Media
                    </div>
                    
                    <div class="form-group">
                        <label for="instructions" class="form-label">Instructions</label>
                        <textarea class="form-control" 
                                  id="instructions" 
                                  name="instructions" 
                                  rows="6" 
                                  placeholder="Enter each instruction step on a new line">{{ old('instructions') }}</textarea>
                        <div class="form-help">
                            <i class="fa-solid fa-info-circle"></i>
                            Enter each instruction step on a new line for better readability
                        </div>
                    </div>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="video_url" class="form-label">YouTube Video URL</label>
                            <input type="url" 
                                   class="form-control" 
                                   id="video_url" 
                                   name="video_url" 
                                   value="{{ old('video_url') }}" 
                                   placeholder="https://www.youtube.com/watch?v=...">
                            <div class="form-help">
                                <i class="fa-solid fa-video"></i>
                                Paste the full YouTube video URL
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="icon" class="form-label">Icon (Emoji)</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="icon" 
                                   name="icon" 
                                   value="{{ old('icon', '💪') }}"
                                   maxlength="10"
                                   placeholder="💪">
                            <div class="form-help">
                                <i class="fa-solid fa-icons"></i>
                                Enter an emoji to represent this exercise
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-plus"></i> Add Exercise
                </button>
                <a href="{{ route('admin.exercises.index') }}" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>


@endsection
