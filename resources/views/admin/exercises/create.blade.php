@extends('skeleton.layout')

@section('title', 'Add New Exercise - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/exercises.css') }}">
@endpush

@section('content')
@if (Auth::user() && Auth::user()->hasAdminAccess())
@include('admin.admin_header')
@else
@include('index.header')
@endif

<section class="py-5" style="min-height: 100vh; background: var(--background);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header -->
                <div class="mb-4">
                    <h1 style="color: var(--foreground);">
                        <i class="fas fa-plus-circle me-2"></i> Add New Exercise
                    </h1>
                    <p class="text-muted">Create a new exercise for the library</p>
                </div>

                <!-- Form Card -->
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <form action="{{ route('admin.exercises.store') }}" method="POST">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Exercise Name *</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}"
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
                                          required>{{ old('description') }}</textarea>
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
                                        <option value="strength" {{ old('category') == 'strength' ? 'selected' : '' }}>Strength</option>
                                        <option value="cardio" {{ old('category') == 'cardio' ? 'selected' : '' }}>Cardio</option>
                                        <option value="flexibility" {{ old('category') == 'flexibility' ? 'selected' : '' }}>Flexibility</option>
                                        <option value="plyometrics" {{ old('category') == 'plyometrics' ? 'selected' : '' }}>Plyometrics</option>
                                        <option value="functional" {{ old('category') == 'functional' ? 'selected' : '' }}>Functional</option>
                                        <option value="core" {{ old('category') == 'core' ? 'selected' : '' }}>Core</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Difficulty *</label>
                                    <select name="difficulty" class="form-select @error('difficulty') is-invalid @enderror" required>
                                        <option value="">Select Difficulty</option>
                                        <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                                        <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                        <option value="expert" {{ old('difficulty') == 'expert' ? 'selected' : '' }}>Expert</option>
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
                                       value="{{ old('equipment') }}"
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
                                       value="{{ old('muscle_group') }}"
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
                                          placeholder="Enter each step on a new line">{{ old('instructions') }}</textarea>
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
                                       value="{{ old('video_url') }}"
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
                                       value="{{ old('icon', '💪') }}"
                                       maxlength="10"
                                       placeholder="💪">
                                <small class="text-muted">Enter an emoji to represent this exercise</small>
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Create Exercise
                                </button>
                                <a href="{{ route('admin.exercises.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-times me-1"></i> Cancel
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
