<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/reports.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="report-page">
    <div class="report-header">
        <h1>Pending Payment Verifications</h1>
        <p class="report-meta">Awaiting admin approval</p>
    </div>

    <div class="report-card">
        <table class="reports-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalRows = 5;
                    $membersCount = $pending->count();
                ?>

                <?php $__empty_1 = true; $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($subscription->user->name); ?></td>
                        <td><?php echo e($subscription->plan->name ?? 'N/A'); ?></td>
                        <td><?php echo e(optional($subscription->start_date)->format('M d, Y')); ?></td>
                        <td><?php echo e(optional($subscription->end_date)->format('M d, Y')); ?></td>
                        <td><?php echo e($subscription->created_at->format('M d, Y')); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr class="empty-row">
                        <td colspan="5">No pending payments found</td>
                    </tr>
                <?php endif; ?>

                <?php if($membersCount && $membersCount < $totalRows): ?>
                    <?php for($i = $membersCount; $i < $totalRows; $i++): ?>
                        <tr class="empty-row">
                            <td colspan="5">—</td>
                        </tr>
                    <?php endfor; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <?php if(method_exists($pending, 'hasPages') && $pending->hasPages()): ?>
            <div class="report-pagination">
                <?php echo e($pending->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <div class="report-footer">
        <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="<?php echo e(route('reports.pending_payments_pdf')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/admin/reports/pending_payments.blade.php ENDPATH**/ ?>