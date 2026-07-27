<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Loan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Show notification list for the logged-in user
     */
    public function index()
{
    if (Auth::user()->role === 'admin') {
        $notifications = Notification::latest()->get();
        $unread = Notification::where('is_read', false)->count();
    } else {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->get();

        $unread = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->count();
    }

    return view('notifications.index', compact('notifications', 'unread'));
}

    /**
     * Show form for admin to create notification
     */
    public function create()
    {
        // Only admin can access this
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $users = User::all();
        return view('notifications.create', compact('users'));
    }

    /**
     * Store notification sent by admin
     */
    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Notification::create([
            'user_id' => $request->user_id,
            'title'   => $request->title,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('notifications.index')->with('success', 'Notification sent successfully!');
    }

    public function fetchNotifications()
{
    $userId = auth()->id();

    $notifications = Notification::where('user_id', $userId)
        ->latest()
        ->take(5)
        ->get();

    $unreadCount = Notification::where('user_id', $userId)
        ->where('is_read', false)
        ->count();

    return response()->json([
        'notifications' => $notifications,
        'unreadCount' => $unreadCount,
    ]);
}

    /**
     * Mark specific notification as read
     */
    public function markAsRead($id)
{
    $notification = Notification::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $notification->update([
        'is_read' => 1
    ]);

    return response()->json(['success' => true]);
}
    /**
     * (Optional) Show all loans + unread count for admin dashboard
     */
    public function adminDashboard()
    {
        $loans = Loan::with('user')->get();
        $unread = Notification::where('user_id', auth()->id())
    ->where('is_read', false)
    ->count();

    return view('loan.index', compact('loans', 'unread'));
        
    }
}
