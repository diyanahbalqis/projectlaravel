@extend(Auth::user()->role == 'admin' / 'layouts.app' : 'layouts.userapp')

@section('title', 'Admin Dashboard')

@section('content')

<div class="class-container-fluid py-3">
    <div class="dashboard-wrapper"></div>
</div>

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the loans for the authenticated user.
     */
    public function index()
    {
        $loans = Loan::where('user_id', Auth::id())->get();
        return view('loans.index', compact('loans'));
    }

    /**
     * Show the form for creating a new loan.
     */
    public function create()
    {
        return view('loans.create');
    }

    /**
     * Store a newly created loan in storage and notify the admin.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0',
            'purpose' => 'required|string|max:255',
            // Add other validation rules as needed
        ]);

        // Create the loan
        $loan = Loan::create([
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'purpose' => $request->purpose,
            'status' => 'pending', // Assuming a default status
            // Add other fields as needed
        ]);

        // Find the admin user (assuming there's at least one admin)
        $admin = User::where('role', 'admin')->first();

        if ($admin) {
            // Create a notification for the admin
            Notification::create([
                'user_id' => $admin->id,
                'title' => 'New Loan Submitted',
                'message' => 'A new loan has been submitted by ' . Auth::user()->name . ' for $' . $request->amount . ' with purpose: ' . $request->purpose,
                'is_read' => false,
            ]);
        }

        return redirect()->route('loans.index')->with('success', 'Loan submitted successfully! Admin has been notified.');
    }

    /**
     * Display the specified loan.
     */
    public function show(Loan $loan)
    {
        // Ensure the user owns the loan or is admin
        if ($loan->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        return view('loans.show', compact('loan'));
    }

    /**
     * Show the form for editing the specified loan (if allowed).
     */
    public function edit(Loan $loan)
    {
        // Only allow editing if status is pending and user owns it
        if ($loan->user_id !== Auth::id() || $loan->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        return view('loans.edit', compact('loan'));
    }

    /**
     * Update the specified loan in storage.
     */
    public function update(Request $request, Loan $loan)
    {
        if ($loan->user_id !== Auth::id() || $loan->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'amount' => 'required|numeric|min:0',
            'purpose' => 'required|string|max:255',
        ]);

        $loan->update($request->only(['amount', 'purpose']));

        return redirect()->route('loans.index')->with('success', 'Loan updated successfully!');
    }

    /**
     * Remove the specified loan from storage (if allowed).
     */
    public function destroy(Loan $loan)
    {
        if ($loan->user_id !== Auth::id() || $loan->status !== 'pending') {
            abort(403, 'Unauthorized action.');
        }

        $loan->delete();

        return redirect()->route('loans.index')->with('success', 'Loan deleted successfully!');
    }
}

<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="notificationDropdown" data-toggle="dropdown">
        Notifications <span class="badge badge-danger" id="unread-count">{{ $unread }}</span>
    </button>
    <div class="dropdown-menu" id="notification-list">
        @foreach($notifications as $notification)
            <!-- Make the entire notification clickable -->
            <a href="{{ route('loans.index') }}" class="dropdown-item notification-link" data-id="{{ $notification->id }}">
                <strong>{{ $notification->title }}</strong><br>
                {{ $notification->message }}
                @if(!$notification->is_read)
                    <span class="badge badge-primary">Unread</span>
                @endif
            </a>
        @endforeach
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('notifications.index') }}">View All</a>
    </div>
</div>