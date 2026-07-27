<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">


    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2, p {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }

        
    </style>
</head>
<body>
    <h2>{{ $title }}</h2>
<p>Date: {{ $date }}<p>

    <table class="table table-bordered" id="example">
    <thead>
        <tr>
            <th>Date</th>
            <th>Name</th>
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
            <td>{{ $log->created_at }}</td>
            <td>{{ $log->users->name ?? 'Unknown User' }}</td>
            <td>{{ $log->action }}</td>
            <td>{{ $log->description }}</td>
            <td>{{ $log->created_at }}</td>
            <td>{{ $log->updated_at }}</td>
            <td>{{ $log->user_id }}</td>
            <td>{{ $log->causer_id }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
</body>
</html>
