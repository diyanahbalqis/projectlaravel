@extends(Auth::user()->role == 'admin' ? 'layouts.app' : 'layouts.userapp')

@section('title','User Profile')

@section('content')
<div class="container mt-5">
    @php
        // $users = Auth::user()->id; 
    @endphp

    

    <div class="card shadow-sm p-4 mt-5">
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/profilepic.jpg') }}" class="rounded-circle border" alt="user profile" width="150" height="150">
            
        <p><strong>Name:</strong> {{ $users->name }}</p>
        <p><strong>Staff ID:</strong> {{ $users->staff_id }}</p>
        <p><strong>Email:</strong> {{ $users->email }}</p>
        <p><strong>Role:</strong> {{ $users->role }}</p>
        <p><strong>Created at:</strong> {{ $users->created_at->format('d M Y') }}</p>

    </div>
</div>
@endsection
