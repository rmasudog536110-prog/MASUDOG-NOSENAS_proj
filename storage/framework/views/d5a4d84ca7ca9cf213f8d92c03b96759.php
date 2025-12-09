<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Pending Payments Report</title>
    <link rel="stylesheet" href="<?php echo e(public_path('css/pdf.css')); ?>">
</head>
<body>
    <h2>Pending Payment Verifications</h2>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Member</th>
                <th>Email</th>
                <th>Plan</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Submitted</th>
            </tr>
        </thead>
        <tbody>
            <?php $__empty_1 = true; $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($index + 1); ?></td>
                    <td><?php echo e($subscription->user->name ?? 'N/A'); ?></td>
                    <td><?php echo e($subscription->user->email ?? 'N/A'); ?></td>
                    <td><?php echo e($subscription->plan->name ?? 'N/A'); ?></td>
                    <td><?php echo e(optional($subscription->start_date)->format('M d, Y') ?? 'N/A'); ?></td>
                    <td><?php echo e(optional($subscription->end_date)->format('M d, Y') ?? 'N/A'); ?></td>
                    <td><?php echo e($subscription->created_at->format('M d, Y')); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="7" style="text-align: center;">No pending payments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\reports\pending_payments_pdf.blade.php ENDPATH**/ ?>