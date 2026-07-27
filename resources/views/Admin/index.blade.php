@extends('layouts.app') 

@section('title', 'User List')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>User Profile</h2>

   
</div>
        <div>
            <a href="{{ route('userinfo.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i> Add New User
            </a>
            <a href="{{ route('loan.create') }}" class="btn btn-success">
                <i class="fa-solid fa-laptop me-1"></i> Add New Loan
            </a>

        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Address</th>
                            <th>Created At</th>
                            <th>Image</th>
                            <th>Action</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
    @if(auth()->user()->role === 'admin')
        {{-- Admin can see all --}}
        @forelse($users as $userinfo)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $userinfo->name }}</td>
                <td>{{ $userinfo->email }}</td>
                <td>{{ $userinfo->phone }}</td>
                <td>{{ $userinfo->address }}</td>
                <td>{{ $userinfo->created_at->format('d M Y, H:i') }}</td>

                <td>
                    <a href="{{ route('images.index') }}" class="btn btn-success btn-sm mb-1">
                        <i class="fa-solid fa-image me-1"></i> Upload
                    </a>
                    <a href="{{ route('images.index') }}" class="btn btn-info btn-sm">
                        <i class="fa-solid fa-eye me-1"></i> View
                    </a>
                </td>

                <td>
                    <a href="{{ route('userinfo.view', [$userinfo->id]) }}" class="btn btn-success btn-sm mb-1" title="View">
    <i class="fa-solid fa-magnifying-glass-plus"></i>
</a>
                    <a href="{{ route('userinfo.edit', ['id' => $userinfo->id]) }}" class="btn btn-warning btn-sm mb-1" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>
                 
                </td>

                <td>
    @if(auth()->user()->role === 'admin')
        <form action="{{ route('userinfo.updateApproval', $userinfo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="approval" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="Pending" {{ $userinfo->approval == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ $userinfo->approval == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ $userinfo->approval == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    @else
        {{ $userinfo->approval }}
    @endif
</td>



            </tr>
        @empty
            <tr><td colspan="9" class="text-center">No data available</td></tr>
        @endforelse

    @else
        {{-- Normal user only sees their own data --}}
@forelse($users as $userinfo)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $userinfo->name }}</td>
                <td>{{ $userinfo->email }}</td>
                <td>{{ $userinfo->phone }}</td>
                <td>{{ $userinfo->address }}</td>
                <td>{{ $userinfo->created_at->format('d M Y, H:i') }}</td>


        <td>
            <a href="{{ route('images.index') }}" class="btn btn-success btn-sm mb-1">
                <i class="fa-solid fa-image me-1"></i> Upload
            </a>
            <a href="{{ route('images.index') }}" class="btn btn-info btn-sm">
                <i class="fa-solid fa-eye me-1"></i> View
            </a>
        </td>

        <td>
            <a href="{{ route('userinfo.view', $userinfo->id)}}" class="btn btn-success btn-sm mb-1" title="View">
                <i class="fa-solid fa-magnifying-glass-plus"></i>
            </a>
            <a href="{{ route('userinfo.edit', ['id' => $userinfo->id]) }}" class="btn btn-warning btn-sm mb-1" title="Edit">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            
        </td>

        <td>
    @if(auth()->user()->role === 'admin')
        <form action="{{ route('userinfo.updateApproval', $userinfo->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="approval" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="Pending" {{ $userinfo->approval == 'Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Approved" {{ $userinfo->approval == 'Approved' ? 'selected' : '' }}>Approved</option>
                <option value="Rejected" {{ $userinfo->approval == 'Rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    @else
        {{ $userinfo->approval }}
    @endif
</td>


    </tr>
@empty
    <tr><td colspan="9" class="text-center">No data available</td></tr>
@endforelse
    @endif
</tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
