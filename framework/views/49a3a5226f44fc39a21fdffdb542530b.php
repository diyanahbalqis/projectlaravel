

<?php $__env->startSection('title','Edit Page'); ?>
<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('userinfo.update', $users->id)); ?>" method="POST" enctype="multipart/form-data">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <input type="text" name="staff_id" placeholder="Staff Id" value="<?php echo e(old('staff_id', $users->staff_id)); ?>">
    <input type="text" name="name" placeholder="Name" value="<?php echo e(old('name', $users->name)); ?>">
    <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email', $users->email)); ?>">
    <input type="text" name="phone" placeholder="Phone" value="<?php echo e(old('phone', $users->phone ?? '')); ?>">
    <!-- <input type="text" name="address" placeholder="Address" value="<?php echo e(old('address', $users->address ?? '')); ?>"> -->
    <input type="text" name="department" placeholder="Department" value="<?php echo e(old('department', $users->department ?? '')); ?>">

    <!-- Approval Dropdown -->
    <select name="approval" class="form-select form-select-sm">
        <option value="0" <?php echo e(old('approval', $users->approval) == 0 ? 'selected' : ''); ?>>Pending</option>
        <option value="1" <?php echo e(old('approval', $users->approval) == 1 ? 'selected' : ''); ?>>Approved</option>
        <option value="2" <?php echo e(old('approval', $users->approval) == 2 ? 'selected' : ''); ?>>Rejected</option>
    </select>

    <input type="file" name="profile_picture">

    <button type="submit">Update</button>
</form>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/userinfo/edit.blade.php ENDPATH**/ ?>