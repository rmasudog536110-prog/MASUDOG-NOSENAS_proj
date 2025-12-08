@extends('skeleton.layout')

@section('title', 'Instructor Requests - Instructor')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
    .requests-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; }
    .requests-table { width: 100%; background: var(--card); border-radius: var(--radius); overflow: hidden; }
    .requests-table th { background: rgba(0,123,255,0.1); padding:1rem; text-align:left; color:var(--primary); }
    .requests-table td { padding:1rem; border-bottom:1px solid rgba(0,123,255,0.1); }
    .status-badge { padding:0.25rem 0.75rem; border-radius:0.5rem; font-size:.875rem; font-weight:600; }
    .status-pending { background: rgba(255,193,7,0.2); color:#ffc107; }
    .status-accepted { background: rgba(40,167,69,0.2); color:#28a745; }
    .status-declined, .status-cancelled { background: rgba(220,53,69,0.2); color:#dc3545; }
    .status-completed { background: rgba(0,123,255,0.2); color:#007bff; }
    .action-buttons { display:flex; gap:0.5rem; }
</style>
@endpush

@section('content')
@include('index.header')

<section class="content-section">
<div class="container">
    <div class="requests-header">
        <div>
            <h1>Instructor Requests</h1>
            <p style="color: var(--muted-foreground);">View all users who requested an instructor</p>
        </div>
        <a href="{{ route('instructor.instructor_dashboard') }}" class="btn btn-outline">
            <i class="fa-solid fa-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    @if(session('success'))
        <div class="flash-message success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="flash-message error">{{ session('error') }}</div>
    @endif

    <div class="dashboard-card">
        <table class="requests-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Exercise Type</th>
                    <th>Preferred Date</th>
                    <th>Preferred Time</th>
                    <th>Status</th>
                    <th>Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->customer_name }}</td>
                        <td>{{ $request->customer_email }}</td>
                        <td>{{ $request->customer_phone ?? 'N/A' }}</td>
                        <td>{{ ucfirst($request->exercise_type) }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->preferred_date)->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($request->preferred_time)->format('H:i') }}</td>
                        <td>
                            <span class="status-badge status-{{ $request->status }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td>{{ $request->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="action-buttons">
                                @if($request->status === 'pending')
                                    <form action="{{ route('instructor.requests.accept', $request) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-sm" title="Accept">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('instructor.requests.decline', $request) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-sm" title="Decline">
                                            <i class="fa-solid fa-ban"></i>
                                        </button>
                                    </form>
                                @elseif($request->status === 'accepted')
                                    <form action="{{ route('instructor.requests.complete', $request) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-outline btn-sm" title="Mark Completed">
                                            <i class="fa-solid fa-check-double"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center" style="padding:3rem; color:var(--muted-foreground);">
                            No instructor requests found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        @if($requests->hasPages())
            <div style="margin-top:2rem;">{{ $requests->links() }}</div>
        @endif
    </div>
</div>
</section>

@include('index.footer')
@endsection
