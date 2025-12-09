<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/reports.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="report-page">
    <div class="report-header">
        <h1>Expiring Soon</h1>
        <p class="report-meta">Upcoming expirations in next 7 days</p>
    </div>

    <div class="report-card">
        <div class="report-section">
            <h2>Expiring Soon</h2>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Plan</th>
                        <th>Expires At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $totalRows = 5;
                        $subscriptions = $subscriptions ?? collect();
                        $membersCount = $subscriptions->count();
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $sub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td><?php echo e($sub->user->name ?? 'N/A'); ?></td>
                            <td><?php echo e($sub->plan->name ?? 'N/A'); ?></td>
                            <td><?php echo e(optional($sub->end_date)->format('M d, Y') ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="empty-row">
                            <td colspan="4">No expiring subscriptions</td>
                        </tr>
                    <?php endif; ?>

                    <?php if($membersCount && $membersCount < $totalRows): ?>
                        <?php for($i = $membersCount; $i < $totalRows; $i++): ?>
                            <tr class="empty-row">
                                <td colspan="4">—</td>
                            </tr>
                        <?php endfor; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="report-section">
            <h2>Active Subscriptions</h2>
            <table class="reports-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Member</th>
                        <th>Email</th>
                        <th>Plan</th>
                        <th>Ends At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $activeRows = 5;
                        $activeSubscriptions = $activeSubscriptions ?? collect();
                        $activeCount = $activeSubscriptions->count();
                    ?>

                    <?php $__empty_1 = true; $__currentLoopData = $activeSubscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $active): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><?php echo e($i + 1); ?></td>
                            <td><?php echo e($active->user->name ?? 'N/A'); ?></td>
                            <td><?php echo e($active->user->email ?? 'N/A'); ?></td>
                            <td><?php echo e($active->plan->name ?? 'N/A'); ?></td>
                            <td><?php echo e(optional($active->end_date)->format('M d, Y') ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr class="empty-row">
                            <td colspan="5">No active subscriptions</td>
                        </tr>
                    <?php endif; ?>

                    <?php if($activeCount && $activeCount < $activeRows): ?>
                        <?php for($i = $activeCount; $i < $activeRows; $i++): ?>
                            <tr class="empty-row">
                                <td colspan="5">—</td>
                            </tr>
                        <?php endfor; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="report-footer">
        <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="<?php echo e(route('reports.expiring_soon_pdf')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\reports\expiring_soon.blade.php ENDPATH**/ ?>