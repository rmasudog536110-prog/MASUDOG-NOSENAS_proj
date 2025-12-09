<?php $__env->startSection('title', 'Manage Exercises - Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/exercises.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin-exercise-form.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<?php echo $__env->make('admin.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="admin-exercises-page">
    <div class="container">
        <!-- Header -->
        <div class="page-header">
            <h1>
                <i class="fas fa-dumbbell me-2"></i> Manage Exercises
            </h1>
            <p>Create, edit, and manage your exercise library</p>
            <div class="header-actions">
                <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn-back">
                    <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                </a>
                <a href="<?php echo e(route('admin.exercises.create')); ?>" class="btn-add-new">
                    <i class="fas fa-plus me-2"></i> Add New Exercise
                </a>
            </div>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Exercises Table -->
        <div class="exercises-card">
            <!-- Search Bar inside table card -->
            <div class="table-search-bar">
                <form method="GET" action="<?php echo e(route('admin.exercises.index')); ?>" class="search-form-inline">
                    <div class="search-controls">
                        <!-- Search Input -->
                        <div class="search-input-wrapper">
                            <input type="text" 
                                   name="search" 
                                   id="search"
                                   class="search-input-inline" 
                                   value="<?php echo e(old('search', $search)); ?>"
                                   placeholder="Search exercises...">
                        </div>

                        <!-- Action Buttons -->
                        <div class="search-actions-inline">
                            <button type="submit" class="btn-search-inline">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="<?php echo e(route('admin.exercises.index')); ?>" class="btn-clear-inline">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="table-container">
            <div class="table-container">
                <table class="exercises-table">
                    <thead>
                        <tr>
                            <th>Icon</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Difficulty</th>
                            <th>Equipment</th>
                            <th>Video</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $exercises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td>
                                    <span class="exercise-icon"><?php echo e($exercise->icon ?? '💪'); ?></span>
                                </td>
                                <td>
                                    <div class="exercise-name"><?php echo e($exercise->name); ?></div>
                                </td>
                                <td>
                                    <span class="category-badge 
                                        <?php switch($exercise->category):
                                            case ('strength'): ?> <?php break; ?>
                                            <?php case ('cardio'): ?> <?php break; ?>
                                            <?php case ('core'): ?>  <?php break; ?>
                                            <?php case ('plyometrics'): ?> <?php break; ?>
                                            <?php case ('functional'): ?>  <?php break; ?>
                                            <?php default: ?>
                                        <?php endswitch; ?>">
                                        <?php echo e(ucfirst($exercise->category)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="difficulty-badge 
                                        <?php switch($exercise->difficulty):
                                            case ('beginner'): ?>  <?php break; ?>
                                            <?php case ('intermediate'): ?> <?php break; ?>
                                            <?php case ('expert'): ?> <?php break; ?>
                                        <?php endswitch; ?>">
                                        <?php echo e(ucfirst($exercise->difficulty)); ?>

                                    </span>
                                </td>
                                <td><?php echo e($exercise->equipment); ?></td>
                                <td>
                                    <?php if($exercise->video_url): ?>
                                        <a href="<?php echo e($exercise->video_url); ?>" target="_blank" class="video-link">
                                            <i class="fab fa-youtube me-1" style="padding: 10px"></i>
                                        </a>
                                    <?php else: ?>
                                        <span style="color: var(--muted-foreground);">No video</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($exercise->is_active): ?>
                                        <span class="status-badge" style="color: #00FF00;">Active</span>
                                    <?php else: ?>
                                        <span class="status-badge" style="color: #FF0000">Inactive</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="<?php echo e(route('admin.exercises.edit', $exercise)); ?>" 
                                           class="btn-action btn-edit"
                                           title="Edit Exercise">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?php echo e(route('admin.exercises.destroy', $exercise)); ?>" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this exercise?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn-action btn-delete" title="Delete Exercise">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8">
                                    <div class="empty-state">
                                        <div class="empty-state-icon">
                                            <i class="fas fa-inbox"></i>
                                        </div>
                                        <div class="empty-state-text">No exercises found</div>
                                        <a href="<?php echo e(route('admin.exercises.create')); ?>" class="btn-add-new">
                                            <i class="fas fa-plus me-2"></i> Add First Exercise
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
                        <?php if($exercises->total() > $exercises->perPage()): ?>
            <div class="d-flex justify-content-between align-items-center p-3" style="border-top: 1px solid var(--table-border);">
                <div class="pagination">
                    Showing <strong><?php echo e($exercises->firstItem()); ?></strong> to <strong><?php echo e($exercises->lastItem()); ?></strong> of <strong><?php echo e($exercises->total()); ?></strong> results
                </div>
                <div class="pagination">
                    <?php echo e($exercises->links('pagination::bootstrap-4')); ?>

                </div>
            </div>
            <?php endif; ?>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/admin/exercises/index.blade.php ENDPATH**/ ?>