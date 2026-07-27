@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'Edit Equipment')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/equipment/edit.css') }}" >
</head>

<body>
    <h2 text-align="center">Equipment Editing</h2>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger">
    {{  session('error')}}
</div>
@endif

    <form action="{{ route('equipment.update', $equipment->id)}}"  method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <table class="table">
            <!-- EQUIPMENT EDITING -->

            <tr>
                <th colspan="3" class="text-center bg-light"> Details of Equipment</th>
            </tr>

            <tr>
                <td>Name:</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="name" id="name" placeholder="name" value="{{ old('name', $equipment->name ?? '') }}">
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td>Equipment Number</td>
                <td colspan="2">
                <div class="mb-3">
                    <input type="text" name="equipment_no" id="equipment_no" placeholder="Number of Equipment" value="{{ old('equipment_no', $equipment->equipment_no ?? '') }}">
                </div>
                </td>
            </tr> -->
            <tr>
                <td>Asset Serial Number</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="serial_no" id="serial_no" placeholder="Asset Serial Number" value="{{ old('serial_no', $equipment->serial_no ?? '') }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td>Model</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="model" id="model" placeholder="Model" value="{{ old('model', $equipment->model ?? '') }}">
                    </div>
                </td>
            </tr>
            <tr>
                <td>Asset No</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="asset_no" id="asset_no" placeholder="Asset No" value="{{ old('asset_no', $equipment->asset_no ?? '') }}">
                    </div>
                </td>
            </tr>
            <!-- <tr>
                <td>Category</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="category" id="category" placeholder="category" value="{{ old('category', $equipment->category ?? '') }}">
                    </div>
                </td>
            </tr> -->
            <!-- <tr>
                <td>Remarks</td>
                <td colspan="2">
                    <div class="mb-3">
                        <input type="text" name="remarks" id="remarks" placeholder="Remarks" value="{{ old('remarks', $equipment->remarks ?? '') }}">
                    </div>
                </td>
            </tr> -->
            <tr>
                <td>Status</td>
                <td colspan="2">
                    <div class="mb-3">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="Available" {{ old('status', $equipment->status) == 'Available' ? 'selected' : '' }}> Available </option>
                                    <option value="Not Available" {{ old('status', $equipment->status) == 'Not Available' ? 'selected' : '' }}> Not Available </option>
                                </select>
                    </div>
                </td>
            </tr>
        </table>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</body>

@endsection