@extends('layouts.app') 

@section('title', 'View User Data')

@section('content')
<head>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.1/css/all.css" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                <table class="table table-bordered table-striped mt-4">
                        <thead class="table-dark">
                            <tr>
                                <th>Action</th>
                            </tr>
                        </thead>

                    <!-- User Information Table -->
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th>ID</th>
                            <td>{{ $users->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $users->name }}</td>
                        </tr>
                        <tr>
                            <th>Staff ID</th>
                            <td>{{ $users->staff_id }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $users->email }}</td>
                        </tr>
                        <tr>
                            <th>Phone</th>
                            <td>{{ $users->phone }}</td>
                        </tr>
                        <tr>
                            <th>Address</th>
                            <td>{{ $users->address }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $users->created_at->format('d M Y, H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Updated At</th>
                            <td>{{ $users->updated_at->format('d M Y, H:i') }}</td>
                        </tr>

                    </table>

                    <!-- Action Buttons -->
                    <div class="mt-4">
                        <a href="{{ route('userinfo.index') }}" class="btn btn-warning"><i class="fa-solid fa-backward-step"></i></a>
                        <a href="{{ route('userinfo.edit', $users->id) }}" class="btn btn-primary">
                            Edit
                        </a>

                        <!-- Delete Form -->
                        <form action="{{ route('loan.destroy', $l->id) }}" method="POST" 
                                        onsubmit="return confirm('Are you sure you want to delete this loan?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
