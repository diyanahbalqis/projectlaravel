@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','Form Pdf')

@section('content')

<head>
    <link rel="stylesheet" href="{{ asset('css/loan/edit.css') }}" >
</head>

<body>

<form action="{{ route('loan.update', $loan->id) }}" method="POST" enctype="multipart/form-data">
    @csrf  
    @method('PUT')

    <table style="width:100%">
  <tr>
    <th colspan="4">Details of Borrower</th>
  </tr>

  <tr>
    <td>Name:</td>
    
    <td colspan="3"><div class="mb-3">
            <input type="text" name="name" id="name" placeholder="name" value="{{ old('name', $loan->name ?? '') }}">
        </div>
    </td>
  </tr>

  <tr>
    <td>	Contact Number</td>
    
    <td colspan="3"><div class="mb-3">
            <input type="text" name="phone" id="phone" placeholder="phone" value="{{ old('phone', $loan->phone ?? '') }}">
        </div>
    </td>
  </tr>

  <td>Department</td>

    <td colspan="3"><div class="mb-3">
            <input type="text" name="department" id="department" placeholder="department" value="{{ old('department', $loan->department ?? '') }}">
        </div>
    </td>
  </tr>

    <tr>
    <td>Staff ID:</td>

    <td><div class="mb-3">
            <input type="text" name="staff_id" id="staff_id" placeholder="staff_id" value="{{ old('staff_id', $loan->staff_id ?? '') }}">
        </div>
    </td>
  
    <td>Email:</td>

    <td><div class="mb-3">
            <input type="text" name="phone" id="phone" placeholder="phone" value="{{ old('phone', $loan->phone ?? '') }}">
        </div>
    </td>
</tr>
<tr>
    <td>
        <div class="mb-3">
          <label for="item" class="form-label"> Purpose </label>
            <select name="purpose" onchange="toggleOtherPurpose()">
    <option value="">Select Purpose</option>
    <option value="Class" {{ old('purpose',$loan->purpose)=='Class'?'selected':'' }}>Class</option>
    <option value="Event" {{ old('purpose',$loan->purpose)=='Event'?'selected':'' }}>Event</option>
    <option value="Others" {{ old('purpose',$loan->purpose)=='Others'?'selected':'' }}>Others</option>
</select>
        </div> 
    </td>

    <td colspan="3"><div class="mb-3">
            <label for="other_purpose" class="form-label"> </label>
            <input type="text" name="other_purpose" id="other_purpose" placeholder="other_purpose" value="{{ old('other_purpose', $loan->other_purpose ?? '') }}">
        </div>
    </td>
  </tr>
  <tr>
    <th colspan="4">Details of Equipment/Items</th>
  </tr>
  <tr>
    <td>Item Type</td>
    <td>
        @php
            $selectedTypes = $loan->item_type
                ? explode(', ', $loan->item_type)
                : [];
        @endphp

        <label class="me-2">
            <input type="checkbox" name="item_type[]" value="Laptop"
                {{ in_array('Laptop', $selectedTypes) ? 'checked' : '' }}>
            Laptop
        </label>

        <label class="me-2">
            <input type="checkbox" name="item_type[]" value="Projector"
                {{ in_array('Projector', $selectedTypes) ? 'checked' : '' }}>
            Projector
        </label>

        <label>
            <input type="checkbox" name="item_type[]" value="Other"
                {{ in_array('Other', $selectedTypes) ? 'checked' : '' }}>
            Other
        </label>
    </td>

    <td>Other Equipment</td>
    <td>
        <input type="text"
               name="other_equipment"
               placeholder="Other equipment"
               value="{{ old('other_equipment', $loan->other_equipment ?? '') }}">
    </td>
</tr>


<tr>
    <th colspan="4">
        *Please get approval from Head of Academic Support if borrow small equipment or asset.
    </th>
</tr>

  <tr>
    <th colspan="2">Fill by Borrower</th>
    <th colspan="2">Fill by ICT Staff</th>
  </tr>
  <tr>
    <td>Equipment/Item 
      <br>Name:
    </td>
    <td>
    <div class="mb-3">
        <label for="item" class="form-label"></label>
        <select name="item" id="item" class="form-control">
            <option value="">Select Equipment</option>
            @foreach($equipment as $equip)
                <option value="{{ $equip->id }}" 
                    {{ old('item', $loan->item ?? '') == $equip->id ? 'selected' : '' }}>
                    {{ $equip->name }}
                </option>
            @endforeach
        </select>
    </div>
