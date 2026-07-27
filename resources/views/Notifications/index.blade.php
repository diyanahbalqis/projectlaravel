@extends('layouts.app')

@section('title', 'Notifications')

@section('content')
<div class="container mt-4">
    <h2>Your Notifications</h2>

    <div>
            <a href="{{ route('notifications.create') }}" class="btn btn-primary">
                <i class="fa-solid fa-laptop me-1"></i> Add New Loan
            </a>
        </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @forelse($notifications as $note)
        <div class="card mb-2">
            <div class="card-body">
                <h5>{{ $note->title }}</h5>
                <p>{{ $note->message }}</p>
                <small class="text-muted">{{ $note->created_at->diffForHumans() }}</small>
                @if(!$note->is_read)
                    <a href="{{ route('notifications.read', $note->id) }}" class="btn btn-sm btn-outline-primary float-end">Mark as Read</a>
                @endif
            </div>
        </div>
    @empty
        <p>No notifications found.</p>
    @endforelse
</div>
@endsection
