<?php $__env->startSection('title', 'Instructor Dashboard - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="content-section">
    <div class="container">
        <!-- Welcome Section -->
        <div class="dashboard-welcome" id="dashboard-welcome">
            <button class="close-btn" onclick="closeWelcome()">×</button>
            <h1 class="welcome-title">👋 Welcome back, <?php echo e(Auth::user()->name); ?>!</h1>
            <p class="welcome-subtitle">Ready to help your clients achieve their fitness goals?</p>
        </div>


        <!-- Flash Messages -->
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

        <!-- Instructor Header -->
        <div class="instructor-header">
            <h1><i class="fas fa-dumbbell"></i> Instructor Dashboard</h1>
            <p class="subtitle" style="text-align: center">Manage your sessions and help clients reach their fitness goals</p>
        </div>

        <!-- Stats Grid -->
        <div class="instructor-stats">
            <div class="instructor-stat-card">
                <div class="stat-label">Total Requests</div>
                <div class="stat-value count-display"><?php echo e($stats['total_requests']); ?></div>
            </div>

            <div class="instructor-stat-card stat-card-pending">
                <div class="stat-label">⏳ Pending</div>
                <div class="stat-value count-display"><?php echo e($stats['pending_requests']); ?></div>
            </div>

            <div class="instructor-stat-card stat-card-completed">
                <div class="stat-label">✅ Accepted</div>
                <div class="stat-value count-display"><?php echo e($stats['accepted_requests']); ?></div>
            </div>

            <div class="instructor-stat-card stat-card-completed">
                <div class="stat-label">🎯 Completed</div>
                <div class="stat-value count-display"><?php echo e($stats['completed_sessions']); ?></div>
            </div>

            <div class="instructor-stat-card">
                <div class="stat-label">📊 Success Rate</div>
                <div class="progress-ring">
                    <svg class="progress-ring" width="120" height="120">
                        <circle class="progress-ring-circle" cx="60" cy="60" r="48"></circle>
                        <circle class="progress-ring-circle-progress" 
                                cx="60" 
                                cy="60" 
                                r="48"
                                data-progress="<?php echo e($completionRate); ?>"></circle>
                    </svg>
                    <div class="progress-text"><?php echo e($completionRate); ?>%</div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="dashboard-section">
            <h2 class="section-title">
                <i class="fa-solid fa-bolt"></i> Quick Actions
            </h2>
            <div class="quick-actions">
                <a href="<?php echo e(route('instructor.requests')); ?>" class="action-btn">
                    <i class="fa-solid fa-list"></i>
                    View All Requests
                </a>
                <a href="<?php echo e(route('instructor.requests', ['status' => 'pending'])); ?>" class="action-btn">
                    <i class="fa-solid fa-clock"></i>
                    Pending Requests (<?php echo e($stats['pending_requests']); ?>)
                </a>
                <a href="#schedule-modal" class="action-btn" data-bs-toggle="modal">
                    <i class="fa-solid fa-calendar-plus"></i>
                    Schedule Session
                </a>
                <a href="<?php echo e(route('profile.show')); ?>" class="action-btn">
                    <i class="fa-solid fa-user"></i>
                    Edit Profile
                </a>
            </div>
        </div>

        <div class="dashboard-grid">
            <!-- Today's Sessions -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-calendar-day"></i> Today's Sessions
                </h2>

                <?php if($todaySessions->count() > 0): ?>
                    <div class="session-list">
                        <?php $__currentLoopData = $todaySessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="session-item">
                                <div class="session-info">
                                    <div class="session-customer"><?php echo e($session->customer->name); ?></div>
                                    <div class="session-details">
                                        <?php if($session->exercise_type): ?>
                                            <i class="fa-solid fa-dumbbell"></i> <?php echo e(ucfirst($session->exercise_type)); ?>

                                        <?php endif; ?>
                                        <?php if($session->goals): ?>
                                            <br><small><?php echo e(Str::limit($session->goals, 50)); ?></small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="session-time">
                                    <div><?php echo e($session->scheduled_at->format('g:i A')); ?></div>
                                    <div class="request-status">
                                        <?php echo $session->status_badge; ?>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">📅</div>
                        <p>No sessions scheduled for today</p>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Upcoming Sessions -->
            <div class="dashboard-section">
                <h2 class="section-title">
                    <i class="fa-solid fa-calendar-week"></i> Upcoming Sessions
                </h2>

                <?php if($upcomingSessions->count() > 0): ?>
                    <div class="session-list">
                        <?php $__currentLoopData = $upcomingSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="session-item">
                                <div class="session-info">
                                    <div class="session-customer"><?php echo e($session->customer->name); ?></div>
                                    <div class="session-details">
                                        <?php echo e($session->scheduled_at->format('M j, g:i A')); ?>

                                        <?php if($session->exercise_type): ?>
                                            <br><i class="fa-solid fa-dumbbell"></i> <?php echo e(ucfirst($session->exercise_type)); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="request-status">
                                    <?php echo $session->status_badge; ?>

                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php else: ?>
                    <div class="empty-state">
                        <div class="empty-state-icon">🔮</div>
                        <p>No upcoming sessions scheduled</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Recent Requests -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-clock-rotate-left"></i> Recent Requests
                </h2>
                <a href="<?php echo e(route('instructor.requests')); ?>" class="btn btn-primary btn-sm">
                    <i class="fa-solid fa-magnifying-glass" style="margin-right: 0.5rem;"></i>
                    View All
                </a>
            </div>

            <?php if($recentRequests->count() > 0): ?>
                <div class="table-responsive">
                    <table style="width: 100%; background: var(--card); border-radius: var(--radius); overflow: hidden;">
                        <thead>
                            <tr style="background: rgba(255, 102, 0, 0.1);">
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Customer</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Preferred Date</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Exercise Type</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Status</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid rgba(255, 102, 0, 0.1);">
                                    <td style="padding: 1rem;">
                                        <div style="font-weight: 600;"><?php echo e($request->customer->name); ?></div>
                                        <div style="font-size: 0.875rem; color: var(--muted-foreground);">
                                            <?php echo e($request->customer->email); ?>

                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        <?php echo e($request->preferred_date_time); ?>

                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        <?php if($request->exercise_type): ?>
                                            <?php echo e(ucfirst($request->exercise_type)); ?>

                                        <?php else: ?>
                                            <span style="color: var(--muted-foreground);">Not specified</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php echo $request->status_badge; ?>

                                    </td>
                                    <td style="padding: 1rem;">
                                        <a href="<?php echo e(route('instructor.requests.show', $request)); ?>" 
                                           class="btn btn-outline btn-sm">
                                            <i class="fa-solid fa-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <p>No instructor requests yet</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Auto-update dashboard every 30 seconds for real-time updates
    setInterval(function() {
        // Optionally implement real-time updates here
        console.log('Dashboard auto-refresh');
    }, 30000);

    // Initialize progress rings
    function initProgressRings() {
        const circles = document.querySelectorAll('.progress-ring-circle-progress');
        circles.forEach(circle => {
            const progress = circle.getAttribute('data-progress') || 0;
            const circumference = 2 * Math.PI * 48; // 2 * π * radius (48)
            const offset = circumference - (progress / 100) * circumference;
            circle.style.strokeDasharray = circumference;
            circle.style.strokeDashoffset = offset;
        });
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', initProgressRings);
    // Auto-hide after 5 seconds
    setTimeout(() => {
        const welcome = document.getElementById('dashboard-welcome');
        if (welcome) {
            welcome.classList.add('hide');
        }
    }, 5000);

    // Close button function
function closeWelcome() {
    const welcome = document.getElementById('dashboard-welcome');
    if (welcome) {
        welcome.classList.add('hide');

        // Remove from DOM after animation
        welcome.addEventListener('transitionend', () => {
            if (welcome.parentNode) {
                welcome.parentNode.removeChild(welcome);
            }
        });
    }
}

// Auto-hide after 5 seconds
setTimeout(closeWelcome, 5000);

</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/instructor/instructor_dashboard.blade.php ENDPATH**/ ?>