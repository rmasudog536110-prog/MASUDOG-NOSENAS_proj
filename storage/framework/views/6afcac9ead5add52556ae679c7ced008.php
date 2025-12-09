<link rel="stylesheet" href="<?php echo e(asset('css/header.css')); ?>">

<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="<?php echo e(route('admin.admin_dashboard')); ?>">
                    <h1>FitClub</h1>
                </a>
            </div>

            <nav class="nav">
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <!-- Admin Links -->
                        <a href="<?php echo e(route('admin.programs.index')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.programs*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-layer-group"></i> Programs
                        </a>
                        <a href="<?php echo e(route('admin.exercises.index')); ?>" class="nav-link <?php echo e(request()->routeIs('exercises*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-weight-hanging"></i> Exercises
                        </a>
                        <a href="<?php echo e(route('admin.admin_dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('admin_dashboard') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-house-user" style="font-size: 2rem"></i> 
                        </a>
                        <a href="<?php echo e(route('admin.users')); ?>" class="nav-link <?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-users"></i> Users
                        </a>
                    <?php else: ?>
                        <!-- Regular User Links -->
                        <a href="<?php echo e(route('user_dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('user_dashboard') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-house-user" style="font-size: 2rem"></i> 
                        </a>
                        <a href="<?php echo e(route('workout-logs.index')); ?>" class="nav-link <?php echo e(request()->routeIs('workout-logs*') ? 'active' : ''); ?>">
                            <i class="fa-solid fa-fire"></i> Workouts
                        </a>
                    <?php endif; ?>
                    
                    <a href="<?php echo e(route('profile.show')); ?>" class="nav-link <?php echo e(request()->routeIs('profile*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-user"></i> Profile
                    </a>
                <?php endif; ?>
            </nav>

            <div class="header-actions">
                <?php if(auth()->guard()->check()): ?>
                    <div class="user-info">
                        
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline">Logout</button>
                        </form>
                    </div>
                <?php endif; ?>

                <?php if(auth()->guard()->guest()): ?>
                    <div class="auth-buttons">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline">Login</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-outline">Sign Up</a>
                    </div>
                <?php endif; ?>
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
<?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\admin\admin_header.blade.php ENDPATH**/ ?>