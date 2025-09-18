<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FitClub - Premium Gym Membership</title>
    <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
     <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <!-- Font Awesome JS -->
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../HTML-CSS/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../PHP/header.php'; ?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Transform Your Body, Transform Your Life</h1>
                <p>Join thousands of members who have achieved their fitness goals with our premium training programs and expert guidance.</p>
                <?php if (!$currentUser): ?>
                    <a href="#subscription-plans" class="btn btn-primary cta-btn">Start Your Free Trial</a>
                <?php else: ?>
                    <a href="dashboard.php" class="btn btn-primary cta-btn">Go to Dashboard</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Subscription Plans -->
    <section class="subscription-plans" id="subscription-plans">
        <div class="container">
            <h2>Choose Your Plan</h2>
            <div class="plans-grid">
                <?php foreach ($plans as $plan): ?>
                    <div class="plan-card <?php echo $plan['name'] === 'Quarterly' ? 'popular' : ''; ?> <?php echo $plan['is_trial'] ? 'trial-plan' : ''; ?>">
                        <?php if ($plan['name'] === 'Quarterly'): ?>
                            <div class="plan-badge">Most Popular</div>
                        <?php endif; ?>
                        
                        <div class="plan-header">
                            <h3><?php echo htmlspecialchars($plan['name']); ?></h3>
                            <div class="plan-price">
                                <span class="price">₱<?php echo number_format($plan['price'], 0); ?></span>
                                <span class="duration">
                                    <?php 
                                    if ($plan['duration_days'] == 7) echo '7 days';
                                    elseif ($plan['duration_days'] == 30) echo 'per month';
                                    elseif ($plan['duration_days'] == 90) echo '3 months';
                                    ?>
                                </span>
                            </div>
                        </div>
                        
                        <ul class="plan-features">
                            <?php 
                            $features = json_decode($plan['features'], true);
                            foreach ($features as $feature): 
                            ?>
                                <li><?php echo htmlspecialchars($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        
                        <?php if ($currentUser): ?>
                            <?php if ($userSubscription && $userSubscription['plan_id'] == $plan['id']): ?>
                                <button class="btn btn-outline" disabled>Current Plan</button>
                            <?php else: ?>
                                <a href="subscribe.php?plan=<?php echo $plan['id']; ?>" class="btn <?php echo $plan['is_trial'] ? 'btn-outline' : 'btn-primary'; ?>">
                                    <?php echo $plan['is_trial'] ? 'Start Free Trial' : 'Subscribe Now'; ?>
                                </a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a href="register.php?plan=<?php echo $plan['id']; ?>" class="btn <?php echo $plan['is_trial'] ? 'btn-outline' : 'btn-primary'; ?>">
                                <?php echo $plan['is_trial'] ? 'Start Free Trial' : 'Subscribe Now'; ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Training Programs Preview -->
    <section class="training-preview">
        <div class="container">
            <h2>Preview Our Training Programs</h2>
            <div class="programs-grid">
                <div class="program-card">
                    <h3>Beginner Fitness</h3>
                    <p>Perfect for those starting their fitness journey. Build foundation strength and learn proper form.</p>
                    <div class="program-meta">
                        <span class="duration">4-6 weeks</span>
                        <span class="level">Beginner</span>
                    </div>
                </div>
                <div class="program-card">
                    <h3>Strength Builder</h3>
                    <p>Intermediate program focused on building muscle mass and increasing overall strength.</p>
                    <div class="program-meta">
                        <span class="duration">8-12 weeks</span>
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
            
            <?php if ($currentUser): ?>
                <div class="text-center" style="margin-top: 2rem;">
                    <a href="programs.php" class="btn btn-primary">View All Programs</a>
                </div>
            <?php else: ?>
                <div class="text-center" style="margin-top: 2rem;">
                    <a href="../PHP/register.php" class="btn btn-primary">Sign Up to Access Programs</a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2>Why Choose FitClub?</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🏋️</div>
                    <h3>Expert Training</h3>
                    <p>Access to professional-grade training programs designed by certified fitness experts.</p>
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

    <?php include '../PHP/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="script.js"></script>
</body>
</html>