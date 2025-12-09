<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign Up - FitClub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('css/register.css')); ?>">
</head>

<body>
    <main>
        <div>

            <div>
                <h1 class="text-center">Join FitClub</h1>


                <?php if(!empty($selectedPlan)): ?>
                <div class="selected-plan-info">
                    <h3>Selected Plan: <?php echo e(data_get($selectedPlan, 'name')); ?></h3>
                    <p>₱<?php echo e(number_format(data_get($selectedPlan, 'price', 0), 0)); ?> - <?php echo e(data_get($selectedPlan, 'description')); ?></p>
                </div>
                <?php endif; ?>

                
                <?php if($errors->has('general')): ?>
                <div class="flash-message error">
                    <?php echo e($errors->first('general')); ?>

                </div>
                <?php endif; ?>

                <form method="POST" action="<?php echo e(route('register.submit')); ?>">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="plan_id" value="<?php echo e(old('plan_id', $selectedPlanId ?? '')); ?>">


                    <div class="form-group mb-3">
                        <label for="name">Full Name</label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            class="form-control <?php echo e($errors->has('name') ? 'is-invalid' : ''); ?>"
                            value="<?php echo e(old('name')); ?>"
                            required>
                        <?php if($errors->has('name')): ?>
                        <div class="form-error text-danger small mt-1"><?php echo e($errors->first('name')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                            value="<?php echo e(old('email')); ?>"
                            required>
                        <?php if($errors->has('email')): ?>
                        <div class="form-error text-danger small mt-1"><?php echo e($errors->first('email')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone_number">Phone Number (Optional)</label>
                        <div class="input-group">

                        
                        <div class="input-group-text">
                            <select name="country_num" class="input-group-text">
                                <option value="+63">+63</option>
                                <option value="+1">+1</option>
                                <option value="+44">+44</option>
                                <option value="+61">+61</option>
                                <option value="+81">+81</option>
                                <option value="+91">+91</option>
                            </select>
                        </div>
                        <input
                            type="tel"
                            id="phone_number"
                            name="phone_number"
                            class="form-control <?php echo e($errors->has('phone') ? 'is-invalid' : ''); ?>"
                            maxlength="10"
                            pattern="[0-9]{10}"
                            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0.10);"
                            value="<?php echo e(old('phone')); ?>"
                            placeholder="9284594158"
                        >
                        </div>
                        <?php if($errors->has('phone_number')): ?>
                        <div class="form-error text-danger small mt-1"><?php echo e($errors->first('phone_number')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
                            required
                            minlength="6">
                        <?php if($errors->has('password')): ?>
                        <div class="form-error text-danger small mt-1"><?php echo e($errors->first('password')); ?></div>
                        <?php endif; ?>
                        <p><small class="text-muted">Minimum 6 characters</small></p>
                    </div>

                    <div class="form-group mb-3">
                        <label for="confirm_password">Confirm Password</label>
                        
                        <input
                            type="password"
                            id="confirm_password"
                            name="password_confirmation"
                            class="form-control <?php echo e($errors->has('password_confirmation') ? 'is-invalid' : ''); ?>"
                            required>
                        <?php if($errors->has('password_confirmation')): ?>
                        <div class="form-error text-danger small mt-1"><?php echo e($errors->first('password_confirmation')); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-3">
                        <label for="plan_id">Choose a Subscription Plan</label>
                        <select
                            id="plan_id"
                            name="plan_id"
                            class="form-control <?php echo e($errors->has('plan_id') ? 'is-invalid' : ''); ?>">
                            <option value="">-- Please Select a Plan --</option>
                            <?php $__currentLoopData = \App\Models\SubscriptionPlan::all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($plan->id); ?>"
                                <?php echo e(old('plan_id', $selectedPlanId ?? '') == $plan->id ? 'selected' : ''); ?>>
                                <?php echo e($plan->name); ?> — ₱<?php echo e(number_format($plan->price, 2)); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>

                        <?php if($errors->has('plan_id')): ?>
                        <div class="form-error text-danger small mt-1"><?php echo e($errors->first('plan_id')); ?></div>
                        <?php endif; ?>
                    </div>

                    <?php
                    $buttonLabel = 'Create Account';
                    ?>

                    <button type="submit" class="btn btn-primary btn-full mt-3"><?php echo e($buttonLabel); ?></button>
                </form>

                <div class="text-muted">
                    <p><a href="<?php echo e(url('/login')); ?>">Already have an account? Login here</a></p>
                </div>
            </div>
        </div>
    </main>
</body>

</html><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\auth\register.blade.php ENDPATH**/ ?>