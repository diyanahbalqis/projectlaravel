<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - ICT Equipment Rental</title>
   
    <link rel="stylesheet" href="<?php echo e(asset ('css/register.css')); ?>">
</head>
<body>
    <div class="register-container">
        <div class="brand">
            <div class="brand-logo">ICT</div>
            <div class="brand-name">ICTRent Pro</div>
            <div class="brand-tagline">ICT Equipment Rental</div>
        </div>

        <h1>Create Account</h1>
        <p class="subtitle">Register to start renting equipment</p>

        <form method="POST" action="<?php echo e(route('register')); ?>">
            <?php echo csrf_field(); ?>

            <!-- Name -->
            <div class="form-group">
                <label for="name">Name</label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="name" 
                           name="name" 
                           value="<?php echo e(old('name')); ?>" 
                           placeholder="Enter your full name"
                           required 
                           autofocus 
                           autocomplete="name">
                    <?php $__errorArgs = ['name'];
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
    <label for="role">Role</label>
    <div class="input-wrapper">
        <select name="role" 
                id="role" 
                required 
                class="form-control">
            <option value="">Select Role</option>
            <option value="user" <?php echo e(old('role') == 'user' ? 'selected' : ''); ?>>User</option>
            <option value="admin" <?php echo e(old('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
        </select>
        <?php $__errorArgs = ['role'];
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

            <!-- Staff ID -->
            <div class="form-group">
                <label for="staff_id">Staff ID</label>
                <div class="input-wrapper">
                    <input type="text" 
                           id="staff_id" 
                           name="staff_id" 
                           value="<?php echo e(old('staff_id')); ?>" 
                           placeholder="Enter your staff ID"
                           required 
                           autocomplete="staff_id">
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

            <!-- Email Address -->
           <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php echo e(old('email')); ?>" required>
        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="error-message"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password" 
                           name="password" 
                           placeholder="Create a strong password"
                           required 
                           autocomplete="new-password">
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

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation">Confirm Password</label>
                <div class="input-wrapper">
                    <input type="password" 
                           id="password_confirmation" 
                           name="password_confirmation" 
                           placeholder="Re-enter your password"
                           required 
                           autocomplete="new-password">
                    <?php $__errorArgs = ['password_confirmation'];
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

            <button type="submit" class="register-btn">
                Register
            </button>
        </form>

        <div class="signin-prompt">
            Already registered?<a href="<?php echo e(route('login')); ?>">Sign in here</a>
        </div>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\projectlaravel\resources\views/auth/register.blade.php ENDPATH**/ ?>