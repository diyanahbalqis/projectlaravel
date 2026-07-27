@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'Loan List')

@section('content')

<head>
    
<link rel="stylesheet" href="{{ asset('css/index.css') }}">

</head>

<div class="container mt-4">

@if($unread > 0)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'New Notification!',
                text: 'You have {{ $unread }} new message(s).',
                icon: 'info',
                confirmButtonText: 'View'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('notifications.create') }}";
                }
            });
        });
    </script>
@endif

@if(auth()->user()->role === 'admin')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Notification form [click the bell button to send notification]</h2>
    <div class="position-relative">
        <a href="{{ route('notifications.create') }}" class="text-green position-relative">
            <i class="fa-solid fa-bell fa-2x"></i>
            @php
                $unread = \App\Models\Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->count();
            @endphp
            @if($unread > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $unread }}
                </span>
            @endif
        </a>
    </div>
</div>
@endif

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Loan List</h2>
        <div>
            <a href="{{ route('equipment.form') }}" class="btn btn-primary">
                <i class="fa-solid fa-laptop me-1"></i> Add New Loan
            </a>
            <a href="{{ route('dashboard') }}" class="btn btn-success">
                <i class="fa-solid fa-house-chimney me-1"></i> Dashboard
            </a>
        </div>
    </div>

    <!-- Admin Search Bar -->
@if(auth()->user()->role === 'admin')
    <form action="{{ route('loan.index') }}" method="GET" class="mb-3 d-flex align-items-center" style="gap: 10px;">
        <input type="text" name="search" class="form-control" placeholder="Search by user name or email"
               value="{{ request('search') }}" style="max-width: 300px;">
        <button type="submit" class="btn btn-dark">
            <i class="fa-solid fa-magnifying-glass"></i> Search
        </button>
        @if(request('search'))
            <a href="{{ route('loan.index') }}" class="btn btn-outline-secondary">
                <i class="fa-solid fa-rotate-left"></i> Reset
            </a>
        @endif
    </form>