</td>
    <td>Asset Tagging No:</td>
    <td>
        <div class="mb-3">
            <label for="asset_no" class="form-label"> </label>
            <input type="text" name="asset_no" id="asset_no" placeholder="asset_no" 
                   value="{{ old('asset_no', $loan->equipment ? $loan->equipment->asset_no : ($loan->asset_no ?? '')) }}">
        </div>
    </td>
  </tr>
  <tr>
    <td>Quantity:</td>
    <td><div class="mb-3">
            <label for="quantity" class="form-label"></label>
            <input type="text" name="quantity" id="quantity" placeholder="quantity" value="{{ old('quantity', $loan->quantity ?? '') }}">
        </div>
    </td>
    <td>Serial Number:</td>
    <td>
        <div class="mb-3">
            <label for="serial_no" class="form-label"></label>
            <input type="text" name="serial_no" id="serial_no" placeholder="serial_no" value="{{ old('serial_no', $loan->serial_no ?? '') }}">
        </div>
    </td>
  </tr>
  <tr>
    <td>Current Location:
      <div class="mb-3">
            <label for="current_location" class="form-label"></label>
            <input type="text" name="current_location" id="current_location" placeholder="current_location" value="{{ old('current_location', $loan->current_location ?? '') }}">
        </div>
      </td>
    <td>Serial Number:
        <div class="mb-3">
            <label for="serial_no" class="form-label"></label>
            <input type="text" name="serial_no" id="serial_no" placeholder="serial_no" 
                   value="{{ old('serial_no', $loan->equipment ? $loan->equipment->serial_no : ($loan->serial_no ?? '')) }}">
        </div>
      </td>
     <td>Model:
        <div class="mb-3">
            <label for="model" class="form-label"></label>
            <input type="text" name="model" id="model" placeholder="model" 
                   value="{{ old('model', $loan->equipment ? $loan->equipment->model : ($loan->model ?? '')) }}">
        </div>
    </td>
    <td>Additional Description:
      <div class="mb-3">
            <label for="additional_description" class="form-label"></label>
            <input type="text" name="additional_description" id="additional_description" placeholder="additional_description" value="{{ old('additional_description', $loan->additional_description ?? '') }}">
        </div>
      </td>
  </tr>

<tr>
    <!-- Borrowing Date & Time -->
    <td>
        <strong>Borrowing Date & Time</strong>
        <div class="mb-3">
            <input type="datetime-local" name="date_borrow" value="{{ old('date_borrow', $loan->date_borrow ? \Carbon\Carbon::parse($loan->date_borrow)->format('Y-m-d\TH:i') : '') }}">
        </div>
    </td>

    <!-- Estimated Return Date & Time -->
    <td>
        <strong>Estimated Return Date & Time</strong>
        <div class="mb-3">
            <input type="datetime-local" name="date_return" value="{{ old('date_return', $loan->date_return ? \Carbon\Carbon::parse($loan->date_return)->format('Y-m-d\TH:i') : '') }}">
        </div>
    </td>

    <!-- Actual Return Date & Time -->
    <td>Estimated Return Date
    <div class="mb-3">
        <input type="date" name="est_ret_date"
            value="{{ old('est_ret_date', $loan->est_ret_date ?? '') }}">
    </div>
    </td>

    <td>Condition
    <div class="mb-3">
        <input type="text" name="condition"
            value="{{ old('condition', $loan->condition ?? '') }}">
      </div>
    </td>

    
</tr>

{{-- ================= BORROWER SECTION ================= --}}
<tr>
    <th colspan="4">Borrower Acknowledgement</th>
</tr>

<tr>
    <td>Name (Borrower)</td>
    <td>
        <input type="text" name="name_borrower"
            value="{{ old('name_borrower', $loan->name_borrower ?? '') }}">
    </td>

    <td>Date</td>
    <td>
        <input type="date" name="date_borrower"
            value="{{ old('date_borrower', $loan->date_borrower ?? '') }}">
    </td>
</tr>

