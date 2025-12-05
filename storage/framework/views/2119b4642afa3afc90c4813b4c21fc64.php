<link rel="stylesheet" href="<?php echo e(asset('css/header.css')); ?>">


<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="logo">
                <a href="<?php echo e(route('user_dashboard')); ?>">
                    <h1>FitClub</h1>
                </a>
            </div>

            <nav class="nav">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('programs.index')); ?>" class="nav-link <?php echo e(request()->is('programs*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-layer-group"></i> Programs</a>
                    <a href="<?php echo e(route('exercises.index')); ?>" class="nav-link <?php echo e(request()->is('exercises*') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-weight-hanging"></i> Exercises</a>
                    <a href="<?php echo e(url('/user_dashboard')); ?>" class="nav-link <?php echo e(request()->is('user_dashboard') ? 'active' : ''); ?>">
                    <i class="fa-solid fa-house-user" style="font-size: 2rem"></i> 
                    </a>
                    <a href="<?php echo e(route('customer.instructor-requests')); ?>" class="nav-link <?php echo e(request()->is('instructor-requests') ? 'active' : ''); ?>">
                        <i class="fa-solid fa-dumbbell"></i> Instructor
                    </a>
                    <a href="<?php echo e(route('profile.show')); ?>" class="nav-link <?php echo e(request()->is('profile*') ? 'active' : ''); ?>">
                        Profile
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
<?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/index/header.blade.php ENDPATH**/ ?>