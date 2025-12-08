<?php $__env->startSection('title', 'Create Program - Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/exercises.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>



    <div style="margin-bottom: 2rem;">
        <a href="<?php echo e(route('admin.programs.index')); ?>" class="btn btn-outline" style="border-color: #fff; color: #fff; margin-top: 10px;">
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

    <div class="form-card">
        <h1 style="text-align: center;"><i class="fa-solid fa-plus-circle"></i> Create New Program</h1>
        <p style="color: #fff; margin-bottom: 2rem; text-align: center">
            Add a new training program to your gym
        </p>

        <form action="<?php echo e(route('admin.programs.store')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <div class="mb-3">
                <label for="title" class="form-label">Program Title </label>
                <input type="text" 
                       class="form-control" 
                       id="title" 
                       name="title" 
                       value="<?php echo e(old('title')); ?>" 
                       placeholder="e.g., Full Body Strength Training"
                       required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" 
                          id="description" 
                          name="description" 
                          rows="5" 
                          placeholder="Describe the program, its benefits, and what participants can expect..."
                          required><?php echo e(old('description')); ?></textarea>
            </div>

            <div class="form-row">
                <div class="mb-3">
                    <label for="level" class="form-label">Difficulty Level </label>
                    <select class="form-control" id="level" name="level" required>
                        <option value="">Select Level</option>
                        <option value="beginner" <?php echo e(old('level') == 'beginner' ? 'selected' : ''); ?>>Beginner</option>
                        <option value="intermediate" <?php echo e(old('level') == 'intermediate' ? 'selected' : ''); ?>>Intermediate</option>
                        <option value="advanced" <?php echo e(old('level') == 'advanced' ? 'selected' : ''); ?>>Advanced</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="duration_weeks" class="form-label">Duration (Weeks) </label>
                    <input type="number" 
                           class="form-control" 
                           id="duration_weeks" 
                           name="duration_weeks" 
                           value="<?php echo e(old('duration_weeks', 8)); ?>" 
                           min="1"
                           required>
                </div>
            </div>

            <div class="form-row">
                <div class="mb-3">
                    <label for="workout_counts" class="form-label">Workouts Per Week </label>
                    <input type="number" 
                           class="form-control" 
                           id="workout_counts" 
                           name="workout_counts" 
                           value="<?php echo e(old('workout_counts', 3)); ?>" 
                           min="1"
                           required>
                </div>

                <div class="mb-3">
                    <label for="equipment_required" class="form-label">Equipment Required</label>
                    <input type="text" 
                           class="form-control" 
                           id="equipment_required" 
                           name="equipment_required" 
                           value="<?php echo e(old('equipment_required')); ?>" 
                           placeholder="e.g., Dumbbells, Barbell, Bench">
                </div>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Status </label>
                <select class="form-control" id="is_active" name="is_active" required>
                    <option value="1" <?php echo e(old('is_active', '1') == '1' ? 'selected' : ''); ?>>Active</option>
                    <option value="0" <?php echo e(old('is_active') == '0' ? 'selected' : ''); ?>>Inactive</option>
                </select>
                <small style="color: var(--muted-foreground);">
                    Only active programs will be visible to users
                </small>
            </div>

            <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Create Program
                </button>
                <a href="<?php echo e(route('admin.programs.index')); ?>" class="btn btn-outline" style="border-color: #fff; color: #fff">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>


<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/admin/programs/create.blade.php ENDPATH**/ ?>