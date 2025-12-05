<?php $__env->startSection('title', 'Manage Users - Admin'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <style>
        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .users-table {
            width: 100%;
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .users-table th {
            background: rgba(255, 102, 0, 0.1);
            padding: 1rem;
            text-align: left;
            color: var(--primary);
        }

        .users-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.1);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-inactive {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('admin.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>


<section class="content-section">
    <div class="container">
        <div class="users-header">
            <div>
                <h1>Manage Users</h1>
                <p style="color: var(--muted-foreground);">View and manage all gym members</p>
            </div>
            <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="flash-message success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="flash-message error">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Users Table -->
        <div class="dashboard-card">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Subscription</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($user->name); ?></td>
                            <td><?php echo e($user->email); ?></td>
                            <td><?php echo e($user->phone_number ?? 'N/A'); ?></td>
                            <td>
                                <span class="status-badge <?php echo e($user->is_active ? 'status-active' : 'status-inactive'); ?>">
                                    <?php echo e($user->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </td>
                            <td>
                                <?php
                                    $activeSub = $user->subscriptions()
                                        ->where('end_date', '>', now())
                                        ->latest()
                                        ->first();
                                ?>
                                <?php if($activeSub): ?>
                                    <?php echo e($activeSub->plan->name ?? 'N/A'); ?>

                                <?php else: ?>
                                    <span style="color: var(--muted-foreground);">No active plan</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($user->created_at->format('M d, Y')); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('admin.edit-user', $user)); ?>" 
                                       class="btn btn-outline btn-sm"
                                       title="Edit User">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <form action="<?php echo e(route('admin.toggle-status', $user)); ?>" 
                                          method="POST" 
                                          style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" 
                                                class="btn btn-outline btn-sm"
                                                title="<?php echo e($user->is_active ? 'Deactivate' : 'Activate'); ?>">
                                            <i class="fa-solid fa-<?php echo e($user->is_active ? 'ban' : 'check'); ?>"></i>
                                        </button>
                                    </form>

                                    <form action="<?php echo e(route('admin.delete-user', $user)); ?>" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="btn btn-outline btn-sm"
                                                style="color: #dc3545; border-color: #dc3545;"
                                                title="Delete User">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem; color: var(--muted-foreground);">
                                No users found
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <!-- Pagination -->
            <?php if($users->hasPages()): ?>
                <div style="margin-top: 2rem;">
                    <?php echo e($users->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/admin/users.blade.php ENDPATH**/ ?>