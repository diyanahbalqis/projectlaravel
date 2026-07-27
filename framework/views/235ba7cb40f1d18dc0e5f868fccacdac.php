

<?php $__env->startSection('title', 'Edit Equipment'); ?>

<?php $__env->startSection('content'); ?>

<head>
    <link rel="stylesheet" href="<?php echo e(asset('css/equipment/edit.css')); ?>" >
</head>

<body>
    <h2 text-align="center">Equipment Editing</h2>

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

    <form action="<?php echo e(route('equipment.update', $equipment->id)); ?>"  method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('PUT'); ?>

        <table class="table">
            <!-- EQUIPMENT EDITING -->

            <tr>
                <th colspan="3" class="text-center bg-light"> Details of Equipment</th>
            </tr>

            <tr>
                <td>Name:</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="name" id="name" placeholder="name" value="<?php echo e(old('name', $equipment->name ?? '')); ?>">
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td>Equipment Number</td>
                <td colspan="2">
                <div class="mb-3">
                    <input type="text" name="equipment_no" id="equipment_no" placeholder="Number of Equipment" value="<?php echo e(old('equipment_no', $equipment->equipment_no ?? '')); ?>">
                </div>
                </td>
            </tr> -->
            <tr>
                <td>Asset Serial Number</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="serial_no" id="serial_no" placeholder="Asset Serial Number" value="<?php echo e(old('serial_no', $equipment->serial_no ?? '')); ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td>Model</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="model" id="model" placeholder="Model" value="<?php echo e(old('model', $equipment->model ?? '')); ?>">
                    </div>
                </td>
            </tr>
            <tr>
                <td>Asset No</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="asset_no" id="asset_no" placeholder="Asset No" value="<?php echo e(old('asset_no', $equipment->asset_no ?? '')); ?>">
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td>Category</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="category" id="category" placeholder="category" value="<?php echo e(old('category', $equipment->category ?? '')); ?>">
                    </div>
                </td>
            </tr> -->
            <!-- <tr>
                <td>Remarks</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="remarks" id="remarks" placeholder="Remarks" value="<?php echo e(old('remarks', $equipment->remarks ?? '')); ?>">
                    </div>
                </td>
            </tr> -->
            <tr>
                <td>Status</td>
                <td colspan="2">
                    <div class="mb-3">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="Available" <?php echo e(old('status', $equipment->status) == 'Available' ? 'selected' : ''); ?>> Available </option>
                                    <option value="Not Available" <?php echo e(old('status', $equipment->status) == 'Not Available' ? 'selected' : ''); ?>> Not Available </option>
                                </select>
                    </div>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/equipment/edit.blade.php ENDPATH**/ ?>