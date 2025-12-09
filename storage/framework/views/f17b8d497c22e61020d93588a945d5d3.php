

<?php $__env->startSection('title', 'Payment History'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="mb-4">Payment History</h2>

    <?php if($transactions->isEmpty()): ?>
        <div class="alert alert-info">You have no payment transactions yet.</div>
    <?php else: ?>
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Plan</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($transaction->created_at->format('M d, Y h:i A')); ?></td>
                            <td><?php echo e(optional($transaction->subscription->plan)->name ?? 'N/A'); ?></td>
                            <td>₱<?php echo e(number_format($transaction->amount, 2)); ?></td>
                            <td><?php echo e(ucfirst($transaction->payment_method)); ?></td>
                            <td>
                                <?php if($transaction->status === 'active'): ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php elseif($transaction->status === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Failed</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo e($transaction->transaction_reference); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($transactions->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layouts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\payment\history.blade.php ENDPATH**/ ?>