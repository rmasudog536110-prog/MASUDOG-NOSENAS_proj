<?php $__env->startSection('title', 'My Profile - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css/profile.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php if(Auth::user() && Auth::user()->hasAdminAccess()): ?>
<?php echo $__env->make('admin.admin_header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php else: ?>
<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php endif; ?>

<section class="content-section">
    <div class="container">
        <!-- Flash Messages -->
        <?php if(session('success')): ?>
            <div class="flash-message success">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture-container">
                <?php if(Auth::user()->profile_picture): ?>
                    <img src="<?php echo e(Storage::url(Auth::user()->profile_picture)); ?>" 
                         alt="Profile Picture" 
                         class="profile-picture">
                <?php else: ?>
                    <div class="profile-picture-placeholder">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    </div>
                <?php endif; ?>
            </div>

            <h1 class="profile-name"><?php echo e(Auth::user()->name); ?></h1>
            <p class="profile-email"><?php echo e(Auth::user()->email); ?></p>

            <?php if(Auth::user()->bio): ?>
                <div class="profile-bio" style="max-width: 600px; margin: 1.5rem auto 0;">
                    <?php echo e(Auth::user()->bio); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Profile Actions -->
        <div class="profile-actions">
            <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary">
                <i class="fa-solid fa-edit"></i> Edit Profile
            </a>
            <a href="<?php echo e(route('user_dashboard')); ?>" class="btn btn-outline">
                <i class="fa-solid fa-dashboard"></i> Back to Dashboard
            </a>
        </div>

        <!-- Profile Information Grid -->
        <div class="profile-grid">
            <!-- Personal Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-user"></i> Personal Information</h3>

                <div class="profile-info-item">
                    <span class="profile-info-label">Full Name</span>
                    <span class="profile-info-value"><?php echo e(Auth::user()->name); ?></span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">Email</span>
                    <span class="profile-info-value"><?php echo e(Auth::user()->email); ?></span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">Phone</span>
                    <span class="profile-info-value"><?php echo e(Auth::user()->phone_number ?? 'Not provided'); ?></span>
                </div>

                <?php if(Auth::user()->date_of_birth): ?>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Date of Birth</span>
                        <span class="profile-info-value"><?php echo e(Auth::user()->date_of_birth->format('F j, Y')); ?></span>
                    </div>

                    <div class="profile-info-item">
                        <span class="profile-info-label">Age</span>
                        <span class="profile-info-value"><?php echo e(Auth::user()->getAge()); ?> years</span>
                    </div>
                <?php endif; ?>

                <?php if(Auth::user()->gender): ?>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Gender</span>
                        <span class="profile-info-value"><?php echo e(ucfirst(str_replace('_', ' ', Auth::user()->gender))); ?></span>
                    </div>
                <?php endif; ?>

                <div class="profile-info-item">
                    <span class="profile-info-label">Member Since</span>
                    <span class="profile-info-value"><?php echo e(Auth::user()->created_at->format('F Y')); ?></span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">Email Notifications</span>
                    <span class="profile-info-value">
                        <?php if(Auth::user()->email_notifications): ?>
                            <span class="badge badge-success">Enabled</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Disabled</span>
                        <?php endif; ?>
                    </span>
                </div>

                <div class="profile-info-item">
                    <span class="profile-info-label">SMS Notifications</span>
                    <span class="profile-info-value">
                        <?php if(Auth::user()->sms_notifications): ?>
                            <span class="badge badge-success">Enabled</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Disabled</span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            <!-- Fitness Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-dumbbell"></i> Fitness Profile</h3>

                <?php if(Auth::user()->height || Auth::user()->weight): ?>
                    <div class="stats-grid">
                        <?php if(Auth::user()->height): ?>
                            <div class="stat-box">
                                <div class="stat-box-value"><?php echo e(Auth::user()->height); ?></div>
                                <div class="stat-box-label">Height (cm)</div>
                            </div>
                        <?php endif; ?>

                        <?php if(Auth::user()->weight): ?>
                            <div class="stat-box">
                                <div class="stat-box-value"><?php echo e(Auth::user()->weight); ?></div>
                                <div class="stat-box-label">Weight (kg)</div>
                            </div>
                        <?php endif; ?>

                        <?php if(Auth::user()->getBMI()): ?>
                            <div class="stat-box">
                                <div class="stat-box-value"><?php echo e(Auth::user()->getBMI()); ?></div>
                                <div class="stat-box-label">BMI</div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <?php if(Auth::user()->getBMICategory()): ?>
                        <div style="margin-top: 1rem; text-align: center;">
                            <span class="badge 
                                <?php if(Auth::user()->getBMICategory() === 'Normal'): ?> badge-success
                                <?php elseif(in_array(Auth::user()->getBMICategory(), ['Underweight', 'Overweight'])): ?> badge-warning
                                <?php else: ?> badge-danger
                                <?php endif; ?>">
                                BMI Category: <?php echo e(Auth::user()->getBMICategory()); ?>

                            </span>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <p style="text-align: center; color: var(--muted-foreground); padding: 2rem 0;">
                        No fitness data yet. <a href="<?php echo e(route('profile.edit')); ?>" style="color: var(--primary);">Add your measurements</a>
                    </p>
                <?php endif; ?>

                <?php if(Auth::user()->fitness_goal): ?>
                    <div class="profile-info-item" style="margin-top: 1.5rem;">
                        <span class="profile-info-label">Fitness Goal</span>
                        <span class="profile-info-value"><?php echo e(Auth::user()->fitness_goal); ?></span>
                    </div>
                <?php endif; ?>

                <?php if(Auth::user()->experience_level): ?>
                    <div class="profile-info-item">
                        <span class="profile-info-label">Experience Level</span>
                        <span class="profile-info-value"><?php echo e(ucfirst(Auth::user()->experience_level)); ?></span>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Activity Stats -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-chart-line"></i> Activity Stats</h3>

                <div class="stats-grid">
                    <div class="stat-box">
                        <div class="stat-box-value"><?php echo e(Auth::user()->bodyMeasurements()->count()); ?></div>
                        <div class="stat-box-label">Measurements</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value"><?php echo e(Auth::user()->subscriptions()->count()); ?></div>
                        <div class="stat-box-label">Subscriptions</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value"><?php echo e(Auth::user()->instructorRequests()->count()); ?></div>
                        <div class="stat-box-label">Instructor Requests</div>
                    </div>

                    <div class="stat-box">
                        <div class="stat-box-value">
                            <?php echo e((int) \Carbon\Carbon::parse(Auth::user()->created_at)->diffInDays(\Carbon\Carbon::now())); ?>

                        </div>

                        <div class="stat-box-label">Days Member</div>
                    </div>
                </div>

                <?php if(Auth::user()->last_login_at): ?>
                    <div class="profile-info-item" style="margin-top: 1.5rem;">
                        <span class="profile-info-label">Last Login</span>
                        <span class="profile-info-value"><?php echo e(Auth::user()->last_login_at->diffForHumans()); ?></span>
                    </div>
                <?php endif; ?>
            </div>


        </div>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views/profile/show.blade.php ENDPATH**/ ?>