@extends('skeleton.layout')

@section('title', 'Log New Workout - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
@endpush

@section('content')


<div class="workout-form-container">
    <!-- Flash Messages -->
    @if ($errors->any())
        <div class="flash-message error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="workout-form-card">
        <h1 style="color: var(--primary); margin-bottom: 0.5rem;">
            <i class="fa-solid fa-dumbbell"></i> Log New Workout
        </h1>
        <p style="color: var(--muted-foreground); margin-bottom: 2rem;">
            Track your exercise session details
        </p>

        <form action="{{ route('workout-logs.store') }}" method="POST">
            @csrf

            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-info-circle"></i> Basic Information
                </h3>

                <div class="mb-3">
                    <label for="workout_date" class="form-label">Workout Date *</label>
                    <input type="date" 
                           class="form-control" 
                           id="workout_date" 
                           name="workout_date" 
                           value="{{ old('workout_date', date('Y-m-d')) }}"
                           max="{{ date('Y-m-d') }}"
                           required>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="exercise_id" class="form-label">Exercise</label>
                        <select class="form-control" id="exercise_id" name="exercise_id">
                            <option value="">Select Exercise (Optional)</option>
                            @foreach($exercises as $exercise)
                                <option value="{{ $exercise->id }}" {{ old('exercise_id') == $exercise->id ? 'selected' : '' }}>
                                    {{ $exercise->name }}
                                </option>
                            @endforeach
                        </select>
                        <small style="color: var(--muted-foreground);">Or select a training program below</small>
                    </div>

                    <div class="mb-3">
                        <label for="training_program_id" class="form-label">Training Program</label>
                        <select class="form-control" id="training_program_id" name="training_program_id">
                            <option value="">Select Program (Optional)</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" {{ old('training_program_id') == $program->id ? 'selected' : '' }}>
                                    {{ $program->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <!-- Workout Details -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-chart-line"></i> Workout Details
                </h3>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="sets" class="form-label">Sets</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="sets" 
                               name="sets" 
                               value="{{ old('sets') }}"
                               min="1"
                               placeholder="e.g., 3">
                    </div>

                    <div class="mb-3">
                        <label for="reps" class="form-label">Reps</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="reps" 
                               name="reps" 
                               value="{{ old('reps') }}"
                               min="1"
                               placeholder="e.g., 10">
                    </div>

                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="weight" 
                               name="weight" 
                               value="{{ old('weight') }}"
                               min="0"
                               step="0.5"
                               placeholder="e.g., 50">
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="duration_minutes" 
                               name="duration_minutes" 
                               value="{{ old('duration_minutes') }}"
                               min="1"
                               placeholder="e.g., 45">
                    </div>

                    <div class="mb-3">
                        <label for="distance" class="form-label">Distance (km)</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="distance" 
                               name="distance" 
                               value="{{ old('distance') }}"
                               min="0"
                               step="0.1"
                               placeholder="e.g., 5.0">
                    </div>

                    <div class="mb-3">
                        <label for="calories_burned" class="form-label">Calories Burned</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="calories_burned" 
                               name="calories_burned" 
                               value="{{ old('calories_burned') }}"
                               min="0"
                               placeholder="e.g., 300">
                    </div>
                </div>

                <!-- Quick Fill Buttons -->
                <div style="display: flex; gap: 0.5rem; flex-wrap: wrap; margin-top: 1rem;">
                    <button type="button" class="quick-fill-btn" onclick="quickFill('strength')">
                        💪 Strength Training
                    </button>
                    <button type="button" class="quick-fill-btn" onclick="quickFill('cardio')">
                        🏃 Cardio
                    </button>
                    <button type="button" class="quick-fill-btn" onclick="quickFill('hiit')">
                        🔥 HIIT
                    </button>
                </div>
            </div>

            <!-- Feedback -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-comment"></i> Workout Feedback
                </h3>

                <div class="mb-3">
                    <label class="form-label">Difficulty Level</label>
                    <div class="difficulty-options">
                        <label class="difficulty-option">
                            <input type="radio" name="difficulty" value="easy" {{ old('difficulty') == 'easy' ? 'checked' : '' }}>
                            <div>
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">😊</div>
                                <div>Easy</div>
                            </div>
                        </label>
                        <label class="difficulty-option">
                            <input type="radio" name="difficulty" value="medium" {{ old('difficulty') == 'medium' ? 'checked' : '' }}>
                            <div>
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">😅</div>
                                <div>Medium</div>
                            </div>
                        </label>
                        <label class="difficulty-option">
                            <input type="radio" name="difficulty" value="hard" {{ old('difficulty') == 'hard' ? 'checked' : '' }}>
                            <div>
                                <div style="font-size: 2rem; margin-bottom: 0.5rem;">😰</div>
                                <div>Hard</div>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Rating (1-5 stars)</label>
                    <div class="rating-input">
                        <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}">
                        <span class="rating-star" data-rating="1">★</span>
                        <span class="rating-star" data-rating="2">★</span>
                        <span class="rating-star" data-rating="3">★</span>
                        <span class="rating-star" data-rating="4">★</span>
                        <span class="rating-star" data-rating="5">★</span>
                        <span style="margin-left: 1rem; color: var(--muted-foreground);" id="rating-text">Not rated</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="notes" class="form-label">Notes</label>
                    <textarea class="form-control" 
                              id="notes" 
                              name="notes" 
                              rows="4" 
                              placeholder="How did you feel? Any observations or improvements?">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Workout
                </button>
                <a href="{{ route('workout-logs.index') }}" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@include('index.footer')

@endsection

@push('scripts')
<script>
    // Rating System
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('rating-text');
    
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            updateStars(rating);
        });
        
        star.addEventListener('mouseenter', function() {
            const rating = this.getAttribute('data-rating');
            updateStars(rating);
        });
    });
    
    document.querySelector('.rating-input').addEventListener('mouseleave', function() {
        updateStars(ratingInput.value);
    });
    
    function updateStars(rating) {
        ratingStars.forEach((star, index) => {
            if (index < rating) {
                star.classList.add('active');
            } else {
                star.classList.remove('active');
            }
        });
        
        const ratingTexts = ['Not rated', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
        ratingText.textContent = ratingTexts[rating] || 'Not rated';
    }
    
    // Initialize stars based on old value
    updateStars({{ (int)old('rating', 0) }});
    
    // Quick Fill Functions
    function quickFill(type) {
        if (type === 'strength') {
            document.getElementById('sets').value = 3;
            document.getElementById('reps').value = 10;
            document.getElementById('duration_minutes').value = 45;
            document.getElementById('calories_burned').value = 250;
        } else if (type === 'cardio') {
            document.getElementById('duration_minutes').value = 30;
            document.getElementById('distance').value = 5;
            document.getElementById('calories_burned').value = 300;
        } else if (type === 'hiit') {
            document.getElementById('duration_minutes').value = 20;
            document.getElementById('calories_burned').value = 400;
        }
    }
    
    // Difficulty selection
    document.querySelectorAll('.difficulty-option').forEach(option => {
        option.addEventListener('click', function() {
            const radio = this.querySelector('input[type="radio"]');
            radio.checked = true;
            
            // Update visual state
            document.querySelectorAll('.difficulty-option').forEach(opt => {
                opt.style.borderColor = 'rgba(255, 102, 0, 0.2)';
                opt.style.background = 'var(--muted)';
            });
            this.style.borderColor = 'var(--primary)';
            this.style.background = 'rgba(255, 102, 0, 0.15)';
        });
    });
</script>
@endpush
