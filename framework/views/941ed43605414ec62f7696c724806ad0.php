

<?php $__env->startSection('title', 'User Report'); ?>

<?php $__env->startSection('content'); ?>

 <head>

<!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

        <link rel="stylesheet" href="<?php echo e(asset('css/userreport.css')); ?>">

</head>
<body>

<!-- <div>
    <a href="<?php echo e(route('user.printpdf')); ?>" class="btn btn-primary" target="_blank">
    View PDF
</a> -->
</div>
    
    <h1><?php echo e($title); ?></h1>
    <p><?php echo e($date); ?></p>
  

    <div class="table-responsive">
    <table class="table table-bordered" id="example">
<thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
</thead>

<tbody>
        <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $users): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($users->id); ?></td>
            <td><?php echo e($users->name); ?></td>
            <td><?php echo e($users->email); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
    </table>
</div>
  <!-- jQuery dan DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
$(document).ready(function () {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ]
    });
});
</script>
</body>

<?php $__env->stopSection(); ?>
<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/user/reportuser.blade.php ENDPATH**/ ?>