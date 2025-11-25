@extends('skeleton.layout')

@section('title', 'Admin Dashboard - FitClub')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .admin-header {
            background: linear-gradient(135deg, #ff6600 0%, #e65c00 100%);
            padding: 2rem;
            border-radius: 1rem;
            margin-bottom: 2rem;
            color: white;
        }

        .admin-header h1 {
            margin: 0 0 0.5rem 0;
            color: white;
        }

        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .admin-stat-card {
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.3);
            border-radius: var(--radius);
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .admin-stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 102, 0, 0.3);
        }

        .stat-label {
            color: var(--muted-foreground);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .admin-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .admin-action-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 1.5rem;
            background: var(--card);
            border: 1px solid rgba(255, 102, 0, 0.2);
            border-radius: var(--radius);
            color: var(--foreground);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .admin-action-btn:hover {
            background: var(--primary);
            color: white;
            transform: translateY(-3px);
        }

        .recent-users-table {
            width: 100%;
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .recent-users-table th {
            background: rgba(255, 102, 0, 0.1);
            padding: 1rem;
            text-align: left;
            color: var(--primary);
        }

        .recent-users-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.1);
        }

        .recent-users-table tr:last-child td {
            border-bottom: none;
        }
    </style>
@endpush

@section('content')

@include('index.header')

<section class="content-section">
    <div class="container">
        <!-- Admin Header -->
        <div class="admin-header">
            <h1><i class="fa-solid fa-shield-halved"></i> Admin Dashboard</h1>
        </div>


        <!-- Flash Messages -->
        @if (session('success'))
            <div class="flash-message success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Stats -->
        <div class="admin-stats">
            <div class="admin-stat-card">
                <div class="stat-label">Total Users</div>
                <div class="stat-value count-display">{{ $stats['total_users'] }}</div>
            </div>

            <div class="admin-stat-card">
                <div class="stat-label">Active Subscriptions</div>
                <div class="stat-value count-display">{{ $stats['active_subscriptions'] }}</div>
            </div>

            <div class="admin-stat-card">
                <div class="stat-label">Total Revenue</div>
                <div class="stat-value price-display">₱{{ number_format($stats['total_revenue'], 2) }}</div>
            </div>

            
            <div class="admin-stat-card" style="border-color: rgba(255, 193, 7, 0.5);">
                <div class="stat-label">⏳ Pending Payments</div>
                <div class="stat-value count-display" style="color: #ffc107;">{{ $stats['pending_payments'] }}</div>
            </div>
        </div>

        <!-- Pending Payments -->
        @if($pendingPayments->count() > 0)
        <div class="dashboard-card" style="margin-bottom: 2rem; border-color: rgba(255, 193, 7, 0.5);">
            <h3 style="color: var(--foreground); margin-bottom: 1.5rem;">
                <i class="fa-solid fa-clock"></i> Pending Payment Approvals
            </h3>
            <div class="table-responsive">
                <table class="recent-users-table">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Plan</th>
                            <th>Amount</th>
                            <th>Submitted</th>
                            <th>Payment Proof</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendingPayments as $subscription)
                        <tr>
                            <td>{{ $subscription->user->name }}</td>
                            <td>{{ $subscription->plan->name }}</td>
                            <td class="price-display">₱{{ number_format($subscription->plan->price, 2) }}</td>
                            <td>{{ $subscription->created_at->diffForHumans() }}</td>
                            <td>
                                @php
                                    $transaction = $subscription->payments->first();
                                    $paymentProof = $transaction ? ($transaction->payment_details['proof_path'] ?? null) : null;
                                @endphp
                                @if($paymentProof)
                                    <a href="{{ asset('storage/' . $paymentProof) }}" 
                                       target="_blank" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fa-solid fa-image"></i> View Proof
                                    </a>
                                @else
                                    <span class="text-muted">No proof uploaded</span>
                                @endif
                            </td>
                            <td>
                                <div style="display: flex; gap: 0.5rem;">
                                    <form action="{{ route('admin.subscriptions.approve', $subscription->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve this subscription?')">
                                            <i class="fa-solid fa-check"></i> Approve
                                        </button>
                                    </form>
                                    <button type="button" class="btn btn-sm btn-danger" onclick="showRejectModal({{ $subscription->id }})">
                                        <i class="fa-solid fa-times"></i> Reject
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <!-- Quick Actions -->
        <h2 style="margin-bottom: 1rem;">Quick Actions</h2>
        <div class="admin-actions">
            <a href="{{ route('admin.users') }}" class="admin-action-btn">
                <i class="fa-solid fa-users"></i>
                Manage Users
            </a>
            <a href="{{ route('admin.programs.index') }}" class="admin-action-btn">
                <i class="fa-solid fa-dumbbell"></i>
                Manage Programs
            </a>
            <a href="{{ route('admin.exercises.index') }}" class="admin-action-btn">
                <i class="fa-solid fa-list"></i>
                Manage Exercises
            </a>
            <a href="{{ route('dashboard') }}" class="admin-action-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Site
            </a>
        </div>

        <!-- Recent Users -->
        <div class="dashboard-card">
            <h3>Recent Users</h3>
            <table class="recent-users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentUsers as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number ?? 'N/A' }}</td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <a href="{{ route('admin.edit-user', $user) }}" class="btn btn-outline btn-sm">
                                    <i class="fa-solid fa-edit"></i> Edit
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; color: var(--muted-foreground);">
                                No users yet
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($recentUsers->count() > 0)
                <div style="text-align: center; margin-top: 1.5rem;">
                    <a href="{{ route('admin.users') }}" class="btn btn-primary">
                        View All Users
                    </a>
                </div>
            @endif
        </div>
    </div>
</section>

@include('index.footer')

<!-- Reject Modal -->
<div id="rejectModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--card); padding: 2rem; border-radius: 1rem; max-width: 500px; width: 90%;">
        <h3 style="color: var(--foreground); margin-bottom: 1rem;">Reject Subscription</h3>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 1rem;">
                <label style="color: var(--foreground); display: block; margin-bottom: 0.5rem;">Reason for Rejection:</label>
                <textarea name="admin_notes" required style="width: 100%; padding: 0.75rem; background: rgba(255,102,0,0.05); border: 1px solid rgba(255,102,0,0.2); border-radius: 0.5rem; color: var(--foreground); min-height: 100px;"></textarea>
            </div>
            <div style="display: flex; gap: 1rem;">
                <button type="submit" class="btn btn-danger" style="flex: 1;">
                    <i class="fa-solid fa-times"></i> Reject
                </button>
                <button type="button" class="btn btn-outline" style="flex: 1;" onclick="closeRejectModal()">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showRejectModal(subscriptionId) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = `/admin/subscriptions/${subscriptionId}/reject`;
        modal.style.display = 'flex';
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').style.display = 'none';
    }

    // Close modal on outside click
    document.getElementById('rejectModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeRejectModal();
        }
    });
</script>

@endsection
