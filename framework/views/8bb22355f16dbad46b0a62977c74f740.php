

<?php $__env->startSection('title','Setting'); ?>

<?php $__env->startSection('content'); ?>

    <div class="container mt-4">
    <h4> Update Password </h4>

    <?php $__sessionArgs = ['success'];
if (session()->has($__sessionArgs[0])) :
if (isset($value)) { $__sessionPrevious[] = $value; }
$value = session()->get($__sessionArgs[0]); ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <?php echo e($value); ?>

    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php unset($value);
if (isset($__sessionPrevious) && !empty($__sessionPrevious)) { $value = array_pop($__sessionPrevious); }
if (isset($__sessionPrevious) && empty($__sessionPrevious)) { unset($__sessionPrevious); }
endif;
unset($__sessionArgs); ?>

<?php if(session('error')): ?>
<div class="alert alert-danger">
    <?php echo e(session('error')); ?>

</div>
<?php endif; ?>

    <div class="card- mt-4">
        <div class="card-header"> Change Your Password </div>
        <div class="card-body">
            <br>
            <form method="POST" action="<?php echo e(route ('settings.updatePassword')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label> Current Password </label>
                    <input type="password" name="current_password" class="form-control" required></input>
                </div>
                <div class=mb-3>
                    <label> New Password </label>
                    <input type="password" name="new_password" class="form-control" required></input>
                </div>
                <div class="mb3">
                    <label> Confirm Password </label>
                    <input type="password" name="new_password_confirmation" class="form-control" required></input>
                </div>
                <br>
                <button type="submit" class="btn btn-primary"> Update password </button>
            </form>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/settings/index.blade.php ENDPATH**/ ?>