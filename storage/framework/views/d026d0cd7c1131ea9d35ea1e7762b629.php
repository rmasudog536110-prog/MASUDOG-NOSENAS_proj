<?php $__env->startSection('title', 'Exercise Library - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="css/exercises.css">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(Auth::user() && Auth::user()->hasAdminAccess()): ?>
    <?php echo $__env->make('admin.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
    <?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<!-- Flash Messages -->
<?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
        <div class="container">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    </div>
<?php endif; ?>

<!-- Exercise Library Section -->
<section class="py-5 bg-light">
    <div class="container">
        <!-- Header -->
        <div class="text-center mb-5">
            <h1 class="display-4 fw-bold mb-3" style="color: var(--primary);">
                <i class="fas fa-book me-3"></i> Exercise Library
            </h1>
            <p class="lead" style="color: var(--muted-foreground);">
                Comprehensive collection of exercises for all fitness levels
            </p>
        </div>

        <!-- Search Bar -->
        <div class="row justify-content-center mb-4">
            <div class="col-lg-8 col-md-10">
                <form action="<?php echo e(route('exercises.index')); ?>" method="GET" class="d-flex gap-0">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               id="searchInput"
                               class="form-control" 
                               name="search"
                               placeholder="Search exercises..."
                               value="<?php echo e(request('search')); ?>">
                        <?php if(request('search')): ?>
                            <button class="btn btn-outline-secondary" type="button" id="clearSearchButton" title="Clear search">
                                <i class="fas fa-times"></i>
                            </button>
                        <?php endif; ?>
                        <button class="btn btn-primary" type="submit">Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Filter Buttons -->
        <?php
            $filter = request('category', 'all');
            $search = request('search');
            $difficulty = request('difficulty', 'all');
        ?>

        <div class="filter-section mb-4">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex flex-wrap gap-2 align-items-center">
                        <!-- Category Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="categoryDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-filter me-2"></i>
                                <?php if($filter === 'all'): ?>
                                    All Categories
                                <?php else: ?>
                                    <?php switch($filter):
                                        case ('warmup'): ?> Warmup <?php break; ?>
                                        <?php case ('strength'): ?> Strength <?php break; ?>
                                        <?php case ('cardio'): ?> Cardio <?php break; ?>
                                        <?php case ('flexibility'): ?> Flexibility <?php break; ?>
                                        <?php case ('core'): ?> Core <?php break; ?>
                                        <?php case ('plyometrics'): ?> Plyometrics <?php break; ?>
                                        <?php case ('functional'): ?> Functional <?php break; ?>
                                        <?php default: ?> All Categories
                                    <?php endswitch; ?>
                                <?php endif; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
                                <li><a class="dropdown-item <?php echo e($filter === 'all' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises' . ($search ? '?search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-th-large me-2"></i> All Exercises
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item <?php echo e($filter === 'warmup' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=warmup' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-fire me-2 text-warning"></i> Warmup
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($filter === 'strength' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=strength' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-dumbbell me-2 text-info"></i> Strength
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($filter === 'cardio' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=cardio' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-heart me-2 text-danger"></i> Cardio
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($filter === 'flexibility' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=flexibility' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-spa me-2 text-success"></i> Flexibility
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($filter === 'core' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=core' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-circle-notch me-2 text-primary"></i> Core
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($filter === 'plyometrics' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=plyometrics' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-bolt me-2 text-warning"></i> Plyometrics
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($filter === 'functional' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises?category=functional' . ($search ? '&search=' . urlencode($search) : ''))); ?>">
                                       <i class="fas fa-running me-2 text-secondary"></i> Functional
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Difficulty Filter Dropdown -->
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="difficultyDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-signal me-2"></i>
                                <?php if($difficulty === 'all'): ?>
                                    All Difficulties
                                <?php else: ?>
                                    <?php echo e(ucfirst($difficulty)); ?>

                                <?php endif; ?>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="difficultyDropdown">
                                <li><a class="dropdown-item <?php echo e($difficulty === 'all' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '') . 
                                            ($search ? ($filter !== 'all' ? '&' : '?') . 'search=' . urlencode($search) : '')
                                       )); ?>">
                                       <i class="fas fa-bars me-2"></i> All Difficulties
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item <?php echo e($difficulty === 'beginner' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '?') . 
                                            'difficulty=beginner' . 
                                            ($search ? '&search=' . urlencode($search) : '')
                                       )); ?>">
                                       <span class="badge bg-success me-2">B</span> Beginner
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($difficulty === 'intermediate' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '?') . 
                                            'difficulty=intermediate' . 
                                            ($search ? '&search=' . urlencode($search) : '')
                                       )); ?>">
                                       <span class="badge bg-warning text-dark me-2">I</span> Intermediate
                                    </a>
                                </li>
                                <li><a class="dropdown-item <?php echo e($difficulty === 'expert' ? 'active' : ''); ?>" 
                                       href="<?php echo e(url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '?') . 
                                            'difficulty=expert' . 
                                            ($search ? '&search=' . urlencode($search) : '')
                                       )); ?>">
                                       <span class="badge bg-danger me-2">H</span> Expert
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <!-- Active Filter Badges -->
                        <?php if($filter !== 'all' || $difficulty !== 'all'): ?>
                            <div class="ms-2">
                                <?php if($filter !== 'all'): ?>
                                    <span class="badge bg-primary me-1">
                                        <?php switch($filter):
                                            case ('warmup'): ?> Warmup <?php break; ?>
                                            <?php case ('strength'): ?> Strength <?php break; ?>
                                            <?php case ('cardio'): ?> Cardio <?php break; ?>
                                            <?php case ('flexibility'): ?> Flexibility <?php break; ?>
                                            <?php case ('core'): ?> Core <?php break; ?>
                                            <?php case ('plyometrics'): ?> Plyometrics <?php break; ?>
                                            <?php case ('functional'): ?> Functional <?php break; ?>
                                        <?php endswitch; ?>
                                        <a href="<?php echo e(url('exercises' . 
                                            ($difficulty !== 'all' ? '?difficulty=' . $difficulty : '') . 
                                            ($search ? ($difficulty !== 'all' ? '&' : '?') . 'search=' . urlencode($search) : '')
                                        )); ?>" class="text-white ms-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                <?php endif; ?>
                                <?php if($difficulty !== 'all'): ?>
                                    <span class="badge bg-secondary">
                                        <?php echo e(ucfirst($difficulty)); ?>

                                        <a href="<?php echo e(url('exercises' . 
                                            ($filter !== 'all' ? '?category=' . $filter : '') . 
                                            ($search ? ($filter !== 'all' ? '&' : '?') . 'search=' . urlencode($search) : '')
                                        )); ?>" class="text-white ms-1">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-4 text-end">
                    <small class="text-muted">
                        <i class="fas fa-chart-bar me-1"></i>
                        Showing <?php echo e(count($exercises)); ?> exercises
                    </small>
                </div>
            </div>
        </div>

        <!-- Exercises Grid -->
        <div class="row g-3" id="exercisesGrid">
            <?php $__empty_1 = true; $__currentLoopData = $exercises; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exercise): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card h-100 shadow-sm exercise-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <span class="fs-4 me-2"><?php echo $exercise->icon; ?></span>
                                <h6 class="card-title fw-bold mb-0" style="color: var(--foreground);"><?php echo e($exercise->name); ?></h6>
                            </div>
                            <p class="card-text small mb-3" style="color: var(--muted-foreground);"><?php echo e($exercise->description); ?></p>
                            <div class="d-flex flex-wrap gap-1 mb-2">
                                <span class="badge 
                                    <?php switch($exercise->category):
                                        case ('warmup'): ?> bg-warning text-dark <?php break; ?>
                                        <?php case ('strength'): ?> bg-info <?php break; ?>
                                        <?php case ('cardio'): ?> bg-danger <?php break; ?>
                                        <?php case ('flexibility'): ?> bg-success <?php break; ?>
                                        <?php case ('functional'): ?> bg-secondary <?php break; ?>
                                        <?php default: ?> bg-primary
                                    <?php endswitch; ?> text-uppercase">
                                    <?php echo e($exercise->category); ?>

                                </span>
                                <span class="badge 
                                    <?php switch($exercise->difficulty):
                                        case ('beginner'): ?> bg-success <?php break; ?>
                                        <?php case ('intermediate'): ?> bg-warning text-dark <?php break; ?>
                                        <?php case ('expert'): ?> bg-danger <?php break; ?>
                                        <?php default: ?> bg-primary
                                    <?php endswitch; ?>">
                                    <?php echo e(ucfirst($exercise->difficulty)); ?>

                                </span>
                            </div>
                            <div class="small" style="color: var(--muted-foreground);">
                                <i class="fas fa-tools me-1"></i> <?php echo e($exercise->equipment); ?>

                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 pt-0">
                            <a href="<?php echo e(route('exercises.show', $exercise->id)); ?>" class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-play me-1"></i> View Exercise
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="text-center py-5">
                    <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No exercises found</h4>
                    <p class="text-muted">Try selecting a different filter or search term.</p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="mt-4 d-flex justify-content-center">
            <?php echo e($exercises->links('pagination::bootstrap-5')); ?>

        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.exercise-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.transition = 'all 0.3s ease';
            this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '';
        });
    });

    // Clear search
    const clearButton = document.getElementById('clearSearchButton');
    const searchInput = document.getElementById('searchInput');
    if (clearButton && searchInput) {
        clearButton.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.form.submit();
        });
    }
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/index/exercises.blade.php ENDPATH**/ ?>