@endif

    <!-- Success Alert -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Loan List Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Action</th>
                            <th>no.</th>
                            <th>name</th>
                            <th>Contact Number</th>
                            <th>Staff ID</th>
                            <th>Email</th>
                            <th>Item Type</th>
                            <th>Equipment/Item Name</th>
                            <th>Quantity</th>
                            <th>Purpose</th>
                            <th>Other Purpose</th>
                            <th>Date of Return</th>
                            <th>Laptop No</th>
                            <th>Projector No</th>
                            <th>Other Equipment</th>
                            <th>Description / Room No</th>
                            <th>Created At</th>
                            <th>Status</th>
                            <td>Department</td>
                            <th>Asset Tagging</th>
                            <th>Serial Number</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- Admin View --}}
                        @if(auth()->user()->role === 'admin')
                            @forelse($loan as $l)
                                <tr>
                                    <td>
                                        <a href="{{ route('loan.show', $l->id)}}" class="btn btn-success btn-sm mb-1" title="View">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        </a>
                                        <a href="#" class="btn btn-warning btn-sm mb-1" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm mb-1" title="Delete" >
                                            <i class="fa-solid fa-trash"></i></a>
                 
                                    </td>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $l->name ?? 'N/A' }}</td>
                                    <td>{{ $l->phone }}</td>
                                    <td>{{ $l->staff_id }}</td>
                                    <td>{{ $l->email }}</td>
                                    <td>{{ $l->item }}</td>
                                    <td>{{ $l->quantity }}</td>
                                    <td>{{ $l->item }}</td>
                                    <td>
                                        {{ $l->purpose }}
                                        @if($l->purpose == 'Others')
                                            <br>
                                            <small class="text-muted">{{ $l->other_purpose }}</small>
                                        @endif
                                    </td>

                                    <td>{{ $l->loan_type }}</td>

                                    <!-- Dates for Admin -->
                                    <td>
                                        <form action="{{ route('loan.updateDates', $l->id) }}" method="POST" class="d-flex align-items-center">
                                        @csrf
                                        @method('PUT')

                                            <input type="date" name="loan_date"
                                                value="{{ $l->loan_date ? $l->loan_date->format('Y-m-d') : '' }}"
                                                class="form-control form-control-sm me-2" style="width: 150px;">

                                            <input type="date" name="return_date"
                                                value="{{ $l->return_date ? $l->return_date->format('Y-m-d') : '' }}"
                                                class="form-control form-control-sm me-2" style="width: 150px;">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fa-solid fa-save"></i>
                                                </button>
                                        </form>
                                    </td>

                                    <td>{{ $l->laptop_number ?? '-' }}</td>
                                    <td>{{ $l->projector_number ?? '-' }}</td>

                                    <td>
                                        {{ $l->other_equipment }}
                                        @if($l->other_equipment == 'Others')
                                            <br>
                                            <small class="text-muted">{{ $l->other_equipment_specify }}</small>
                                        @endif
                                    </td>

                                    <td>{{ $l->description ?? '-' }}</td>
                                    <td>{{ $l->created_at->format('d M Y, H:i') }}</td>

                                    <td>
                                        <!-- <form action="{{ route('loan.updateDates', $l->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                                <option value="Pending"  {{ $l->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                                <option value="Approved" {{ $l->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                                <option value="Rejected" {{ $l->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                            </select>
                                        </form> -->
                                    </td>
                                    <td>{{ $l->department }}</td>
                                    <td>{{ $l->asset_no }}</td>
                                    <td>{{ $l->serial_no }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No loan data available</td>
                                </tr>
                            @endforelse

                        {{-- User View --}}
                        @else
                            @forelse($loans as $loan)
                                    
                                <tr>
                                    <td>
                                        <a href="{{ route('loan.show', $loan->id)}}" class="btn btn-success btn-sm mb-1" title="View">
                                            <i class="fa-solid fa-magnifying-glass-plus"></i>
                                        </a>
                                        <a href="{{ route('loan.edit', $loan->id)}}" class="btn btn-warning btn-sm mb-1" title="Edit">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <a href="#" class="btn btn-danger btn-sm mb-1" title="Delete" >
                                            <i class="fa-solid fa-trash"></i></a>
                 
                                    </td>
                                        <td>{{ $loop->iteration }}</td>
                                    <td>{{ $loan->name ?? 'N/A' }}</td>
                                    <td>{{ $loan->phone }}</td>
                                    <td>{{ $loan->staff_id }}</td>
                                    <td>{{ $loan->email }}</td>
                                    <td>{{ $loan->item_type }}</td>
                                    <td>{{ $loan->quantity }}</td>
                                    <td>{{ $loan->item }}</td>
                                    <td>{{ $loan->purpose }}</td>
                                    <td>{{ $loan->other_purpose }}</td>


                                        <td>{{ $loan->loan_type }}</td>

                                        <!-- Read-only Dates for Users -->
                                        <td>
                                        {{ $loan->date_borrow }}
                                    </td>

                                        <td>{{ $loan->laptop_number ?? '-' }}</td>
                                        <td>{{ $loan->projector_number ?? '-' }}</td>

                                        <td>
                                            {{ $loan->item }}
                                            @if($loan->item == 'Others')
                                                <br>
                                                <small class="text-muted">{{ $loan->item }}</small>
                                            @endif
                                        </td>

                                        <td>{{ $loan->description ?? '-' }}</td>
                                        <td>{{ $loan->created_at->format('d M Y, H:i') }}</td>

                                        <td>
                                            <span class="badge 
                                                @if($loan->status == 'Approved') bg-success 
                                                @elseif($loan->status == 'Rejected') bg-danger 
                                                @else bg-warning text-dark 
                                                @endif">
                                                {{ $loan->status }}
                                            </span>
                                        </td>
                                        <td>{{ $loan->department }}</td>
                                        <td>{{ $loan->assets_no }}</td>
                                        <td>{{ $loan->serial_no }}</td>
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="text-center">No loan data available</td>
                                </tr>
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
<!-- <a href="{{ route('equipment.printpdf', $loan->id ?? '') }}" class="btn btn-primary">
            <i class="fa-solid fa-file-pdf"></i> Print PDF
        </a> -->