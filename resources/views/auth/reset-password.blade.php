@extends('skeleton.layout')

@section('title', 'Reset Password | FitClub')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow px-4 py-5" style="max-width: 400px; width: 100%; border-radius: 18px;">
        <div class="card-header bg-white text-center border-0 mb-3" style="font-size:1.4rem; font-weight:600; color:#444; letter-spacing: .02em;">
            <i class="fa-solid fa-key text-primary me-2"></i> Reset Password
        </div>
        <div class="card-body p-0">
            <form method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">
                <div class="mb-3">
                    <label for="password" class="form-label fw-semibold">New Password</label>
                    <input type="password" name="password" id="password" class="form-control form-control-lg rounded-3 @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg rounded-3 @error('password_confirmation') is-invalid @enderror" required>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2 rounded-pill" style="font-weight: 600; letter-spacing: .03em;">
                    <i class="fa-solid fa-rotate me-1"></i> Reset Password
                </button>
                <div class="d-flex justify-content-between mt-2">
                    <a href="{{ route('login') }}" class="small text-primary">Back to Login</a>
                    <a href="/" class="small text-muted">Home</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection