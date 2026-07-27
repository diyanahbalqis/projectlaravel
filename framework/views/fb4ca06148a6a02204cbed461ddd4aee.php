

<?php $__env->startSection('title','Loan Details'); ?>

<?php $__env->startSection('content'); ?>

<head>
    <style>
    .table td, .table th {
        padding: 12px;
        vertical-align: middle;
    }
    
    .table td:first-child {
        font-weight: 500;
        width: 25%;
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.9rem;
        padding: 5px 15px;
    }
</style>
</head>
<body>
    


<div class="container mt-4">

    <h2 class="text-center mb-4">Loan Details (View Only)</h2>

    <table class="table table-bordered" style="table-layout: fixed;">

        
        <tr>
            <th colspan="4" class="text-center bg-light">Details of Borrower</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td colspan="3"><?php echo e($loans->name ?? '-'); ?></td>
        </tr>

        <tr>
            <td><strong>Contact Number</strong></td>
            <td><?php echo e($loans->phone ?? '-'); ?></td>
            <td><strong>Email</strong></td>
            <td><?php echo e($loans->email ?? '-'); ?></td>
        </tr>

        <tr>
            <td><strong>Department</strong></td>
            <td><?php echo e($loans->department ?? '-'); ?></td>
            <td><strong>Staff ID</strong></td>
            <td><?php echo e($loans->staff_id ?? '-'); ?></td>
        </tr>

        <tr>
            <td><strong>Purpose</strong></td>
            <td colspan="3">
                <?php echo e($loans->purpose ?? '-'); ?>

                <?php if($loans->purpose === 'Others' && $loans->other_purpose): ?>
                    <br>
                    <small class="text-muted">Specify: <?php echo e($loans->other_purpose); ?></small>
                <?php endif; ?>
            </td>
        </tr>

        
        <tr>
            <th colspan="4" class="text-center bg-light">Details of Equipment / Items</th>
        </tr>

        <tr>
            <td><strong>Item Type</strong></td>
            <td><?php echo e($loans->item_type ?? '-'); ?></td>
            <td><strong>Other Equipment</strong></td>
            <td><?php echo e($loans->other_equipment ?? '-'); ?></td>
        </tr>

        <tr>
            <td><strong>Equipment/Item</strong></td>
            <td colspan="3">
                <?php if($loans->equipment): ?>
                    <?php echo e($loans->equipment->name); ?> (<?php echo e($loans->equipment->equipment_no); ?>)
                <?php else: ?>
                    <?php echo e($loans->item ?? '-'); ?>

                <?php endif; ?>
            </td>
        </tr>

        <tr>
            <td><strong>Quantity</strong></td>
            <td><?php echo e($loans->quantity ?? '-'); ?></td>
            <td><strong>Asset Tagging No</strong></td>
            <td>
        <?php if($loans->equipment): ?>
            <?php echo e($loans->equipment->asset_no ?? '-'); ?>

        <?php else: ?>
            <?php echo e($loans->asset_no ?? '-'); ?>

        <?php endif; ?>
    </td>
        </tr>

        <tr>
            <td><strong>Serial Number</strong></td>
            <td>
        <?php if($loans->equipment): ?>
            <?php echo e($loans->equipment->serial_no ?? '-'); ?>

        <?php else: ?>
            <?php echo e($loans->serial_no ?? '-'); ?>

        <?php endif; ?>
    </td>
        <td><strong>Model</strong></td>
    <td>
        <?php if($loans->equipment): ?>
            <?php echo e($loans->equipment->model ?? '-'); ?>

        <?php else: ?>
            <?php echo e($loans->model ?? '-'); ?>

        <?php endif; ?>
    </td>
        </tr>

        <tr>
            <td><strong>Current Location</strong></td>
            <td><?php echo e($loans->current_location ?? '-'); ?></td>
            <td><strong>Condition</strong></td>
            <td><?php echo e($loans->condition ?? '-'); ?></td>
        </tr>

        <tr>
            <td><strong>Additional Description</strong></td>
            <td colspan="3"><?php echo e($loans->additional_description ?? '-'); ?></td>
        </tr>

        
        <tr>
            <th colspan="4" class="text-center bg-light">Loan Duration</th>
        </tr>

        <tr>
            <td><strong>Borrowing Date & Time</strong></td>
            <td>
                <?php echo e($loans->date_borrow
                    ? \Carbon\Carbon::parse($loans->date_borrow)->format('d M Y, H:i')
                    : '-'); ?>

            </td>

            <td><strong>Estimated Return Date</strong></td>
            <td>
                <?php echo e($loans->est_ret_date
                    ? \Carbon\Carbon::parse($loans->est_ret_date)->format('d M Y, H:i')
                    : '-'); ?>

            </td>
        </tr>

        <tr>
            <td><strong>Actual Return Date & Time</strong></td>
            <td>
                <?php echo e($loans->date_return
                    ? \Carbon\Carbon::parse($loans->date_return)->format('d M Y, H:i')
                    : '-'); ?>

            </td>

            <td><strong>Status</strong></td>
            <td>
                <span class="badge 
                    <?php if($loans->status == 'Approved'): ?> bg-success
                    <?php elseif($loans->status == 'Rejected'): ?> bg-danger
                    <?php elseif($loans->status == 'Returned'): ?> bg-info
                    <?php else: ?> bg-warning text-dark
                    <?php endif; ?>">
                    <?php echo e($loans->status); ?>

                </span>
            </td>
        </tr>

        
        <tr>
            <th colspan="4" class="text-center bg-light">Borrower Confirmation</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td><?php echo e($loans->name_borrower ?? '-'); ?></td>

            <td><strong>Date</strong></td>
            <td>
                <?php echo e($loans->date_borrower
                    ? \Carbon\Carbon::parse($loans->date_borrower)->format('d M Y, H:i')
                    : '-'); ?>

            </td>
        </tr>

        <tr>
            <td><strong>Signature</strong></td>
            <td colspan="3">
                <?php if($loans->sign_borrower): ?>
                    <img src="<?php echo e(asset('storage/'.$loans->sign_borrower)); ?>" 
                         style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                         alt="Borrower Signature">
                <?php else: ?>
                    <span class="text-muted">No signature</span>
                <?php endif; ?>
            </td>
        </tr>

        <?php if($loans->stamp_borrower): ?>
        <tr>
            <td><strong>Stamp</strong></td>
            <td colspan="3">
                <img src="<?php echo e(asset('storage/'.$loans->stamp_borrower)); ?>" 
                     style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                     alt="Borrower Stamp">
            </td>
        </tr>
        <?php endif; ?>

        
        <!-- <tr>
            <th colspan="4" class="text-center bg-light">Superior Approval</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td><?php echo e($loans->name_superior ?? '-'); ?></td>

            <td><strong>Date</strong></td>
            <td>
                <?php echo e($loans->date_superior
                    ? \Carbon\Carbon::parse($loans->date_superior)->format('d M Y, H:i')
                    : '-'); ?>

            </td>
        </tr>

        <tr>
            <td><strong>Signature</strong></td>
            <td colspan="3">
                <?php if($loans->sign_superior): ?>
                    <img src="<?php echo e(asset('storage/'.$loans->sign_superior)); ?>" 
                         style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                         alt="Superior Signature">
                <?php else: ?>
                    <span class="text-muted">No signature</span>
                <?php endif; ?>
            </td>
        </tr> -->

        
        <tr>
            <th colspan="4" class="text-center bg-light">ICT Verification</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td><?php echo e($loans->name_ict ?? '-'); ?></td>

            <td><strong>Date</strong></td>
            <td>
                <?php echo e($loans->date_ict
                    ? \Carbon\Carbon::parse($loans->date_ict)->format('d M Y, H:i')
                    : '-'); ?>

            </td>
        </tr>

        <tr>
            <td><strong>Signature</strong></td>
            <td colspan="3">
                <?php if($loans->sign_ict): ?>
                    <img src="<?php echo e(asset('storage/'.$loans->sign_ict)); ?>" 
                         style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                         alt="ICT Signature">
                <?php else: ?>
                    <span class="text-muted">No signature</span>
                <?php endif; ?>
            </td>
        </tr>

        
        <tr>
            <th colspan="4" class="text-center bg-light">System Information</th>
        </tr>

        <tr>
            <td><strong>Created By</strong></td>
            <td>
                <?php if($loans->user): ?>
                    <?php echo e($loans->user->name); ?>

                <?php else: ?>
                    -
                <?php endif; ?>
            </td>

            <td><strong>Created At</strong></td>
            <td><?php echo e($loans->created_at->format('d M Y, H:i')); ?></td>
        </tr>

        <tr>
            <td><strong>Last Updated</strong></td>
            <td colspan="3"><?php echo e($loans->updated_at->format('d M Y, H:i')); ?></td>
        </tr>

    </table>

    
    <div class="text-center mt-4 mb-5">
        <a href="<?php echo e(route('loan.index')); ?>" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>

        <?php if(Auth::user()->role == 'admin' || $loans->user_id == Auth::id()): ?>
            <a href="<?php echo e(route('loan.edit', $loans->id)); ?>" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Edit
            </a>
        <?php endif; ?>

        <a href="<?php echo e(route('loanshow.printpdf', $loans->id)); ?>" class="btn btn-primary" target="_blank">
            <i class="fa-solid fa-print"></i> Print PDF
        </a>

        <?php if($loans->status === 'Approved' && !$loans->date_return): ?>
            <form action="<?php echo e(route('loan.return', $loans->id)); ?>" method="POST" style="display:inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-success" 
                        onclick="return confirm('Mark this equipment as returned?')">
                    <i class="fa-solid fa-check"></i> Mark as Returned
                </button>
            </form>
        <?php endif; ?>
    </div>

</div>
</body>


<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/loan/show.blade.php ENDPATH**/ ?>