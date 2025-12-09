<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-header"><?php echo e(__('Forgot Your Password?')); ?></div>

    <div class="card-body">
        <?php if(session('status')): ?>
        <div class="alert alert-success">
            <?php echo e(session('status')); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.email')); ?>">
            <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="email"><?php echo e(__('E-Mail Address')); ?></label>
                <input type="email" name="email" id="email" class="form-control" value="<?php echo e(old('email')); ?>" required autofocus>
            </div>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <?php echo e(__('Send Password Reset Link')); ?>

                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\auth\forgot-password.blade.php ENDPATH**/ ?>