@extends('skeleton.layout')

@section('title', 'Edit User - Admin')

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

        .edit-container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem 4rem 1rem;
            position: relative;
            z-index: 1;
        }

        .edit-card {
            background: rgba(26, 26, 26, 0.95);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .edit-card h2 {
            color: var(--primary);
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.2);
        }

        .form-row {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }
    </style>
@endpush

@section('content')

@include('index.header')

<div class="edit-container">
    <div style="margin-bottom: 2rem;">
        <a href="{{ route('admin.users') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Users
        </a>
    </div>

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

    <!-- User Information -->
    <div class="edit-card">
        <h2><i class="fa-solid fa-user-edit"></i> Edit User Information</h2>

        <form action="{{ route('admin.update-user', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Full Name *</label>
                <input type="text" 
                       class="form-control" 
                       id="name" 
                       name="name" 
                       value="{{ old('name', $user->name) }}" 
                       required>
            </div>

            <div class="form-row">
                <div class="mb-3">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" 
                           class="form-control" 
                           id="email" 
                           name="email" 
                           value="{{ old('email', $user->email) }}" 
                           required>
                </div>

                <div class="mb-3">
                    <label for="phone_number" class="form-label">Phone Number</label>
                    <input type="text" 
                           class="form-control" 
                           id="phone_number" 
                           name="phone_number" 
                           value="{{ old('phone_number', $user->phone_number) }}">
                </div>
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Account Status *</label>
                <select class="form-control" id="is_active" name="is_active" required>
                    <option value="1" {{ old('is_active', $user->is_active) == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ old('is_active', $user->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fa-solid fa-save"></i> Update User
            </button>
        </form>
    </div>

    <!-- Subscription Management -->
    <div class="edit-card">
        <h2><i class="fa-solid fa-credit-card"></i> Manage Subscription</h2>

        @php
            $activeSub = $user->subscriptions()
                ->where('status', 'active')
                ->where('end_date', '>', now())
                ->latest()
                ->first();
        @endphp

        @if($activeSub)
            <div style="background: rgba(40, 167, 69, 0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(40, 167, 69, 0.3);">
                <div style="display: flex; justify-content: space-between; align-items: start;">
                    <div>
                        <h4 style="margin-bottom: 0.5rem; color: #28a745;">
                            <i class="fa-solid fa-check-circle"></i> Active Subscription
                        </h4>
                        <p style="margin: 0; color: var(--foreground);">
                            <strong>Plan:</strong> {{ $activeSub->plan->name ?? 'N/A' }}<br>
                            <strong>Start Date:</strong> {{ $activeSub->start_date->format('M d, Y') }}<br>
                            <strong>End Date:</strong> {{ $activeSub->end_date->format('M d, Y') }}<br>
                            <strong>Days Remaining:</strong> {{ now()->diffInDays($activeSub->end_date) }} days
                        </p>
                    </div>
                    <div style="display: flex; gap: 0.5rem;">
                        <button type="button" 
                                class="btn btn-outline btn-sm"
                                onclick="toggleSubscriptionForm('update')">
                            <i class="fa-solid fa-edit"></i> Edit
                        </button>
                        <form action="{{ route('admin.cancel-subscription', [$user, $activeSub]) }}" 
                              method="POST" 
                              style="display: inline;"
                              onsubmit="return confirm('Are you sure you want to cancel this subscription?')">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-outline btn-sm"
                                    style="color: #dc3545; border-color: #dc3545;">
                                <i class="fa-solid fa-ban"></i> Cancel
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div style="background: rgba(220, 53, 69, 0.1); padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem; border: 1px solid rgba(220, 53, 69, 0.3);">
                <p style="margin: 0; color: #dc3545;">
                    <i class="fa-solid fa-exclamation-triangle"></i> No active subscription
                </p>
            </div>
        @endif

        <!-- Subscription Form -->
        <div id="subscription-form" style="display: {{ $activeSub ? 'none' : 'block' }};">
            <h4 style="margin-bottom: 1rem;">
                <span id="form-title">{{ $activeSub ? 'Update Subscription' : 'Add New Subscription' }}</span>
            </h4>

            <form action="{{ route('admin.update-subscription', $user) }}" method="POST" id="subForm">
                @csrf
                <input type="hidden" name="action" id="action" value="{{ $activeSub ? 'update' : 'add' }}">
                <input type="hidden" name="subscription_id" id="subscription_id" value="{{ $activeSub->id ?? '' }}">

                <div class="mb-3">
                    <label for="plan_id" class="form-label">Subscription Plan *</label>
                    <select class="form-control" id="plan_id" name="plan_id" required onchange="updateEndDate()">
                        <option value="">Select a plan</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" 
                                    data-duration="{{ $plan->duration_days }}"
                                    {{ old('plan_id', $activeSub->plan_id ?? '') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - ₱{{ number_format($plan->price, 2) }} ({{ $plan->duration_days }} days)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-row">
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date *</label>
                        <input type="date" 
                               class="form-control" 
                               id="start_date" 
                               name="start_date" 
                               value="{{ old('start_date', $activeSub ? $activeSub->start_date->format('Y-m-d') : now()->format('Y-m-d')) }}" 
                               onchange="updateEndDate()"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date *</label>
                        <input type="date" 
                               class="form-control" 
                               id="end_date" 
                               name="end_date" 
                               value="{{ old('end_date', $activeSub ? $activeSub->end_date->format('Y-m-d') : now()->addMonth()->format('Y-m-d')) }}" 
                               required>
                        <small style="color: var(--muted-foreground);">Auto-calculated based on plan duration</small>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i> 
                        <span id="submit-text">{{ $activeSub ? 'Update Subscription' : 'Add Subscription' }}</span>
                    </button>
                    
                    @if($activeSub)
                        <button type="button" class="btn btn-outline" onclick="toggleSubscriptionForm('cancel')">
                            <i class="fa-solid fa-times"></i> Cancel
                        </button>
                    @endif
                </div>
            </form>
        </div>

        <!-- Subscription History -->
        @php
            $allSubscriptions = $user->subscriptions()->with('plan')->latest()->get();
        @endphp

        @if($allSubscriptions->count() > 1)
            <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(255, 102, 0, 0.2);">
                <h4 style="margin-bottom: 1rem;">Subscription History</h4>
                <div style="max-height: 300px; overflow-y: auto;">
                    @foreach($allSubscriptions as $sub)
                        @if($sub->id !== ($activeSub->id ?? null))
                            <div style="background: var(--muted); padding: 0.75rem; border-radius: 0.5rem; margin-bottom: 0.5rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <strong>{{ $sub->plan->name ?? 'N/A' }}</strong><br>
                                        <small style="color: var(--muted-foreground);">
                                            {{ $sub->start_date->format('M d, Y') }} - {{ $sub->end_date->format('M d, Y') }}
                                        </small>
                                    </div>
                                    <span class="status-badge {{ $sub->status === 'active' ? 'status-active' : 'status-inactive' }}">
                                        {{ ucfirst($sub->status) }}
                                    </span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function toggleSubscriptionForm(action) {
            const form = document.getElementById('subscription-form');
            const actionInput = document.getElementById('action');
            const formTitle = document.getElementById('form-title');
            const submitText = document.getElementById('submit-text');

            if (action === 'update') {
                form.style.display = 'block';
                actionInput.value = 'update';
                formTitle.textContent = 'Update Subscription';
                submitText.textContent = 'Update Subscription';
            } else if (action === 'cancel') {
                form.style.display = 'none';
            }
        }

        function updateEndDate() {
            const planSelect = document.getElementById('plan_id');
            const startDateInput = document.getElementById('start_date');
            const endDateInput = document.getElementById('end_date');

            const selectedOption = planSelect.options[planSelect.selectedIndex];
            const duration = selectedOption.getAttribute('data-duration');
            const startDate = new Date(startDateInput.value);

            if (duration && startDate) {
                const endDate = new Date(startDate);
                endDate.setDate(endDate.getDate() + parseInt(duration));
                endDateInput.value = endDate.toISOString().split('T')[0];
            }
        }

        // Initialize end date on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateEndDate();
        });
    </script>
    @endpush

    <!-- User Stats -->
    <div class="edit-card">
        <h2><i class="fa-solid fa-chart-bar"></i> User Statistics</h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <div style="background: var(--muted); padding: 1rem; border-radius: 0.5rem;">
                <div style="color: var(--muted-foreground); font-size: 0.875rem;">Total Workouts</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">
                    {{ $user->workoutLogs()->count() }}
                </div>
            </div>

            <div style="background: var(--muted); padding: 1rem; border-radius: 0.5rem;">
                <div style="color: var(--muted-foreground); font-size: 0.875rem;">Total Spent</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">
                    ₱{{ number_format($user->transactions()->where('status', 'completed')->sum('amount'), 2) }}
                </div>
            </div>

            <div style="background: var(--muted); padding: 1rem; border-radius: 0.5rem;">
                <div style="color: var(--muted-foreground); font-size: 0.875rem;">Member Since</div>
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--primary);">
                    {{ $user->created_at->format('M Y') }}
                </div>
            </div>

            <div style="background: var(--muted); padding: 1rem; border-radius: 0.5rem;">
                <div style="color: var(--muted-foreground); font-size: 0.875rem;">Subscriptions</div>
                <div style="font-size: 2rem; font-weight: 700; color: var(--primary);">
                    {{ $user->subscriptions()->count() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('index.footer')

@endsection
