@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp') 

@section('title', 'Report Equipment')

@section('content')

<head>

<!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

        <link rel="stylesheet" href="{{ asset('css/reportloan.css') }}">

</head>
<body>
<!-- 
<h1>
    Report untuk
     Loan 
</h1>

<div>
    <a href="{{ route('equipment.printpdf') }}" class="btn btn-primary" target="_blank">
    view PDF
</a> -->
</div>

    <h2>{{ $title }}</h2>
<p>Date: {{ $date }}</p>

<div class="table-responsive">
<table class="table table-bordered" id="example">
<thead>
<tr>
    <th>No</th>
    <th>ID</th>
    <th>Username</th>
    <th>Name</th>
    <th> Asset Serial Number </th>  <!-- New column -->
    <th> Model </th>                <!-- New column -->
    <th> Asset No </th>     
    <th> Status </th>
</tr>
</thead>
<tbody>
@foreach($equipment as $index => $item)
<tr>
    <td>{{ $index + 1 }}</td>
    <td>{{ $item->id }}</td>
    <td>{{ $item->user->name ?? '-' }}</td>
    <td>{{ $item->name }}</td>
    <td>{{ $item->serial_no ?? '-' }}</td>  <!-- New field, with fallback -->
    <td>{{ $item->model ?? '-' }}</td>                <!-- New field, with fallback -->
    <td>{{ $item->asset_no ?? '-' }}</td>  
    <td>{{ $item->status }}</td>
</tr>
@endforeach
</tbody>
</table>
</div>
  <!-- jQuery dan DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

        <script>
$(document).ready(function () {
    $('#example').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
            'print'
        ]
    });
});
</script>

</body>

@endsection