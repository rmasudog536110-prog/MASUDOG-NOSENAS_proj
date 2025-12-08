<?php $__env->startSection('title', 'Dashboard - FitClub'); ?>
<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<?php if($userSubscription && $userSubscription->status === 'active'): ?>
<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>


    
    <?php if(session('success')): ?>
        <div class="flash-message success">
            <div class="container"><?php echo e(session('success')); ?></div>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="flash-message error">
            <div class="container"><?php echo e(session('error')); ?></div>
        </div>
    <?php endif; ?>

    <?php if(session('warning')): ?>
        <div class="flash-message warning">
            <div class="container"><?php echo e(session('warning')); ?></div>
        </div>
    <?php endif; ?>

    <div class="dashboard-container">
        <!-- Welcome Section -->
        <div class="dashboard-welcome">

            <?php if(session('success')): ?>
                <h1 class="welcome-title session-welcome">
                    👋 Welcome back, <?php echo e(Auth::user()->name); ?>!
                </h1>
            <?php endif; ?>

            <?php if(!empty($subtitle)): ?>
                <p class="welcome-subtitle"><?php echo e($subtitle); ?></p>
            <?php endif; ?>

            <h1 class="welcome-title main-title">
                FITCLUB <br> 
                <span>Results start here. Push yourself because no one else will.</span>
            </h1>
        </div>
    </div>

