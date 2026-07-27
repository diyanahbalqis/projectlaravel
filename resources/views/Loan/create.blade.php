@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','Form ')

@section('content')

<head>

    <link rel="stylesheet" href="{{ asset('css/loan/create.css') }}" >

</head>
<body>

<h1>
    Loan Form
</h1>

<form method="POST" action="{{ route('loan.store') }}" enctype="multipart/form-data">
    @csrf  

    <table style="width:100%">
  <tr>
    <th colspan="4">Details of Borrower</th>
  </tr>

  <tr>
    <td>
        <strong>Name:</strong>
    </td>
    
    <td colspan="3"><div class="mb-3">
            <label for="name" class="form-label">Name of Borrower</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter the name of borrower">
        </div>
    </td>
  </tr>

  <tr>
    <td>
        <strong>Contact Number</strong>
    </td>
    
    <td colspan="3"><div class="mb-3">
            <label for="phone" class="form-label">	Contact Number</label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="phone">
        </div>
    </td>
  </tr>

  <td>Department</td>

    <td colspan="3"><div class="mb-3">
            <label for="department" class="form-label">Department</label>
            <input type="text" name="department" id="department" class="form-control" placeholder="Enter Department">
        </div>
    </td>
  </tr>

    <tr>
    <td>Staff ID:</td>

    <td><div class="mb-3">
            <label for="staff_id" class="form-label"> </label>
            <input type="text" name="staff_id" id="staff_id" class="form-control" placeholder="your staff id">
        </div>
    </td>
  
    <td>Email:</td>

    <td><div class="mb-3">
            <label for="email" class="form-label"> </label>
            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
        </div>
    </td>
</tr>
<tr>
    <td>
        <div class="mb-3">
            <label for="purpose" class="form-label">Purpose</label>
            <select name="purpose" id="purpose" class="form-select" required onchange="toggleOtherPurpose()">
                <option value="Others">Select Purpose</option>
                <option value="Class">Class</option>
                <option value="Event">Event</option>
                <option value="Others">Others (Specify)</option>
            </select>
        </div> 
    </td>

    <td colspan="3"><div class="mb-3">
            <label for="other_purpose" class="form-label"> </label>
            <input type="text" name="other_purpose" id="other_purpose" class="form-control" placeholder="Other purpose">
        </div>
    </td>
  </tr>
  <tr>
    <th colspan="4">Details of Equipment/Items</th>
  </tr>
  <tr>
  <td>Item Type</td>
    <td colspan="1">
        <label>
            <input type="checkbox" name="item_type[]" value="Laptop"> Laptop
        </label>
        <label class="ms-3">
            <input type="checkbox" name="item_type[]" value="Projector"> Projector
        </label>
        <label class="ms-3">
            <input type="checkbox" name="item_type[]" value="Other"> Other
        </label>
    </td>

<td>Other Equipment</td>

    <td><div class="mb-3">
            <label for="other_equipment" class="form-label"> </label>
            <input type="text" name="other_equipment" id="other_equipment" class="form-control" placeholder="Other Equipment">
        </div>
    </td>
    
  </tr>
  <tr>
    <th colspan="4">*Please get approval from Head of Academic Support if borrow small equipment or asset.</th>
  </tr>
  <tr>
    <th colspan="2">Fill by Borrower</th>
    <th colspan="2">Fill by ICT Staff</th>
  </tr>
  <tr>
    <td>Equipment/Item 
    <br>Name and Number:
