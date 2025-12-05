<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/reports.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="report-page">
    <div class="report-header">
        <h1>Payments</h1>
        <p class="report-meta">Snapshot of latest approved transactions</p>
    </div>

    <div class="report-card">
        <div class="total-revenue-display">
            <h2>Total Revenue</h2>
            <h2>₱<?php echo e(number_format($revenue, 2)); ?></h2>
        </div>

        <table class="reports-table">
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $totalRows = 5;
                    $combined = $combined ?? collect();
                    $membersCount = $combined->count();
                ?>

                <?php $__empty_1 = true; $__currentLoopData = $combined; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($row['user']->name ?? 'N/A'); ?></td>
                        <td>₱<?php echo e(number_format($row['latest_amount'] ?? 0, 2)); ?></td>
                        <td><?php echo e(ucfirst($row['payment_method'] ?? 'N/A')); ?></td>
                        <td><?php echo e(ucfirst($row['status'] ?? 'N/A')); ?></td>
                        <td><?php echo e(isset($row['date']) ? $row['date']->format('M d, Y') : 'N/A'); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr class="empty-row">
                        <td colspan="5">No payments found</td>
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
    </div>

    <div class="report-footer">
        <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="<?php echo e(route('reports.payments_pdf')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/admin/reports/payments.blade.php ENDPATH**/ ?>