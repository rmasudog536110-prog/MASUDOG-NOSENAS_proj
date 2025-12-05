<?php $__env->startSection('title', 'My Training Plan - ' . ($program['title'] ?? 'Program')); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="css/programs.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<?php if(session('info')): ?>
    <div class="alert alert-info alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-info-circle me-2"></i>
            <?php echo e(session('info')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<div class="container-fluid px-0">
    <!-- Plan Header -->
    <div class="plan-header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-2">
                            <li class="breadcrumb-item"><a href="<?php echo e(route('programs.index')); ?>" class="text-primary-50">All Programs</a></li>
                            <li class="breadcrumb-item active text-white" aria-current="page">My Training Plan</li>
                        </ol>
                    </nav>
                    <div class="d-flex align-items-center mb-3">
                        <div class="display-4 me-3"><?php echo e($program['icon'] ?? '🏋️'); ?></div>
                        <div>
                            <h1 class="display-6 fw-bold mb-1"><?php echo e($program['title'] ?? 'My Training Plan'); ?></h1>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-dark text-light"><?php echo e($program['level']); ?> Level</span>
                                <span class="badge bg-dark text-light"><?php echo e($program['focus_area']); ?></span>
                                <span class="badge bg-dark text-light"><?php echo e($program['duration_weeks']); ?> Weeks</span>
                            </div>
                        </div>
                    </div>
                    <p class="lead mb-0"><?php echo e($program['overview']); ?></p>
                </div>
                <div class="col-md-4 text-md-end mt-3 mt-md-0">
                    <div class="btn-group">
                        <a href="<?php echo e(route('programs.show', $program['id'])); ?>" class="btn btn-light">
                            <i class="fas fa-info-circle me-1"></i> Program Details
                        </a>
                        <form action="<?php echo e(route('my-plan.unenroll', $program['id'])); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to mark this program as completed?')">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-light ms-2">
                                <i class="fas fa-flag-checkered me-1"></i> Mark Complete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <!-- Progress Section -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4">
                        <h4 class="fw-bold mb-3">
                            <i class="fas fa-chart-line me-2 text-primary"></i> Your Progress
                        </h4>
                        <div class="progress-container">
                            <div class="progress-bar" style="width: <?php echo e($progressPercentage); ?>%">
                                <?php echo e(round($progressPercentage, 1)); ?>%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-muted small mb-3">
                            <span><?php echo e($completedCount); ?> of <?php echo e($totalDays); ?> days completed</span>
                            <span><?php echo e(round($progressPercentage, 1)); ?>% Complete</span>
                        </div>
                        <div class="row text-center">
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-white"><?php echo e($currentDay); ?></div>
                                    <div class="text-muted small">Current Day</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-white"><?php echo e($completedCount); ?></div>
                                    <div class="text-muted small">Completed</div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="border rounded p-2">
                                    <div class="fw-bold text-white"><?php echo e($totalDays - $completedCount); ?></div>
                                    <div class="text-muted small">Remaining</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Workout Schedule -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h4 class="fw-bold mb-0">
                                <i class="fas fa-calendar-alt me-2 text-primary"></i> Workout Schedule
                            </h4>
                            <div class="d-flex gap-2">
                                <span class="badge bg-primary">Current</span>
                                <span class="badge bg-success">Completed</span>
                                <span class="badge bg-secondary">Upcoming</span>
                            </div>
                        </div>
                        
                        <?php if(count($workoutSchedule) > 0): ?>
                            <?php $__currentLoopData = $workoutSchedule; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $day): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="day-card <?php echo e($day['completed'] ? 'completed' : ''); ?> <?php echo e($day['is_current'] ? 'current' : ''); ?>">
                                    <div class="day-header">
                                        <div>
                                            <h5 class="fw-bold mb-1">
                                                Day <?php echo e($day['day_number']); ?>: <?php echo e($day['day_name']); ?>

                                                <?php if($day['is_current']): ?>
                                                    <span class="badge bg-primary day-badge ms-2">Today</span>
                                                <?php endif; ?>
                                            </h5>
                                            <p class="text-muted mb-0 small">
                                                <?php echo e(count($day['exercises'])); ?> exercises • 
                                                <?php if($day['completed']): ?>
                                                    <span class="text-success">Completed</span>
                                                <?php elseif($day['is_current']): ?>
                                                    <span class="text-primary">In Progress</span>
                                                <?php else: ?>
                                                    <span class="text-muted">Upcoming</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div>
                                            <?php if($day['completed']): ?>
                                                <span class="badge bg-success day-badge">
                                                    <i class="fas fa-check me-1"></i> Done
                                                </span>
                                            <?php elseif($day['is_current']): ?>
                                                <form action="<?php echo e(route('my-plan.complete-day')); ?>" method="POST" class="d-inline">
                                                    <?php echo csrf_field(); ?>
                                                    <input type="hidden" name="program_id" value="<?php echo e($program['id']); ?>">
                                                    <input type="hidden" name="day_name" value="<?php echo e(strtolower($day['day_name'])); ?>">
                                                    <button type="submit" class="btn btn-success btn-sm">
                                                        <i class="fas fa-check me-1"></i> Mark Complete
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    
                                    <div class="day-body">
                                        <?php $__currentLoopData = $day['exercises']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="exercise-item">
                                                <div class="exercise-number"><?php echo e($index + 1); ?></div>
                                                <div class="flex-grow-1"><?php echo e($exercise); ?></div>
                                                <?php if($day['is_current'] && !$day['completed']): ?>
                                                    <button class="btn btn-outline-primary btn-sm" onclick="markExerciseComplete(this)">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                No workout schedule available for this program.
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4 mt-4 mt-lg-0">
                <div class="plan-actions">
                    <!-- Stats Cards -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-white">
                                <i class="fas fa-chart-bar me-2 text-primary"></i> Program Stats
                            </h5>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-primary bg-opacity-10 text-primary mx-auto">
                                            <i class="fas fa-calendar-day"></i>
                                        </div>
                                        <h4 class="fw-bold"><?php echo e($totalDays); ?></h4>
                                        <p class="text-muted small mb-0">Total Days</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-success bg-opacity-10 text-success mx-auto">
                                            <i class="fas fa-check-circle"></i>
                                        </div>
                                        <h4 class="fw-bold"><?php echo e($completedCount); ?></h4>
                                        <p class="text-muted small mb-0">Completed</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-info bg-opacity-10 text-info mx-auto">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <h4 class="fw-bold"><?php echo e($totalDays - $completedCount); ?></h4>
                                        <p class="text-muted small mb-0">Remaining</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="stats-card text-center">
                                        <div class="stats-icon bg-warning bg-opacity-10 text-warning mx-auto">
                                            <i class="fas fa-fire"></i>
                                        </div>
                                        <h4 class="fw-bold"><?php echo e($currentDay); ?></h4>
                                        <p class="text-muted small mb-0">Current Day</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Program Info -->
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-white">
                                <i class="fas fa-info-circle me-2 text-primary"></i> Program Details
                            </h5>
                            <ul">
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Level</span>
                                    <span class="fw-bold text-white"><?php echo e($program['level']); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Duration</span>
                                    <span class="fw-bold text-white"><?php echo e($program['duration_weeks']); ?> weeks</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Workouts</span>
                                    <span class="fw-bold text-white"><?php echo e($totalDays); ?> days</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Equipment</span>
                                    <span class="fw-bold text-white"><?php echo e($program['equipment']); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Enrolled</span>
                                    <span class="fw-bold text-white"><?php echo e($enrolledDate); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 py-2">
                                    <span class="text-muted">Last Activity</span>
                                    <span class="fw-bold text-white"><?php echo e($enrollment->last_activity ? $enrollment->last_activity->diffForHumans() : 'Never'); ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow-sm border-0">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-3 text-white">
                                <i class="fas fa-bolt me-2 text-warning"></i> Quick Actions
                            </h5>
                            <div class="d-grid gap-2">
                                <a href="<?php echo e(route('programs.show', $program['id'])); ?>" class="btn btn-outline-primary">
                                    <i class="fas fa-redo me-1"></i> View Program Details
                                </a>
                                <button class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#updateProgressModal">
                                    <i class="fas fa-percentage me-1"></i> Update Progress
                                </button>
                                <form action="<?php echo e(route('my-plan.unenroll', $program['id'])); ?>" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to mark this program as completed?')">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-flag-checkered me-1"></i> Mark as Complete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Progress Modal -->
