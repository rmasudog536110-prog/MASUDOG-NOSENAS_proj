<?php
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
?>

<link rel="stylesheet" href="{{ asset('css/header.css') }}">

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
                       class="nav-link {{ request()->is('programs') ? 'active' : '' }}">
                        Programs
                    </a>
                    <a href="{{ route('exercises') }}" 
                       class="nav-link {{ request()->is('exercises') ? 'active' : '' }}">
                        Exercises
                    </a>
                    <a href="{{ route('dashboard') }}" 
                       class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        Dashboard
                    </a>
                @endauth
            </nav>

            <div class="header-actions">
                @auth
                    <div class="user-info">
                        <span class="user-name">
                            Welcome, {{ Auth::user()->name }}
                        </span>
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


<!-- Mobile Menu Toggle (for responsive design) -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add mobile menu functionality if needed
    const header = document.querySelector('.header');
    const nav = document.querySelector('.nav');
    
    // Add mobile menu button if not exists
    if (window.innerWidth <= 768 && !document.querySelector('.mobile-menu-btn')) {
        const mobileBtn = document.createElement('button');
        mobileBtn.className = 'mobile-menu-btn';
        mobileBtn.innerHTML = '☰';
        mobileBtn.onclick = function() {
            nav.classList.toggle('mobile-open');
        };
        document.querySelector('.header-content').insertBefore(mobileBtn, nav);
    }
});
</script>