<tr>
    <td>Signature (Borrower)</td>

    <td colspan="3">
        @if(Auth::user()->role == 'admin')
            <!-- Admin can update signature -->
            <div class="form-group">
                <label>Borrower Signature</label>
                <button type="button" class="btn btn-primary" onclick="openSignaturePad('sign_borrower')">
                    Click to Sign
                </button>
                <input type="hidden" id="sign_borrower" name="sign_borrower" value="{{ old('sign_borrower', $loan->sign_borrower ?? '') }}">
                <br>
                <img id="signPreview" src="{{ $loan->sign_borrower ?? '' }}" style="display:{{ $loan->sign_borrower ? 'block' : 'none' }}; max-width:300px; margin-top:10px; border:1px solid #ccc;">
            </div>
        @else
            <!-- Non-admin view only -->
            @if($loan->sign_borrower)
                <img src="{{ $loan->sign_borrower }}" style="max-width:300px; border:1px solid #ccc;">
            @else
                <p>No signature available.</p>
            @endif
        @endif
    </td>
</tr>


{{-- ================= SUPERIOR SECTION ================= --}}
<!-- <tr>
    <th colspan="4">Superior Approval</th>
</tr>

<tr>
    <td>Name (Superior)</td>
    <td>
        <input type="text" name="name_superior"
            value="{{ old('name_superior', $loan->name_superior ?? '') }}">
    </td>

    <td>Date</td>
    <td>
        <input type="date" name="date_superior"
            value="{{ old('date_superior', $loan->date_superior ?? '') }}">
    </td>
</tr>

<tr>
    <td>Signature (Superior)</td>

    <td colspan="3">
        @if(Auth::user()->role == 'admin')
            <!-- Admin can update signature -->
            <div class="form-group">
                <label>Superior Signature</label>
                <button type="button" class="btn btn-primary" onclick="openSignaturePad('sign_superior')">
                    Click to Sign
                </button>
                <input type="hidden" id="sign_superior" name="sign_superior" value="{{ old('sign_superior', $loan->sign_superior ?? '') }}">
                <br>
                <img id="signPreview_superior" src="{{ $loan->sign_superior ?? '' }}" style="display:{{ $loan->sign_superior ? 'block' : 'none' }}; max-width:300px; margin-top:10px; border:1px solid #ccc;">
            </div>
        @else
            <!-- Non-admin view only -->
            @if($loan->sign_superior)
                <img src="{{ $loan->sign_superior }}" style="max-width:300px; border:1px solid #ccc;">
            @else
                <p>No signature available.</p>
            @endif
        @endif
    </td>
</tr> -->


{{-- ================= ICT SECTION ================= --}}
<tr>
    <th colspan="4">ICT Verification</th>
</tr>

<tr>
    <td>Name (ICT)</td>
    <td>
        <input type="text" name="name_ict"
            value="{{ old('name_ict', $loan->name_ict ?? '') }}">
    </td>

    <td>Date</td>
    <td>
        <input type="date" name="date_ict"
            value="{{ old('date_ict', $loan->date_ict ?? '') }}">
    </td>
</tr>

<tr>
    <td>Signature (ICT)</td>

    <td colspan="3">
        @if(Auth::user()->role == 'admin')
            <!-- Admin can update signature -->
            <div class="form-group">
                <label>ICT Signature</label>
                <button type="button" class="btn btn-primary" onclick="openSignaturePad('sign_ict')">
                    Click to Sign
                </button>
                <input type="hidden" id="sign_ict" name="sign_ict" value="{{ old('sign_ict', $loan->sign_ict ?? '') }}">
                <br>
                <img id="signPreview_ict" src="{{ $loan->sign_ict ?? '' }}" style="display:{{ $loan->sign_ict ? 'block' : 'none' }}; max-width:300px; margin-top:10px; border:1px solid #ccc;">
            </div>
        @else
            <!-- Non-admin view only -->
            @if($loan->sign_ict)
                <img src="{{ $loan->sign_ict }}" style="max-width:300px; border:1px solid #ccc;">
            @else
                <p>No signature available.</p>
            @endif
        @endif
    </td>
</tr>

    </table>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>

<script>
function openSignaturePad(targetId) {
    // Opens signature pad in popup window
    window.open(
        '/signature/index?target=' + targetId, 
        'SignaturePad', 
        'width=800,height=600,scrollbars=yes'
    );
}
</script>

</body>

@endsection