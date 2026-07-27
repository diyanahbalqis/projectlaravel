@extends('layouts.app')

@section('title', 'role')

@section('content')
<div class="container mt-4">

    <h2>Settings Role</h2>

    {{-- Admin Section --}}
@if(Auth::user()->role === 'admin')
<div class="card mt-5">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <span>Admin Settings</span>
        <form method="GET" action="{{ route('settings.role') }}" class="d-flex" style="gap: 10px;">
            <input type="text" name="search" class="form-control" placeholder="Search by email" 
                   value="{{ request('search') }}" style="width: 250px;">
            <button type="submit" class="btn btn-light">Search</button>
        </form>
    </div>
    <div class="card-body">
        @if(request('search'))
            <p>Showing results for: <strong>{{ request('search') }}</strong></p>
        @endif


        @session('success')
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ $value }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endsession


        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Change Role</th>
                    <th>Change Password</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                <tr>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td><span class="badge bg-secondary">{{ $u->role }}</span></td>
                    <td>
                        <form method="POST" action="{{ route('settings.updateRole', $u->id) }}">
                            @csrf
                            <select name="role" class="form-select" onchange="this.form.submit()">
                                <option value="user" {{ $u->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $u->role == 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('settings.adminUpdatePassword', $u->id) }}">
                            @csrf
                            <input type="password" name="new_password" placeholder="New Password" class="form-control mb-2" required>
                            <input type="password" name="new_password_confirmation" placeholder="Confirm Password" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-sm btn-warning">Update</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No users found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endif

</div>
@endsection
