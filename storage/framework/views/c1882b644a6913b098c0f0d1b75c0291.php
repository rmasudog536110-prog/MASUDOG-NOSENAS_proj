<?php $__env->startSection('title', 'FitClub - Premium Gym Membership'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/index.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('index.index_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Hero Section -->
<section class="hero" aria-label="Hero section">
    <div class="container">
        <div class="hero-content">
            <h1>Transform Your Body, Transform Your Life</h1>
            <p>
                Join thousands of members who have achieved their fitness goals
                with our premium training programs and expert guidance.
            </p>

            <?php if(auth()->guard()->guest()): ?>
            <a href="#subscription-plans" class="btn btn-primary cta-btn">Start Your Free Trial</a>
            <?php else: ?>
            <a href="<?php echo e(route('user_dashboard')); ?>" class="btn btn-primary cta-btn">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Subscription Plans -->
<section class="subscription-plans" id="subscription-plans" aria-labelledby="plans-heading">
    <div class="container">
        <h2 id="plans-heading">Choose Your Plan</h2>
        <div class="plans-grid">
            <?php $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="plan-card
                        <?php echo e($plan['name'] === 'Quarterly' ? 'popular' : ''); ?>

                        <?php echo e($plan['is_trial'] ? 'trial-plan' : ''); ?>">

                <?php if($plan['name'] === 'Pro Plan'): ?>
                <div class="plan-badge">Most Popular</div>
                <?php endif; ?>

                        <div class="plan-header">
                            <h3><?php echo e($plan['name']); ?></h3>
                            <div>
                                <span class="price">₱<?php echo e(number_format($plan['price'], 2)); ?></span>
                            </div>
                            <span class="free-trial">7-Day Free Trial</span>
                        </div>

                <ul class="plan-features">
                    <?php $__currentLoopData = $plan['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($feature); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <?php if(auth()->guard()->check()): ?>
                <?php if($userSubscription && $userSubscription->plan_id == $plan->id && $userSubscription->status == 'approved'): ?>
                <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline" aria-label="View current active plan">
                    <i class="fa-solid fa-check"></i> Current Plan
                </a>
                <?php elseif($userSubscription && $userSubscription->plan_id == $plan->id && $userSubscription->status == 'pending'): ?>
                <button class="btn btn-warning" onclick="cancelPayment(<?php echo e($userSubscription->id); ?>)" aria-label="Cancel pending payment">
                    <i class="fa-solid fa-clock"></i> Cancel Payment
                </button>
                <?php elseif($userSubscription && $userSubscription->status == 'approved'): ?>
                <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-secondary" aria-label="View current subscription">
                    <i class="fa-solid fa-ban"></i> View Current Plan
                </a>
                <?php elseif($userSubscription && $userSubscription->status == 'pending'): ?>
                <button class="btn btn-secondary" onclick="cancelPayment(<?php echo e($userSubscription->id); ?>)" aria-label="Cancel payment pending for another plan">
                    <i class="fa-solid fa-hourglass-half"></i> Cancel Payment
                </button>
                <?php else: ?>
                <a href="<?php echo e(route('subscription.payment.form', $plan->id)); ?>"
                    class="btn <?php echo e($plan->is_trial ? 'btn-outline' : 'btn-primary'); ?>"
                    aria-label="Subscribe to <?php echo e($plan['name']); ?> plan">
                    <i class="fa-solid fa-credit-card"></i> <?php echo e($plan->is_trial ? 'Start Free Trial' : 'Subscribe Now'); ?>

                </a>
                <?php endif; ?>
                <?php else: ?>
                <a href="<?php echo e(route('register', ['plan' => $plan->id])); ?>"
                    class="btn <?php echo e($plan->is_trial ? 'btn-outline' : 'btn-primary'); ?>"
                    aria-label="Login to subscribe to <?php echo e($plan['name']); ?> plan">
                    <i class="fa-solid fa-sign-in-alt"></i> <?php echo e($plan->is_trial ? 'Login to Start Trial' : 'Login to Subscribe'); ?>

                </a>
                <?php endif; ?>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<!-- Training Programs Preview -->
<section class="training-preview" aria-labelledby="programs-heading">
    <div class="container">
        <h2 id="programs-heading">Preview Our Training Programs</h2>
        <div class="programs-grid">
            <div class="program-card">
                <h3>Beginner Fitness</h3>
                <p>Perfect for those starting their fitness journey. Build foundation strength and learn proper form.</p>
                <div class="program-meta">
                    <span class="duration">4–6 weeks</span>
                    <span class="level">Beginner</span>
                </div>
            </div>

            <div class="program-card">
                <h3>Strength Builder</h3>
                <p>Intermediate program focused on building muscle mass and increasing overall strength.</p>
                <div class="program-meta">
                    <span class="duration">8–12 weeks</span>
                    <span class="level">Intermediate</span>
                </div>
            </div>

            <div class="program-card">
                <h3>Athletic Performance</h3>
                <p>Advanced training for serious athletes looking to maximize their performance potential.</p>
                <div class="program-meta">
                    <span class="duration">12+ weeks</span>
                    <span class="level">Expert</span>
                </div>
            </div>
        </div>

        <?php if(auth()->guard()->check()): ?>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('programs.index')); ?>" class="btn btn-primary">View All Programs</a>
        </div>
        <?php else: ?>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary">Sign Up to Access Programs</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Features Section -->
<section class="features" aria-labelledby="features-heading">
    <div class="container">
        <h2 id="features-heading">Why Choose FitClub?</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🏋️</div>
                <h3>Expert Training</h3>
                <p>Access professional-grade training programs designed by certified fitness experts.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Mobile Access</h3>
                <p>Train anywhere with our mobile-optimized platform and offline workout capabilities.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Progress Tracking</h3>
                <p>Monitor your progress with detailed analytics and personalized recommendations.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Goal-Oriented</h3>
                <p>Customized workout plans tailored to your specific fitness goals and experience level.</p>
            </div>
        </div>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function cancelPayment(subscriptionId) {
        if (confirm('Are you sure you want to cancel this pending payment? This action cannot be undone.')) {
            // Create form for cancellation
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '/payment/cancel';

            // Add CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);

            // Add subscription ID
            const subscriptionInput = document.createElement('input');
            subscriptionInput.type = 'hidden';
            subscriptionInput.name = 'subscription_id';
            subscriptionInput.value = subscriptionId;
            form.appendChild(subscriptionInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/index/index.blade.php ENDPATH**/ ?>