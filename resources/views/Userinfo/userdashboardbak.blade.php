@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'Dashboard')

@section('content')
<div class="container">
    <h1>Welcome to the User Dashboard</h1>
    <p>This is where your dashboard content</p>
</div>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_GOOGLE_MAPS_API_KEY"></script>

    <style>
        #map {
            height: 400px;
            width: 100%;
            border-radius: 10px;
        }

        body {
            min-height: 100vh;
            display: flex;
            margin: 0;
            font-family: Times New Roman, sans-serif;
        }

        
    </style>
</head>

<div class="py-5">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- REMOVE dark: classes -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-dark">

            <h1 class="mb-4 text-2xl fw-bold text-dark">Welcome to the Dashboard</h1>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-dark">Total Users</h5>
                            <p class="fs-4 fw-bold text-dark">{{ $totalUsers ?? '0'  }}</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-dark">Reports</h5>
                            <p class="fs-4 fw-bold text-dark">-</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-3">
                    <div class="card shadow-sm border-0">
                        <div class="card-body text-center">
                            <h5 class="card-title text-dark">Settings Updated</h5>
                            <p class="fs-4 fw-bold text-dark">-</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Google Map -->
            <h4 class="mb-3 text-dark">Dashboard Map</h4>
            <div id="map"></div>

        </div>
    </div>
</div>

<script>
    function initMap() {
        const location = { lat: 3.139, lng: 101.6869 }; // Kuala Lumpur
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 11,
            center: location,
        });
        new google.maps.Marker({
            position: location,
            map: map,
            title: "Kuala Lumpur",
        });
    }
    window.onload = initMap;
</script>
@endsection
