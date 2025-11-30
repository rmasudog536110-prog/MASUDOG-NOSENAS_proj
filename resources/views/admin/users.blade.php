@extends('skeleton.layout')

@section('title', 'Manage Users - Admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .users-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .users-table {
            width: 100%;
            background: var(--card);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .users-table th {
            background: rgba(255, 102, 0, 0.1);
            padding: 1rem;
            text-align: left;
            color: var(--primary);
        }

        .users-table td {
            padding: 1rem;
            border-bottom: 1px solid rgba(255, 102, 0, 0.1);
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.875rem;
            font-weight: 600;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
        }

        .status-inactive {
            background: rgba(220, 53, 69, 0.2);
            color: #dc3545;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
    </style>
@endpush

@section('content')

@include('admin.admin_header')


<section class="content-section">
    <div class="container">
        <div class="users-header">
            <div>
                <h1>Manage Users</h1>
                <p style="color: var(--muted-foreground);">View and manage all gym members</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline">
                <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="flash-message success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="flash-message error">
                {{ session('error') }}
            </div>
        @endif

        <!-- Users Table -->
        <div class="dashboard-card">
            <table class="users-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Subscription</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone_number ?? 'N/A' }}</td>
                            <td>
                                <span class="status-badge {{ $user->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                @php
                                    $activeSub = $user->subscriptions()
                                        ->where('end_date', '>', now())
                                        ->latest()
                                        ->first();
                                @endphp
                                @if($activeSub)
                                    {{ $activeSub->plan->name ?? 'N/A' }}
                                @else
                                    <span style="color: var(--muted-foreground);">No active plan</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('admin.edit-user', $user) }}" 
                                       class="btn btn-outline btn-sm"
                                       title="Edit User">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.toggle-status', $user) }}" 
                                          method="POST" 
                                          style="display: inline;">
                                        @csrf
                                        <button type="submit" 
                                                class="btn btn-outline btn-sm"
                                                title="{{ $user->is_active ? 'Deactivate' : 'Activate' }}">
                                            <i class="fa-solid fa-{{ $user->is_active ? 'ban' : 'check' }}"></i>
                                        </button>
                                    </form>

                                    <form action="{{ route('admin.delete-user', $user) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-outline btn-sm"
                                                style="color: #dc3545; border-color: #dc3545;"
                                                title="Delete User">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 3rem; color: var(--muted-foreground);">
                                No users found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- Pagination -->
            @if($users->hasPages())
                <div style="margin-top: 2rem;">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</section>

@include('index.footer')

@endsection
