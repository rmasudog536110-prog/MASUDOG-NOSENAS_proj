<?php $__env->startSection('title', 'Log New Workout - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/workout-form.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="workout-form-container">
    <!-- Flash Messages -->
    <?php if($errors->any()): ?>
        <div class="flash-message error">
            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="workout-form-card">
        <!-- Progress Indicator -->
        <div class="form-progress-text" id="progress-text">Form Completion: 0%</div>
        <div class="form-progress">
            <div class="form-progress-bar" id="progress-bar" style="width: 0%"></div>
        </div>

        <!-- Header -->
        <div class="workout-form-header">
            <h1><i class="fa-solid fa-dumbbell"></i> Log New Workout</h1>
            <p>Track your exercise session details and monitor your progress</p>
        </div>

        <form action="<?php echo e(route('workout-logs.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- Basic Information -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-info-circle"></i> Basic Information
                </h3>

                <div class="form-group">
                    <label for="workout_date" class="form-label">
                        Workout Date <span class="required">*</span>
                    </label>
                    <div class="input-wrapper">
                        <input type="date" 
                               class="form-control" 
                               id="workout_date" 
                               name="workout_date" 
                               value="<?php echo e(old('workout_date', date('Y-m-d'))); ?>"
                               max="<?php echo e(date('Y-m-d')); ?>"
                               required>
                        <span class="validation-feedback" id="workout_date-feedback">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    <div class="field-error" id="workout_date-error">Please select a valid workout date</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="exercise_id" class="form-label">Exercise</label>
                        <select class="form-control" id="exercise_id" name="exercise_id">
                            <option value="">Select Exercise (Optional)</option>
                            <?php $__currentLoopData = $exercises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($exercise->id); ?>" <?php echo e(old('exercise_id') == $exercise->id ? 'selected' : ''); ?>>
                                    <?php echo e($exercise->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <div class="form-help">Or select a training program below</div>
                    </div>

                    <div class="form-group">
                        <label for="training_program_id" class="form-label">Training Program</label>
                        <select class="form-control" id="training_program_id" name="training_program_id">
                            <option value="">Select Program (Optional)</option>
                            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($program->id); ?>" <?php echo e(old('training_program_id') == $program->id ? 'selected' : ''); ?>>
                                    <?php echo e($program->title); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <div class="form-group">
                        <label for="sets" class="form-label">Sets</label>
                        <div class="input-wrapper">
                            <input type="number" 
                                   class="form-control numeric-align" 
                                   id="sets" 
                                   name="sets" 
                                   value="<?php echo e(old('sets')); ?>"
                                   min="1"
                                   placeholder="e.g., 3">
                            <span class="validation-feedback" id="sets-feedback">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        </div>
                        <div class="field-error" id="sets-error">Please enter a valid number of sets</div>
                    </div>

                    <div class="form-group">
                        <label for="reps" class="form-label">Reps</label>
                        <div class="input-wrapper">
                            <input type="number" 
                                   class="form-control numeric-align" 
                                   id="reps" 
                                   name="reps" 
                                   value="<?php echo e(old('reps')); ?>"
                                   min="1"
                                   placeholder="e.g., 10">
                            <span class="validation-feedback" id="reps-feedback">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        </div>
                        <div class="field-error" id="reps-error">Please enter a valid number of reps</div>
                    </div>

                    <div class="form-group">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <div class="input-wrapper">
                            <input type="number" 
                                   class="form-control numeric-align" 
                                   id="weight" 
                                   name="weight" 
                                   value="<?php echo e(old('weight')); ?>"
                                   min="0"
                                   step="0.5"
                                   placeholder="e.g., 50">
                            <span class="validation-feedback" id="weight-feedback">
                                <i class="fa-solid fa-check"></i>
                            </span>
                        </div>
                        <div class="field-error" id="weight-error">Please enter a valid weight</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="duration_minutes" class="form-label">Duration (minutes)</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="duration_minutes" 
                               name="duration_minutes" 
                               value="<?php echo e(old('duration_minutes')); ?>"
                               min="1"
                               placeholder="e.g., 45">
                    </div>

                    <div class="form-group">
                        <label for="distance" class="form-label">Distance (km)</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="distance" 
                               name="distance" 
                               value="<?php echo e(old('distance')); ?>"
                               min="0"
                               step="0.1"
                               placeholder="e.g., 5.0">
                    </div>

                    <div class="form-group">
                        <label for="calories_burned" class="form-label">Calories Burned</label>
                        <input type="number" 
                               class="form-control numeric-align" 
                               id="calories_burned" 
                               name="calories_burned" 
                               value="<?php echo e(old('calories_burned')); ?>"
                               min="0"
                               placeholder="e.g., 300">
                    </div>
                </div>

                <!-- Smart Calculator -->
                <div class="smart-calculator" id="smart-calculator" style="display: none;">
                    <i class="fa-solid fa-calculator"></i>
                    <span>Estimated Volume:</span>
                    <span class="calculator-result" id="volume-result">0 kg</span>
                </div>

                <!-- Quick Fill Buttons -->
                <div class="quick-fill-buttons">
                    <button type="button" class="quick-fill-btn" onclick="quickFill('strength')">
                        <i class="fa-solid fa-dumbbell"></i> Strength Training
                    </button>
                    <button type="button" class="quick-fill-btn" onclick="quickFill('cardio')">
                        <i class="fa-solid fa-running"></i> Cardio
                    </button>
                    <button type="button" class="quick-fill-btn" onclick="quickFill('hiit')">
                        <i class="fa-solid fa-fire"></i> HIIT
                    </button>
                </div>
            </div>

            <!-- Feedback -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-comment"></i> Workout Feedback
                </h3>

                <div class="form-group">
                    <label class="form-label">Difficulty Level</label>
                    
                    <!-- Modern Design -->
                    <div class="difficulty-selector-alt">
                        <div class="difficulty-value-display">
                            <div class="value" id="difficulty-value">Not Selected</div>
                            <div class="label">Current Difficulty</div>
                        </div>
                        
                        <div class="difficulty-slider-container">
                            <input type="range" 
                                   class="difficulty-slider" 
                                   id="difficulty-slider" 
                                   min="1" 
                                   max="3" 
                                   value="<?php echo e(old('difficulty') == 'easy' ? '1' : (old('difficulty') == 'medium' ? '2' : (old('difficulty') == 'hard' ? '3' : '0'))); ?>"
                                   step="1">
                        </div>
                        
                        <div class="difficulty-progress">
                            <div class="difficulty-progress-bar <?php echo e(old('difficulty') ?? 'easy'); ?>" id="difficulty-progress-bar"></div>
                        </div>
                        
                        <div class="difficulty-levels">
                            <div class="difficulty-level easy <?php echo e(old('difficulty') == 'easy' ? 'active' : ''); ?>" data-level="easy">
                                <span class="difficulty-icon">😊</span>
                                <div class="difficulty-label">Easy</div>
                                <div class="difficulty-description">Light workout</div>
                            </div>
                            <div class="difficulty-level medium <?php echo e(old('difficulty') == 'medium' ? 'active' : ''); ?>" data-level="medium">
                                <span class="difficulty-icon">😅</span>
                                <div class="difficulty-label">Medium</div>
                                <div class="difficulty-description">Moderate intensity</div>
                            </div>
                            <div class="difficulty-level hard <?php echo e(old('difficulty') == 'hard' ? 'active' : ''); ?>" data-level="hard">
                                <span class="difficulty-icon">😰</span>
                                <div class="difficulty-label">Hard</div>
                                <div class="difficulty-description">Challenging workout</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hidden radio buttons for form submission -->
                    <div style="display: none;">
                        <input type="radio" name="difficulty" value="easy" <?php echo e(old('difficulty') == 'easy' ? 'checked' : ''); ?> id="difficulty-easy">
                        <input type="radio" name="difficulty" value="medium" <?php echo e(old('difficulty') == 'medium' ? 'checked' : ''); ?> id="difficulty-medium">
                        <input type="radio" name="difficulty" value="hard" <?php echo e(old('difficulty') == 'hard' ? 'checked' : ''); ?> id="difficulty-hard">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Rating (1-5 stars)</label>
                    <div class="rating-input">
                        <input type="hidden" name="rating" id="rating" value="<?php echo e(old('rating', 0)); ?>">
                        <span class="rating-star" data-rating="1">★</span>
                        <span class="rating-star" data-rating="2">★</span>
                        <span class="rating-star" data-rating="3">★</span>
                        <span class="rating-star" data-rating="4">★</span>
                        <span class="rating-star" data-rating="5">★</span>
                        <span id="rating-text">Not rated</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">Notes</label>
                    <div class="input-wrapper">
                        <textarea class="form-control" 
                                  id="notes" 
                                  name="notes" 
                                  rows="4" 
                                  placeholder="How did you feel? Any observations or improvements?"><?php echo e(old('notes')); ?></textarea>
                        <span class="validation-feedback" id="notes-feedback">
                            <i class="fa-solid fa-check"></i>
                        </span>
                    </div>
                    <div class="form-help">Optional: Share your thoughts about this workout</div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Workout
                </button>
                <a href="<?php echo e(route('workout-logs.index')); ?>" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // ===== Enhanced Form Features =====
    
    // Form Progress Tracking
    function updateFormProgress() {
        const requiredFields = ['workout_date'];
        const optionalFields = ['exercise_id', 'training_program_id', 'sets', 'reps', 'weight', 'duration_minutes', 'distance', 'calories_burned', 'difficulty', 'rating', 'notes'];
        
        let completedFields = 0;
        let totalFields = requiredFields.length + optionalFields.length;
        
        // Check required fields
        requiredFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && field.value) {
                completedFields++;
            }
        });
        
        // Check optional fields
        optionalFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);
            if (field && field.value) {
                completedFields++;
            }
        });
        
        // Check difficulty selection
        const difficultySelected = document.querySelector('input[name="difficulty"]:checked');
        if (difficultySelected) completedFields++;
        
        // Check rating
        const rating = document.getElementById('rating').value;
        if (rating > 0) completedFields++;
        
        const progress = Math.round((completedFields / (totalFields + 2)) * 100);
        
        // Update progress bar
        const progressBar = document.getElementById('progress-bar');
        const progressText = document.getElementById('progress-text');
        
        progressBar.style.width = progress + '%';
        progressText.textContent = `Form Completion: ${progress}%`;
        
        // Add color coding
        if (progress >= 80) {
            progressBar.style.background = 'linear-gradient(90deg, #28a745 0%, #20c997 100%)';
        } else if (progress >= 50) {
            progressBar.style.background = 'linear-gradient(90deg, #ffc107 0%, #ff6600 100%)';
        } else {
            progressBar.style.background = 'linear-gradient(90deg, #ff6600 0%, #ff8c00 100%)';
        }
    }
    
    // Real-time Validation
    function validateField(fieldId) {
        const field = document.getElementById(fieldId);
        const feedback = document.getElementById(fieldId + '-feedback');
        const error = document.getElementById(fieldId + '-error');
        
        if (!field) return true;
        
        let isValid = true;
        
        // Date validation
        if (fieldId === 'workout_date') {
            const selectedDate = new Date(field.value);
            const today = new Date();
            today.setHours(23, 59, 59, 999);
            
            if (!field.value || selectedDate > today) {
                isValid = false;
            }
        }
        
        // Numeric validation
        if (field.type === 'number') {
            const value = parseFloat(field.value);
            const min = parseFloat(field.min);
            
            if (fieldId === 'sets' || fieldId === 'reps') {
                isValid = value >= min && Number.isInteger(value);
            } else if (fieldId === 'weight' || fieldId === 'calories_burned') {
                isValid = value >= min;
            } else if (fieldId === 'duration_minutes') {
                isValid = value >= min && Number.isInteger(value);
            } else if (fieldId === 'distance') {
                isValid = value >= min;
            }
        }
        
        // Update UI
        if (isValid && field.value) {
            field.classList.remove('invalid');
            field.classList.add('valid');
            if (feedback) {
                feedback.classList.add('show', 'valid');
                feedback.classList.remove('invalid');
            }
            if (error) error.classList.remove('show');
        } else if (field.value) {
            field.classList.remove('valid');
            field.classList.add('invalid');
            if (feedback) {
                feedback.classList.add('show', 'invalid');
                feedback.classList.remove('valid');
            }
            if (error) error.classList.add('show');
        } else {
            field.classList.remove('valid', 'invalid');
            if (feedback) feedback.classList.remove('show');
            if (error) error.classList.remove('show');
        }
        
        return isValid;
    }
    
    // Smart Calculator
    function updateVolumeCalculator() {
        const sets = parseFloat(document.getElementById('sets').value) || 0;
        const reps = parseFloat(document.getElementById('reps').value) || 0;
        const weight = parseFloat(document.getElementById('weight').value) || 0;
        
        if (sets > 0 && reps > 0 && weight > 0) {
            const volume = sets * reps * weight;
            const calculator = document.getElementById('smart-calculator');
            const result = document.getElementById('volume-result');
            
            calculator.style.display = 'flex';
            result.textContent = `${volume.toLocaleString()} kg`;
            
            // Add animation
            calculator.style.animation = 'fadeInUp 0.3s ease';
        } else {
            const calculator = document.getElementById('smart-calculator');
            calculator.style.display = 'none';
        }
    }
    
    // Enhanced Quick Fill with validation
    function quickFill(type) {
        const fields = {
            strength: { sets: 3, reps: 10, duration_minutes: 45, calories_burned: 250 },
            cardio: { duration_minutes: 30, distance: 5, calories_burned: 300 },
            hiit: { duration_minutes: 20, calories_burned: 400 }
        };
        
        const data = fields[type];
        if (!data) return;
        
        // Fill fields with animation
        Object.entries(data).forEach(([fieldId, value], index) => {
            setTimeout(() => {
                const field = document.getElementById(fieldId);
                if (field) {
                    field.value = value;
                    validateField(fieldId);
                    updateFormProgress();
                    updateVolumeCalculator();
                    
                    // Visual feedback
                    field.style.animation = 'pulse 0.5s ease';
                    setTimeout(() => {
                        field.style.animation = '';
                    }, 500);
                }
            }, index * 100);
        });
        
        // Show success message
        showNotification(`${type.charAt(0).toUpperCase() + type.slice(1)} template applied!`, 'success');
    }
    
    // Notification System
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fa-solid fa-${type === 'success' ? 'check-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        `;
        
        // Style the notification
        Object.assign(notification.style, {
            position: 'fixed',
            top: '20px',
            right: '20px',
            background: type === 'success' ? 'linear-gradient(135deg, rgba(40, 167, 69, 0.9) 0%, rgba(32, 201, 151, 0.9) 100%)' : 'linear-gradient(135deg, rgba(255, 102, 0, 0.9) 0%, rgba(255, 140, 0, 0.9) 100%)',
            color: 'white',
            padding: '1rem 1.5rem',
            borderRadius: '0.7rem',
            boxShadow: '0 4px 20px rgba(0, 0, 0, 0.3)',
            zIndex: '9999',
            display: 'flex',
            alignItems: 'center',
            gap: '0.75rem',
            animation: 'slideInRight 0.3s ease',
            maxWidth: '300px'
        });
        
        document.body.appendChild(notification);
        
        // Auto remove
        setTimeout(() => {
            notification.style.animation = 'slideOutRight 0.3s ease';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
    
    // Form Submission with Loading State
    function handleFormSubmit(e) {
        const submitBtn = e.target.querySelector('button[type="submit"]');
        
        // Validate required fields
        const workDate = document.getElementById('workout_date').value;
        if (!workDate) {
            e.preventDefault();
            validateField('workout_date');
            showNotification('Please select a workout date', 'info');
            document.getElementById('workout_date').focus();
            return;
        }
        
        // Add loading state
        submitBtn.classList.add('loading');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Saving...';
        
        // Show notification
        showNotification('Saving your workout...', 'info');
    }
    
    // Rating System (Enhanced)
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    const ratingText = document.getElementById('rating-text');
    
    ratingStars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;
            updateStars(rating);
            updateFormProgress();
            showNotification(`Rating: ${rating} stars`, 'success');
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
        
        if (rating > 0) {
            ratingText.classList.add('active');
        } else {
            ratingText.classList.remove('active');
        }
    }
    
    // Initialize stars based on old value
    updateStars(<?php echo e((int)old('rating', 0)); ?>);
    
    // Alternative Difficulty Selector
    const difficultySlider = document.getElementById('difficulty-slider');
    const difficultyValue = document.getElementById('difficulty-value');
    const difficultyProgressBar = document.getElementById('difficulty-progress-bar');
    const difficultyLevels = document.querySelectorAll('.difficulty-level');
    
    // Initialize alternative difficulty selector
    if (difficultySlider) {
        // Set initial state
        const initialValue = difficultySlider.value;
        updateAlternativeDifficulty(initialValue);
        
        // Slider change handler
        difficultySlider.addEventListener('input', function() {
            updateAlternativeDifficulty(this.value);
        });
        
        // Click handlers for difficulty cards
        difficultyLevels.forEach(level => {
            level.addEventListener('click', function() {
                const levelName = this.dataset.level;
                const sliderValue = levelName === 'easy' ? '1' : levelName === 'medium' ? '2' : '3';
                difficultySlider.value = sliderValue;
                updateAlternativeDifficulty(sliderValue);
            });
        });
    }
    
    function updateAlternativeDifficulty(value) {
        const levelNames = { '1': 'easy', '2': 'medium', '3': 'hard' };
        const displayNames = { '1': 'Easy', '2': 'Medium', '3': 'Hard', '0': 'Not Selected' };
        const level = levelNames[value] || 'easy';
        
        // Update hidden radio button
        const radioButton = document.querySelector(`input[name="difficulty"][value="${level}"]`);
        if (radioButton) {
            radioButton.checked = true;
        }
        
        // Update display
        if (difficultyValue) {
            difficultyValue.textContent = displayNames[value] || 'Not Selected';
        }
        
        // Update progress bar
        if (difficultyProgressBar) {
            difficultyProgressBar.className = `difficulty-progress-bar ${level}`;
        }
        
        // Update active states
        difficultyLevels.forEach(levelEl => {
            levelEl.classList.remove('active');
            if (levelEl.dataset.level === level) {
                levelEl.classList.add('active');
            }
        });
        
        // Update form progress
        updateFormProgress();
        
        // Show notification
        if (value !== '0') {
            showNotification(`Difficulty: ${displayNames[value]}`, 'success');
        }
    }
    
    // Sync hidden radio buttons with alternative selector
    document.querySelectorAll('#difficulty-easy, #difficulty-medium, #difficulty-hard').forEach(radio => {
        radio.addEventListener('change', function() {
            const levelName = this.value;
            const sliderValue = levelName === 'easy' ? '1' : levelName === 'medium' ? '2' : '3';
            if (difficultySlider) {
                difficultySlider.value = sliderValue;
                updateAlternativeDifficulty(sliderValue);
            }
        });
    });
    
    // Add event listeners for real-time validation
    document.addEventListener('DOMContentLoaded', function() {
        // Add validation to all form inputs
        const inputs = document.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                validateField(this.id);
                updateFormProgress();
                updateVolumeCalculator();
            });
            
            input.addEventListener('blur', function() {
                validateField(this.id);
            });
        });
        
        // Form submission handler
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', handleFormSubmit);
        }
        
        // Initialize progress
        updateFormProgress();
        updateVolumeCalculator();
        
        // Add keyboard navigation
        document.addEventListener('keydown', function(e) {
            // Ctrl/Cmd + Enter to submit
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                const form = document.querySelector('form');
                if (form) form.requestSubmit();
            }
            
            // Escape to cancel
            if (e.key === 'Escape') {
                const cancelBtn = document.querySelector('.btn-outline');
                if (cancelBtn && confirm('Are you sure you want to cancel?')) {
                    window.location.href = cancelBtn.href;
                }
            }
        });
        
        // Auto-save draft (optional enhancement)
        let autoSaveTimer;
        inputs.forEach(input => {
            input.addEventListener('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(() => {
                    saveDraft();
                }, 2000);
            });
        });
    });
    
    // Auto-save draft functionality
    function saveDraft() {
        const formData = new FormData(document.querySelector('form'));
        const draft = {};
        
        for (let [key, value] of formData.entries()) {
            if (value) draft[key] = value;
        }
        
        localStorage.setItem('workoutDraft', JSON.stringify(draft));
        console.log('Draft saved automatically');
    }
    
    // Load draft on page load
    function loadDraft() {
        const draft = localStorage.getItem('workoutDraft');
        if (!draft) return;
        
        try {
            const data = JSON.parse(draft);
            Object.entries(data).forEach(([key, value]) => {
                const field = document.getElementById(key);
                if (field && !field.value) {
                    field.value = value;
                    validateField(key);
                }
            });
            
            updateFormProgress();
            updateVolumeCalculator();
            showNotification('Draft restored from previous session', 'info');
        } catch (e) {
            console.error('Error loading draft:', e);
        }
    }
    
    // Load draft on page load
    loadDraft();
    
    // Clear draft on successful submission
    window.addEventListener('beforeunload', function(e) {
        const form = document.querySelector('form');
        if (form && form.querySelector('.btn.loading')) {
            // Form is being submitted, don't show warning
            return;
        }
        
        const draft = localStorage.getItem('workoutDraft');
        if (draft) {
            e.preventDefault();
            e.returnValue = 'You have unsaved changes. Are you sure you want to leave?';
        }
    });
    
    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }
        .notification { font-weight: 500; }
    `;
    document.head.appendChild(style);
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/workout-logs/create.blade.php ENDPATH**/ ?>