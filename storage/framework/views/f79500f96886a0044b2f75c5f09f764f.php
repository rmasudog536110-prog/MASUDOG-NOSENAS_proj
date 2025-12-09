<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/reports.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="report-page">
    <div class="report-header">
        <h1>Active Members</h1>
        <p class="report-meta">
            <?php echo e($active); ?> active · <?php echo e($cancelled); ?> cancelled
        </p>
    </div>

    <div class="report-card">
        <table class="reports-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $totalRows = 5;
            $membersCount = count($members);
        ?>

            <?php $__empty_1 = true; $__currentLoopData = $members; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($member->name); ?></td>
                    <td><?php echo e($member->email); ?></td>
                    <td><?php echo e($member->phone_number ?? 'N/A'); ?></td>
                    <td><?php echo e($member->created_at->format('M d, Y')); ?></td>
                </tr>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <?php endif; ?>
            <?php for($i = $membersCount; $i < $totalRows; $i++): ?>
                    <tr class="empty-row">
                        <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                            No users yet
                        </td>
                    </tr>
            <?php endfor; ?>
            
        </tbody>
    </table>

<footer class="footer-reports">
<div class="report-footer">
    <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-success">
        <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
    </a>
    <a href="<?php echo e(route('reports.active_members_pdf')); ?>" class="btn btn-primary">
        <i class="fa-solid fa-download"></i> Export to PDF
    </a>
</div>

</footer>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\reports\active_members.blade.php ENDPATH**/ ?>