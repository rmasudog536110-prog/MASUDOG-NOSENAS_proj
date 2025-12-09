@extends('skeleton.layout')

@section('title', 'Forgot Password | FitClub')

@section('content')
<div class="d-flex justify-content-center align-items-center min-vh-100 bg-light">
    <div class="card shadow px-4 py-5" style="max-width: 400px; width: 100%; border-radius: 18px;">
        <div class="card-header bg-white text-center border-0 mb-3" style="font-size:1.4rem; font-weight:600; color:#444; letter-spacing: .02em;">
            <i class="fa-solid fa-unlock-keyhole text-primary me-2"></i> Forgot Your Password?
        </div>

        <div class="card-body p-0">
            @if (session('status'))
                <div class="alert alert-success text-center mb-4" style="border-radius: 8px;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label fw-semibold">E-Mail Address</label>
                    <input type="email" name="email" id="email" class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-2 rounded-pill" style="font-weight: 600; letter-spacing: .03em;">
                    <i class="fa-solid fa-paper-plane me-1"></i> Send Password Reset Link
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