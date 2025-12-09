@extends('skeleton.layout')

@section('title', 'Pending Approval')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <div class="dashboard-welcome">
        <h1 class="welcome-title">Pending Approval</h1>
        <p class="welcome-subtitle" style="margin-left: 200px;">
            Your account is currently waiting for admin approval. 
            You will receive a notification once your account is approved.
        </p>
        <div class="empty-state">
            <i class="fa-solid fa-hourglass-half empty-state-icon"></i>
            <p>Please be patient while we review your account.</p>
        </div>
        <div class="quick-actions-pending" style="justify-content: center; margin-top: 1.5rem;">
            <form method="POST" action="{{ route('logout') }}">
                @csrf   
                <button type="submit" class="btn btn-outline">Logout</button>
            </form>
        </div>
    </div>
</div>
@endsection
