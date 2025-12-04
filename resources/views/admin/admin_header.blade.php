<link rel="stylesheet" href="{{ asset('css/header.css') }}">

<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="{{ route('admin.admin_dashboard') }}">
                    <h1>FitClub</h1>
                </a>
            </div>

            <nav class="nav">
                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin Links -->
                        <a href="{{ route('admin.programs.index') }}" class="nav-link {{ request()->routeIs('admin.programs*') ? 'active' : '' }}">
                            <i class="fa-solid fa-layer-group"></i> Programs
                        </a>
                        <a href="{{ route('admin.exercises.index') }}" class="nav-link {{ request()->routeIs('exercises*') ? 'active' : '' }}">
                            <i class="fa-solid fa-weight-hanging"></i> Exercises
                        </a>
                        <a href="{{ route('admin.admin_dashboard') }}" class="nav-link {{ request()->routeIs('admin_dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-house-user" style="font-size: 2rem"></i> 
                        </a>
                        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <i class="fa-solid fa-users"></i> Users
                        </a>
                    @else
                        <!-- Regular User Links -->
                        <a href="{{ route('user_dashboard') }}" class="nav-link {{ request()->routeIs('user_dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-house-user" style="font-size: 2rem"></i> 
                        </a>
                        <a href="{{ route('workout-logs.index') }}" class="nav-link {{ request()->routeIs('workout-logs*') ? 'active' : '' }}">
                            <i class="fa-solid fa-fire"></i> Workouts
                        </a>
                    @endif
                    
                    <a href="{{ route('profile.show') }}" class="nav-link {{ request()->routeIs('profile*') ? 'active' : '' }}">
                        <i class="fa-solid fa-user"></i> Profile
                    </a>
                @endauth
            </nav>

            <div class="header-actions">
                @auth
                    <div class="user-info">
                        
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const nav = document.querySelector('.nav');
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
