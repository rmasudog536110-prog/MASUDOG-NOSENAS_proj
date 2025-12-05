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
                    <i class="fas fa-book me-3"></i>
                    Exercise Library
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
            ?>
            <div class="filter-buttons">
                <a href="<?php echo e(url('exercises' . ($search ? '?search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'all' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                    <i class="fas fa-th-large me-2"></i> All Exercises
                </a>
                <a href="<?php echo e(url('exercises?category=warmup' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'warmup' ? 'btn-warning text-dark' : 'btn-outline-warning'); ?>">
                    <i class="fas fa-fire me-2"></i> Warmup
                </a>
                <a href="<?php echo e(url('exercises?category=strength' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'strength' ? 'btn-info' : 'btn-outline-info'); ?>">
                    <i class="fas fa-dumbbell me-2"></i> Strength
                </a>
                <a href="<?php echo e(url('exercises?category=cardio' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'cardio' ? 'btn-danger' : 'btn-outline-danger'); ?>">
                    <i class="fas fa-heart me-2"></i> Cardio
                </a>
                <a href="<?php echo e(url('exercises?category=flexibility' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'flexibility' ? 'btn-success' : 'btn-outline-success'); ?>">
                    <i class="fas fa-spa me-2"></i> Flexibility
                </a>
                <a href="<?php echo e(url('exercises?category=core' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'core' ? 'btn-primary' : 'btn-outline-primary'); ?>">
                    <i class="fas fa-circle-notch me-2"></i> Core
                </a>
                <a href="<?php echo e(url('exercises?category=plyometrics' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'plyometrics' ? 'btn-warning text-dark' : 'btn-outline-warning'); ?>">
                    <i class="fas fa-bolt me-2"></i> Plyometrics
                </a>
                <a href="<?php echo e(url('exercises?category=functional' . ($search ? '&search=' . urlencode($search) : ''))); ?>" 
                   class="btn <?php echo e($filter === 'functional' ? 'btn-secondary' : 'btn-outline-secondary'); ?>">
                    <i class="fas fa-running me-2"></i> Functional
                </a>
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
                                    <i class="fas fa-tools me-1"></i>
                                    <?php echo e($exercise->equipment); ?>

                                </div>
                            </div>

                            <div class="card-footer bg-transparent border-0 pt-0">
                                <a href="<?php echo e(route('exercises.show', $exercise->id)); ?>" 
                                   class="btn btn-outline-primary btn-sm w-100">
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

            // Clear search functionality
            const clearButton = document.getElementById('clearSearchButton');
            const searchInput = document.getElementById('searchInput');
            
            if (clearButton && searchInput) {
                clearButton.addEventListener('click', function() {
                    searchInput.value = '';
                    searchInput.form.submit(); // Submit the form to clear search
                });

                // Show/hide clear button based on input
                searchInput.addEventListener('input', function() {
                    if (this.value.trim()) {
                        // Add clear button if it doesn't exist
                        if (!document.getElementById('clearSearchButton')) {
                            const clearBtn = document.createElement('button');
                            clearBtn.type = 'button';
                            clearBtn.id = 'clearSearchButton';
                            clearBtn.className = 'btn btn-outline-secondary';
                            clearBtn.title = 'Clear search';
                            clearBtn.innerHTML = '<i class="fas fa-times"></i>';
                            clearBtn.addEventListener('click', function() {
                                searchInput.value = '';
                                searchInput.form.submit();
                            });
                            searchInput.parentNode.insertBefore(clearBtn, searchInput.nextSibling);
                        }
                    } else {
                        // Remove clear button if input is empty
                        const existingBtn = document.getElementById('clearSearchButton');
                        if (existingBtn) {
                            existingBtn.remove();
                        }
                    }
                });
            }
        });
    </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/index/exercises.blade.php ENDPATH**/ ?>