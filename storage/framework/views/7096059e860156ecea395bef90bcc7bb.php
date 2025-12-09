<?php $__env->startSection('title', 'Program Details - Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <style>
        .program-header {
            background: linear-gradient(135deg, var(--card) 0%, rgba(26, 26, 26, 0.8) 100%);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .program-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary) 0%, #ff8c00 100%);
        }

        .program-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .program-level {
            display: inline-block;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }

        .level-beginner {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(40, 167, 69, 0.1) 100%);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .level-intermediate {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 193, 7, 0.1) 100%);
            color: #ffc107;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .level-advanced {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%);
            color: #dc3545;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .program-status {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(40, 167, 69, 0.1) 100%);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-inactive {
            background: linear-gradient(135deg, rgba(108, 117, 125, 0.2) 0%, rgba(108, 117, 125, 0.1) 100%);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.15);
            border-radius: 0.7rem;
            padding: 1.5rem;
            transition: all var(--transition-speed) ease;
        }

        .info-card:hover {
            border-color: rgba(255, 102, 0, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.1);
        }

        .info-card h3 {
            color: var(--primary);
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-card .value {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .info-card .label {
            font-size: 0.875rem;
            color: var(--muted-foreground);
        }

        .description-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.15);
            border-radius: 0.7rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .description-card h3 {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .description-card p {
            color: var(--foreground);
            line-height: 1.6;
            margin-bottom: 0;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.7rem;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all var(--transition-speed) ease;
            border: none;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, #ff8c00 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 102, 0, 0.3);
        }

        .btn-outline {
            background: transparent;
            color: var(--primary);
            border: 1px solid var(--primary);
        }

        .btn-outline:hover {
            background: var(--primary);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }

        @media (max-width: 768px) {
            .program-title {
                font-size: 2rem;
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Program Header -->
    <div class="program-header">
        <div class="program-header-content">
            <h1 class="program-title">
                <i class="fa-solid fa-dumbbell"></i>
                <?php echo e($program->title); ?>

            </h1>
            
            <div class="program-meta">
                <span class="program-level level-<?php echo e($program->level); ?>">
                    <?php echo e(ucfirst($program->level)); ?>

                </span>
                
                <span class="program-status <?php echo e($program->is_active ? 'status-active' : 'status-inactive'); ?>">
                    <i class="fa-solid fa-<?php echo e($program->is_active ? 'check-circle' : 'times-circle'); ?>"></i>
                    <?php echo e($program->is_active ? 'Active' : 'Inactive'); ?>

                </span>
            </div>
        </div>
    </div>

    <!-- Program Information Grid -->
    <div class="info-grid">
        <div class="info-card">
            <h3>
                <i class="fa-solid fa-calendar"></i>
                Duration
            </h3>
            <div class="value"><?php echo e($program->duration_weeks); ?></div>
            <div class="label">Weeks</div>
        </div>

        <div class="info-card">
            <h3>
                <i class="fa-solid fa-fire"></i>
                Workouts
            </h3>
            <div class="value"><?php echo e($program->workout_counts); ?></div>
            <div class="label">Total Sessions</div>
        </div>

        <div class="info-card">
            <h3>
                <i class="fa-solid fa-tools"></i>
                Equipment
            </h3>
            <div class="value"><?php echo e($program->equipment_required ?: 'None Required'); ?></div>
            <div class="label">Required</div>
        </div>

        <div class="info-card">
            <h3>
                <i class="fa-solid fa-clock"></i>
                Created
            </h3>
            <div class="value"><?php echo e($program->created_at->format('M d, Y')); ?></div>
            <div class="label">Date Added</div>
        </div>
    </div>

    <!-- Program Description -->
    <div class="description-card">
        <h3>
            <i class="fa-solid fa-info-circle"></i>
            Program Description
        </h3>
        <p>
            <?php if(is_string($program->description)): ?>
                <?php echo e($program->description); ?>

            <?php else: ?>
                <?php echo e($program->description['overview'] ?? 'No description available.'); ?>

            <?php endif; ?>
        </p>
    </div>

    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="<?php echo e(route('admin.programs.edit', $program->id)); ?>" class="btn btn-primary">
            <i class="fa-solid fa-edit"></i>
            Edit Program
        </a>

        <a href="<?php echo e(route('admin.programs.toggle-status', $program->id)); ?>" class="btn btn-outline">
            <i class="fa-solid fa-power-off"></i>
            <?php echo e($program->is_active ? 'Deactivate' : 'Activate'); ?>

        </a>

        <a href="<?php echo e(route('admin.programs.index')); ?>" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i>
            Back to Programs
        </a>

        <form action="<?php echo e(route('admin.programs.destroy', $program->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this program? This action cannot be undone.');">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger">
                <i class="fa-solid fa-trash"></i>
                Delete Program
            </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\programs\show.blade.php ENDPATH**/ ?>