</td>
<td>
    <div class="form-group">
        <label for="equipment_id">Select Equipment</label>
        <select name="equipment_id" id="equipment_id" class="form-control" required>
            <option value="">-- Select Equipment --</option>
            @foreach($equipment as $equip)
                <option value="{{ $equip->id }}">
                    {{ $equip->name }} ({{ $equip->equipment_no }})
                </option>
            @endforeach
        </select>
        @error('equipment_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</td>
    <td>Asset Tagging No:</td>
    <td><div class="mb-3">
            <label for="asset_no" class="form-label"> </label>
            <input type="text" name="asset_no" id="asset_no" class="form-control" placeholder=" ">
        </div>
    </td>
  </tr>
  <tr>
    <td>Quantity:</td>
    <td><div class="mb-3">
            <label for="quantity" class="form-label"></label>
            <input type="number" name="quantity" id="quantity" class="form-control" placeholder=" ">
        </div>
    </td>
    <td>Serial Number:</td>
    <td>
        <div class="mb-3">
            <label for="serial_no" class="form-label"></label>
            <input type="" name="serial_no" id="serial_no" class="form-control" placeholder=" ">
        </div>
    </td>
  </tr>
  <tr>
    <td>Serial Number:</td>
    <td>
        <div class="mb-3">
            <input type="text"
                   name="serial_number"
                   id="serial_number"
                   class="form-control"
                   placeholder="Enter serial number">
        </div>
    </td>
    <td>Current Location:</td>
    <td>
        <div class="mb-3">
            <input type="text" name="current_location" id="current_location" class="form-control" placeholder="Enter current location">
        </div>
    </td>
</tr>
<tr>

    <td>Model:</td>
    <td>
        <div class="mb-3">
            <input type="text" name="model" id="model" class="form-control" placeholder="Enter model">
        </div>
    </td>

    <td>Additional Description:</td>
    <td>
        <div class="mb-3">
            <input type="text" name="additional_description" id="additional_description" class="form-control" placeholder="Enter description">
        </div>
    </td>
</tr>

<tr>
    <!-- Borrowing Date & Time -->
    <td>
        <strong>Borrowing Date & Time</strong>
        <div class="mb-3">
            <input type="datetime-local" name="date_borrow" id="date_borrow" class="form-control">
        </div>
    </td>

    <!-- Estimated Return Date & Time -->
    <td>
        <strong>Estimated Return Date & Time</strong>
        <div class="mb-3">
            <input type="datetime-local" name="est_ret_date" id="est_ret_date" class="form-control">
        </div>
    </td>

    <td>
        <strong>Return Date</strong>
        <div class="mb-3">
            <input type="datetime-local" name="date_return" id="date_return" class="form-control">
        </div>
    </td>

    <td>
        <strong>Condition of Equipment</strong>
        <div class="mb-3">
            <input type="text-local" name="condition" id="condition" class="form-control">
        </div>
    </td>
</tr>


{{-- ================= BORROWER SIGNATURE ================= --}}
<tr>
    <th colspan="4">Borrower Confirmation</th>
</tr>
<tr>
    <td>Name:</td>
    <td>
        <input type="text" name="name_borrower" class="form-control">
    </td>
    <td>Date:</td>
    <td>
        <input type="datetime-local" name="date_borrower" class="form-control">
    </td>
    
</tr>
<tr>
    <td>Signature:</td>
    <td>
     <div class="form-group">
            <label>Borrower Signature</label>
            <button type="button" class="btn btn-primary" onclick="openSignaturePad('sign_borrower')">
                Click to Sign
            </button>
            <input type="hidden" id="sign_borrower" name="sign_borrower">
            <br>
            <img id="signPreview" style="display:none; max-width:300px; margin-top:10px; border:1px solid #ccc;">
        </div>
    </td>
    <td colspan="2"></td>
</tr>
{{-- ================= SUPERIOR APPROVAL ================= --}}
<!-- <tr>
    <th colspan="4">Superior Approval</th>
</tr>
<tr>
    <td>Name:</td>
    <td>
        <input type="text" name="name_superior" class="form-control">
    </td>
   <td>Date:</td>
    <td>
        <input type="datetime-local" name="date_superior" class="form-control">
    </td> 
    
</tr>
<tr>
    <td>Superior Signature:</td>
    <td>
    <div class="form-group">
            <label>Superior Signature</label>
            <button type="button" class="btn btn-primary" onclick="openSignaturePad('sign_superior')">
                Click to Sign
            </button>
            <input type="hidden" id="sign_superior" name="sign_superior">
            <br>
            <img id="signPreview_superior" style="display:none; max-width:300px; margin-top:10px; border:1px solid #ccc;">
        </div>
    </td>
</tr> -->

{{-- ================= ICT APPROVAL ================= --}}
<tr>
    <th colspan="4">ICT Verification</th>
</tr>
<tr>
    <td>Name:</td>
    <td>
        <input type="text" name="name_ict" class="form-control">
    </td>
   <td>Date:</td>
    <td>
        <input type="datetime-local" name="date_ict" class="form-control">
    </td> 
    
</tr>
<tr>
    <td>ICT Signature:</td>
    <td>
    <div class="form-group">
            <label>ICT Signature</label>
            <button type="button" class="btn btn-primary" onclick="openSignaturePad('sign_ict')">
                Click to Sign
            </button>
            <input type="hidden" id="sign_ict" name="sign_ict">
            <br>
            <img id="signPreview_ict" style="display:none; max-width:300px; margin-top:10px; border:1px solid #ccc;">
        </div>
    </td>
</tr>

</table>
      <button type="submit" class="btn btn-primary">Submit</button>
</form>

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('/equipment/list')
        .then(response => response.json())
        .then(data => {
            const select = document.getElementById('item');
            data.forEach(equipment => {
                const option = document.createElement('option');
                option.value = equipment.id; // or equipment.equipment_id
                option.textContent = equipment.name + ' - ' + equipment.number;
                select.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
});

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