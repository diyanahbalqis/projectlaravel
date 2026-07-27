<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title }}</title>
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
    <p>Date: {{ $date }}</p>

    <table>
        <thead>
            <tr>
            <th>No</th>
            <th>id </th>
            <th>Name</th>
            <th>purpose</th>
            <th>Loan Type</th>
            <th>Tarikh</th>
        </tr>
        </thead>
        <tbody>
            @foreach($loan as $index => $loans)
            <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $loans->id }}</td>
            <td>{{ $loans->name }}</td>
            <td>{{ $loans->user->name }}</td>
            <td>{{ $loans->purpose }}</td>
            <td>{{ $loans->loan_type }}</td>
            <td>{{ $loans->created_at->format('d/m/Y') }}</td>
        </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
