<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FitClub</title>
  
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../HTML-CSS/dashboard.css">
    <link rel="stylesheet" href="../HTML-CSS/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../PHP/header.php'; ?>

    <?php $successMessage = $_GET['success'] ?? '';
    $errorMessage = $_GET['error'] ?? '';
    ?>

    <!-- Flash Messages -->
    <?php if ($successMessage): ?>
        <div class="flash-message success">
            <div class="container">
                <?php echo htmlspecialchars($successMessage); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="flash-message error">
            <div class="container">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="flash-message warning">
            <div class="container">
                <?php echo htmlspecialchars($warningMessage); ?>
            </div>
        </div>
    <?php endif; ?>

    

    <main class="content-section">
        <div class="container">
            <h1>Welcome back, <?php echo htmlspecialchars($currentUser['name']); ?>!</h1>
            
            <div class="dashboard-grid">
                <!-- Subscription Status -->
                <div class="dashboard-card">
                    <h3>Subscription Status</h3>
                    <div class="subscription-info">
                        <?php if ($userSubscription): ?>
                            <div class="subscription-plan">
                                <strong>Plan:</strong> <?php echo htmlspecialchars($userSubscription['plan_name']); ?>
                            </div>
                            <div class="subscription-status <?php echo $subscriptionStatus; ?>">
                                <strong>Status:</strong> 
                                <?php 
                                switch ($subscriptionStatus) {
                                    case 'trial':
                                        echo 'Free Trial Active';
                                        break;
                                    case 'active':
                                        echo 'Premium Active';
                                        break;
                                    case 'expired':
                                        echo 'Expired';
                                        break;
                                    default:
                                        echo 'No Active Subscription';
                                }
                                ?>
                            </div>
                            <?php if ($subscriptionExpiry): ?>
                                <div class="subscription-expires">
                                    <strong>
                                        <?php echo $subscriptionStatus === 'expired' ? 'Expired on:' : 'Expires on:'; ?>
                                    </strong>
                                    <?php echo $subscriptionExpiry->format('F j, Y'); ?>
                                    <?php if ($subscriptionStatus !== 'expired'): ?>
                                        <br><small>(<?php echo $daysLeft; ?> days left)</small>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="subscription-amount">
                                <strong>Amount Paid:</strong> ₱<?php echo number_format($userSubscription['price'], 0); ?>
                            </div>
                        <?php else: ?>
                            <div class="no-subscription">
                                <p>You don't have an active subscription.</p>
                                <a href="index.php#subscription-plans" class="btn btn-primary" style="margin-top: 1rem;">Choose a Plan</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Progress Overview -->
                <div class="dashboard-card">
                    <h3>Progress Overview</h3>
                    <div class="progress-stats">
                        <div class="stat">
                            <span class="stat-value"><?php echo $workoutStats['total_workouts'] ?? 0; ?></span>
                            <span class="stat-label">Total Workouts</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo $workoutStats['weekly_workouts'] ?? 0; ?></span>
                            <span class="stat-label">This Week</span>
                        </div>
                        <div class="stat">
                            <span class="stat-value"><?php echo $workoutStats['days_active'] ?? 0; ?></span>
                            <span class="stat-label">Days Active</span>
                        </div>
                    </div>
                    
                    <div style="margin-top: 1.5rem;">
                        <?php if ($subscriptionStatus === 'active' || $subscriptionStatus === 'trial'): ?>
                            <a href="programs.php" class="btn btn-primary btn-full">Start New Workout</a>
                        <?php else: ?>
                            <p style="text-align: center; color: var(--muted-foreground);">
                                Subscribe to access workout programs
                            </p>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Activities -->
                <div class="dashboard-card">
                    <h3>Recent Activities</h3>
                    <div class="activity-list">
                        <?php if (!empty($recentActivities)): ?>
                            <?php foreach ($recentActivities as $activity): ?>
                                <div class="activity-item">
                                    <div class="activity-details">
                                        <span class="activity-name">
                                            <?php echo htmlspecialchars($activity['exercise_name'] ?? $activity['program_title'] ?? 'Workout'); ?>
                                        </span>
                                        <?php if ($activity['sets_completed'] || $activity['reps_completed']): ?>
                                            <small class="activity-meta">
                                                <?php if ($activity['sets_completed']): ?>
                                                    <?php echo $activity['sets_completed']; ?> sets
                                                <?php endif; ?>
                                                <?php if ($activity['reps_completed']): ?>
                                                    × <?php echo $activity['reps_completed']; ?> reps
                                                <?php endif; ?>
                                                <?php if ($activity['weight_used']): ?>
                                                    @ <?php echo $activity['weight_used']; ?>kg
                                                <?php endif; ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                    <span class="activity-date">
                                        <?php echo date('M j', strtotime($activity['workout_date'])); ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="no-activities">
                                <p>No workout activities yet.</p>
                                <?php if ($subscriptionStatus === 'active' || $subscriptionStatus === 'trial'): ?>
                                    <a href="programs.php" class="btn btn-outline" style="margin-top: 1rem;">Start First Workout</a>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="dashboard-card">
                    <h3>Quick Actions</h3>
                    <div class="quick-actions">
                        <?php if ($subscriptionStatus === 'active' || $subscriptionStatus === 'trial'): ?>
                            <a href="../PHP/programs.php" class="action-btn">
                                <span class="action-icon">🏋️</span>
                                <span>Training Programs</span>
                            </a>
                            <a href="exercises.php" class="action-btn">
                                <span class="action-icon">💪</span>
                                <span>Exercise Library</span>
                            </a>
                        <?php endif; ?>
                        
                        <a href="profile.php" class="action-btn">
                            <span class="action-icon">👤</span>
                            <span>Edit Profile</span>
                        </a>
                        
                        <?php if ($subscriptionStatus === 'expired' || !$userSubscription): ?>
                            <a href="index.php#subscription-plans" class="action-btn">
                                <span class="action-icon">⭐</span>
                                <span>Upgrade Plan</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Subscription History -->
                <?php if (!empty($subscriptionHistory)): ?>
                <div class="dashboard-card">
                    <h3>Subscription History</h3>
                    <div class="subscription-history">
                        <?php foreach (array_slice($subscriptionHistory, 0, 3) as $subscription): ?>
                            <div class="history-item">
                                <div class="history-details">
                                    <span class="history-plan"><?php echo htmlspecialchars($subscription['plan_name']); ?></span>
                                    <span class="history-period">
                                        <?php echo date('M j, Y', strtotime($subscription['start_date'])); ?> - 
                                        <?php echo date('M j, Y', strtotime($subscription['end_date'])); ?>
                                    </span>
                                </div>
                                <div class="history-amount">
                                    ₱<?php echo number_format($subscription['price'], 0); ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        
                        <?php if (count($subscriptionHistory) > 3): ?>
                            <div class="text-center" style="margin-top: 1rem;">
                                <a href="subscription-history.php" class="btn btn-outline">View All History</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php include '../PHP/footer.php'; ?>
</body>
</html>