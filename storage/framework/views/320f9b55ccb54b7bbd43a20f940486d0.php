<?php $__env->startSection('title', 'Create Program - Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-program-form.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="admin-program-container">
    <div class="form-card">

        <div class="back-to-programs">
            <a href="<?php echo e(route('admin.programs.index')); ?>" class="btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Programs
            </a>
        </div>

        <?php if($errors->any()): ?>
            <div class="flash-message error">
                <ul style="margin: 0; padding-left: 1.5rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <h1><i class="fa-solid fa-plus-circle"></i> Create New Program</h1>
        <p>Add a new training program to your gym</p>

        <form action="<?php echo e(route('admin.programs.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

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
                               value="<?php echo e(old('title')); ?>" 
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
                                  required><?php echo e(old('description')); ?></textarea>
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
                                <option value="beginner" <?php echo e(old('level') == 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                                <option value="intermediate" <?php echo e(old('level') == 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                                <option value="advanced" <?php echo e(old('level') == 'advanced' ? 'selected' : ''); ?>>Advanced</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="duration_weeks" class="form-label">Duration (Weeks)<span class="required">*</span></label>
                            <input type="number" 
                                   class="form-control" 
                                   id="duration_weeks" 
                                   name="duration_weeks" 
                                   value="<?php echo e(old('duration_weeks', 8)); ?>" 
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
                                   value="<?php echo e(old('workout_counts', 3)); ?>" 
                                   min="1"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="equipment_required" class="form-label">Equipment Required</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="equipment_required" 
                                   name="equipment_required" 
                                   value="<?php echo e(old('equipment_required')); ?>" 
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
                            <option value="1" <?php echo e(old('is_active', '1') == '1' ? 'selected' : ''); ?>>Active</option>
                            <option value="0" <?php echo e(old('is_active') == '0' ? 'selected' : ''); ?>>Inactive</option>
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
                <a href="<?php echo e(route('admin.programs.index')); ?>" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\programs\create.blade.php ENDPATH**/ ?>