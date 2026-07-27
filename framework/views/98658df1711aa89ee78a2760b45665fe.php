

<?php $__env->startSection('title', 'Loan List'); ?>

<head>
<link rel="stylesheet" href="<?php echo e(asset('css/index.css')); ?>">
</head>

<?php $__env->startSection('content'); ?>
<div class="container mt-4">

    
    <?php if($unread > 0): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'New Notification!',
                    text: 'You have <?php echo e($unread); ?> new message(s).',
                    icon: 'info',
                    confirmButtonText: 'View'
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = "<?php echo e(route('notifications.create')); ?>";
                    }
                });
            });
        </script>
    <?php endif; ?>

    
    <?php if(auth()->user()->role === 'admin'): ?>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Notification form [click the bell button to send notification]</h2>

            <div class="position-relative">
                <a href="<?php echo e(route('notifications.create')); ?>" class="text-green position-relative">
                    <i class="fa-solid fa-bell fa-2x"></i>

                    <?php
                        $unread = \App\Models\Notification::where('user_id', Auth::id())
                            ->where('is_read', false)
                            ->count();
                    ?>

                    <?php if($unread > 0): ?>
                        <span class="position-relative top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            <?php echo e($unread); ?>

                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
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
<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2> Loan List Management</h2>

        <div>
            <a href="<?php echo e(route('loan.create')); ?>" class="btn btn-primary">
                <i class="fa-solid fa-laptop me-1"></i> Add New Loan
            </a>
        </div>
    </div>

    
    <?php if(auth()->user()->role === 'admin'): ?>
        <form action="<?php echo e(route('loan.index')); ?>" method="GET"
              class="mb-3 d-flex align-items-center" style="gap: 10px;">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search by user name or email"
                   value="<?php echo e(request('search')); ?>"
                   style="max-width: 300px;">

            <button type="submit" class="btn btn-dark">
                <i class="fa-solid fa-magnifying-glass"></i> Search
            </button>

            <?php if(request('search')): ?>
                <a href="<?php echo e(route('loan.index')); ?>" class="btn btn-outline-secondary">
                    <i class="fa-solid fa-rotate-left"></i> Reset
                </a>
            <?php endif; ?>
        </form>
    <?php endif; ?>

    

    
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive" style="max-height:500px; overflow:auto;">
                <table class="table table-bordered table-striped table-sm align-middle text-nowrap">

                    
                    <thead class="table-dark">
<tr>
    <th>Action</th>
    <th>No</th>
    <th>Name</th>
    <th>Staff ID</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Department</th>
    <th>Item</th>
    <th>Other Equipment</th>
    <th>Qty</th>
    <th>Purpose</th>
    <th>Other Purpose</th>
    <th>Borrow Date</th>
    <th>Est. Return</th>
    <th>Return Date</th>
    <th>Return Status</th>
    <th>Description</th>
    <th>Created</th>
    <th>Asset No</th>
    <th>Serial No</th>
    <th>Condition</th>
    <th>Location</th>
    <th>Model</th>
    <th>Status</th>
</tr>
</thead>

                    
                    <tbody>

                    
                    <?php if(auth()->user()->role === 'admin'): ?>

                        <?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
    <td>
        <a href="<?php echo e(route('loan.show', $l->id)); ?>" class="btn btn-success btn-sm mb-1">
            <i class="fa-solid fa-magnifying-glass-plus"></i>
        </a>
        <a href="<?php echo e(route('loan.edit', $l->id)); ?>" class="btn btn-warning btn-sm mb-1">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="<?php echo e(route('loan.destroy', $l->id)); ?>" method="POST"
              onsubmit="return confirm('Are you sure?')" style="display:inline;">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </td>

    <td><?php echo e($loop->iteration); ?></td>
    <td><?php echo e($l->name ?? 'N/A'); ?></td>
    <td><?php echo e($l->staff_id); ?></td>
    <td><?php echo e($l->phone); ?></td>
    <td><?php echo e($l->email); ?></td>
    <td><?php echo e($l->department); ?></td>

    <td>
        <?php echo e($l->equipment
            ? $l->equipment->name.' - '.$l->equipment->number
            : 'N/A'); ?>

    </td>

    <td><?php echo e($l->other_equipment ?? '-'); ?></td>
    <td><?php echo e($l->quantity); ?></td>
    <td><?php echo e($l->purpose); ?></td>
    <td><?php echo e($l->other_purpose ?? '-'); ?></td>
    <td><?php echo e($l->date_borrow); ?></td>
    <td><?php echo e($l->est_ret_date); ?></td>

    <td>
    <form action="<?php echo e(route('loan.updateReturnDate', $l->id)); ?>" method="POST" class="d-flex">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <input type="date" name="date_return"
               value="<?php echo e(optional($l->date_return)->format('Y-m-d')); ?>"
               class="form-control form-control-sm me-1">
        <button class="btn btn-sm btn-primary">
            <i class="fa-solid fa-save"></i>
        </button>
    </form>
</td>
<td>
    <?php if($l->status === 'Returned'): ?>
        <span class="badge bg-success">Returned</span>
    <?php elseif($l->status === 'Approved'): ?>
        <span class="badge bg-warning text-dark">On Loan</span>
    <?php elseif($l->status === 'Rejected'): ?>
        <span class="badge bg-danger">Rejected</span>
    <?php elseif($l->status === 'Pending'): ?>
        <span class="badge bg-secondary">Pending</span>
    <?php else: ?>
        <span class="badge bg-info"><?php echo e($l->status); ?></span>
    <?php endif; ?>
    
    
    <?php if($l->status === 'Approved' || $l->status === 'Pending'): ?>
        <form action="<?php echo e(route('loan.return', $l->id)); ?>" method="POST" style="display:inline;" class="ms-2">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-success btn-sm" 
                    onclick="return confirm('Mark this equipment as returned?')">
                <i class="fas fa-check"></i> Return
            </button>
        </form>
    <?php endif; ?>
