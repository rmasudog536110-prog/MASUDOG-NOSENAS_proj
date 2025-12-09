<?php $__env->startSection('title', 'Subscribe - ' . e($plan['name']) . ' Plan - FitClub'); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <main class="content-section py-5">
        <div class="container">
            <div class="subscription-container mx-auto" style="max-width: 700px;">
                <h1 class="text-center mb-5">Complete Your Subscription</h1>

                <!-- Selected Plan Info -->
                <div class="selected-plan mb-4">
                    <h2><?php echo e($plan['name']); ?> Plan</h2>
                    <div class="plan-price mb-3">
                        <span class="price">₱<?php echo e(number_format($plan['price'], 0)); ?></span>
                        <span class="duration">
                            <?php if($plan['duration_days'] == 7): ?>
                                7 days
                            <?php elseif($plan['duration_days'] == 30): ?>
                                per month
                            <?php elseif($plan['duration_days'] == 90): ?>
                                3 months
                            <?php elseif($plan['duration_days'] == 365): ?>
                                per year
                            <?php endif; ?>
                        </span>
                    </div>
                    <p><?php echo e($plan['description']); ?></p>

                    <div class="plan-features">
                        <h4>What's included:</h4>
                        <ul>
                            <?php $__currentLoopData = json_decode($plan['features'], true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><?php echo e($feature); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>

                <!-- Error Messages -->
                <?php if(!empty($errors['general'])): ?>
                    <div class="alert alert-danger"><?php echo e($errors['general']); ?></div>
                <?php endif; ?>

                <?php if(!empty($errors['payment'])): ?>
                    <div class="alert alert-danger"><?php echo e($errors['payment']); ?></div>
                <?php endif; ?>

                <!-- Payment Form -->
                <form method="POST" action="" class="payment-form">
                    <?php echo csrf_field(); ?>
                    <?php if(!$plan['is_trial']): ?>
                        <div class="form-group mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="form-select" required>
                                <option value="">Select Payment Method</option>
                                <option value="gcash" <?php echo e(old('payment_method') === 'gcash' ? 'selected' : ''); ?>>GCash</option>
                                <option value="paymaya" <?php echo e(old('payment_method') === 'paymaya' ? 'selected' : ''); ?>>PayMaya</option>
                                <option value="card" <?php echo e(old('payment_method') === 'card' ? 'selected' : ''); ?>>Credit/Debit Card</option>
                                <option value="bank" <?php echo e(old('payment_method') === 'bank' ? 'selected' : ''); ?>>Bank Transfer</option>
                            </select>
                            <?php if(!empty($errors['payment_method'])): ?>
                                <div class="form-error text-danger mt-1"><?php echo e($errors['payment_method']); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="card-details" style="display: none;">
                            <div class="form-group mb-3">
                                <label for="card_number" class="form-label">Card Number</label>
                                <input type="text" id="card_number" name="card_number"
                                       class="form-control" placeholder="1234 5678 9012 3456"
                                       maxlength="19">
                                <?php if(!empty($errors['card_number'])): ?>
                                    <div class="form-error text-danger mt-1"><?php echo e($errors['card_number']); ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="expiry" class="form-label">Expiry Date</label>
                                    <input type="text" id="expiry" name="expiry"
                                           class="form-control" placeholder="MM/YY" maxlength="5">
                                    <?php if(!empty($errors['expiry'])): ?>
                                        <div class="form-error text-danger mt-1"><?php echo e($errors['expiry']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cvv" class="form-label">CVV</label>
                                    <input type="text" id="cvv" name="cvv"
                                           class="form-control" placeholder="123" maxlength="4">
                                    <?php if(!empty($errors['cvv'])): ?>
                                        <div class="form-error text-danger mt-1"><?php echo e($errors['cvv']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div class="form-group mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" id="full_name" name="full_name" class="form-control"
                               value="<?php echo e(old('full_name', $currentUser['name'] ?? '')); ?>" required>
                        <?php if(!empty($errors['full_name'])): ?>
                            <div class="form-error text-danger mt-1"><?php echo e($errors['full_name']); ?></div>
                        <?php endif; ?>
                    </div>

                    <div class="form-group mb-4">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                               value="<?php echo e(old('email', $currentUser['email'] ?? '')); ?>" required>
                        <?php if(!empty($errors['email'])): ?>
                            <div class="form-error text-danger mt-1"><?php echo e($errors['email']); ?></div>
                        <?php endif; ?>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2">
                        <?php if($plan['is_trial']): ?>
                            Start Free Trial
                        <?php else: ?>
                            Complete Payment - ₱<?php echo e(number_format($plan['price'], 0)); ?>

                        <?php endif; ?>
                    </button>
                </form>

                <div class="security-note mt-4">
                    <p><strong>🔒 Secure Payment:</strong> Your payment information is encrypted and secure.
                        We use industry-standard security measures to protect your data.
                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php $__env->startPush('scripts'); ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const paymentMethodSelect = document.getElementById('payment_method');
                const cardDetails = document.querySelector('.card-details');
                const form = document.querySelector('.payment-form');
                const submitBtn = form.querySelector('button[type="submit"]');

                if (paymentMethodSelect) {
                    paymentMethodSelect.addEventListener('change', function () {
                        if (this.value === 'card') {
                            cardDetails.style.display = 'block';
                            cardDetails.querySelectorAll('input').forEach(input => input.required = true);
                        } else {
                            cardDetails.style.display = 'none';
                            cardDetails.querySelectorAll('input').forEach(input => input.required = false);
                        }
                    });
                    paymentMethodSelect.dispatchEvent(new Event('change'));
                }

                // Card number formatting
                const cardNumberInput = document.getElementById('card_number');
                if (cardNumberInput) {
                    cardNumberInput.addEventListener('input', function () {
                        let value = this.value.replace(/\s/g, '').replace(/[^0-9]/g, '');
                        this.value = value.match(/.{1,4}/g)?.join(' ') ?? value;
                    });
                }

                // Expiry formatting
                const expiryInput = document.getElementById('expiry');
                if (expiryInput) {
                    expiryInput.addEventListener('input', function () {
                        let value = this.value.replace(/\D/g, '');
                        if (value.length >= 2) value = value.slice(0, 2) + '/' + value.slice(2, 4);
                        this.value = value;
                    });
                }

                // CVV numeric only
                const cvvInput = document.getElementById('cvv');
                if (cvvInput) {
                    cvvInput.addEventListener('input', function () {
                        this.value = this.value.replace(/\D/g, '');
                    });
                }

                // Disable button on submit
                form.addEventListener('submit', function () {
                    submitBtn.textContent = 'Processing...';
                    submitBtn.disabled = true;
                });
            });
        </script>
    <?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\index\subscribe.blade.php ENDPATH**/ ?>