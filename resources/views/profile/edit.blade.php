@extends('skeleton.layout')

@section('title', 'Edit Profile - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
    <style>
        .profile-section form {
            margin-top: 1.5rem;
        }
        
        .profile-form .form-group {
            margin-bottom: 1rem;
        }
        
        .profile-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--foreground);
        }
        
        .profile-form input,
        .profile-form select,
        .profile-form textarea {
            width: 100%;
            padding: 0.75rem;
            background: rgba(255, 102, 0, 0.05);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 0.5rem;
            color: var(--foreground);
            font-size: 1rem;
        }
        
        .profile-form input:focus,
        .profile-form select:focus,
        .profile-form textarea:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(255, 102, 0, 0.1);
        }
        
        .form-actions {
            margin-top: 2rem;
            display: flex;
            gap: 1rem;
            justify-content: flex-start;
        }
        
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        
        .toggle-slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        
        .toggle-slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        
        input:checked + .toggle-slider {
            background-color: var(--primary);
        }
        
        input:checked + .toggle-slider:before {
            transform: translateX(26px);
        }
        
        .notification-toggle {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(255, 102, 0, 0.05);
            border-radius: 0.5rem;
        }
        
        .notification-info h4 {
            margin: 0 0 0.25rem 0;
            color: var(--foreground);
        }
        
        .notification-info p {
            margin: 0;
            color: var(--muted-foreground);
            font-size: 0.9rem;
        }
        
        .profile-picture-edit {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 2rem;
        }
        
        .profile-picture-edit img {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
        
        .profile-picture-edit .profile-picture-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            font-weight: bold;
            color: white;
        }
        
        .picture-upload-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: var(--primary);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .picture-upload-btn input {
            display: none;
        }
        
        .image-preview {
            display: none;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')

@if (Auth::user() && Auth::user()->hasAdminAccess())
@include('admin.admin_header')
@else
@include('index.header')
@endif

<section class="content-section">
    <div class="container">
        <!-- Flash Messages -->
        @if (session('success'))
            <div class="flash-message success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="flash-message error">
                <ul style="margin: 0; padding-left: 1rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Header -->
        <div class="profile-header">
            <div class="profile-picture-edit">
                @if(Auth::user()->profile_picture)
                    <img src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                         alt="Profile Picture" 
                         class="image-preview"
                         id="imagePreview">
                    <div class="profile-picture-placeholder" id="imagePlaceholder" style="display: none;">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                @else
                    <div class="profile-picture-placeholder" id="imagePlaceholder">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <img src="#" alt="Preview" class="image-preview" id="imagePreview" style="display: none;">
                @endif
                <label class="picture-upload-btn">
                    <i class="fa-solid fa-camera"></i>
                    <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                </label>
            </div>

            <h1 class="profile-name">Edit Profile</h1>
            <p class="profile-email">{{ Auth::user()->email }}</p>
        </div>

        <!-- Profile Actions -->
        <div class="profile-actions">
            <a href="{{ route('profile.show') }}" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Profile
            </a>
            <a href="{{ route('user_dashboard') }}" class="btn btn-outline">
                <i class="fa-solid fa-dashboard"></i> Back to Dashboard
            </a>
        </div>

        <!-- Profile Information Grid -->
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="profile-grid">
            @csrf
            @method('PUT')
            
            <!-- Personal Information -->
            <div class="profile-section">
                <h3><i class="fa-solid fa-user"></i> Personal Information</h3>
                <div class="profile-form">

                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="phone_number">Phone Number</label>
                        <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}" placeholder="+1 (555) 123-4567">
                    </div>

                    <div class="form-group">
                        <label for="date_of_birth">Date of Birth</label>
                        <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', Auth::user()->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', Auth::user()->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', Auth::user()->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            <option value="prefer_not_to_say" {{ old('gender', Auth::user()->gender) === 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="bio">Bio</label>
                        <textarea id="bio" name="bio" rows="3" placeholder="Tell us about yourself...">{{ old('bio', Auth::user()->bio) }}</textarea>
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
                        <input type="number" id="height" name="height" value="{{ old('height', Auth::user()->height) }}" min="50" max="300" step="0.1" placeholder="170">
                    </div>

                    <div class="form-group">
                        <label for="weight">Weight (kg)</label>
                        <input type="number" id="weight" name="weight" value="{{ old('weight', Auth::user()->weight) }}" min="20" max="500" step="0.1" placeholder="70">
                    </div>

                    <div class="form-group">
                        <label for="fitness_goal">Fitness Goal</label>
                        <select id="fitness_goal" name="fitness_goal">
                            <option value="">Select Goal</option>
                            <option value="Weight Loss" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                            <option value="Muscle Gain" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Muscle Gain' ? 'selected' : '' }}>Muscle Gain</option>
                            <option value="Strength" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Strength' ? 'selected' : '' }}>Strength</option>
                            <option value="Endurance" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Endurance' ? 'selected' : '' }}>Endurance</option>
                            <option value="General Fitness" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'General Fitness' ? 'selected' : '' }}>General Fitness</option>
                            <option value="Body Toning" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Body Toning' ? 'selected' : '' }}>Body Toning</option>
                            <option value="Competition Prep" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Competition Prep' ? 'selected' : '' }}>Competition Prep</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="experience_level">Experience Level</label>
                        <select id="experience_level" name="experience_level">
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('experience_level', Auth::user()->experience_level) === 'beginner' ? 'selected' : '' }}>Beginner (0-6 months)</option>
                            <option value="intermediate" {{ old('experience_level', Auth::user()->experience_level) === 'intermediate' ? 'selected' : '' }}>Intermediate (6 months - 2 years)</option>
                            <option value="advanced" {{ old('experience_level', Auth::user()->experience_level) === 'advanced' ? 'selected' : '' }}>Advanced (2-5 years)</option>
                            <option value="expert" {{ old('experience_level', Auth::user()->experience_level) === 'expert' ? 'selected' : '' }}>Expert (5+ years)</option>
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
                        <input type="checkbox" name="email_notifications" value="1" {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <div class="notification-toggle">
                    <div class="notification-info">
                        <h4>SMS Notifications</h4>
                        <p>Get important alerts and reminders via text message</p>
                    </div>
                    <label class="toggle-switch">
                        <input type="checkbox" name="sms_notifications" value="1" {{ Auth::user()->sms_notifications ? 'checked' : '' }}>
                        <span class="toggle-slider"></span>
                    </label>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> Save Changes
                    </button>
                    <a href="{{ route('profile.show') }}" class="btn btn-outline">
                        Cancel
                    </a>
                </div>
            </div>
        </form>

        <!-- Change Password Section (Separate Form) -->
        <div class="dashboard-card" style="margin-top: 2rem;">
            <h3><i class="fa-solid fa-key"></i> Change Password</h3>
            
            <form action="{{ route('profile.password') }}" method="POST" class="profile-form" style="max-width: 500px; margin: 0 auto;">
                @csrf
                @method('PUT')
                
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
@endpush