<?php if($userSubscription && $userSubscription->status === 'active'): ?>
    <!-- Quick Actions Section -->
    <div class="dashboard-container1">
            <h2 class="section-title">
                <i class="fa-solid fa-bolt"></i> Quick Actions
            </h2>

        <div class="quick-actions-grid">

            
            <?php if($subscriptionStatus === 'active'): ?>

                <a href="<?php echo e(route('workout-logs.create')); ?>" class="action-card">
                    <span class="action-card-icon">➕</span>
                    <span class="action-card-text">Log Workout</span>
                </a>

                <a href="<?php echo e(route('programs.index')); ?>" class="action-card">
                    <span class="action-card-icon">🏋️</span>
                    <span class="action-card-text">Training Programs</span>
                </a>

                <a href="<?php echo e(route('exercises.index')); ?>" class="action-card">
                    <span class="action-card-icon">💪</span>
                    <span class="action-card-text">Exercise Library</span>
                </a>

                <a href="<?php echo e(route('workout-logs.index')); ?>" class="action-card">
                    <span class="action-card-icon">📊</span>
                    <span class="action-card-text">My Workouts</span>
                </a>

                <a href="#request-instructor-modal" data-bs-toggle="modal" class="action-card">
                    <span class="action-card-icon">👨‍🏫</span>
                    <span class="action-card-text">Request Instructor</span>
                </a>

                
                <a href="<?php echo e(route('profile.show')); ?>" class="action-card">
                    <span class="action-card-icon"><i class="fa-solid fa-user"></i></span>
                    <span class="action-card-text">Edit Profile</span>
                </a>

            <?php else: ?>
                
                <a href="<?php echo e(url('subscription')); ?>" class="btn btn-primary btn-sm">
                    <span class="action-card-icon">⭐</span>
                    <span class="action-card-text">
                        <?php echo e($subscriptionStatus === 'expired' ? 'Renew Plan' : 'Choose a Plan'); ?>

                    </span>
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
        <!-- Subscription Status Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-credit-card"></i> Subscription Status
                </h2>
            </div>

            <?php if($userSubscription): ?>
                <div class="subscription-card">
                    <div class="subscription-header">
                        <div class="subscription-plan">
                            <div class="plan-icon">
                                <?php if($userSubscription->plan->name === 'Pro Plan'): ?>
                                    <i class="fa-solid fa-crown"></i>
                                <?php elseif($userSubscription->plan->name === 'Basic Plan'): ?>
                                    <i class="fa-solid fa-star"></i>
                                <?php else: ?>
                                    <i class="fa-solid fa-rocket"></i>
                                <?php endif; ?>
                            </div>
                            <div class="plan-info">
                                <h3 class="plan-name"><?php echo e($userSubscription->plan->name); ?></h3>
                                <div class="plan-price">₱<?php echo e(number_format($userSubscription->plan->price ?? 0, 2)); ?></div>
                            </div>
                        </div>
                        <div class="subscription-status-badge">
                            <?php
                                $statusClass = match($subscriptionStatus) {
                                    'active' => 'status-active',
                                    'expired' => 'status-expired',
                                    'pending' => 'status-pending',
                                    'rejected' => 'status-rejected',
                                    'cancelled' => 'status-cancelled',
                                    default => 'status-unknown'
                                };
                            ?>
                            <span class="status-badge <?php echo e($statusClass); ?>">
                                <?php if($subscriptionStatus === 'active'): ?>
                                    <i class="fa-solid fa-check-circle"></i> Active
                                <?php elseif($subscriptionStatus === 'expired'): ?>
                                    <i class="fa-solid fa-times-circle"></i> Expired
                                <?php elseif($subscriptionStatus === 'pending'): ?>
                                    <i class="fa-solid fa-clock"></i> Pending
                                <?php elseif($subscriptionStatus === 'rejected'): ?>
                                    <i class="fa-solid fa-exclamation-circle"></i> Rejected
                                <?php else: ?>
                                    <i class="fa-solid fa-question-circle"></i> <?php echo e(ucfirst($subscriptionStatus)); ?>

                                <?php endif; ?>
                            </span>
                        </div>
                    </div>

                    <div class="subscription-details-grid">
                        
                        <div class="detail-card">
                            <div class="detail-card-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="detail-card-content">
                                <div class="detail-card-label">Started On</div>
                                <div class="detail-card-value"><?php echo e(\Carbon\Carbon::parse($userSubscription->start_date)->format('M j, Y')); ?></div>
                            </div>
                        </div>


                        <?php if($subscriptionExpiry): ?>
                            <div class="detail-card">
                                <div class="detail-card-icon">
                                    <i class="fa-solid fa-calendar-alt"></i>
                                </div>
                                <div class="detail-card-content">
                                    <div class="detail-card-label"><?php echo e($subscriptionStatus === 'expired' ? 'Expired On' : 'Expires On'); ?></div>
                                    <div class="detail-card-value"><?php echo e($subscriptionExpiry->format('M j, Y')); ?></div>
                                </div>
                            </div>

                            <?php if($subscriptionStatus !== 'expired'): ?>
                                <div class="detail-card">
                                    <div class="detail-card-icon">
                                        <i class="fa-solid fa-hourglass-half"></i>
                                    </div>
                                    <div class="detail-card-content">
                                        <div class="detail-card-label">Days Remaining</div>
                                        <div class="detail-card-value"><?php echo e($daysLeft); ?> days</div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>

                        <div class="detail-card">
                            <div class="detail-card-icon">
                                <i class="fa-solid fa-money-bill-wave"></i>
                            </div>
                            <div class="detail-card-content">
                                <div class="detail-card-label">Amount Paid</div>
                                <div class="detail-card-value price-display">₱<?php echo e(number_format($userSubscription->plan->price ?? 0, 2)); ?></div>
                            </div>
                        </div>
                    </div>

                    <?php if($subscriptionStatus === 'pending'): ?>
                        <div class="subscription-alert alert-pending">
                            <i class="fa-solid fa-hourglass-half"></i>
                            <div class="alert-content">
                                <strong>Payment Verification:</strong> Your payment proof is being reviewed by our admin team. You'll be notified once approved.
                            </div>
                        </div>
                    <?php elseif($subscriptionStatus === 'rejected' && $userSubscription->admin_notes): ?>
                        <div class="subscription-alert alert-rejected">
                            <i class="fa-solid fa-exclamation-triangle"></i>
                            <div class="alert-content">
                                <strong>Payment Rejected:</strong> <?php echo e($userSubscription->admin_notes); ?>

                                <div class="alert-actions">
                                    <a href="<?php echo e(url('#subscription-plans')); ?>" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-redo"></i> Try Again
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php elseif($subscriptionStatus === 'expired'): ?>
                        <div class="subscription-alert alert-expired">
                            <i class="fa-solid fa-clock"></i>
                            <div class="alert-content">
                                <strong>Subscription Expired:</strong> Your subscription has expired. Renew to continue enjoying our services.
                                <div class="alert-actions">
                                    <a href="<?php echo e(url('#subscription-plans')); ?>" class="btn btn-primary btn-sm">
                                        <i class="fa-solid fa-star"></i> Renew Plan
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="empty-state-card">
                    <div class="empty-state-icon">
                        <i class="fa-solid fa-credit-card"></i>
                    </div>
                    <h3>No Active Subscription</h3>
                    <p>You don't have an active subscription. Choose a plan to unlock all features.</p>
                    <a href="<?php echo e(url('#subscription-plans')); ?>" class="btn btn-primary">
                        <i class="fa-solid fa-star"></i> Choose a Plan
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Recent Activities Section -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-clock-rotate-left"></i> Recent Activities
                </h2>
                <div class="section-actions"> 
                <?php if($subscriptionStatus === 'pending' || $subscriptionStatus === 'expired'): ?>
                    <?php if(auth()->guard()->check()): ?>
                        <div class="user-info">
                            <form method="POST" action="<?php echo e(route('logout')); ?>">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline">Logout</button>
                            </form>
                        </div>
                     <?php endif; ?>
                <?php else: ?>
                    <a href="<?php echo e(route('workout-logs.index')); ?>" class="btn btn-primary btn-sm">
                        <i class="fa-solid fa-magnifying-glass" style="margin-right: 10px;"></i> View All
                     </a>
                <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($recentActivities)): ?>
                <?php $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="activity-item">
                        <span class="activity-icon">🏋️</span>
                        <div class="activity-info">
                            <span class="activity-name">
                                <?php echo e($activity['exercise_name'] ?? $activity['program_title'] ?? 'Workout'); ?>

                            </span>
                            <?php if(!empty($activity['sets_completed']) || !empty($activity['reps_completed'])): ?>
                                <span class="activity-meta">
                                    <?php if(!empty($activity['sets_completed'])): ?>
                                        <?php echo e($activity['sets_completed']); ?> sets
                                    <?php endif; ?>
                                    <?php if(!empty($activity['reps_completed'])): ?>
                                        × <?php echo e($activity['reps_completed']); ?> reps
                                    <?php endif; ?>
                                    <?php if(!empty($activity['weight_used'])): ?>
                                        @ <?php echo e($activity['weight_used']); ?>kg
                                    <?php endif; ?>
                                </span>
                            <?php endif; ?>
                        </div>
                        <span class="activity-date">
                            <?php echo e(\Carbon\Carbon::parse($activity['workout_date'])->format('M j')); ?>

                        </span>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <p>No workout activities yet.</p>
                    <?php if(in_array($subscriptionStatus, ['active', 'trial'])): ?>
                        <a href="<?php echo e(route('programs.index')); ?>" class="btn btn-primary" style="margin-top: 1rem;">
                            <i class="fa-solid fa-play"></i> Start First Workout
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>    

    <?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <!-- Instructor Request Modal -->
    <div class="modal fade" id="request-instructor-modal" tabindex="-1" aria-labelledby="request-instructor-modal-label" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" style="background: var(--card); border: 1px solid rgba(255, 102, 0, 0.2);">
                <div class="modal-header" style="border-bottom: 1px solid rgba(255, 102, 0, 0.2);">
                    <h5 class="modal-title" id="request-instructor-modal-label" style="color: var(--primary);">
                        <i class="fa-solid fa-dumbbell"></i> Request Personal Instructor
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="<?php echo e(route('instructor.requests.store')); ?>" method="POST" id="instructor-request-form">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="preferred_date" class="form-label" style="color: var(--foreground);">Preferred Date</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="preferred_date" 
                                       name="preferred_date" 
                                       min="<?php echo e(date('Y-m-d')); ?>"
                                       required
                                       style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground);">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="preferred_time" class="form-label" style="color: var(--foreground);">Preferred Time</label>
                                <input type="time" 
                                       class="form-control" 
                                       id="preferred_time" 
                                       name="preferred_time" 
                                       required
                                       style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground);">
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="exercise_type" class="form-label" style="color: var(--foreground);">Exercise Type</label>
                            <select class="form-select" 
                                    id="exercise_type" 
                                    name="exercise_type" 
                                    required
                                    style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground);">
                                <option value="">Select Exercise Type</option>
                                <option value="strength">💪 Strength Training</option>
                                <option value="cardio">🏃 Cardio</option>
                                <option value="yoga">🧘 Yoga</option>
                                <option value="pilates">🤸 Pilates</option>
                                <option value="crossfit">⚡ CrossFit</option>
                                <option value="bodybuilding">🏋️ Bodybuilding</option>
                                <option value="rehabilitation">🏥 Rehabilitation</option>
                                <option value="weight_loss">📉 Weight Loss</option>
                                <option value="flexibility">🤸‍♂️ Flexibility</option>
                                <option value="functional">🔧 Functional Training</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="goals" class="form-label" style="color: var(--foreground);">Your Goals & Requirements</label>
                            <textarea class="form-control" 
                                      id="goals" 
                                      name="goals" 
                                      rows="4" 
                                      placeholder="Tell us about your fitness goals, experience level, injuries, equipment preferences, etc."
                                      style="background: rgba(255, 102, 0, 0.05); border: 1px solid rgba(255, 102, 0, 0.2); color: var(--foreground); resize: vertical;"
                                      required></textarea>
                        </div>
                        
                        <div class="alert alert-info" style="background: rgba(255, 102, 0, 0.1); border: 1px solid rgba(255, 102, 0, 0.3); color: var(--foreground);">
                            <i class="fa-solid fa-info-circle"></i>
                            <strong>How it works:</strong> Our instructors will review your request and get back to you with scheduling options and recommendations.
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(255, 102, 0, 0.2);">
                        <button type="button" class="btn btn-outline" data-bs-dismiss="modal" style="color: var(--muted-foreground);">Cancel</button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-paper-plane"></i> Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/index/user_dashboard.blade.php ENDPATH**/ ?>