@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'User List')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>User Profile</h2>
   
</div>
        <div>
            <!-- <a href="{{ route('userinfo.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-user-plus me-1"></i> Add New User
            </a> -->
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
                            <th>Staff ID</th>
                            <th>Email</th>
                            <th>Contact No.</th>
                            <!-- <th>Address</th> -->
                            <th>Created At</th>
                            <th>Department</th>
                            <th>Action</th>
                            <th>Approval</th>
                        </tr>
                    </thead>
                    <tbody>
    @if(auth()->user()->role === 'admin')
        {{-- Admin can see all --}}
        @forelse($user as $users)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $users->name }}</td>
                <td>{{ $users->staff_id }}</td>
                <td>{{ $users->email }}</td>
                <td>{{ $users->phone }}</td>
                <!-- <td>{{ $users->address }}</td> -->
                <td>{{ $users->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $users->department }}</td>
                <!-- <td>
                    <a href="{{ route('images.index') }}" class="btn btn-success btn-sm mb-1">
                        <i class="fa-solid fa-image me-1"></i> Upload
                    </a>
                    <a href="{{ route('images.index') }}" class="btn btn-info btn-sm">
                        <i class="fa-solid fa-eye me-1"></i> View
                    </a>
                </td> -->

                <td>
                    <a href="{{ route('userinfo.userprofile', [$users->id]) }}" class="btn btn-success btn-sm mb-1" title="View">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </a>
                    <a href="{{ route('userinfo.edit', ['id' => $users->id]) }}" class="btn btn-warning btn-sm mb-1" title="Edit">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <form action="{{ route('userinfo.destroy', $users->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </form>
                </td>

                <td>
    <form action="{{ route('userinfo.updateApproval', $users->id) }}" method="POST">
        @csrf
        @method('PUT')
        <select name="approval" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="0" {{ $users->approval == 0 ? 'selected' : '' }}>Pending</option>
            <option value="1" {{ $users->approval == 1 ? 'selected' : '' }}>Approved</option>
            <option value="2" {{ $users->approval == 2 ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>
</td>

            </tr>
        @empty
            <tr><td colspan="9" class="text-center">No data available</td></tr>
        @endforelse

    @else
        {{-- Normal user only sees their own data --}}
@forelse($user as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->staff_id }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <!-- <td>{{ $user->address }}</td> -->
                <td>{{ $user->created_at->format('d M Y, H:i') }}</td>
                <td>{{ $user->department }}</td>
        <!-- <td>
            <a href="{{ route('images.index') }}" class="btn btn-success btn-sm mb-1">
                <i class="fa-solid fa-image me-1"></i> Upload
            </a>
            <a href="{{ route('images.index') }}" class="btn btn-info btn-sm">
                <i class="fa-solid fa-eye me-1"></i> View
            </a>
        </td> -->

        <td>
            <a href="{{ route('userinfo.userprofile', [$user->id]) }}" class="btn btn-success btn-sm mb-1" title="View">
                <i class="fa-solid fa-magnifying-glass-plus"></i>
            </a>
            <a href="{{ route('userinfo.edit', ['id' => $user->id]) }}" class="btn btn-warning btn-sm mb-1" title="Edit">
                <i class="fa-solid fa-pen-to-square"></i>
            </a>
            
        </td>

        <td>
    @if(auth()->user()->role === 'admin')
        <!-- Admin can update approval -->
        <form action="{{ route('userinfo.updateApproval', $users->id) }}" method="POST">
            @csrf
            @method('PUT')
            <select name="approval" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="0" {{ $users->approval == 0 ? 'selected' : '' }}>Pending</option>
                <option value="1" {{ $users->approval == 1 ? 'selected' : '' }}>Approved</option>
                <option value="2" {{ $users->approval == 2 ? 'selected' : '' }}>Rejected</option>
            </select>
        </form>
    @else
        <!-- Normal user just sees approval status -->
        @php
            $statusLabels = [0 => 'Pending', 1 => 'Approved', 2 => 'Rejected'];
        @endphp
        {{ $statusLabels[$user->approval] ?? 'Unknown' }}
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
