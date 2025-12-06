<?php $__env->startSection('title', 'Edit Exercise - Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/exercises.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php if(Auth::user() && Auth::user()->hasAdminAccess()): ?>
<?php echo $__env->make('admin.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

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
                        <form action="<?php echo e(route('admin.exercises.update', $exercise)); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PUT'); ?>

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
                                       class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('name', $exercise->name)); ?>"
                                       required>
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Description *</label>
                                <textarea name="description" 
                                          class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          rows="3"
                                          required><?php echo e(old('description', $exercise->description)); ?></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Category & Difficulty -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Category *</label>
                                    <select name="category" class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select Category</option>
                                        <option value="warmup" <?php echo e(old('category', $exercise->category) == 'warmup' ? 'selected' : ''); ?>>Warmup</option>
                                        <option value="strength" <?php echo e(old('category', $exercise->category) == 'strength' ? 'selected' : ''); ?>>Strength</option>
                                        <option value="cardio" <?php echo e(old('category', $exercise->category) == 'cardio' ? 'selected' : ''); ?>>Cardio</option>
                                        <option value="flexibility" <?php echo e(old('category', $exercise->category) == 'flexibility' ? 'selected' : ''); ?>>Flexibility</option>
                                        <option value="plyometrics" <?php echo e(old('category', $exercise->category) == 'plyometrics' ? 'selected' : ''); ?>>Plyometrics</option>
                                        <option value="functional" <?php echo e(old('category', $exercise->category) == 'functional' ? 'selected' : ''); ?>>Functional</option>
                                        <option value="core" <?php echo e(old('category', $exercise->category) == 'core' ? 'selected' : ''); ?>>Core</option>
                                    </select>
                                    <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Difficulty *</label>
                                    <select name="difficulty" class="form-select <?php $__errorArgs = ['difficulty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value="">Select Difficulty</option>
                                        <option value="beginner" <?php echo e(old('difficulty', $exercise->difficulty) == 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                                        <option value="intermediate" <?php echo e(old('difficulty', $exercise->difficulty) == 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                                        <option value="expert" <?php echo e(old('difficulty', $exercise->difficulty) == 'expert' ? 'selected' : ''); ?>>Expert</option>
                                    </select>
                                    <?php $__errorArgs = ['difficulty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <!-- Equipment -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Equipment *</label>
                                <input type="text" 
                                       name="equipment" 
                                       class="form-control <?php $__errorArgs = ['equipment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('equipment', $exercise->equipment)); ?>"
                                       placeholder="e.g., Dumbbells, Barbell, Bodyweight"
                                       required>
                                <?php $__errorArgs = ['equipment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Muscle Group -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Muscle Group</label>
                                <input type="text" 
                                       name="muscle_group" 
                                       class="form-control <?php $__errorArgs = ['muscle_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('muscle_group', $exercise->muscle_group)); ?>"
                                       placeholder="e.g., Chest, Triceps, Shoulders (comma-separated)">
                                <small class="text-muted">Separate multiple muscle groups with commas</small>
                                <?php $__errorArgs = ['muscle_group'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Instructions -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">Instructions</label>
                                <textarea name="instructions" 
                                          class="form-control <?php $__errorArgs = ['instructions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          rows="5"
                                          placeholder="Enter each step on a new line"><?php echo e(old('instructions', $exercise->instructions)); ?></textarea>
                                <small class="text-muted">Enter each instruction step on a new line</small>
                                <?php $__errorArgs = ['instructions'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Video URL -->
                            <div class="mb-3">
                                <label class="form-label fw-bold">YouTube Video URL</label>
                                <input type="url" 
                                       name="video_url" 
                                       class="form-control <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('video_url', $exercise->video_url)); ?>"
                                       placeholder="https://www.youtube.com/watch?v=...">
                                <small class="text-muted">Paste the full YouTube video URL</small>
                                <?php $__errorArgs = ['video_url'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Icon -->
                            <div class="mb-4">
                                <label class="form-label fw-bold">Icon (Emoji)</label>
                                <input type="text" 
                                       name="icon" 
                                       class="form-control <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       value="<?php echo e(old('icon', $exercise->icon)); ?>"
                                       maxlength="10"
                                       placeholder="💪">
                                <small class="text-muted">Enter an emoji to represent this exercise</small>
                                <?php $__errorArgs = ['icon'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            </div>

                            <!-- Form Actions -->
                            <div class="form-actions">
                                <button type="submit" class="btn-save">
                                    <i class="fas fa-save me-2"></i> Update Exercise
                                </button>
                                <a href="<?php echo e(route('admin.exercises.index')); ?>" class="btn-cancel">
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

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/admin/exercises/edit.blade.php ENDPATH**/ ?>