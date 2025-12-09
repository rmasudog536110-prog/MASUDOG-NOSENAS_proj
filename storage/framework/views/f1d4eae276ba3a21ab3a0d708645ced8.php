<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header"><?php echo e(__('Reset Password')); ?></div>

    <div class="card-body">
        <form method="POST" action="<?php echo e(route('password.update')); ?>">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="token" value="<?php echo e($token); ?>">
            <input type="hidden" name="email" value="<?php echo e($email); ?>">

            <div class="form-group">
                <label for="password"><?php echo e(__('New Password')); ?></label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password_confirmation"><?php echo e(__('Confirm Password')); ?></label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <?php echo e(__('Reset Password')); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\auth\reset-password.blade.php ENDPATH**/ ?>