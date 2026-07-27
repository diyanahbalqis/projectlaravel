@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','Loan Details')

@section('content')

<head>
    <style>
    .table td, .table th {
        padding: 12px;
        vertical-align: middle;
    }
    
    .table td:first-child {
        font-weight: 500;
        width: 25%;
        background-color: #f8f9fa;
    }
    
    .badge {
        font-size: 0.9rem;
        padding: 5px 15px;
    }
</style>
</head>
<body>
    


<div class="container mt-4">

    <h2 class="text-center mb-4">Loan Details (View Only)</h2>

    <table class="table table-bordered" style="table-layout: fixed;">

        {{-- ================= BORROWER DETAILS ================= --}}
        <tr>
            <th colspan="4" class="text-center bg-light">Details of Borrower</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td colspan="3">{{ $loans->name ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Contact Number</strong></td>
            <td>{{ $loans->phone ?? '-' }}</td>
            <td><strong>Email</strong></td>
            <td>{{ $loans->email ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Department</strong></td>
            <td>{{ $loans->department ?? '-' }}</td>
            <td><strong>Staff ID</strong></td>
            <td>{{ $loans->staff_id ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Purpose</strong></td>
            <td colspan="3">
                {{ $loans->purpose ?? '-' }}
                @if($loans->purpose === 'Others' && $loans->other_purpose)
                    <br>
                    <small class="text-muted">Specify: {{ $loans->other_purpose }}</small>
                @endif
            </td>
        </tr>

        {{-- ================= EQUIPMENT DETAILS ================= --}}
        <tr>
            <th colspan="4" class="text-center bg-light">Details of Equipment / Items</th>
        </tr>

        <tr>
            <td><strong>Item Type</strong></td>
            <td>{{ $loans->item_type ?? '-' }}</td>
            <td><strong>Other Equipment</strong></td>
            <td>{{ $loans->other_equipment ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Equipment/Item</strong></td>
            <td colspan="3">
                @if($loans->equipment)
                    {{ $loans->equipment->name }} ({{ $loans->equipment->equipment_no }})
                @else
                    {{ $loans->item ?? '-' }}
                @endif
            </td>
        </tr>

        <tr>
            <td><strong>Quantity</strong></td>
            <td>{{ $loans->quantity ?? '-' }}</td>
            <td><strong>Asset Tagging No</strong></td>
            <td>
        @if($loans->equipment)
            {{ $loans->equipment->asset_no ?? '-' }}
        @else
            {{ $loans->asset_no ?? '-' }}
        @endif
    </td>
        </tr>

        <tr>
            <td><strong>Serial Number</strong></td>
            <td>
        @if($loans->equipment)
            {{ $loans->equipment->serial_no ?? '-' }}
        @else
            {{ $loans->serial_no ?? '-' }}
        @endif
    </td>
        <td><strong>Model</strong></td>
    <td>
        @if($loans->equipment)
            {{ $loans->equipment->model ?? '-' }}
        @else
            {{ $loans->model ?? '-' }}
        @endif
    </td>
        </tr>

        <tr>
            <td><strong>Current Location</strong></td>
            <td>{{ $loans->current_location ?? '-' }}</td>
            <td><strong>Condition</strong></td>
            <td>{{ $loans->condition ?? '-' }}</td>
        </tr>

        <tr>
            <td><strong>Additional Description</strong></td>
            <td colspan="3">{{ $loans->additional_description ?? '-' }}</td>
        </tr>

        {{-- ================= LOAN DURATION ================= --}}
        <tr>
            <th colspan="4" class="text-center bg-light">Loan Duration</th>
        </tr>

        <tr>
            <td><strong>Borrowing Date & Time</strong></td>
            <td>
                {{ $loans->date_borrow
                    ? \Carbon\Carbon::parse($loans->date_borrow)->format('d M Y, H:i')
                    : '-' }}
            </td>

            <td><strong>Estimated Return Date</strong></td>
            <td>
                {{ $loans->est_ret_date
                    ? \Carbon\Carbon::parse($loans->est_ret_date)->format('d M Y, H:i')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td><strong>Actual Return Date & Time</strong></td>
            <td>
                {{ $loans->date_return
                    ? \Carbon\Carbon::parse($loans->date_return)->format('d M Y, H:i')
                    : '-' }}
            </td>

            <td><strong>Status</strong></td>
            <td>
                <span class="badge 
                    @if($loans->status == 'Approved') bg-success
                    @elseif($loans->status == 'Rejected') bg-danger
                    @elseif($loans->status == 'Returned') bg-info
                    @else bg-warning text-dark
                    @endif">
                    {{ $loans->status }}
                </span>
            </td>
        </tr>

        {{-- ================= BORROWER CONFIRMATION ================= --}}
        <tr>
            <th colspan="4" class="text-center bg-light">Borrower Confirmation</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td>{{ $loans->name_borrower ?? '-' }}</td>

            <td><strong>Date</strong></td>
            <td>
                {{ $loans->date_borrower
                    ? \Carbon\Carbon::parse($loans->date_borrower)->format('d M Y, H:i')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td><strong>Signature</strong></td>
            <td colspan="3">
                @if($loans->sign_borrower)
                    <img src="{{ asset('storage/'.$loans->sign_borrower) }}" 
                         style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                         alt="Borrower Signature">
                @else
                    <span class="text-muted">No signature</span>
                @endif
            </td>
        </tr>

        @if($loans->stamp_borrower)
        <tr>
            <td><strong>Stamp</strong></td>
            <td colspan="3">
                <img src="{{ asset('storage/'.$loans->stamp_borrower) }}" 
                     style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                     alt="Borrower Stamp">
            </td>
        </tr>
        @endif

        {{-- ================= SUPERIOR APPROVAL ================= --}}
        <!-- <tr>
            <th colspan="4" class="text-center bg-light">Superior Approval</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td>{{ $loans->name_superior ?? '-' }}</td>

            <td><strong>Date</strong></td>
            <td>
                {{ $loans->date_superior
                    ? \Carbon\Carbon::parse($loans->date_superior)->format('d M Y, H:i')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td><strong>Signature</strong></td>
            <td colspan="3">
                @if($loans->sign_superior)
                    <img src="{{ asset('storage/'.$loans->sign_superior) }}" 
                         style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                         alt="Superior Signature">
                @else
                    <span class="text-muted">No signature</span>
                @endif
            </td>
        </tr> -->

        {{-- ================= ICT VERIFICATION ================= --}}
        <tr>
            <th colspan="4" class="text-center bg-light">ICT Verification</th>
        </tr>

        <tr>
            <td><strong>Name</strong></td>
            <td>{{ $loans->name_ict ?? '-' }}</td>

            <td><strong>Date</strong></td>
            <td>
                {{ $loans->date_ict
                    ? \Carbon\Carbon::parse($loans->date_ict)->format('d M Y, H:i')
                    : '-' }}
            </td>
        </tr>

        <tr>
            <td><strong>Signature</strong></td>
            <td colspan="3">
                @if($loans->sign_ict)
                    <img src="{{ asset('storage/'.$loans->sign_ict) }}" 
                         style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                         alt="ICT Signature">
                @else
                    <span class="text-muted">No signature</span>
                @endif
            </td>
        </tr>

        {{-- ================= SYSTEM INFO ================= --}}
        <tr>
            <th colspan="4" class="text-center bg-light">System Information</th>
        </tr>

        <tr>
            <td><strong>Created By</strong></td>
            <td>
                @if($loans->user)
                    {{ $loans->user->name }}
                @else
                    -
                @endif
            </td>

            <td><strong>Created At</strong></td>
            <td>{{ $loans->created_at->format('d M Y, H:i') }}</td>
        </tr>

        <tr>
            <td><strong>Last Updated</strong></td>
            <td colspan="3">{{ $loans->updated_at->format('d M Y, H:i') }}</td>
        </tr>

    </table>

    {{-- ================= ACTION BUTTONS ================= --}}
    <div class="text-center mt-4 mb-5">
        <a href="{{ route('loan.index') }}" class="btn btn-secondary">
            <i class="fa-solid fa-arrow-left"></i> Back to List
        </a>

        @if(Auth::user()->role == 'admin' || $loans->user_id == Auth::id())
            <a href="{{ route('loan.edit', $loans->id) }}" class="btn btn-warning">
                <i class="fa-solid fa-edit"></i> Edit
            </a>
        @endif

        <a href="{{ route('loanshow.printpdf', $loans->id) }}" class="btn btn-primary" target="_blank">
            <i class="fa-solid fa-print"></i> Print PDF
        </a>

        @if($loans->status === 'Approved' && !$loans->date_return)
            <form action="{{ route('loan.return', $loans->id) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-success" 
                        onclick="return confirm('Mark this equipment as returned?')">
                    <i class="fa-solid fa-check"></i> Mark as Returned
                </button>
            </form>
        @endif
    </div>

</div>
</body>


@endsection