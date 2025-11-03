@extends('skeleton.layout')

@section('title', 'Edit Exercise - Admin')

@push('styles')
<style>
    .edit-exercise-page {
        min-height: 100vh;
        background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
        padding: 2rem 0;
    }
    
    .form-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border-radius: 1rem;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 20px rgba(0, 123, 255, 0.3);
    }
    
    .form-header h1 {
        color: white;
        margin: 0;
        font-weight: 700;
        font-size: 2rem;
    }
    
    .form-header p {
        color: rgba(255, 255, 255, 0.9);
        margin: 0.5rem 0 0 0;
    }
    
    .form-card {
        background: var(--card);
        border-radius: 1rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
    }
    
    .form-section {
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        color: var(--primary);
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(255, 102, 0, 0.2);
    }
    
    .form-label {
        color: var(--foreground);
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
    }
    
    .form-label .required {
        color: #dc3545;
    }
    
    .form-control, .form-select {
        background: rgba(255, 102, 0, 0.05);
        border: 1px solid rgba(255, 102, 0, 0.2);
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        color: var(--foreground);
        transition: all 0.3s ease;
    }
    
    .form-select option {
        background: #2d2d2d;
        color: white;
        padding: 0.5rem;
    }
    
    .form-control:focus, .form-select:focus {
        background: rgba(255, 102, 0, 0.08);
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
        outline: none;
    }
    
    .form-text {
        color: var(--muted-foreground);
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
    
    .form-actions {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 102, 0, 0.1);
    }
    
    .btn-save {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 0.875rem 2.5rem;
        border-radius: 0.5rem;
        font-weight: 700;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
    }
    
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 123, 255, 0.4);
    }
    
    .btn-cancel {
        background: rgba(108, 117, 125, 0.2);
        color: var(--foreground);
        padding: 0.875rem 2rem;
        border-radius: 0.5rem;
        font-weight: 600;
        border: 1px solid rgba(108, 117, 125, 0.3);
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-block;
    }
    
    .btn-cancel:hover {
        background: rgba(108, 117, 125, 0.3);
        color: var(--foreground);
        transform: translateY(-2px);
    }
    
    .input-icon {
        position: relative;
    }
    
    .input-icon i {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        color: var(--primary);
    }
    
    .input-icon .form-control {
        padding-left: 3rem;
    }
</style>
@endpush

@section('content')
@include('index.header')

<section class="edit-exercise-page">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <!-- Header -->
                <div class="form-header">
                    <h1>
                        <i class="fas fa-edit me-2"></i> Edit Exercise
                    </h1>
                    <p>Update exercise details and information</p>
                </div>

                <!-- Form Card -->
                <div class="form-card">
                        <form action="{{ route('admin.exercises.update', $exercise) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information Section -->
                            <div class="form-section">
                                <h3 class="form-section-title">
                                    <i class="fas fa-info-circle me-2"></i> Basic Information
                                </h3>

                                <!-- Name -->
                                <div class="mb-3">
                                    <label class="form-label">Exercise Name <span class="required">*</span></label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $exercise->name) }}"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description *</label>
                                <textarea name="description" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          rows="3"
                                          required>{{ old('description', $exercise->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Category & Difficulty -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Category *</label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                        <option value="">Select Category</option>
                                        <option value="strength" {{ old('category', $exercise->category) == 'strength' ? 'selected' : '' }}>Strength</option>
                                        <option value="cardio" {{ old('category', $exercise->category) == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                        <option value="flexibility" {{ old('category', $exercise->category) == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                        <option value="plyometrics" {{ old('category', $exercise->category) == 'plyometrics' ? 'selected' : '' }}>Plyometrics</option>
                                        <option value="functional" {{ old('category', $exercise->category) == 'functional' ? 'selected' : '' }}>Functional</option>
                                        <option value="core" {{ old('category', $exercise->category) == 'core' ? 'selected' : '' }}>Core</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Difficulty *</label>
                                    <select name="difficulty" class="form-select @error('difficulty') is-invalid @enderror" required>
                                        <option value="">Select Difficulty</option>
                                        <option value="beginner" {{ old('difficulty', $exercise->difficulty) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="intermediate" {{ old('difficulty', $exercise->difficulty) == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="expert" {{ old('difficulty', $exercise->difficulty) == 'expert' ? 'selected' : '' }}>Expert</option>
                                    </select>
                                    @error('difficulty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Equipment -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Equipment *</label>
                                <input type="text" 
                                       name="equipment" 
                                       class="form-control @error('equipment') is-invalid @enderror" 
                                       value="{{ old('equipment', $exercise->equipment) }}"
                                       placeholder="e.g., Dumbbells, Barbell, Bodyweight"
                                       required>
                                @error('equipment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Muscle Group -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Muscle Group</label>
                                <input type="text" 
                                       name="muscle_group" 
                                       class="form-control @error('muscle_group') is-invalid @enderror" 
                                       value="{{ old('muscle_group', $exercise->muscle_group) }}"
                                       placeholder="e.g., Chest, Triceps, Shoulders (comma-separated)">
                                <small class="text-muted">Separate multiple muscle groups with commas</small>
                                @error('muscle_group')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Instructions -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Instructions</label>
                                <textarea name="instructions" 
                                          class="form-control @error('instructions') is-invalid @enderror" 
                                          rows="5"
                                          placeholder="Enter each step on a new line">{{ old('instructions', $exercise->instructions) }}</textarea>
                                <small class="text-muted">Enter each instruction step on a new line</small>
                                @error('instructions')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Video URL -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">YouTube Video URL</label>
                                <input type="url" 
                                       name="video_url" 
                                       class="form-control @error('video_url') is-invalid @enderror" 
                                       value="{{ old('video_url', $exercise->video_url) }}"
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">Paste the full YouTube video URL</small>
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Icon (Emoji)</label>
                                <input type="text" 
                                       name="icon" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       value="{{ old('icon', $exercise->icon) }}"
                                       maxlength="10"
                                       placeholder="💪">
                                <small class="text-muted">Enter an emoji to represent this exercise</small>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save me-2"></i> Update Exercise
                                </button>
                                <a href="{{ route('admin.exercises.index') }}" class="btn-cancel">
                                    <i class="fas fa-times me-2"></i> Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('index.footer')
@endsection
