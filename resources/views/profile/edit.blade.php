@extends('skeleton.layout')

@section('title', 'Edit Profile - FitClub')

@push('styles')
        <link rel="stylesheet" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/profile_edit.css') }}">
@endpush

@section('content')

<div class="edit-profile-container">
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

    <!-- 3-Column Grid Layout -->
    <div class="profile-grid">
        <!-- Column 1: Profile Card -->
        <div class="profile-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card-header">
                    <i class="fa-solid fa-user"></i>
                    <span>Profile</span>
                </div>

                <!-- Profile Picture -->
                <div class="profile-pic-section">
                    @if(Auth::user()->profile_picture)
                        <img src="{{ Storage::url(Auth::user()->profile_picture) }}" 
                             alt="Profile" 
                             class="profile-pic"
                             id="imagePreview">
                    @else
                        <div class="profile-pic-placeholder" id="imagePlaceholder">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <img src="#" alt="Preview" class="profile-pic" id="imagePreview" style="display: none;">
                    @endif
                    <label class="pic-upload-btn">
                        <i class="fa-solid fa-camera"></i>
                        <input type="file" name="profile_picture" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Full Name</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone_number" value="{{ old('phone_number', Auth::user()->phone_number) }}">
                    </div>

                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', Auth::user()->date_of_birth?->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}">
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select</option>
                            <option value="male" {{ old('gender', Auth::user()->gender) === 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', Auth::user()->gender) === 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', Auth::user()->gender) === 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="form-group full-width">
                        <label>Bio</label>
                        <textarea name="bio" rows="2" maxlength="500" placeholder="About you...">{{ old('bio', Auth::user()->bio) }}</textarea>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-save"></i> Save
                </button>
            </form>
        </div>

        <!-- Column 2: Fitness Card -->
        <div class="profile-card">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card-header">
                    <i class="fa-solid fa-dumbbell"></i>
                    <span>Fitness</span>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Height (cm)</label>
                        <input type="number" name="height" value="{{ old('height', Auth::user()->height) }}" min="50" max="300" step="0.1" placeholder="170">
                    </div>

                    <div class="form-group">
                        <label>Weight (kg)</label>
                        <input type="number" name="weight" value="{{ old('weight', Auth::user()->weight) }}" min="20" max="500" step="0.1" placeholder="70">
                    </div>

                    <div class="form-group">
                        <label>Fitness Goal</label>
                        <select name="fitness_goal">
                            <option value="">Select Goal</option>
                            <option value="Weight Loss" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Weight Loss' ? 'selected' : '' }}>Weight Loss</option>
                            <option value="Muscle Gain" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Muscle Gain' ? 'selected' : '' }}>Muscle Gain</option>
                            <option value="Strength" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Strength' ? 'selected' : '' }}>Strength</option>
                            <option value="Endurance" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'Endurance' ? 'selected' : '' }}>Endurance</option>
                            <option value="General Fitness" {{ old('fitness_goal', Auth::user()->fitness_goal) === 'General Fitness' ? 'selected' : '' }}>General Fitness</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Experience Level</label>
                        <select name="experience_level">
                            <option value="">Select Level</option>
                            <option value="beginner" {{ old('experience_level', Auth::user()->experience_level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('experience_level', Auth::user()->experience_level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                            <option value="advanced" {{ old('experience_level', Auth::user()->experience_level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            <option value="expert" {{ old('experience_level', Auth::user()->experience_level) === 'expert' ? 'selected' : '' }}>Expert</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-save"></i> Save
                </button>
            </form>
        </div>

        <!-- Column 3: Password + Notifications Card -->
        <div class="profile-card">
            <div class="card-header">
                <i class="fa-solid fa-cog"></i>
                <span>Settings</span>
            </div>

            <!-- Password Section -->
            <form action="{{ route('profile.password') }}" method="POST" class="password-form">
                @csrf
                @method('PUT')
                
                <div class="section-title">Change Password</div>
                <div class="form-grid">
                    <div class="form-group full-width">
                        <label>Current Password</label>
                        <input type="password" name="current_password" required>
                    </div>

                    <div class="form-group full-width">
                        <label>New Password</label>
                        <input type="password" name="password" required minlength="6">
                    </div>

                    <div class="form-group full-width">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" required>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-key"></i> Update Password
                </button>
            </form>

            <!-- Notifications Section -->
            <form action="{{ route('profile.update') }}" method="POST" class="notifications-form">
                @csrf
                @method('PUT')
                
                <div class="section-title">Notifications</div>
                <div class="toggles">
                    <div class="toggle-item">
                        <div class="toggle-info">
                            <div class="toggle-label">Email Notifications</div>
                            <small>Workout updates & more</small>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="email_notifications" value="1" {{ Auth::user()->email_notifications ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="toggle-item">
                        <div class="toggle-info">
                            <div class="toggle-label">SMS Notifications</div>
                            <small>Important text alerts</small>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" name="sms_notifications" value="1" {{ Auth::user()->sms_notifications ? 'checked' : '' }}>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>

                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-save"></i> Save Settings
                </button>
            </form>
        </div>
    </div>
</div>



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
