

<?php $__env->startSection('title','User Profile'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-5">
    <?php
        // $users = Auth::user()->id; 
    ?>

    

    <div class="card shadow-sm p-4 mt-5">
        <div class="text-center mb-4">
            <img src="<?php echo e(asset('storage/images/profilepic.jpg')); ?>" class="rounded-circle border" alt="user profile" width="150" height="150">
            
        <p><strong>Name:</strong> <?php echo e($users->name); ?></p>
        <p><strong>Staff ID:</strong> <?php echo e($users->staff_id); ?></p>
        <p><strong>Email:</strong> <?php echo e($users->email); ?></p>
        <p><strong>Role:</strong> <?php echo e($users->role); ?></p>
        <p><strong>Created at:</strong> <?php echo e($users->created_at->format('d M Y')); ?></p>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/userinfo/userprofile.blade.php ENDPATH**/ ?>