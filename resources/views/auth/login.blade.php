<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitClub</title>
    <!-- use asset() so the path resolves correctly in Laravel -->
    <link rel="stylesheet" href="{{ asset('css/HTML-CSS.styles') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <main class="content-section">
        <div class="container">
            <div class="form-container">
                <h1 class="text-center" style="margin-bottom: 2rem;">Login to FitClub</h1>

                {{-- flash success (if any) --}}
                @if(session('success'))
                    <div class="flash-message success" style="margin-bottom:1.5rem; padding:1rem; border-radius:var(--radius);">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- single login error (e.g. returned via withErrors(['login' => '...'])) --}}
                @if ($errors->has('login'))
                    <div class="flash-message error" style="margin-bottom: 1.5rem; padding: 1rem; border-radius: var(--radius);">
                        {{ $errors->first('login') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="email">Email Address</label>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                            value="{{ old('email') }}"
                            required
                        >
                        @if ($errors->has('email'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('email') }}</div>
                        @endif
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}"
                            required
                        >
                        @if ($errors->has('password'))
                            <div class="form-error text-danger small mt-1">{{ $errors->first('password') }}</div>
                        @endif
                    </div>

                    <button type="submit" class="btn btn-primary btn-full mt-3">Login</button>
                </form>

                <div class="text-center" style="margin-top: 2rem;">
                    <p>Don't have an account? <a href="{{ url('/register') }}" style="color: var(--primary); font-weight: var(--font-weight-medium);">Sign up here</a></p>
                    <p><a href="{{ url('/forgot-password') }}" style="color: var(--muted-foreground);">Forgot your password?</a></p>
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const submitBtn = form.querySelector('button[type="submit"]');

            form.addEventListener('submit', function() {
                submitBtn.textContent = 'Logging in...';
                submitBtn.disabled = true;
            });

            // safely inject whether there were server-side validation errors
            const hasErrors = @json($errors->any());
            if (hasErrors) {
                // restore button if validation failed
                submitBtn.textContent = 'Login';
                submitBtn.disabled = false;
            }
        });
    </script>
</body>
</html>