</td>

    <td><?php echo e($l->description ?? '-'); ?></td>
    <td><?php echo e($l->created_at->format('d M Y, H:i')); ?></td>
    <td>
        <?php if($l->equipment): ?>
            <?php echo e($l->equipment->asset_no ?? '-'); ?>

        <?php else: ?>
            <?php echo e($l->asset_no ?? '-'); ?>

        <?php endif; ?>
    </td>
    <td>
        <?php if($l->equipment): ?>
            <?php echo e($l->equipment->serial_no ?? '-'); ?>

        <?php else: ?>
            <?php echo e($l->serial_no ?? '-'); ?>

        <?php endif; ?>
    </td>
    <td><?php echo e($l->condition ?? '-'); ?></td>
    <td><?php echo e($l->current_location ?? '-'); ?></td>
    <td>
        <?php if($l->equipment): ?>
            <?php echo e($l->equipment->model ?? '-'); ?>

        <?php else: ?>
            <?php echo e($l->model ?? '-'); ?>

        <?php endif; ?>
    </td>
    <td>
    <form action="<?php echo e(route('loan.updateStatus', $l->id)); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="Approved" <?php echo e($l->status == 'Approved' ? 'selected' : ''); ?>>Approved</option>
            <option value="Pending" <?php echo e($l->status == 'Pending' ? 'selected' : ''); ?>>Pending</option>
            <option value="Rejected" <?php echo e($l->status == 'Rejected' ? 'selected' : ''); ?>>Rejected</option>
        </select>
    </form>
</td>
</tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="21" class="text-center">No loan data available</td>
                            </tr>
                        <?php endif; ?>

                    
<?php else: ?>

<?php $__empty_1 = true; $__currentLoopData = $loans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<tr>
    
    <td>
        <a href="<?php echo e(route('loan.show', $loan->id)); ?>" class="btn btn-success btn-sm mb-1">
            <i class="fa-solid fa-magnifying-glass-plus"></i>
        </a>
        <a href="<?php echo e(route('loan.edit', $loan->id)); ?>" class="btn btn-warning btn-sm mb-1">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="<?php echo e(route('loan.destroy', $loan->id)); ?>" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this loan?')"
              style="display:inline;">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </td>

    <td><?php echo e($loop->iteration); ?></td>
    <td><?php echo e($loan->name ?? 'N/A'); ?></td>
    <td><?php echo e($loan->staff_id); ?></td>
    <td><?php echo e($loan->phone); ?></td>
    <td><?php echo e($loan->email); ?></td>
    <td><?php echo e($loan->department); ?></td>
    <td>
        <?php echo e($loan->equipment
            ? $loan->equipment->name.' - '.$loan->equipment->number
            : 'N/A'); ?>

    </td>
    <!-- <td><?php echo e($loan->item ?? '-'); ?></td> -->
    <td><?php echo e($loan->other_equipment ?? '-'); ?></td>
    <td><?php echo e($loan->quantity); ?></td>
    <td><?php echo e($loan->purpose); ?></td>
    <td><?php echo e($loan->other_purpose ?? '-'); ?></td>

    
    <td><?php echo e($loan->date_borrow); ?></td>
    <td><?php echo e($loan->est_ret_date); ?></td>
    <td><?php echo e($loan->date_return ?? '-'); ?></td>
    <td>
    <span class="badge 
        <?php if($loan->date_return === null && $loan->status === 'Approved'): ?> bg-warning text-dark
        <?php elseif($loan->date_return !== null): ?> bg-success
        <?php elseif($loan->status == 'Rejected'): ?> bg-danger
        <?php else: ?> bg-secondary
        <?php endif; ?>">
        <?php echo e($loan->date_return === null && $loan->status === 'Approved' ? 'On Loan' : ($loan->date_return ? 'Returned' : $loan->status)); ?>

    </span>
</td>

    
    <td><?php echo e($loan->description ?? '-'); ?></td>
    <td><?php echo e($loan->created_at->format('d M Y, H:i')); ?></td>

    
    <td>
        <?php if($loan->equipment): ?>
            <?php echo e($loan->equipment->asset_no ?? '-'); ?>

        <?php else: ?>
            <?php echo e($loan->asset_no ?? '-'); ?>

        <?php endif; ?>
    </td>
    <td>
        <?php if($loan->equipment): ?>
            <?php echo e($loan->equipment->serial_no ?? '-'); ?>

        <?php else: ?>
            <?php echo e($loan->serial_no ?? '-'); ?>

        <?php endif; ?>
    </td>
    <td><?php echo e($loan->condition ?? '-'); ?></td>
    <td><?php echo e($loan->current_location ?? '-'); ?></td>
    <td>
        <?php if($loan->equipment): ?>
            <?php echo e($loan->equipment->model ?? '-'); ?>

        <?php else: ?>
            <?php echo e($loan->model ?? '-'); ?>

        <?php endif; ?>
    </td>
    <td><?php echo e($loan->status ?? '-'); ?></td>
</tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<tr>
    <td colspan="23" class="text-center">
        No loan data available
    </td>
</tr>
<?php endif; ?>

<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/loan/index.blade.php ENDPATH**/ ?>