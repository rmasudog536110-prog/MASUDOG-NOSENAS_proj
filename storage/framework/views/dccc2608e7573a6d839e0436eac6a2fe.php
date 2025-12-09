    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login - FitClub</title>

    
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">

        

    </head>

    <body>
        <main>
            <h2 class="text-center mb-4 fw-bold">Welcome to FitClub</h2>
            <div class="login-card">
                <div class="login-image"></div>
                <div class="login-body">

                    
                    <?php if(session('success')): ?>
                        <div class="flash-message success mb-3">
                            <?php echo e(session('success')); ?>

                        </div>
                    <?php endif; ?>

                    
                    <?php if($errors->has('login')): ?>
                        <div class="flash-message error mb-3">
                            <?php echo e($errors->first('login')); ?>

                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input 
                                type="email" 
                                id="email" 
                                name="email" 
                                class="form-control <?php echo e($errors->has('email') ? 'is-invalid' : ''); ?>"
                                value="<?php echo e(old('email')); ?>"
                                required
                            >
                            <?php if($errors->has('email')): ?>
                                <div class="text-danger small mt-1"><?php echo e($errors->first('email')); ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                class="form-control <?php echo e($errors->has('password') ? 'is-invalid' : ''); ?>"
                                required
                            >
                            <?php if($errors->has('password')): ?>
                                <div class="text-danger small mt-1"><?php echo e($errors->first('password')); ?></div>
                            <?php endif; ?>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Login</button>
                    </form>

                    <div class="text-muted mt-3">
                        <p class="mb-1"> <a href="<?php echo e(url('/register')); ?>">Don’t have an account? Sign up</a></p>
                        <p><a href="<?php echo e(url('/forgot-password')); ?>">Forgot your password?</a></p>
                    </div>
                </div>
            </div>
        </main>
    </body>
    </html>
<?php /**PATH C:\xampp\htdocs\backup\MASUDOG-NOSENAS_proj\resources\views\auth\login.blade.php ENDPATH**/ ?>