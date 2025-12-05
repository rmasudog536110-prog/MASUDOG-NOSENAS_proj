<?php $__env->startSection('title', 'Training Programs - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="css/programs.css">
    <link rel="stylesheet" href="css/exercises.csse">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Flash Messages -->
<?php if($successMessage ?? false): ?>
    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e($successMessage); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<?php if($errorMessage ?? false): ?>
    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo e($errorMessage); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Programs Section -->
<section class="py-5 bg-light">
    <div class="container">

        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary);">
                <i class="fas fa-dumbbell me-3"></i>
                Training Programs
            </h1>
            <p class="lead" style="color: var(--muted-foreground);">
                Professional programs designed for every fitness level
            </p>
        </div>

        <!-- Filter Buttons -->
        <div class="d-flex justify-content-center mb-5 flex-wrap gap-2">

            <a href="<?php echo e(route('programs.index', ['level' => 'all'])); ?>"
            class="btn <?php echo e(($level === 'all') ? 'btn-primary' : 'btn-outline-primary'); ?>">
                <i class="fas fa-bullseye me-1"></i> All Levels
            </a>

            <a href="<?php echo e(route('programs.index' , ['level' => 'beginner'])); ?>"
            class="btn <?php echo e(($level === 'beginner') ? 'btn-success' : 'btn-outline-success'); ?>">
                <i class="fas fa-seedling me-1"></i> Beginner
            </a>

            <a href="<?php echo e(route('programs.index', ['level' => 'intermediate'])); ?>"
            class="btn <?php echo e(($level === 'intermediate') ? 'btn-warning' : 'btn-outline-warning'); ?>">
                <i class="fas fa-chart-line me-1"></i> Intermediate
            </a>

            <a href="<?php echo e(route('programs.index', ['level' => 'expert'])); ?>"
            class="btn <?php echo e(($level === 'expert') ? 'btn-danger' : 'btn-outline-danger'); ?>">
                <i class="fas fa-star me-1"></i> Expert
            </a>


        </div>

        <!-- Programs Grid -->
        <div class="row g-4">
           <?php $__empty_1 = true; $__currentLoopData = $filteredPrograms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm program-card">

                            <div class="card-body">

                                <!-- Icon + Title -->
                                <div class="d-flex align-items-center mb-3">
                                    <span class="fs-2 me-3"><?php echo e($program['icon']); ?></span>
                                    <h5 class="fw-bold mb-0"><?php echo e($program['title']); ?></h5>
                                </div>

                                <!-- Description -->
                                <p class="text-muted mb-4">
                                    <?php echo e($program['description']); ?>

                                </p>

                                <!-- Program Details -->
                                <div class="mb-4">
                                    <div class="row g-2">
                                        <div class="col-12 mt-2">
                                            <small class="text-muted">Equipment:</small>
                                            <div class="fw-medium"><?php echo e($program['equipment']); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Difficulty Badge + View Button -->
                                <div class="d-flex justify-content-between align-items-center">

                                    <span class="badge 
                                        <?php switch($program['level']):
                                            case ('beginner'): ?> bg-success <?php break; ?>
                                            <?php case ('intermediate'): ?> bg-warning text-dark <?php break; ?>
                                            <?php case ('expert'): ?> bg-danger <?php break; ?>
                                            <?php default: ?> bg-primary
                                        <?php endswitch; ?>
                                        px-3 py-2">
                                        <?php echo e(ucfirst($program['level'])); ?>

                                    </span>

                                    <a href="<?php echo e(route('programs.show', $program['id'])); ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i> View Program
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-search fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No programs found</h4>
                        <p class="text-muted">Try selecting a different level filter.</p>
                    </div>
             <?php endif; ?>
        </div>

    </div>
</section>

<?php $__env->startPush('scripts'); ?>
<script>

    document.addEventListener('DOMContentLoaded', () => {
        const cards = document.querySelectorAll('.program-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
                card.style.transition = '0.3s ease';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'translateY(0)';
            });
        });
    });
</script>
<?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/index/programs.blade.php ENDPATH**/ ?>