<div class="modal fade" id="updateProgressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Your current progress is <strong><?php echo e(round($progressPercentage, 1)); ?>%</strong>.</p>
                <form action="<?php echo e(route('my-plan.complete-day')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="program_id" value="<?php echo e($program['id']); ?>">
                    <div class="mb-3">
                        <label for="progressInput" class="form-label">Or manually set progress percentage:</label>
                        <div class="input-group">
                            <input type="number" name="progress" class="form-control" 
                                   id="progressInput" min="0" max="100" 
                                   value="<?php echo e(round($progressPercentage, 0)); ?>">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Progress</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function markExerciseComplete(button) {
        const exerciseItem = button.closest('.exercise-item');
        const checkIcon = button.querySelector('i');
        
        // Toggle state
        if (checkIcon.classList.contains('fa-check')) {
            checkIcon.classList.remove('fa-check');
            checkIcon.classList.add('fa-times');
            button.classList.remove('btn-outline-primary');
            button.classList.add('btn-outline-success');
            exerciseItem.style.textDecoration = 'line-through';
            exerciseItem.style.opacity = '0.7';
        } else {
            checkIcon.classList.remove('fa-times');
            checkIcon.classList.add('fa-check');
            button.classList.remove('btn-outline-success');
            button.classList.add('btn-outline-primary');
            exerciseItem.style.textDecoration = 'none';
            exerciseItem.style.opacity = '1';
        }
    }
    
    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            if (alert.classList.contains('show')) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        });
    }, 5000);
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/my-plan/show.blade.php ENDPATH**/ ?>