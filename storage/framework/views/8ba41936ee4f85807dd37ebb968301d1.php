<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/reports.css')); ?>">
    <style>
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="report-page">
    <div class="report-header">
        <h1>Full Gym Report</h1>
        <p class="report-meta">Generated on: <?php echo e(now()->format('F d, Y h:i A')); ?></p>
    </div>
    
    <div class="report-card has-scroll">
        <div class="total-revenue-display">
            <h2>Total Revenue</h2>
            <h2>₱<?php echo e(number_format($revenue, 2)); ?></h2>
        </div>

        <table class="reports-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Member Name</th>
                    <th>Email</th>
                    <th>Subscription Status</th>
                    <th>Plan</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Payment Status</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
           <tbody>
    <?php
        $counter = 1;

        // Key active members by user ID
        $users = $active_members->keyBy('id');

        // Group approved payments by user ID
        $approvedPaymentsByUser = $payments->groupBy(fn($p) => $p->user_id);
    ?>

    
    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $activeSub = $user->subscriptions->where('status', 'active')->first();
            $userPayments = $approvedPaymentsByUser[$user->id] ?? collect();
            $latestPayment = $userPayments->sortByDesc('created_at')->first();
        ?>

        <tr>
            <td><?php echo e($counter++); ?></td>
            <td><?php echo e($user->name); ?></td>
            <td><?php echo e($user->email); ?></td>
            <td><span class="badge bg-success"><?php echo e($activeSub->status); ?></span></td>
            <td><?php echo e($activeSub->plan->name ?? 'N/A'); ?></td>
            <td><?php echo e($activeSub && $activeSub->start_date ? \Carbon\Carbon::parse($activeSub->start_date)->format('M d, Y') : 'N/A'); ?></td>
            <td><?php echo e($activeSub && $activeSub->end_date ? \Carbon\Carbon::parse($activeSub->end_date)->format('M d, Y') : 'N/A'); ?></td>

            <?php if($latestPayment): ?>
                <td><span class="badge bg-success">Approved</span></td>
                <td>₱<?php echo e(number_format($latestPayment->amount ?? 0, 2)); ?></td>
                <td><?php echo e($latestPayment->created_at ? \Carbon\Carbon::parse($latestPayment->created_at)->format('M d, Y') : 'N/A'); ?></td>
            <?php else: ?>
                <td>-</td>
                <td>-</td>
                <td>-</td>
            <?php endif; ?>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!isset($users[$payment->user_id])): ?>
            <tr>
                <td><?php echo e($counter++); ?></td>
                <td><?php echo e($payment->user->name ?? 'N/A'); ?></td>
                <td><?php echo e($payment->user->email ?? 'N/A'); ?></td>
                <td><span class="badge bg-warning"><?php echo e($payment->status); ?></span></td>
                <td>₱<?php echo e(number_format($payment->amount ?? 0, 2)); ?></td>
                <td><?php echo e($payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('M d, Y') : 'N/A'); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>
        </table>
    </div>

    <div class="report-footer">
        <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="<?php echo e(route('reports.full_report_pdf')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/admin/reports/full_report.blade.php ENDPATH**/ ?>