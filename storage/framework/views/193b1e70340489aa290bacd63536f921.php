

<?php $__env->startSection('title', 'Pending Approval'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="dashboard-container">
    <div class="dashboard-welcome">
        <h1 class="welcome-title">Pending Approval</h1>
        <p class="welcome-subtitle" style="margin-left: 200px;">
            Your account is currently waiting for admin approval. 
            You will receive a notification once your account is approved.
        </p>
        <div class="empty-state">
            <i class="fa-solid fa-hourglass-half empty-state-icon"></i>
            <p>Please be patient while we review your account.</p>
        </div>
        <div class="quick-actions-pending" style="justify-content: center; margin-top: 1.5rem;">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>   
                <button type="submit" class="btn btn-outline">Logout</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\index\pending_dashboard.blade.php ENDPATH**/ ?>