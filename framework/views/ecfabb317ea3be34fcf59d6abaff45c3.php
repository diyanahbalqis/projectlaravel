

<?php $__env->startSection('title', 'User List'); ?>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>User Profile</h2>
   
</div>
        <div>
            <!-- <a href="<?php echo e(route('userinfo.create')); ?>" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i> Add New User
            </a> -->
            <a href="<?php echo e(route('loan.create')); ?>" class="btn btn-success">
                <i class="fa-solid fa-laptop me-1"></i> Add New Loan
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Staff ID</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <!-- <th>Address</th> -->
                            <th>Created At</th>
                            <th>Department</th>
                            <th>Action</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
    <?php if(auth()->user()->role === 'admin'): ?>
        
        <?php $__empty_1 = true; $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($users->name); ?></td>
                <td><?php echo e($users->staff_id); ?></td>
                <td><?php echo e($users->email); ?></td>
                <td><?php echo e($users->phone); ?></td>
                <!-- <td><?php echo e($users->address); ?></td> -->
                <td><?php echo e($users->created_at->format('d M Y, H:i')); ?></td>
                <td><?php echo e($users->department); ?></td>
                <!-- <td>
                    <a href="<?php echo e(route('images.index')); ?>" class="btn btn-success btn-sm mb-1">
                        <i class="fa-solid fa-image me-1"></i> Upload
                    </a>
                    <a href="<?php echo e(route('images.index')); ?>" class="btn btn-info btn-sm">
                        <i class="fa-solid fa-eye me-1"></i> View
                    </a>
                </td> -->

                <td>
                    <a href="<?php echo e(route('userinfo.userprofile', [$users->id])); ?>" class="btn btn-success btn-sm mb-1" title="View">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </a>
                    <a href="<?php echo e(route('userinfo.edit', ['id' => $users->id])); ?>" class="btn btn-warning btn-sm mb-1" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form action="<?php echo e(route('userinfo.destroy', $users->id)); ?>" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>

                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>

                <td>
    <form action="<?php echo e(route('userinfo.updateApproval', $users->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <select name="approval" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="0" <?php echo e($users->approval == 0 ? 'selected' : ''); ?>>Pending</option>
            <option value="1" <?php echo e($users->approval == 1 ? 'selected' : ''); ?>>Approved</option>
            <option value="2" <?php echo e($users->approval == 2 ? 'selected' : ''); ?>>Rejected</option>
        </select>
    </form>
</td>

            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="9" class="text-center">No data available</td></tr>
        <?php endif; ?>

    <?php else: ?>
        
<?php $__empty_1 = true; $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td><?php echo e($user->name); ?></td>
                <td><?php echo e($user->staff_id); ?></td>
                <td><?php echo e($user->email); ?></td>
                <td><?php echo e($user->phone); ?></td>
                <!-- <td><?php echo e($user->address); ?></td> -->
                <td><?php echo e($user->created_at->format('d M Y, H:i')); ?></td>
                <td><?php echo e($user->department); ?></td>
        <!-- <td>
            <a href="<?php echo e(route('images.index')); ?>" class="btn btn-success btn-sm mb-1">
                <i class="fa-solid fa-image me-1"></i> Upload
            </a>
            <a href="<?php echo e(route('images.index')); ?>" class="btn btn-info btn-sm">
                <i class="fa-solid fa-eye me-1"></i> View
            </a>
        </td> -->

        <td>
            <a href="<?php echo e(route('userinfo.userprofile', [$user->id])); ?>" class="btn btn-success btn-sm mb-1" title="View">
                <i class="fa-solid fa-magnifying-glass-plus"></i>
            </a>
            <a href="<?php echo e(route('userinfo.edit', ['id' => $user->id])); ?>" class="btn btn-warning btn-sm mb-1" title="Edit">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            
        </td>

        <td>
    <?php if(auth()->user()->role === 'admin'): ?>
        <!-- Admin can update approval -->
        <form action="<?php echo e(route('userinfo.updateApproval', $users->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <select name="approval" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="0" <?php echo e($users->approval == 0 ? 'selected' : ''); ?>>Pending</option>
                <option value="1" <?php echo e($users->approval == 1 ? 'selected' : ''); ?>>Approved</option>
                <option value="2" <?php echo e($users->approval == 2 ? 'selected' : ''); ?>>Rejected</option>
            </select>
        </form>
    <?php else: ?>
        <!-- Normal user just sees approval status -->
        <?php
            $statusLabels = [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected'];
        ?>
        <?php echo e($statusLabels[$user->approval] ?? 'Unknown'); ?>

    <?php endif; ?>
</td>


    </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <tr><td colspan="9" class="text-center">No data available</td></tr>
<?php endif; ?>
    <?php endif; ?>
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/userinfo/index.blade.php ENDPATH**/ ?>