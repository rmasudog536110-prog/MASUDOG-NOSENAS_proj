

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/reports.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div>
    <h2>Total Revenue Report</h2>

    <h3>₱<?php echo e(number_format($revenue, 2)); ?></h3>
</div>

<footer class="footer-reports">
    <div class="report-footer" style="margin-top: 20px;">
        <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="btn btn-success">
            <i class="fa-solid fa-arrow-left"></i> Return to Dashboard
        </a>
        <a href="<?php echo e(route('reports.expiring_soon_pdf')); ?>" class="btn btn-primary">
            <i class="fa-solid fa-download"></i> Export to PDF
        </a>
    </div>
</footer>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\reports\revenue_reports.blade.php ENDPATH**/ ?>