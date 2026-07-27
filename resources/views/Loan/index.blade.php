@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'Loan List')

<head>
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>

@section('content')
<div class="container mt-4">

    {{-- ================= NOTIFICATION POPUP ================= --}}
    @if($unread > 0)
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    title: 'New Notification!',
                    text: 'You have {{ $unread }} new message(s).',
                    icon: 'info',
                    confirmButtonText: 'View'
                }).then(result => {
                    if (result.isConfirmed) {
                        window.location.href = "{{ route('notifications.create') }}";
                    }
                });
            });
        </script>
    @endif

    {{-- ================= ADMIN NOTIFICATION HEADER ================= --}}
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
                        <span class="position-relative top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ $unread }}
                        </span>
                    @endif
                </a>
            </div>
        </div>
    @endif

@session('success')
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2> Loan List Management</h2>

        <div>
            <a href="{{ route('loan.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-laptop me-1"></i> Add New Loan
            </a>
        </div>
    </div>

    {{-- ================= ADMIN SEARCH BAR ================= --}}
    @if(auth()->user()->role === 'admin')
        <form action="{{ route('loan.index') }}" method="GET"
              class="mb-3 d-flex align-items-center" style="gap: 10px;">

            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="Search by user name or email"
                   value="{{ request('search') }}"
                   style="max-width: 300px;">

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

    

    {{-- ================= LOAN LIST TABLE ================= --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive" style="max-height:500px; overflow:auto;">
                <table class="table table-bordered table-striped table-sm align-middle text-nowrap">

                    {{-- ===== TABLE HEADER ===== --}}
                    <thead class="table-dark">
<tr>
    <th>Action</th>
    <th>No</th>
    <th>Name</th>
    <th>Staff ID</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Department</th>
    <th>Item</th>
    <th>Other Equipment</th>
    <th>Qty</th>
    <th>Purpose</th>
    <th>Other Purpose</th>
    <th>Borrow Date</th>
    <th>Est. Return</th>
    <th>Return Date</th>
    <th>Return Status</th>
    <th>Description</th>
    <th>Created</th>
    <th>Asset No</th>
    <th>Serial No</th>
    <th>Condition</th>
    <th>Location</th>
    <th>Model</th>
    <th>Status</th>
</tr>
</thead>

                    
                    <tbody>

                    {{-- ================= ADMIN VIEW ================= --}}
                    @if(auth()->user()->role === 'admin')

                        @forelse($loans as $l)
                            <tr>
    <td>
        <a href="{{ route('loan.show', $l->id) }}" class="btn btn-success btn-sm mb-1">
            <i class="fa-solid fa-magnifying-glass-plus"></i>
        </a>
        <a href="{{ route('loan.edit', $l->id) }}" class="btn btn-warning btn-sm mb-1">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="{{ route('loan.destroy', $l->id) }}" method="POST"
              onsubmit="return confirm('Are you sure?')" style="display:inline;">
            @csrf @method('DELETE')
            <button class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </td>

    <td>{{ $loop->iteration }}</td>
    <td>{{ $l->name ?? 'N/A' }}</td>
    <td>{{ $l->staff_id }}</td>
    <td>{{ $l->phone }}</td>
    <td>{{ $l->email }}</td>
    <td>{{ $l->department }}</td>

    <td>
        {{ $l->equipment
            ? $l->equipment->name.' - '.$l->equipment->number
            : 'N/A' }}
    </td>

    <td>{{ $l->other_equipment ?? '-' }}</td>
    <td>{{ $l->quantity }}</td>
    <td>{{ $l->purpose }}</td>
    <td>{{ $l->other_purpose ?? '-' }}</td>
    <td>{{ $l->date_borrow }}</td>
    <td>{{ $l->est_ret_date }}</td>

    <td>
    <form action="{{ route('loan.updateReturnDate', $l->id) }}" method="POST" class="d-flex">
        @csrf
        @method('PUT')
        <input type="date" name="date_return"
               value="{{ optional($l->date_return)->format('Y-m-d') }}"
               class="form-control form-control-sm me-1">
        <button class="btn btn-sm btn-primary">
            <i class="fa-solid fa-save"></i>
        </button>
    </form>
</td>
<td>
    @if($l->status === 'Returned')
        <span class="badge bg-success">Returned</span>
    @elseif($l->status === 'Approved')
        <span class="badge bg-warning text-dark">On Loan</span>
    @elseif($l->status === 'Rejected')
        <span class="badge bg-danger">Rejected</span>
    @elseif($l->status === 'Pending')
        <span class="badge bg-secondary">Pending</span>
    @else
        <span class="badge bg-info">{{ $l->status }}</span>
    @endif
    
    {{-- Show return button if approved and not returned yet --}}
    @if($l->status === 'Approved' || $l->status === 'Pending')
        <form action="{{ route('loan.return', $l->id) }}" method="POST" style="display:inline;" class="ms-2">
            @csrf
            <button type="submit" class="btn btn-success btn-sm" 
                    onclick="return confirm('Mark this equipment as returned?')">
                <i class="fas fa-check"></i> Return
            </button>
        </form>
    @endif
</td>

    <td>{{ $l->description ?? '-' }}</td>
    <td>{{ $l->created_at->format('d M Y, H:i') }}</td>
    <td>
        @if($l->equipment)
            {{ $l->equipment->asset_no ?? '-' }}
        @else
            {{ $l->asset_no ?? '-' }}
        @endif
    </td>
    <td>
        @if($l->equipment)
            {{ $l->equipment->serial_no ?? '-' }}
        @else
            {{ $l->serial_no ?? '-' }}
        @endif
    </td>
    <td>{{ $l->condition ?? '-' }}</td>
    <td>{{ $l->current_location ?? '-' }}</td>
    <td>
        @if($l->equipment)
            {{ $l->equipment->model ?? '-' }}
        @else
            {{ $l->model ?? '-' }}
        @endif
    </td>
    <td>
    <form action="{{ route('loan.updateStatus', $l->id) }}" method="POST">
        @csrf
        @method('PUT')
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="Approved" {{ $l->status == 'Approved' ? 'selected' : '' }}>Approved</option>
            <option value="Pending" {{ $l->status == 'Pending' ? 'selected' : '' }}>Pending</option>
            <option value="Rejected" {{ $l->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
        </select>
    </form>
</td>
</tr>
                        @empty
                            <tr>
                                <td colspan="21" class="text-center">No loan data available</td>
                            </tr>
                        @endforelse

                    {{-- ================= USER VIEW ================= --}}
@else

@forelse($loans as $loan)
<tr>
    {{-- Action --}}
    <td>
        <a href="{{ route('loan.show', $loan->id) }}" class="btn btn-success btn-sm mb-1">
            <i class="fa-solid fa-magnifying-glass-plus"></i>
        </a>
        <a href="{{ route('loan.edit', $loan->id) }}" class="btn btn-warning btn-sm mb-1">
            <i class="fa-solid fa-pen-to-square"></i>
        </a>
        <form action="{{ route('loan.destroy', $loan->id) }}" method="POST"
              onsubmit="return confirm('Are you sure you want to delete this loan?')"
              style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
    </td>

    <td>{{ $loop->iteration }}</td>
    <td>{{ $loan->name ?? 'N/A' }}</td>
    <td>{{ $loan->staff_id }}</td>
    <td>{{ $loan->phone }}</td>
    <td>{{ $loan->email }}</td>
    <td>{{ $loan->department }}</td>
    <td>
        {{ $loan->equipment
            ? $loan->equipment->name.' - '.$loan->equipment->number
            : 'N/A' }}
    </td>
    <!-- <td>{{ $loan->item ?? '-' }}</td> -->
    <td>{{ $loan->other_equipment ?? '-' }}</td>
    <td>{{ $loan->quantity }}</td>
    <td>{{ $loan->purpose }}</td>
    <td>{{ $loan->other_purpose ?? '-' }}</td>

    {{-- Dates --}}
    <td>{{ $loan->date_borrow }}</td>
    <td>{{ $loan->est_ret_date }}</td>
    <td>{{ $loan->date_return ?? '-' }}</td>
    <td>
    <span class="badge 
        @if($loan->date_return === null && $loan->status === 'Approved') bg-warning text-dark
        @elseif($loan->date_return !== null) bg-success
        @elseif($loan->status == 'Rejected') bg-danger
        @else bg-secondary
        @endif">
        {{ $loan->date_return === null && $loan->status === 'Approved' ? 'On Loan' : ($loan->date_return ? 'Returned' : $loan->status) }}
    </span>
</td>

    {{-- Description --}}
    <td>{{ $loan->description ?? '-' }}</td>
    <td>{{ $loan->created_at->format('d M Y, H:i') }}</td>

    {{-- Asset Info --}}
    <td>
        @if($loan->equipment)
            {{ $loan->equipment->asset_no ?? '-' }}
        @else
            {{ $loan->asset_no ?? '-' }}
        @endif
    </td>
    <td>
        @if($loan->equipment)
            {{ $loan->equipment->serial_no ?? '-' }}
        @else
            {{ $loan->serial_no ?? '-' }}
        @endif
    </td>
    <td>{{ $loan->condition ?? '-' }}</td>
    <td>{{ $loan->current_location ?? '-' }}</td>
    <td>
        @if($loan->equipment)
            {{ $loan->equipment->model ?? '-' }}
        @else
            {{ $loan->model ?? '-' }}
        @endif
    </td>
    <td>{{ $loan->status ?? '-' }}</td>
</tr>

@empty
<tr>
    <td colspan="23" class="text-center">
        No loan data available
    </td>
</tr>
@endforelse

@endif

@endsection
