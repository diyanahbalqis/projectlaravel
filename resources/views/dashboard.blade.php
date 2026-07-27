@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'Dashboard')

@section('content')

<!-- Dashboard Content -->
<div class="container-fluid py-3">

    <!-- Welcome Header -->
    <div class="mb-4">
        <h1 class="h3">Welcome to the User Dashboard</h1>
        <p class="text-muted">Here's what's happening with your ICT equipment rental platform today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">👥</div>
                    <h5 class="card-title mt-2">Total Users</h5>
                    <p class="card-text fs-4">0</p>
                    <span class="text-success">+12.5%</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">💻</div>
                    <h5 class="card-title mt-2">Active Rentals</h5>
                    <p class="card-text fs-4">156</p>
                    <span class="text-success">+8.2%</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">📊</div>
                    <h5 class="card-title mt-2">Reports</h5>
                    <p class="card-text fs-4">35</p>
                    <span class="text-success">+23.1%</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">⚙️</div>
                    <h5 class="card-title mt-2">Settings Updated</h5>
                    <p class="card-text fs-4">5</p>
                    <span class="text-danger">-2.4%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Dashboard Charts & Activity -->
    <div class="row g-3 mb-4">
        <!-- Revenue Overview -->
        <div class="col-lg-6 col-md-12">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0">Revenue Overview</h5>
                    <div>
                        <button class="btn btn-sm btn-primary active">Week</button>
                        <button class="btn btn-sm btn-outline-primary">Month</button>
                        <button class="btn btn-sm btn-outline-primary">Year</button>
                    </div>
                </div>
                <div class="card-body text-center text-muted">
                    📈 Revenue chart placeholder
                    <small class="d-block mt-2">Integrate with Chart.js or similar library</small>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 col-md-12">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="m-0">Recent Activity</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex justify-content-between mb-2">
                            <span>👤 New user registered</span>
                            <small class="text-muted">2 mins ago</small>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>💻 MacBook Pro rented</span>
                            <small class="text-muted">15 mins ago</small>
                        </li>
                        <li class="d-flex justify-content-between mb-2">
                            <span>📋 Report generated</span>
                            <small class="text-muted">1 hour ago</small>
                        </li>
                        <li class="d-flex justify-content-between">
                            <span>✅ Equipment returned</span>
                            <small class="text-muted">3 hours ago</small>
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
                    <p class="card-text fs-4">342</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">🔄</div>
                    <h5 class="card-title mt-2">Currently Rented</h5>
                    <p class="card-text fs-4">156</p>
                </div>
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="card text-center h-100">
                <div class="card-body">
                    <div class="fs-3">🔧</div>
                    <h5 class="card-title mt-2">Under Maintenance</h5>
                    <p class="card-text fs-4">23</p>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
