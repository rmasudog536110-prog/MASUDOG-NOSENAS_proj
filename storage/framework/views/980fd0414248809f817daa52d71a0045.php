<?php $__env->startSection('title', 'Workout Logs - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(Auth::user() && Auth::user()->hasAdminAccess()): ?>
<?php echo $__env->make('admin.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<section class="content-section">
    <div class="container">
        <!-- Flash Messages -->
        <?php if(session('success')): ?>
        <div class="flash-message success">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <!-- Header -->
        <div class="workout-logs-header">
            <div>
                <h1>Workout Logs</h1>
                <p>Track your fitness journey</p>
            </div>
            <a href="<?php echo e(route('workout-logs.create')); ?>" class="btn btn-primary btn-large">
                <i class="fa-solid fa-plus"></i> Log New Workout
            </a>
        </div>

        <!-- Stats Overview -->
        <div class="workout-stats-grid">
            <div class="workout-stat-card">
                <div class="workout-stat-icon">
                    <i class="fa-solid fa-fire"></i>
                </div>
                <span class="workout-stat-value"><?php echo e($stats['total_workouts']); ?></span>
                <span class="workout-stat-label">Total Workouts</span>
            </div>
            <div class="workout-stat-card">
                <div class="workout-stat-icon">
                    <i class="fa-solid fa-calendar-week"></i>
                </div>
                <span class="workout-stat-value"><?php echo e($stats['this_week']); ?></span>
                <span class="workout-stat-label">This Week</span>
            </div>
            <div class="workout-stat-card">
                <div class="workout-stat-icon">
                    <i class="fa-solid fa-calendar-days"></i>
                </div>
                <span class="workout-stat-value"><?php echo e($stats['this_month']); ?></span>
                <span class="workout-stat-label">This Month</span>
            </div>
            <div class="workout-stat-card">
                <div class="workout-stat-icon">
                    <i class="fa-solid fa-burn"></i>
                </div>
                <span class="workout-stat-value"><?php echo e(number_format($stats['total_calories'])); ?></span>
                <span class="workout-stat-label">Calories Burned</span>
            </div>
        </div>

        <!-- Filters -->
        <div class="workout-filters">
            <button class="filter-btn active" onclick="filterWorkouts('all')">All</button>
            <button class="filter-btn" onclick="filterWorkouts('week')">This Week</button>
            <button class="filter-btn" onclick="filterWorkouts('month')">This Month</button>
        </div>

        <!-- Workout List -->
        <?php if($workouts->count() > 0): ?>
        <div class="workout-list">
            <?php $__currentLoopData = $workouts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workout): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="workout-item">
                <div class="workout-header">
                    <div>
                        <h3 class="workout-title">
                            <?php if($workout->exercise): ?>
                            <?php echo e($workout->exercise->name); ?>

                            <?php elseif($workout->trainingProgram): ?>
                            <?php echo e($workout->trainingProgram->title); ?>

                            <?php else: ?>
                            Workout Session
                            <?php endif; ?>
                        </h3>
                        <p class="workout-date">
                            <i class="fa-solid fa-calendar"></i>
                            <?php echo e($workout->workout_date->format('F j, Y')); ?>

                            (<?php echo e($workout->workout_date->diffForHumans()); ?>)
                        </p>
                    </div>
                    <div class="workout-actions">
                        <a href="<?php echo e(route('workout-logs.show', $workout)); ?>"
                            class="btn btn-outline btn-icon"
                            title="View Details">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                        <a href="<?php echo e(route('workout-logs.edit', $workout)); ?>"
                            class="btn btn-outline btn-icon"
                            title="Edit">
                            <i class="fa-solid fa-edit"></i>
                        </a>
                        <form action="<?php echo e(route('workout-logs.destroy', $workout)); ?>"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Are you sure you want to delete this workout log?')">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                class="btn btn-outline btn-icon"
                                title="Delete"
                                style="color: #dc3545; border-color: #dc3545;">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <div class="workout-details">
                    <?php if($workout->sets && $workout->reps): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Sets × Reps</span>
                        <span class="workout-detail-value"><?php echo e($workout->sets); ?> × <?php echo e($workout->reps); ?></span>
                    </div>
                    <?php endif; ?>

                    <?php if($workout->weight): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Weight</span>
                        <span class="workout-detail-value"><?php echo e($workout->weight); ?> kg</span>
                    </div>
                    <?php endif; ?>

                    <?php if($workout->duration_minutes): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Duration</span>
                        <span class="workout-detail-value"><?php echo e($workout->duration_minutes); ?> min</span>
                    </div>
                    <?php endif; ?>

                    <?php if($workout->distance): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Distance</span>
                        <span class="workout-detail-value"><?php echo e($workout->distance); ?> km</span>
                    </div>
                    <?php endif; ?>

                    <?php if($workout->calories_burned): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Calories</span>
                        <span class="workout-detail-value"><?php echo e($workout->calories_burned); ?> kcal</span>
                    </div>
                    <?php endif; ?>

                    <?php if($workout->difficulty): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Difficulty</span>
                        <span class="difficulty-badge difficulty-<?php echo e($workout->difficulty); ?>">
                            <?php echo e(ucfirst($workout->difficulty)); ?>

                        </span>
                    </div>
                    <?php endif; ?>

                    <?php if($workout->rating): ?>
                    <div class="workout-detail">
                        <span class="workout-detail-label">Rating</span>
                        <span class="rating-stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <?php if($i <=$workout->rating): ?>
                                <i class="fa-solid fa-star"></i>
                                <?php else: ?>
                                <i class="fa-regular fa-star"></i>
                                <?php endif; ?>
                                <?php endfor; ?>
                        </span>
                    </div>
                    <?php endif; ?>
                </div>

                <?php if($workout->notes): ?>
                <div class="workout-notes">
                    <i class="fa-solid fa-note-sticky"></i> <?php echo e($workout->notes); ?>

                </div>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 2rem;">
            <?php echo e($workouts->links()); ?>

        </div>
        <?php else: ?>
        <div class="empty-state">
            <div class="empty-state-icon">
                <i class="fa-solid fa-dumbbell"></i>
            </div>
            <h2>No Workouts Logged Yet</h2>
            <p>Start tracking your fitness journey by logging your first workout!</p>
            <div class="empty-state-actions">
                <a href="<?php echo e(route('workout-logs.create')); ?>" class="btn btn-primary btn-large">
                    <i class="fa-solid fa-plus"></i> Log Your First Workout
                </a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function filterWorkouts(period) {
        // Remove active class from all buttons
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        // Add active class to clicked button
        event.target.classList.add('active');

        // In a real implementation, you would filter the workouts
        // For now, we'll just reload with a query parameter
        const url = new URL(window.location.href);
        url.searchParams.set('filter', period);
        window.location.href = url.toString();
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\workout-logs\index.blade.php ENDPATH**/ ?>