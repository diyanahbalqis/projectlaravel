

<?php $__env->startSection('title', 'role'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    <h2>Settings Role</h2>

    
<?php if(Auth::user()->role === 'admin'): ?>
<div class="card mt-5">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span>Admin Settings</span>
        <form method="GET" action="<?php echo e(route('settings.role')); ?>" class="d-flex" style="gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Search by email" 
                   value="<?php echo e(request('search')); ?>" style="width: 250px;">
            <button type="submit" class="btn btn-light">Search</button>
        </form>
    </div>
    <div class="card-body">
        <?php if(request('search')): ?>
            <p>Showing results for: <strong><?php echo e(request('search')); ?></strong></p>
        <?php endif; ?>


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


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Change Role</th>
                    <th>Change Password</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <td><?php echo e($u->name); ?></td>
                    <td><?php echo e($u->email); ?></td>
                    <td><span class="badge bg-secondary"><?php echo e($u->role); ?></span></td>
                    <td>
                        <form method="POST" action="<?php echo e(route('settings.updateRole', $u->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <select name="role" class="form-select" onchange="this.form.submit()">
                                <option value="user" <?php echo e($u->role == 'user' ? 'selected' : ''); ?>>User</option>
                                <option value="admin" <?php echo e($u->role == 'admin' ? 'selected' : ''); ?>>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="<?php echo e(route('settings.adminUpdatePassword', $u->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="password" name="new_password" placeholder="New Password" class="form-control mb-2" required>
                            <input type="password" name="new_password_confirmation" placeholder="Confirm Password" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-sm btn-warning">Update</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="text-center text-muted">No users found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/settings/role.blade.php ENDPATH**/ ?>