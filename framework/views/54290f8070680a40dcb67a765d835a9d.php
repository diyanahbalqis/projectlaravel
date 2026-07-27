<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - ICT Equipment Rental</title>
    
    <link rel="stylesheet" href="<?php echo e(asset('css/login.css')); ?>">
</head>
<body>
    
    <div class="signin-container">
        <div class="brand">
            <div class="brand-logo">ICT</div>
            <div class="brand-name">ICTRent Pro</div>
            <div class="brand-tagline">ICT Equipment Rental</div>
        </div>

        <h1>Welcome Back</h1>
        <p class="subtitle">Sign in to access your account</p>

        <!-- Session Status -->
        <?php if(session('status')): ?>
            <div class="status-message">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>

            <div class="form-group">
                <label for="staff_id">STAFF ID</label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="staff_id" 
                           name="staff_id" 
                           value="<?php echo e(old('staff_id')); ?>" 
                           placeholder="Enter your username"
                           required 
                           autofocus 
                           autocomplete="username">
                    <?php $__errorArgs = ['staff_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Enter your password" 
                           required 
                           autocomplete="current-password">
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="options">
                <div class="remember-me">
                    <input type="checkbox" id="remember_me" name="remember">
                    <label for="remember_me">Remember me</label>
                </div>
                <?php if(Route::has('password.request')): ?>
                    <a href="<?php echo e(route('password.request')); ?>" class="forgot-link">Forgot password?</a>
                <?php endif; ?>
            </div>

            <button type="submit" class="signin-btn">
                Log in
            </button>
        </form>
        
        <div class="signup-prompt">
            Don't have an account?<a href="<?php echo e(route('register')); ?>">Create one now</a>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\projectlaravel\resources\views/auth/login.blade.php ENDPATH**/ ?>