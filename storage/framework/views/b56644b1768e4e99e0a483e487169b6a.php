<?php $__env->startSection('title', 'My Instructor Requests - FitClub'); ?>

<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/dashboard.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<section class="content-section">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-welcome">
            <h1 class="welcome-title">👨‍🏫 My Instructor Requests</h1>
            <p class="welcome-subtitle">Track your personal training session requests and instructor communications</p>
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

        <!-- Request Stats -->
        <div class="stats-grid mb-4">
            <div class="stat-card">
                <div class="stat-icon">📋</div>
                <div class="stat-value count-display"><?php echo e($requests->total()); ?></div>
                <div class="stat-label">Total Requests</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">⏳</div>
                <div class="stat-value count-display"><?php echo e($requests->where('status', 'pending')->count()); ?></div>
                <div class="stat-label">Pending</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">✅</div>
                <div class="stat-value count-display"><?php echo e($requests->where('status', 'accepted')->count()); ?></div>
                <div class="stat-label">Accepted</div>
            </div>

            <div class="stat-card">
                <div class="stat-icon">🎯</div>
                <div class="stat-value count-display"><?php echo e($requests->where('status', 'completed')->count()); ?></div>
                <div class="stat-label">Completed</div>
            </div>
        </div>

        <!-- New Request Button -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-plus"></i> Make a New Request
                </h2>
                <a href="#request-instructor-modal" class="btn btn-primary" data-bs-toggle="modal">
                    <i class="fa-solid fa-dumbbell"></i> Request Instructor
                </a>
            </div>
        </div>

        <!-- Instructor Requests List -->
        <div class="dashboard-section">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fa-solid fa-list"></i> Your Requests
                </h2>
            </div>

            <?php if($requests->count() > 0): ?>
                <div class="table-responsive">
                    <table style="width: 100%; background: var(--card); border-radius: var(--radius); overflow: hidden;">
                        <thead>
                            <tr style="background: rgba(255, 102, 0, 0.1);">
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Request Date</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Preferred Date</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Exercise Type</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Status</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Instructor</th>
                                <th style="padding: 1rem; text-align: left; color: var(--primary);">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr style="border-bottom: 1px solid rgba(255, 102, 0, 0.1);">
                                    <td style="padding: 1rem;">
                                        <div style="font-size: 0.875rem; color: var(--muted-foreground);">
                                            <?php echo e($request->created_at->format('M j, Y g:i A')); ?>

                                        </div>
                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        <?php echo e($request->preferred_date_time); ?>

                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        <?php if($request->exercise_type): ?>
                                            <span class="badge badge-pending"><?php echo e(ucfirst($request->exercise_type)); ?></span>
                                        <?php else: ?>
                                            <span style="color: var(--muted-foreground);">Not specified</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <?php echo $request->status_badge; ?>

                                    </td>
                                    <td style="padding: 1rem; color: var(--foreground);">
                                        <?php if($request->instructor): ?>
                                            <?php echo e($request->instructor->name); ?>

                                        <?php else: ?>
                                            <span style="color: var(--muted-foreground);">Not assigned</span>
                                        <?php endif; ?>
                                    </td>
                                    <td style="padding: 1rem;">
                                        <div style="display: flex; gap: 0.5rem;">
                                            <a href="<?php echo e(route('customer.instructor-request-details', $request)); ?>" 
                                               class="btn btn-outline btn-sm">
                                                <i class="fa-solid fa-eye"></i> View
                                            </a>
                                            
                                            <?php if($request->status === 'pending'): ?>
                                                <form action="<?php echo e(route('customer.instructor-requests.cancel', $request)); ?>" 
                                                      method="POST" style="display: inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" 
                                                            class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to cancel this request?')">
                                                        <i class="fa-solid fa-times"></i> Cancel
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div style="margin-top: 2rem; text-align: center;">
                    <?php echo e($requests->links()); ?>

                </div>
            <?php else: ?>
                <div class="empty-state">
                    <div class="empty-state-icon">📋</div>
                    <h3>No instructor requests yet</h3>
                    <p>Start your fitness journey with personalized training from our expert instructors.</p>
                    <a href="#request-instructor-modal" class="btn btn-primary" data-bs-toggle="modal" style="margin-top: 1rem;">
                        <i class="fa-solid fa-dumbbell"></i> Request Your First Session
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<!-- Instructor Request Modal (reuse from dashboard) -->
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
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/customer/instructor-requests.blade.php ENDPATH**/ ?>