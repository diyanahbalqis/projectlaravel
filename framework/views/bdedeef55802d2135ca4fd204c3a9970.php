

<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>

<body>
<div class="container-fluid py-3">

    <div class="mb-4">
        <h1 class="h3">Welcome to the Admin Dashboard</h1>
        <p class="text-muted">Here's what's happening with your ICT equipment rental platform today.</p>
    </div>

<!-- Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">👥</div>
                    <h5 class="card-title mt-2">Total Users</h5>
                    <p class="card-text fs-4"><?php echo e($totalUsers ?? '0'); ?></p>
                    <!-- <span class="text-success">+12.5%</span> -->
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">💻</div>
                    <h5 class="card-title mt-2">Rentals</h5>
                    <p class="card-text fs-4"><?php echo e($totalLoan ?? '0'); ?></p>
                    <!-- <span class="text-success">+8.2%</span> -->
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">📊</div>
                    <h5 class="card-title mt-2">Reports</h5>
                    <p class="card-text fs-4">-</p>
                    <!-- <span class="text-success">+23.1%</span> -->
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">⚙️</div>
                    <h5 class="card-title mt-2">Settings Updated</h5>
                    <p class="card-text fs-4">0</p>
                    <!-- <span class="text-danger">-2.4%</span> -->
                </div>
            </div>
        </div>
    </div>

            <!-- Dashboard Grid -->
    <div class="row g-3 mb-4">
                <!-- Revenue Overview -->
        <!-- <div class="col-lg-6 col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Revenue Overview</h5>
                    
                        <button class="btn btn-sm btn-primary active">Week</button>
                        <button class="btn btn-sm btn-outline-primary">Month</button>
                        <button class="btn btn-sm btn-outline-primary">Year</button>
                    
                </div>
                <div class="card-body text-center text-muted">
                    📈 Revenue chart placeholder
                    <small class="d-block mt-2">Integrate with Chart.js or similar library</small>
                </div>
            </div>
        </div> -->

        <!-- Recent Activity -->
        <div class="col-lg-12 col-md-20">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="m-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span>👤 New user registered</span>
                            <small class="text-muted"><?php echo e($totalUsers ?? '0'); ?></small>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>💻 Laptop rented</span>
                            <!-- <small class="text-muted">15 mins ago</small> -->
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>📋 Projectore Rented</span>
                            <!-- <small class="text-muted">1 hour ago</small> -->
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>✅ Other Equipment Rented</span>
                            <!-- <small class="text-muted">-</small> -->
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Equipment Status -->
    <div class="row g-3">
        <div class="col-md-4 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">✅</div>
                    <h5 class="card-title mt-2">Available Equipment</h5>
                    <p class="card-text fs-4"><?php echo e($availableEquipment ?? '0'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">🔄</div>
                    <h5 class="card-title mt-2">Currently Rented</h5>
                    <p class="card-text fs-4"><?php echo e($totalLoan ?? '0'); ?></p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">🔧</div>
                    <h5 class="card-title mt-2">Under Maintenance</h5>
                    <p class="card-text fs-4">-</p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>




<?php $__env->stopSection(); ?>

<?php echo $__env->make(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\projectlaravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>