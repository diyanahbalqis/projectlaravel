@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','Form Pdf')

@section('content')

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
    </style>

</head>
<body>

<h1>
    Form PDF
</h1>
<form>
<!-- <div>
    <a href="{{ route('equipment.printpdf') }}" class="btn btn-primary" target="_blank">
    Print PDF
</a>
</div> -->

    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
    tempor incididunt ut labore et dolore magna aliqua.</p>

<form method="POST" action="{{ route('equipment.store') }}">
    @csrf  
    
    <table style="width:100%">
  <tr>
    <th colspan="4">Details of Borrower</th>
  </tr>

  <tr>
    <td>Name:</td>
    
    <td colspan="3"><div class="mb-3">
            <label for="name" class="form-label">Name of Borrower</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Enter the name of borrower">
        </div>
    </td>
  </tr>

  <tr>
    <td>Contact Number</td>

    <td><div class="mb-3">
            <label for="phone" class="form-label"> </label>
            <input type="text" name="phone" id="phone" class="form-control" placeholder="Enter contact number">
        </div>
    </td>
  
    <td>Department</td>

    <td><div class="mb-3">
            <label for="department" class="form-label"> </label>
            <input type="text" name="department" id="department" class="form-control" placeholder="Enter department">
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
  <tr><div class="fieldset">
				<div class="label"></div>
				<div class="space"></div>
    <td>Item Type</td>
    <td>Laptop PC<div><input type="checkbox" /> Vue</div></td>
    <td>Projector<div><input type="checkbox" /> jaVa</div></td>
    <td>Other Equipment<div><input type="checkbox" /> jaVa</div></td>
    
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
      <br>Name:
    </td>
    <td><div class="mb-3">
            <label for="type" class="form-label"> </label>
            <input type="text" name="item" id="item" class="form-control" placeholder="">
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
            <input type="text" name="quantity" id="quantity" class="form-control" placeholder=" ">
        </div>
    </td>
    <td>Serial Number:</td>
    <td>
        <div class="mb-3">
            <label for="serial_no" class="form-label"></label>
            <input type="text" name="serial_no" id="serial_no" class="form-control" placeholder=" ">
        </div>
    </td>
  </tr>

</table>
</form>



    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</body>
<script>
    function toggleOtherPurpose() {
        const purposeSelect = document.getElementById('purpose');
        const otherPurposeInput = document.getElementById('other_purpose');
        if (purposeSelect.value === 'Others') {
            otherPurposeInput.style.display = 'block';
        } else {
            otherPurposeInput.style.display = 'none';
            otherPurposeInput.value = '';
        }
    }

    function toggleOtherEquipment() {
        const equipmentSelect = document.getElementById('other_equipment');
        const otherEquipmentInput = document.getElementById('other_equipment_specify');
        if (equipmentSelect.value === 'Others') {
            otherEquipmentInput.style.display = 'block';
        } else {
            otherEquipmentInput.style.display = 'none';
            otherEquipmentInput.value = '';
        }
    }
</script>

@endsection