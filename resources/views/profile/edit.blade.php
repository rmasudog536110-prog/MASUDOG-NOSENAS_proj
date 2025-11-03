@extends('skeleton.layout')

@section('title', 'Edit Profile - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <style>
        body {
            overflow-y: auto !important;
            min-height: 100vh;
        }

        body::before {
            position: fixed !important;
            height: 100vh !important;
        }

        main {
            position: relative;
            z-index: 1;
            min-height: 100vh;
        }

        .edit-profile-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem 4rem 1rem;
            position: relative;
            z-index: 1;
        }

        .profile-edit-card {
            background: rgba(26, 26, 26, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 1rem;
            padding: 2.5rem;
            margin-bottom: 2rem;
        }

        .profile-edit-card h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.2);
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .form-section:last-child {
            margin-bottom: 0;
        }

        .form-section-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .image-upload-preview {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .current-image {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            margin-bottom: 1rem;
        }

        .image-placeholder {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            color: white;
            border: 3px solid var(--primary);
            margin-bottom: 1rem;
        }

        .file-input-wrapper {
            position: relative;
            display: inline-block;
        }

        .file-input-label {
            display: inline-block;
            padding: 0.75rem 1.5rem;
            background: var(--muted);
            color: var(--foreground);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.5rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-label:hover {
            background: var(--primary);
            color: #fff;
        }

        .file-input-label input[type="file"] {
            display: none;
        }

        .danger-zone {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            border-radius: 0.5rem;
            padding: 1.5rem;
            margin-top: 2rem;
        }

        .danger-zone h3 {
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .btn-danger {
            background: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background: #c82333;
            border-color: #bd2130;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 50px;
            height: 24px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 24px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked + .slider {
            background-color: var(--primary);
        }

        input:checked + .slider:before {
            transform: translateX(26px);
        }

        .notification-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: var(--muted);
            border-radius: 0.5rem;
            margin-bottom: 0.75rem;
        }

        .notification-label {
            display: flex;
            flex-direction: column;
        }

        .notification-label strong {
            color: var(--foreground);
            margin-bottom: 0.25rem;
        }

        .notification-label small {
            color: var(--muted-foreground);
        }

        @media (max-width: 768px) {
            .profile-edit-card {
                padding: 1.5rem;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

@include('index.header')

<div class="edit-profile-container">
    <!-- Flash Messages -->
    @if (session('success'))
        <div class="flash-message success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="flash-message error">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Information Form -->
    <div class="profile-edit-card">
        <h2><i class="fa-solid fa-user-edit"></i> Edit Profile</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Profile Picture -->
            <div class="form-section">
                <div class="image-upload-preview">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                             alt="Profile Picture" 
                             class="current-image"
                             id="imagePreview">
                    @else
                        <div class="image-placeholder" id="imagePlaceholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <img src="#" alt="Preview" class="current-image" id="imagePreview" style="display: none;">
                    @endif

                    <div class="file-input-wrapper">
                        <label class="file-input-label">
                            <i class="fa-solid fa-camera"></i> Choose Photo
                            <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                        </label>
                    </div>
                    <p style="color: var(--muted-foreground); font-size: 0.875rem; margin-top: 0.5rem;">
                        Max size: 2MB. Formats: JPG, PNG, GIF
                    </p>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-id-card"></i> Personal Information
                </h3>

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name *</label>
                    <input type="text" 
                           class="form-control" 
                           id="name" 
                           name="name" 
                           value="{{ old('name', Auth::user()->name) }}" 
                           required>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" 
                               class="form-control" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', Auth::user()->email) }}" 
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" 
                               class="form-control" 
                               id="phone_number" 
                               name="phone_number" 
                               value="{{ old('phone_number', Auth::user()->phone_number) }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="date_of_birth" class="form-label">Date of Birth</label>
                        <input type="date" 
                               class="form-control" 
                               id="date_of_birth" 
                               name="date_of_birth" 
                               value="{{ old('date_of_birth', Auth::user()->date_of_birth?->format('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-control" id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', Auth::user()->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', Auth::user()->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', Auth::user()->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            <option value="prefer_not_to_say" {{ old('gender', Auth::user()->gender) === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" 
                              id="bio" 
                              name="bio" 
                              rows="3" 
                              maxlength="500" 
                              placeholder="Tell us about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
                    <small style="color: var(--muted-foreground);">Max 500 characters</small>
                </div>
            </div>

            <!-- Fitness Information -->
            <div class="form-section">
                <h3 class="form-section-title">
                    <i class="fa-solid fa-dumbbell"></i> Fitness Information
                </h3>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="height" class="form-label">Height (cm)</label>
                        <input type="number" 
                               class="form-control" 
                               id="height" 
                               name="height" 
                               value="{{ old('height', Auth::user()->height) }}"
                               min="50"
                               max="300"
                               step="0.1"
                               placeholder="170">
                    </div>

                    <div class="mb-3">
                        <label for="weight" class="form-label">Weight (kg)</label>
                        <input type="number" 
                               class="form-control" 
                               id="weight" 
                               name="weight" 
                               value="{{ old('weight', Auth::user()->weight) }}"
                               min="20"
                               max="500"
                               step="0.1"
                               placeholder="70">
                    </div>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="fitness_goal" class="form-label">Fitness Goal</label>
                        <select class="form-control" id="fitness_goal" name="fitness_goal">
                            <option value="">Select Goal</option>
                            <option value="Weight Loss" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                            <option value="Muscle Gain" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Muscle Gain' ? 'selected' : '' }}>Muscle Gain</option>
                            <option value="Strength" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Strength' ? 'selected' : '' }}>Strength</option>
                            <option value="Endurance" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Endurance' ? 'selected' : '' }}>Endurance</option>
                            <option value="General Fitness" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'General Fitness' ? 'selected' : '' }}>General Fitness</option>
                            <option value="Flexibility" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Flexibility' ? 'selected' : '' }}>Flexibility</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="experience_level" class="form-label">Experience Level</label>
                        <select class="form-control" id="experience_level" name="experience_level">
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('experience_level', Auth::user()->experience_level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('experience_level', Auth::user()->experience_level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('experience_level', Auth::user()->experience_level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            <option value="expert" {{ old('experience_level', Auth::user()->experience_level) === 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                </div>
            </div>

            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-save"></i> Save Changes
                </button>
                <a href="{{ route('profile.show') }}" class="btn btn-outline">
                    <i class="fa-solid fa-times"></i> Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Change Password -->
    <div class="profile-edit-card" id="password">
        <h2><i class="fa-solid fa-lock"></i> Change Password</h2>

        <form action="{{ route('profile.password') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password *</label>
                <input type="password" 
                       class="form-control" 
                       id="current_password" 
                       name="current_password" 
                       required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password *</label>
                <input type="password" 
                       class="form-control" 
                       id="password" 
                       name="password" 
                       required
                       minlength="6">
                <small style="color: var(--muted-foreground);">Minimum 6 characters</small>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password *</label>
                <input type="password" 
                       class="form-control" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required>
            </div>

            <button type="submit" class="btn btn-primary btn-full">
                <i class="fa-solid fa-key"></i> Update Password
            </button>
        </form>
    </div>

    <!-- Notification Settings -->
    <div class="profile-edit-card" id="notifications">
        <h2><i class="fa-solid fa-bell"></i> Notification Preferences</h2>

        <form action="{{ route('profile.notifications') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="notification-item">
                <div class="notification-label">
                    <strong>Email Notifications</strong>
                    <small>Receive updates about your workouts, subscriptions, and more</small>
                </div>
                <label class="switch">
                    <input type="checkbox" 
                           name="email_notifications" 
                           value="1" 
                           {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <div class="notification-item">
                <div class="notification-label">
                    <strong>SMS Notifications</strong>
                    <small>Get text messages for important updates</small>
                </div>
                <label class="switch">
                    <input type="checkbox" 
                           name="sms_notifications" 
                           value="1" 
                           {{ Auth::user()->sms_notifications ? 'checked' : '' }}>
                    <span class="slider"></span>
                </label>
            </div>

            <button type="submit" class="btn btn-primary btn-full" style="margin-top: 1rem;">
                <i class="fa-solid fa-save"></i> Save Preferences
            </button>
        </form>
    </div>

    <!-- Danger Zone -->
    <div class="profile-edit-card">
        <div class="danger-zone">
            <h3><i class="fa-solid fa-exclamation-triangle"></i> Danger Zone</h3>
            <p style="color: var(--muted-foreground); margin-bottom: 1rem;">
                Once you delete your account, there is no going back. Please be certain.
            </p>

            <button type="button" class="btn btn-danger" onclick="confirmDelete()">
                <i class="fa-solid fa-trash"></i> Delete Account
            </button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--card); padding: 2rem; border-radius: 1rem; max-width: 500px; margin: 1rem;">
        <h3 style="color: #dc3545; margin-bottom: 1rem;">Delete Account</h3>
        <p style="color: var(--foreground); margin-bottom: 1.5rem;">
            Are you sure you want to delete your account? This action cannot be undone.
        </p>

        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')

            <div class="mb-3">
                <label for="delete_password" class="form-label">Enter your password to confirm:</label>
                <input type="password" 
                       class="form-control" 
                       id="delete_password" 
                       name="password" 
                       required>
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-danger" style="flex: 1;">
                    Yes, Delete My Account
                </button>
                <button type="button" class="btn btn-outline" onclick="closeDeleteModal()" style="flex: 1;">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

@include('index.footer')

@endsection

@push('scripts')
<script>
    // Image Preview
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('imagePreview');
                const placeholder = document.getElementById('imagePlaceholder');
                
                preview.src = e.target.result;
                preview.style.display = 'block';
                
                if (placeholder) {
                    placeholder.style.display = 'none';
                }
            };
            reader.readAsDataURL(file);
        }
    }

    // Delete Modal
    function confirmDelete() {
        document.getElementById('deleteModal').style.display = 'flex';
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').style.display = 'none';
    }

    // Close modal on outside click
    document.getElementById('deleteModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
</script>
@endpush
