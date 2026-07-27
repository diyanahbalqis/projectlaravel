<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  table-layout: fixed;
  border-collapse: collapse;
}

th, td {
  border: 1px solid black;
  padding: 6px;
  word-wrap: break-word;
  overflow-wrap: break-word;
  box-sizing: border-box;
}

h2 {
    text-align: center;
}

p {
  text-align: center;
}

img {
  border-radius: 50%;
  display: block;
  margin-left: auto;
  margin-right: auto;
}

.center {
  display: block;
  margin-left: auto;
  margin-right: auto;
  text-align: center;
}

.badge {
    font-size: 0.9rem;
    padding: 5px 15px;
    border-radius: 4px;
}

.bg-success { background-color: #28a745; color: white; }
.bg-danger { background-color: #dc3545; color: white; }
.bg-info { background-color: #17a2b8; color: white; }
.bg-warning { background-color: #ffc107; color: black; }

</style>
</head>
<body>

<div style="text-align:center;">
    <img src="storage/images/ICTRent.png" alt="Logo" style="width:150px;">
</div>

<h2>ICT EQUIPMENT RENTAL</h2>
<p>
By signing this form, the user acknowledges and accepts the followings:
</p>
<ul>
    <li>The equipment is borrowed for official use only.</li>
    <li>The borrower is responsible for the safe return of the equipment in the same condition.</li>
</ul>

<table>
    {{-- ================= BORROWER DETAILS ================= --}}
    <tr>
        <th colspan="4" class="text-center">Details of Borrower</th>
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
                <small>Specify: {{ $loans->other_purpose }}</small>
            @endif
        </td>
    </tr>

    {{-- ================= EQUIPMENT DETAILS ================= --}}
    <tr>
        <th colspan="4" class="text-center">Details of Equipment / Items</th>
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
        <th colspan="4" class="text-center">Loan Duration</th>
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
                @else bg-warning
                @endif">
                {{ $loans->status }}
            </span>
        </td>
    </tr>

    {{-- ================= BORROWER CONFIRMATION ================= --}}
    <tr>
        <th colspan="4" class="text-center">Borrower Confirmation</th>
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
                <img src="{{ storage_path('app/public/'.$loans->sign_borrower) }}" 
                     style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                     alt="Borrower Signature">
            @else
                <span>No signature</span>
            @endif
        </td>
    </tr>

    @if($loans->stamp_borrower)
    <tr>
        <td><strong>Stamp</strong></td>
        <td colspan="3">
            <img src="{{ storage_path('app/public/'.$loans->stamp_borrower) }}" 
                 style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                 alt="Borrower Stamp">
        </td>
    </tr>
    @endif

    {{-- ================= SUPERIOR APPROVAL ================= --}}
    <tr>
        <th colspan="4" class="text-center">Superior Approval</th>
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
                <img src="{{ storage_path('app/public/'.$loans->sign_superior) }}" 
                     style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                     alt="Superior Signature">
            @else
                <span>No signature</span>
            @endif
        </td>
    </tr>

    {{-- ================= ICT VERIFICATION ================= --}}
    <tr>
        <th colspan="4" class="text-center">ICT Verification</th>
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
                <img src="{{ storage_path('app/public/'.$loans->sign_ict) }}" 
                     style="max-width: 200px; border: 1px solid #ccc; padding: 5px;" 
                     alt="ICT Signature">
            @else
                <span>No signature</span>
            @endif
        </td>
    </tr>

    {{-- ================= SYSTEM INFO ================= --}}
    <tr>
        <th colspan="4" class="text-center">System Information</th>
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
</body>
</html>