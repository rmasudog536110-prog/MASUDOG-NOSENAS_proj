

<?php $__env->startSection('title', 'Instructor Requests - Instructor'); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<style>
    .requests-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .requests-table { width: 100%; background: var(--card); border-radius: var(--radius); overflow: hidden; }
    .requests-table th { background: rgba(0,123,255,0.1); padding:1rem; text-align:left; color:var(--primary); }
    .requests-table td { padding:1rem; border-bottom:1px solid rgba(0,123,255,0.1); }
    .status-badge { padding:0.25rem 0.75rem; border-radius:0.5rem; font-size:.875rem; font-weight:600; }
    .status-pending { background: rgba(255,193,7,0.2); color:#ffc107; }
    .status-accepted { background: rgba(40,167,69,0.2); color:#28a745; }
    .status-declined, .status-cancelled { background: rgba(220,53,69,0.2); color:#dc3545; }
    .status-completed { background: rgba(0,123,255,0.2); color:#007bff; }
    .action-buttons { display:flex; gap:0.5rem; }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="content-section">
<div class="container">
    <div class="requests-header">
        <div>
            <h1>Instructor Requests</h1>
            <p style="color: var(--muted-foreground);">View all users who requested an instructor</p>
        </div>
        <a href="<?php echo e(route('instructor.instructor_dashboard')); ?>" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <?php if(session('success')): ?>
        <div class="flash-message success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
        <div class="flash-message error"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="dashboard-card">
        <table class="requests-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Exercise Type</th>
                    <th>Preferred Date</th>
                    <th>Preferred Time</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($request->customer_name); ?></td>
                        <td><?php echo e($request->customer_email); ?></td>
                        <td><?php echo e($request->customer_phone ?? 'N/A'); ?></td>
                        <td><?php echo e(ucfirst($request->exercise_type)); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($request->preferred_date)->format('M d, Y')); ?></td>
                        <td><?php echo e(\Carbon\Carbon::parse($request->preferred_time)->format('H:i')); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo e($request->status); ?>">
                                <?php echo e(ucfirst($request->status)); ?>

                            </span>
                        </td>
                        <td><?php echo e($request->created_at->format('M d, Y')); ?></td>
                        <td>
                            <div class="action-buttons">
                                <?php if($request->status === 'pending'): ?>
                                    <form action="<?php echo e(route('instructor.requests.accept', $request)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline btn-sm" title="Accept">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="<?php echo e(route('instructor.requests.decline', $request)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline btn-sm" title="Decline">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </form>
                                <?php elseif($request->status === 'accepted'): ?>
                                    <form action="<?php echo e(route('instructor.requests.complete', $request)); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-outline btn-sm" title="Mark Completed">
                                            <i class="fa-solid fa-check-double"></i>
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center" style="padding:3rem; color:var(--muted-foreground);">
                            No instructor requests found.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if($requests->hasPages()): ?>
            <div style="margin-top:2rem;"><?php echo e($requests->links()); ?></div>
        <?php endif; ?>
    </div>
</div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/instructor/requests.blade.php ENDPATH**/ ?>