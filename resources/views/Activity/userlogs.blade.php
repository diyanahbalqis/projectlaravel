@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title', 'User Activity Log')

@section('content')

@if(isset($user) && $user)
  <h2>Activity Logs for {{ $user->name }}</h2>
@else
  <h2>Activity Logs</h2>
@endif

<head>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">
    
    <!-- FontAwesome for icons (add if not already included globally) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/userlogs.css') }}">
</head>
<body>
    <div>
        <a href="{{ route('activity.printpdf', ['search' => $search ?? '']) }}" class="btn btn-primary" target="_blank">
            Print PDF
        </a>
    </div>

    

    <!-- Removed scrollable div to avoid conflicts with DataTables -->
    <table class="table table-bordered table-hover" id="example">
        <thead>
            <tr>
                <th>Date</th>
                <th>Name</th>
                <th>Staff ID</th>
                <th>Action</th>
                <th>Description</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>User ID</th>
                <th>Causer ID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->users->name ?? 'Unknown User' }}</td>
                    <td>{{ $log->staff_id }}</td>
                    <td>{{ $log->action }}</td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->updated_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $log->user_id }}</td>
                    <td>{{ $log->causer_id }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- jQuery and DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(document).ready(function () {
            try {
                $('#example').DataTable({
                    dom: 'Bfrtip',  // Buttons, filter (search), table, info, pagination
                    buttons: [
                        'copyHtml5',
                        'excelHtml5',
                        'csvHtml5',
                        'pdfHtml5',
                        'print'
                    ],
                    paging: true,      // Enable pagination
                    searching: true,   // Enable DataTables' built-in search (optional, in addition to your form)
                    ordering: true,    // Enable sorting
                    scrollY: '500px',  // Add scrolling if needed (replaces your div)
                    scrollCollapse: true
                });
                console.log('DataTable initialized successfully.');
            } catch (error) {
                console.error('DataTable init failed:', error);
            }
        });
    </script>
</body>
@endsection