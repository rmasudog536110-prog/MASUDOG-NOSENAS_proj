<link rel="stylesheet" href="{{ asset('css/index_header.css') }}">

<!-- Header -->
<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="{{ url('/') }}">
                    <h1>FitClub</h1>
                </a>
            </div>

            <nav class="nav">
                <a href="{{ url('/') }}" 
                   class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                    <i class="fa-solid fa-house-user"></i> Home
                </a>

                @auth
                    <a href="{{ route('programs') }}" 
                       class="nav-link {{ request()->is('programs*') ? 'active' : '' }}">
                        Programs
                    </a>
                    <a href="{{ route('exercises') }}" 
                       class="nav-link {{ request()->is('exercises*') ? 'active' : '' }}">
                        Exercises
                    </a>
                    <a href="{{ route('user_dashboard') }}" 
                       class="nav-link {{ request()->is('dashboard') || request()->is('admin*') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i> Dashboard
                    </a>
                    <a href="{{ route('workout-logs.index') }}" 
                       class="nav-link {{ request()->is('workout-logs*') ? 'active' : '' }}">
                        <i class="fa-solid fa-dumbbell"></i> Workouts
                    </a>
                    <a href="{{ route('profile.show') }}" 
                       class="nav-link {{ request()->is('profile*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i> Profile
                    </a>
                @endauth
            </nav>

            <div class="header-actions">
                @auth
                    <div class="user-info">
                        <span class="user-name">Welcome, {{ Auth::user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline">Logout</button>
                        </form>
                    </div>
                @endauth

                @guest
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline">Sign Up</a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>

<!-- Mobile Menu Toggle -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('.nav');
    
    // Create mobile menu button
    if (!document.querySelector('.mobile-menu-btn')) {
        const mobileBtn = document.createElement('button');
        mobileBtn.className = 'mobile-menu-btn';
        mobileBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
        mobileBtn.setAttribute('aria-label', 'Toggle navigation menu');
        mobileBtn.setAttribute('aria-expanded', 'false');

        mobileBtn.onclick = () => {
            nav.classList.toggle('mobile-open');
            const isOpen = nav.classList.contains('mobile-open');
            mobileBtn.innerHTML = isOpen ? '<i class="fa-solid fa-times"></i>' : '<i class="fa-solid fa-bars"></i>';
            mobileBtn.setAttribute('aria-expanded', isOpen);
        };

        document.querySelector('.logo').after(mobileBtn);
    }

    // Close menu when clicking a nav link (mobile)
    document.querySelectorAll('.nav-link').forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                nav.classList.remove('mobile-open');
                const mobileBtn = document.querySelector('.mobile-menu-btn');
                if (mobileBtn) {
                    mobileBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
                    mobileBtn.setAttribute('aria-expanded', 'false');
                }
            }
        });
    });

    // Close mobile menu on outside click
    document.addEventListener('click', (event) => {
        if (window.innerWidth <= 768) {
            const isInside = nav.contains(event.target) || event.target.closest('.mobile-menu-btn');
            if (!isInside && nav.classList.contains('mobile-open')) {
                nav.classList.remove('mobile-open');
                const mobileBtn = document.querySelector('.mobile-menu-btn');
                if (mobileBtn) {
                    mobileBtn.innerHTML = '<i class="fa-solid fa-bars"></i>';
                    mobileBtn.setAttribute('aria-expanded', 'false');
                }
            }
        }
    });
});
</script>
