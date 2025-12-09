<?php $__env->startSection('title', 'Submit Payment - FitClub'); ?>

<?php $__env->startSection('content'); ?>

<div class="payment-container py-5" style="background-color: var(--background); min-height: 100vh;">
    <div class="payment-card" 
         style="max-width: 700px; margin: 0 auto; background-color: var(--card) !important; 
                color: var(--foreground) !important; border-radius: var(--radius); padding: 2rem; box-shadow: 0 4px 15px rgba(0,0,0,0.5);">
        
        <!-- Header -->
        <div class="payment-header text-center mb-4">
            <h1 style="color: var(--primary);">💳 Submit Payment</h1>
            <p>Upload your payment proof for verification</p>
        </div>

        <!-- Flash message -->
        <?php if(session('success')): ?>
            <div class="alert alert-success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Plan Summary -->
        <div class="plan-summary mb-4">
            <h3><?php echo e($plan->name ?? $subscription->plan->name); ?></h3>
            <div class="plan-detail d-flex justify-between">
                <span class="plan-detail-label">Duration</span>
                <span class="plan-detail-value duration-display"><?php echo e($plan->duration ?? 'N/A'); ?> days</span>
            </div>
            <div class="plan-detail d-flex justify-between">
                <span class="plan-detail-label">Price</span>
                <span class="plan-detail-value price-display">₱<?php echo e(number_format($plan->price ?? $subscription->plan->price, 2)); ?></span>
            </div>
            <?php if(isset($subscription->plan->description)): ?>
            <div class="plan-detail mt-2">
                <span class="plan-detail-label">Description:</span>
                <span class="plan-detail-value"><?php echo e($subscription->plan->description); ?></span>
            </div>
            <?php endif; ?>
        </div>

        <!-- Payment Instructions -->
        <div class="payment-instructions mb-4" style="color: #fff;">
            <h4>📋 Payment Instructions</h4>
            <ol>
                <li>Select your preferred payment method below</li>
                <li>Transfer the amount according to the instructions</li>
                <li>Take a screenshot or photo of the payment receipt</li>
                <li>Upload the payment proof below</li>
                <li>Wait for admin approval (usually within 24 hours)</li>
                <li>You'll receive a notification once approved</li>
            </ol>
        </div>

        <!-- Payment Form -->
        <form action="<?php echo e(route('subscription.payment.submit', $plan->id ?? $subscription->id)); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- Payment Method -->
            <div class="mb-3">
                <label for="payment_method" class="form-label">Select Payment Method</label>
                <select id="payment_method" name="payment_method" class="form-select" required onchange="togglePaymentInstructions()"
                        style="background-color: var(--muted); color: var(--foreground); border-radius: var(--radius);">
                    <option value="">-- Choose Method --</option>
                    <option value="gcash">GCash</option>
                    <option value="paymaya">PayMaya</option>
                    <option value="credit_card">Credit Card</option>
                    <option value="bank_transfer">Bank Transfer</option>
                </select>
            </div>

            <!-- Dynamic Instructions -->
            <div id="payment_instructions" class="p-3 mb-3" style="display: none; background-color: var(--accent); border-radius: var(--radius); color: #fff;">
                <h6 id="instruction_title" class="fw-bold mb-2"></h6>
                <p id="instruction_text" class="mb-0"></p>
            </div>

            <!-- Transaction Reference -->
            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID / Reference Number</label>
                <input 
                    type="text" 
                    id="transaction_id" 
                    name="transaction_reference" 
                    class="form-control" 
                    placeholder="Enter your transaction ID from the payment receipt" 
                    required
                    style="background-color: var(--muted); color: var(--foreground); border-radius: var(--radius);"
                >
            </div>

            <!-- Proof Upload -->
            <div class="mb-3">
                <label class="form-label">Upload Payment Proof</label>
                <input type="file" 
                       name="payment_proof" 
                       id="payment_proof" 
                       class="form-control" 
                       accept="image/*,.pdf" 
                       required
                       style="background-color: var(--muted); color: var(--foreground); border-radius: var(--radius);">
                <?php $__errorArgs = ['payment_proof'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Amount Display -->
            <div class="mb-3">
                <label class="form-label">Amount to Pay</label>
                <input type="text" class="form-control payment-amount" value="₱<?php echo e(number_format($plan->price ?? $subscription->plan->price, 2)); ?>" readonly
                       style="background-color: var(--muted); color: var(--foreground); border-radius: var(--radius);">
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn w-100" style="background-color: var(--primary); color: var(--foreground);">
                <i class="fa-solid fa-paper-plane"></i> Confirm Payment
            </button>
        </form>

            <div class="text-center mt-4">
                <form method="POST" action="<?php echo e(route('payment.cancel')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-outline" style="color: var(--primary);">
                        <i class="fa-solid fa-arrow-left"></i> Cancel
                    </button>
                </form>
            </div>

    </div>
</div>


<script>
    function togglePaymentInstructions() {
    const method = document.getElementById('payment_method').value;
    const container = document.getElementById('payment_instructions');
    const title = document.getElementById('instruction_title');
    const text = document.getElementById('instruction_text');

    if (!method) {
        container.style.display = 'none';
        return;
    }

    container.style.display = 'block';

    switch(method) {
        case 'gcash':
            title.textContent = 'GCash Payment Instructions';
            text.textContent = 'Send the exact amount to our GCash number: 0928-459-4158. After sending, enter your GCash reference number below.';
            break;
        case 'paymaya':
            title.textContent = 'PayMaya Payment Instructions';
            text.textContent = 'Pay via PayMaya using our merchant name: FitClub PH. Enter your PayMaya transaction ID after completing the payment.';
            break;
        case 'credit_card':
            title.textContent = 'Credit Card Payment';
            text.textContent = 'You will be redirected to our secure credit card processor after confirming.';
            break;
        case 'bank_transfer':
            title.textContent = 'Bank Transfer Instructions';
            text.textContent = 'Transfer the amount to: BDO Account #1234-5678-90, Name: FitClub PH. Upload your deposit slip for verification.';
            break;
    }
}

    history.pushState(null, "", location.href);

    window.onpopstate = function () {
        window.location.href = "<?php echo e(route('payment.cancel')); ?>";
    };


</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\subscriptions\payment-form.blade.php ENDPATH**/ ?>