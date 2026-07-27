

<?php $__env->startSection('title','New Equipment Input'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <?php if(session('success')): ?>
        <div class="alert alert-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>

    <div class="py-12">
        <div class="content text-dark">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-dark">
                        <h2 class="font-semibold text-xl text-dark leading-tight mb-4">
                            <?php echo e(__('Add New Equipment Record')); ?>

                        </h2>

                        <form action="<?php echo e(route ('equipment.store')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>

                            <div class="m-3">
                                <label for="name" class="form-label">Equipment Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name of Equipment" value="<?php echo e(old('name')); ?>">
                            </div>
                            <!-- <div class="m-3">
                                <label for="equipment_no" class="form-label">Equipment Number</label>
                                <input type="text" name="equipment_no" id="equipment_no" class="form-control" placeholder="Enter Equipment Number" value="<?php echo e(old('equipment_no')); ?>">
                            </div> -->
                            <div class="m-3">
                                <label for="serial_no" class="form-label">Asset Serial Number</label>
                                <input type="text" name="serial_no" id="serial_no" class="form-control" placeholder="Enter Asset Serial Number" value="<?php echo e(old('serial_no')); ?>">
                            </div>
                            <div class="m-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" id="model" class="form-control" placeholder="Enter Model" value="<?php echo e(old('model')); ?>">
                            </div>
                            <div class="m-3">
                                <label for="asset_no" class="form-label">Asset No</label>
                                <input type="text" name="asset_no" id="asset_no" class="form-control" placeholder="Enter Asset Number" value="<?php echo e(old('asset_no')); ?>">
                            </div>
                            <!-- <div class="m-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks" value="<?php echo e(old('remarks')); ?>">
                            </div> -->
                            <div class="m-3"> 
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="Available" <?php echo e(old('status') == 'Available' ? 'selected' : ''); ?>>Available</option>
                                    <option value="Not Available" <?php echo e(old('status') == 'Not Available' ? 'selected' : ''); ?>>Not Available</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/equipment/create.blade.php ENDPATH**/ ?>