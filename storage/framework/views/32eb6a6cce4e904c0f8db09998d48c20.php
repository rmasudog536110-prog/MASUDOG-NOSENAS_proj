<?php $__env->startSection('title', 'Edit Profile - FitClub'); ?>

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

        <?php if($errors->any()): ?>
            <div class="flash-message error">
                <ul style="margin: 0; padding-left: 1rem;">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture-edit">
                <?php if(Auth::user()->profile && Auth::user()->profile->profile_picture): ?>
                    <img src="<?php echo e(Storage::url(Auth::user()->profile->profile_picture)); ?>" 
                         alt="Profile Picture" 
                         class="profile-picture"
                         id="imagePreview">
                    <div class="profile-picture-placeholder" id="imagePlaceholder" style="display: none;">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    </div>
                    <div class="profile-picture-actions">
                        <label class="picture-upload-btn">
                            <i class="fa-solid fa-camera"></i>
                            <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                        </label>
                        <button type="button" class="picture-delete-btn" onclick="deleteProfilePicture()" title="Delete Profile Picture">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                <?php else: ?>
                    <div class="profile-picture-placeholder" id="imagePlaceholder">
                        <?php echo e(strtoupper(substr(Auth::user()->name, 0, 1))); ?>

                    </div>
                    <img src="#" alt="Preview" class="image-preview" id="imagePreview" style="display: none;">
                    <div class="profile-picture-actions">
                        <label class="picture-upload-btn">
                            <i class="fa-solid fa-camera"></i>
                            <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                        </label>
                    </div>
                <?php endif; ?>
            </div>

            <h1 class="profile-name">Edit Profile</h1>
            <p class="profile-email"><?php echo e(Auth::user()->email); ?></p>
        </div>

        <!-- Profile Actions -->
        <div class="profile-actions">
            <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Profile
            </a>
            <a href="<?php echo e(route('user_dashboard')); ?>" class="btn btn-outline">
                <i class="fa-solid fa-dashboard"></i> Back to Dashboard
            </a>
        </div>

        <!-- Profile Information Grid -->
        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="profile-grid">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            
            <!-- Personal Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-user"></i> Personal Information</h3>
                <div class="profile-form">

                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="<?php echo e(old('name', Auth::user()->name)); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="<?php echo e(old('email', Auth::user()->email)); ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="<?php echo e(old('phone_number', Auth::user()->phone_number)); ?>" placeholder="+1 (555) 123-4567">
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo e(old('date_of_birth', Auth::user()->date_of_birth?->format('Y-m-d'))); ?>" max="<?php echo e(date('Y-m-d')); ?>">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" <?php echo e(old('gender', Auth::user()->gender) === 'male' ? 'selected' : ''); ?>>Male</option>
                            <option value="female" <?php echo e(old('gender', Auth::user()->gender) === 'female' ? 'selected' : ''); ?>>Female</option>
                            <option value="other" <?php echo e(old('gender', Auth::user()->gender) === 'other' ? 'selected' : ''); ?>>Other</option>
                            <option value="prefer_not_to_say" <?php echo e(old('gender', Auth::user()->gender) === 'prefer_not_to_say' ? 'selected' : ''); ?>>Prefer not to say</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio" rows="3" placeholder="Tell us about yourself..."><?php echo e(old('bio', Auth::user()->bio)); ?></textarea>
                        <small style="color: var(--muted-foreground);">Maximum 500 characters</small>
                    </div>
                </div>
            </div>

            <!-- Fitness Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-dumbbell"></i> Fitness Profile</h3>
                <div class="profile-form">

                    <div class="form-group">
                        <label for="height">Height (cm)</label>
                        <input type="number" id="height" name="height" value="<?php echo e(old('height', Auth::user()->height)); ?>" min="50" max="300" step="0.1" placeholder="170">
                    </div>

                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" value="<?php echo e(old('weight', Auth::user()->weight)); ?>" min="20" max="500" step="0.1" placeholder="70">
                    </div>

                    <div class="form-group">
                        <label for="fitness_goal">Fitness Goal</label>
                        <select id="fitness_goal" name="fitness_goal">
                            <option value="">Select Goal</option>
                            <option value="Weight Loss" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'Weight Loss' ? 'selected' : ''); ?>>Weight Loss</option>
                            <option value="Muscle Gain" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'Muscle Gain' ? 'selected' : ''); ?>>Muscle Gain</option>
                            <option value="Strength" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'Strength' ? 'selected' : ''); ?>>Strength</option>
                            <option value="Endurance" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'Endurance' ? 'selected' : ''); ?>>Endurance</option>
                            <option value="General Fitness" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'General Fitness' ? 'selected' : ''); ?>>General Fitness</option>
                            <option value="Body Toning" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'Body Toning' ? 'selected' : ''); ?>>Body Toning</option>
                            <option value="Competition Prep" <?php echo e(old('fitness_goal', Auth::user()->fitness_goal) === 'Competition Prep' ? 'selected' : ''); ?>>Competition Prep</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience_level">Experience Level</label>
                        <select id="experience_level" name="experience_level">
                            <option value="">Select Level</option>
                            <option value="beginner" <?php echo e(old('experience_level', Auth::user()->experience_level) === 'beginner' ? 'selected' : ''); ?>>Beginner (0-6 months)</option>
                            <option value="intermediate" <?php echo e(old('experience_level', Auth::user()->experience_level) === 'intermediate' ? 'selected' : ''); ?>>Intermediate (6 months - 2 years)</option>
                            <option value="advanced" <?php echo e(old('experience_level', Auth::user()->experience_level) === 'advanced' ? 'selected' : ''); ?>>Advanced (2-5 years)</option>
                            <option value="expert" <?php echo e(old('experience_level', Auth::user()->experience_level) === 'expert' ? 'selected' : ''); ?>>Expert (5+ years)</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Notifications & Settings -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-bell"></i> Notifications & Settings</h3>
                
                <div class="notification-toggle">
                    <div class="notification-info">
                        <h4>Email Notifications</h4>
                        <p>Receive workout updates, program alerts, and newsletters</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="email_notifications" value="1" <?php echo e(Auth::user()->email_notifications ? 'checked' : ''); ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="notification-toggle">
                    <div class="notification-info">
                        <h4>SMS Notifications</h4>
                        <p>Get important alerts and reminders via text message</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="sms_notifications" value="1" <?php echo e(Auth::user()->sms_notifications ? 'checked' : ''); ?>>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Save Changes
                    </button>
                    <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline">
                        Cancel
                    </a>
                </div>
            </div>
        </form>

        <!-- Change Password Section (Separate Form) -->
        <div class="dashboard-card" style="margin-top: 2rem;">
            <h3><i class="fa-solid fa-key"></i> Change Password</h3>
            
            <form action="<?php echo e(route('profile.password')); ?>" method="POST" class="profile-form" style="max-width: 500px; margin: 0 auto;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                
                <div class="form-group">
                    <label for="current_password">Current Password *</label>
                    <input type="password" id="current_password" name="current_password" required>
                </div>

                <div class="form-group">
                    <label for="password">New Password *</label>
                    <input type="password" id="password" name="password" required minlength="6">
                    <small style="color: var(--muted-foreground);">Minimum 6 characters</small>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm New Password *</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-key"></i> Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<?php echo $__env->make('index.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Image Preview
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                showFlashMessage('File size must be less than 2MB', 'error');
                event.target.value = '';
                return;
            }
            
            // Validate file type
            if (!file.type.match(/image\/(jpeg|jpg|png|gif)/)) {
                showFlashMessage('File must be an image (JPEG, PNG, or GIF)', 'error');
                event.target.value = '';
                return;
            }
            
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('imagePlaceholder');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                preview.className = 'profile-picture'; // Ensure it uses the correct class
                
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // Handle file input change - upload immediately
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.querySelector('input[name="profile_picture"]');
        if (fileInput) {
            fileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    uploadProfilePicture(file);
                }
            });
        }
    });

    // AJAX Profile Picture Upload
    function uploadProfilePicture(file) {
        const formData = new FormData();
        formData.append('profile_picture', file);
        
        // Show loading state
        const uploadBtn = document.querySelector('.picture-upload-btn');
        const originalContent = uploadBtn.innerHTML;
        uploadBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i>';
        uploadBtn.style.pointerEvents = 'none';
        
        fetch('<?php echo e(route("profile.picture.update")); ?>', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update the image preview with the new URL
                const preview = document.getElementById('imagePreview');
                preview.src = data.url;
                preview.style.display = 'block';
                preview.className = 'profile-picture'; // Ensure it uses the correct class
                
                const placeholder = document.getElementById('imagePlaceholder');
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
                
                // Show success message
                showFlashMessage('Profile picture updated successfully!', 'success');
            } else {
                showFlashMessage(data.message || 'Failed to upload profile picture', 'error');
            }
        })
        .catch(error => {
            console.error('Upload error:', error);
            showFlashMessage('Failed to upload profile picture. Please try again.', 'error');
        })
        .finally(() => {
            // Restore button state
            uploadBtn.innerHTML = originalContent;
            uploadBtn.style.pointerEvents = 'auto';
        });
    }

    // Delete Profile Picture
    function deleteProfilePicture() {
        if (!confirm('Are you sure you want to delete your profile picture?')) {
            return;
        }
        
        fetch('<?php echo e(route("profile.picture.delete")); ?>', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide image and show placeholder
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('imagePlaceholder');
                
                preview.style.display = 'none';
                placeholder.style.display = 'flex';
                
                // Clear file input
                document.querySelector('input[name="profile_picture"]').value = '';
                
                showFlashMessage('Profile picture deleted successfully!', 'success');
            } else {
                showFlashMessage(data.message || 'Failed to delete profile picture', 'error');
            }
        })
        .catch(error => {
            console.error('Delete error:', error);
            showFlashMessage('Failed to delete profile picture. Please try again.', 'error');
        });
    }

    // Show flash message function
    function showFlashMessage(message, type) {
        // Remove existing flash messages
        const existingMessages = document.querySelectorAll('.flash-message');
        existingMessages.forEach(msg => msg.remove());
        
        // Create new flash message
        const flashDiv = document.createElement('div');
        flashDiv.className = `flash-message ${type}`;
        flashDiv.textContent = message;
        
        // Insert at the top of the container
        const container = document.querySelector('.container');
        container.insertBefore(flashDiv, container.firstChild);
        
        // Auto remove after 5 seconds
        setTimeout(() => {
            flashDiv.remove();
        }, 5000);
    }

    // Auto calculate BMI when height or weight changes
    document.addEventListener('DOMContentLoaded', function() {
        const heightInput = document.getElementById('height');
        const weightInput = document.getElementById('weight');
        
        function calculateBMI() {
            const height = parseFloat(heightInput.value) / 100; // Convert cm to m
            const weight = parseFloat(weightInput.value);
            
            if (height > 0 && weight > 0) {
                const bmi = weight / (height * height);
                // You could display this somewhere if you want
                console.log('BMI:', bmi.toFixed(1));
            }
        }
        
        if (heightInput && weightInput) {
            heightInput.addEventListener('input', calculateBMI);
            weightInput.addEventListener('input', calculateBMI);
        }
    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/profile/edit.blade.php ENDPATH**/ ?>