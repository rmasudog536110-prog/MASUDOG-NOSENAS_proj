@extends('skeleton.layout')

@section('title', 'Forgot Password | FitClub')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: var(--background);">
    <div class="dashboard-card shadow px-4 py-5" style="max-width: 400px; width: 100%; border-radius: var(--radius);">
        <div class="text-center mb-3" style="font-size:1.4rem; font-weight:600; color:var(--primary); letter-spacing: .02em;">
            <i class="fa-solid fa-unlock-keyhole text-primary me-2"></i> Forgot Your Password?
        </div>
        <div class="card-body p-0">
            @if (session('status'))
                <div class="flash-message success text-center mb-4" style="border-radius: 8px;">
                    {{ session('status') }}
                </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold" style="color: var(--foreground);">E-Mail Address</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback" style="color: #ff4c4c;">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2 rounded-pill" style="font-weight: 600; letter-spacing: .03em; box-shadow: 0 4px 12px rgba(255,102,0,0.25);">
                    <i class="fa-solid fa-paper-plane me-1"></i> Send Password Reset Link
                </button>
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('login') }}" class="small" style="color: var(--primary);">Back to Login</a>
                    <a href="/" class="small" style="color: var(--muted-foreground);">Home</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection