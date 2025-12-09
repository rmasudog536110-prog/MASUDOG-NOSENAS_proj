@extends('skeleton.layout')

@section('title', 'Reset Password | FitClub')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush
@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100" style="background: var(--background);">
    <div class="dashboard-card shadow px-4 py-5" style="max-width: 400px; width: 100%; border-radius: var(--radius);">
        <div class="text-center mb-3" style="font-size:1.4rem; font-weight:600; color:var(--primary); letter-spacing: .02em;">
            <i class="fa-solid fa-key text-primary me-2"></i> Reset Password
        </div>
        <div class="card-body p-0">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold" style="color: var(--foreground);">New Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback" style="color: #ff4c4c;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold" style="color: var(--foreground);">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg rounded-3 @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback" style="color: #ff4c4c;">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2 rounded-pill" style="font-weight: 600; letter-spacing: .03em; box-shadow: 0 4px 12px rgba(255,102,0,0.25);">
                    <i class="fa-solid fa-rotate me-1"></i> Reset Password
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