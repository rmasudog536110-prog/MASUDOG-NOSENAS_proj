<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subscribe - <?php echo htmlspecialchars($plan['name']); ?> Plan - FitClub</title>
    <link rel="stylesheet" href="../HTML-CSS/styles.css">
        <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
     @include('index.header')

    <main class="content-section">
        <div class="container">
            <div class="subscription-container">
                <h1 class="text-center" style="margin-bottom: 3rem;">Complete Your Subscription</h1>
                
                <!-- Selected Plan Info -->
                <div class="selected-plan">
                    <h2><?php echo htmlspecialchars($plan['name']); ?> Plan</h2>
                    <div class="plan-price">
                        <span class="price">₱<?php echo number_format($plan['price'], 0); ?></span>
                        <span class="duration">
                            <?php 
                            if ($plan['duration_days'] == 7) echo '7 days';
                            elseif ($plan['duration_days'] == 30) echo 'per month';
                            elseif ($plan['duration_days'] == 90) echo '3 months';
                            elseif ($plan['duration_days'] == 365) echo 'per year';
                            ?>
                        </span>
                    </div>
                    <p><?php echo htmlspecialchars($plan['description']); ?></p>
                    
                    <div class="plan-features">
                        <h4>What's included:</h4>
                        <ul>
                            <?php 
                            $features = json_decode($plan['features'], true);
                            foreach ($features as $feature): 
                            ?>
                                <li><?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
                
                <?php if (isset($errors['general'])): ?>
                    <div class="flash-message error">
                        <?php echo htmlspecialchars($errors['general']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($errors['payment'])): ?>
                    <div class="flash-message error">
                        <?php echo htmlspecialchars($errors['payment']); ?>
                    </div>
                <?php endif; ?>
                
                <!-- Payment Form -->
                <form method="POST" action="" class="payment-form">
                    <?php if (!$plan['is_trial']): ?>
                        <div class="form-group">
                            <label for="payment_method">Payment Method</label>
                            <select id="payment_method" name="payment_method" class="form-control" required>
                                <option value="">Select Payment Method</option>
                                <option value="gcash" <?php echo ($_POST['payment_method'] ?? '') === 'gcash' ? 'selected' : ''; ?>>GCash</option>
                                <option value="paymaya" <?php echo ($_POST['payment_method'] ?? '') === 'paymaya' ? 'selected' : ''; ?>>PayMaya</option>
                                <option value="card" <?php echo ($_POST['payment_method'] ?? '') === 'card' ? 'selected' : ''; ?>>Credit/Debit Card</option>
                                <option value="bank" <?php echo ($_POST['payment_method'] ?? '') === 'bank' ? 'selected' : ''; ?>>Bank Transfer</option>
                            </select>
                            <?php if (isset($errors['payment_method'])): ?>
                                <div class="form-error"><?php echo htmlspecialchars($errors['payment_method']); ?></div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="card-details" style="display: none;">
                            <div class="form-group">
                                <label for="card_number">Card Number</label>
                                <input 
                                    type="text" 
                                    id="card_number" 
                                    name="card_number" 
                                    class="form-control"
                                    placeholder="1234 5678 9012 3456"
                                    maxlength="19"
                                >
                                <?php if (isset($errors['card_number'])): ?>
                                    <div class="form-error"><?php echo htmlspecialchars($errors['card_number']); ?></div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="card-row">
                                <div class="form-group">
                                    <label for="expiry">Expiry Date</label>
                                    <input 
                                        type="text" 
                                        id="expiry" 
                                        name="expiry" 
                                        class="form-control"
                                        placeholder="MM/YY"
                                        maxlength="5"
                                    >
                                    <?php if (isset($errors['expiry'])): ?>
                                        <div class="form-error"><?php echo htmlspecialchars($errors['expiry']); ?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="form-group">
                                    <label for="cvv">CVV</label>
                                    <input 
                                        type="text" 
                                        id="cvv" 
                                        name="cvv" 
                                        class="form-control"
                                        placeholder="123"
                                        maxlength="4"
                                    >
                                    <?php if (isset($errors['cvv'])): ?>
                                        <div class="form-error"><?php echo htmlspecialchars($errors['cvv']); ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input 
                            type="text" 
                            id="full_name" 
                            name="full_name" 
                            class="form-control"
                            value="<?php echo htmlspecialchars($_POST['full_name'] ?? $currentUser['name']); ?>"
                            required
                        >
                        <?php if (isset($errors['full_name'])): ?>
                            <div class="form-error"><?php echo htmlspecialchars($errors['full_name']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control"
                            value="<?php echo htmlspecialchars($_POST['email'] ?? $currentUser['email']); ?>"
                            required
                        >
                        <?php if (isset($errors['email'])): ?>
                            <div class="form-error"><?php echo htmlspecialchars($errors['email']); ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-full">
                        <?php if ($plan['is_trial']): ?>
                            Start Free Trial
                        <?php else: ?>
                            Complete Payment - ₱<?php echo number_format($plan['price'], 0); ?>
                        <?php endif; ?>
                    </button>
                </form>
                
                <div class="security-note">
                    <p><strong>🔒 Secure Payment:</strong> Your payment information is encrypted and secure. We use industry-standard security measures to protect your data.</p>
                </div>
            </div>
        </div>
    </main>

     @include('index.footer')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const paymentMethodSelect = document.getElementById('payment_method');
            const cardDetails = document.querySelector('.card-details');
            const form = document.querySelector('.payment-form');
            const submitBtn = form.querySelector('button[type="submit"]');
            
            // Show/hide card details based on payment method
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', function() {
                    if (this.value === 'card') {
                        cardDetails.style.display = 'block';
                        // Make card fields required
                        cardDetails.querySelectorAll('input').forEach(input => {
                            input.required = true;
                        });
                    } else {
                        cardDetails.style.display = 'none';
                        // Remove required from card fields
                        cardDetails.querySelectorAll('input').forEach(input => {
                            input.required = false;
                        });
                    }
                });
                
                // Trigger change event for pre-selected values
                paymentMethodSelect.dispatchEvent(new Event('change'));
            }
            
            // Card number formatting
            const cardNumberInput = document.getElementById('card_number');
            if (cardNumberInput) {
                cardNumberInput.addEventListener('input', function() {
                    let value = this.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
                    let matches = value.match(/\d{4,16}/g);
                    let match = matches && matches[0] || '';
                    let parts = [];
                    
                    for (let i = 0, len = match.length; i < len; i += 4) {
                        parts.push(match.substring(i, i + 4));
                    }
                    
                    if (parts.length) {
                        this.value = parts.join(' ');
                    } else {
                        this.value = value;
                    }
                });
            }
            
            // Expiry date formatting
            const expiryInput = document.getElementById('expiry');
            if (expiryInput) {
                expiryInput.addEventListener('input', function() {
                    let value = this.value.replace(/\D/g, '');
                    if (value.length >= 2) {
                        value = value.substring(0, 2) + '/' + value.substring(2, 4);
                    }
                    this.value = value;
                });
            }
            
            // CVV numeric only
            const cvvInput = document.getElementById('cvv');
            if (cvvInput) {
                cvvInput.addEventListener('input', function() {
                    this.value = this.value.replace(/\D/g, '');
                });
            }
            
            // Form submission
            form.addEventListener('submit', function(e) {
                const originalText = submitBtn.textContent;
                submitBtn.textContent = 'Processing...';
                submitBtn.disabled = true;
                
                // Re-enable button if there are PHP validation errors
                setTimeout(function() {
                    if (<?php echo !empty($errors) ? 'true' : 'false'; ?>) {
                        submitBtn.textContent = originalText;
                        submitBtn.disabled = false;
                    }
                }, 100);
            });
        });
    </script>
</body>
</html>