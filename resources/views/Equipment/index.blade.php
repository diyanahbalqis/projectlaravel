@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'Equipment Inventory')

@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="{{ asset('css/equipment/equip.css')}}">
</head>
<body>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('equipment.create') }}" class="btn btn-success">
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
                    @foreach ($equipment as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                    <a href="{{ route('equipment.edit', $item->id) }}" class="btn btn-warning btn-sm mb-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
            <form action="{{ route('equipment.destroy', $item->id) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-danger" 
                        onclick="return confirm('Are you sure?')">
                    <i class="fa-solid fa-trash"></i>
                </button>
            </form>
                                </td>
                            <td>{{ $item->name }}</td>
                            <!-- <td>{{ $item->equipment_no }}</td> -->
                            <!-- <td>{{ $item->category }}</td> -->
                            <td>{{ $item->serial_no ?? '-' }}</td>  <!-- New field, with fallback -->
                            <td>{{ $item->model ?? '-' }}</td>                <!-- New field, with fallback -->
                            <td>{{ $item->asset_no ?? '-' }}</td>  
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</table>

</body>
</html>

@endsection