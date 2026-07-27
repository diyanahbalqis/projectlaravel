@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','New Equipment Input')

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="py-12">
        <div class="content text-dark">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-dark">
                        <h2 class="font-semibold text-xl text-dark leading-tight mb-4">
                            {{__('Add New Equipment Record') }}
                        </h2>

                        <form action="{{ route ('equipment.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="m-3">
                                <label for="name" class="form-label">Equipment Name</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter Name of Equipment" value="{{ old('name') }}">
                            </div>
                            <!-- <div class="m-3">
                                <label for="equipment_no" class="form-label">Equipment Number</label>
                                <input type="text" name="equipment_no" id="equipment_no" class="form-control" placeholder="Enter Equipment Number" value="{{ old('equipment_no') }}">
                            </div> -->
                            <div class="m-3">
                                <label for="serial_no" class="form-label">Asset Serial Number</label>
                                <input type="text" name="serial_no" id="serial_no" class="form-control" placeholder="Enter Asset Serial Number" value="{{ old('serial_no') }}">
                            </div>
                            <div class="m-3">
                                <label for="model" class="form-label">Model</label>
                                <input type="text" name="model" id="model" class="form-control" placeholder="Enter Model" value="{{ old('model') }}">
                            </div>
                            <div class="m-3">
                                <label for="asset_no" class="form-label">Asset No</label>
                                <input type="text" name="asset_no" id="asset_no" class="form-control" placeholder="Enter Asset Number" value="{{ old('asset_no') }}">
                            </div>
                            <!-- <div class="m-3">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input type="text" name="remarks" id="remarks" class="form-control" placeholder="Enter Remarks" value="{{ old('remarks') }}">
                            </div> -->
                            <div class="m-3"> 
                                <label for="status" class="form-label">Status</label>
                                <select name="status" id="status" class="form-control" required>
                                    <option value="">Select Status</option>
                                    <option value="Available" {{ old('status') == 'Available' ? 'selected' : '' }}>Available</option>
                                    <option value="Not Available" {{ old('status') == 'Not Available' ? 'selected' : '' }}>Not Available</option>
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

@endsection