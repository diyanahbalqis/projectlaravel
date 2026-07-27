

<?php $__env->startSection('title', 'Equipment Inventory'); ?>

<?php $__env->startSection('content'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="<?php echo e(asset('css/equipment/equip.css')); ?>">
</head>
<body>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="<?php echo e(route('equipment.create')); ?>" class="btn btn-success">
         Add New Equipment <i class="fa-solid fa-toolbox"></i>
        </a>
    </div>
</div>

    <h4>Equipment Inventory</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th> id </th>
                            <th>Action</th>
                            <th> Name </th>
                            <!-- <th> Equipment No. </th> -->
                            <!-- <th> Category </th> -->
                            <th> Asset Serial Number </th>  <!-- New column -->
                            <th> Model </th>                <!-- New column -->
                            <th> Asset No </th>     
                            <th> Status </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = $equipment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($loop->iteration); ?></td>
                            <td>
                                    <a href="<?php echo e(route('equipment.edit', $item->id)); ?>" class="btn btn-warning btn-sm mb-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
            <form action="<?php echo e(route('equipment.destroy', $item->id)); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="btn btn-sm btn-danger" 
                        onclick="return confirm('Are you sure?')">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
                                </td>
                            <td><?php echo e($item->name); ?></td>
                            <!-- <td><?php echo e($item->equipment_no); ?></td> -->
                            <!-- <td><?php echo e($item->category); ?></td> -->
                            <td><?php echo e($item->serial_no ?? '-'); ?></td>  <!-- New field, with fallback -->
                            <td><?php echo e($item->model ?? '-'); ?></td>                <!-- New field, with fallback -->
                            <td><?php echo e($item->asset_no ?? '-'); ?></td>  
                            <td><?php echo e($item->status); ?></td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</table>

</body>
</html>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/equipment/index.blade.php ENDPATH**/ ?>