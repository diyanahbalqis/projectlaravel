<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\Loan;

use PDF;

trait ActivityLogger
{

    /**
     * Log activity for current user
     *
     * @param string $action
     * @param string|null $description
     * @param mixed $subject optional Eloquent model
     */

    // Show ALL logs (For admin)
    public function index(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');

        $query = ActivityLog::with('users')->latest();

// Extract params from request (adjust if $request isn't available)
$search = $request->input('search');
$month = $request->input('month');
$year = $request->input('year');

// Apply date filters if provided (for both roles)
if ($month && $year) {
    $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
}

if ($user->role === 'admin') {
    // Admins can search globally by user ID or name
    if ($search) {
        $query->whereHas('users', function ($q) use ($search) {
            $q->where('id', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
        });
    }
    // Get all matching logs (with optional filters)
    $logs = $query->paginate(50);  // Use paginate for performance; change to get() if needed
} else {
    // Non-admins: Filter by their own user_id, plus optional search within their logs
    $query->where('user_id', $user->id);
    if ($search) {
        // Allow searching by their own name/ID (though redundant, for consistency)
        $query->whereHas('users', function ($q) use ($search) {
            $q->where('id', 'like', "%{$search}%")
              ->orWhere('name', 'like', "%{$search}%");
        });
    }
    $logs = $query->paginate(50);
}

        return view('activity.userlogs', compact('logs', 'search'));
    }

    // Log activity
    public function logActivity($action, $description = null, $subject = null)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id'     => $user->id,
            'log_name'    =>$user->name,
            'staff_id'    => $user->staff_id,
            'action'      => $action,
            'description' => $description,
            'causer_id'   => $user->id,
            'causer_type' => get_class($user),
            'subject_id'  => null,
            'subject_type'=> null,
            'properties'  => [],
        ]);
    }

    // Logs for 1 user
    public function userLogs($id)
    {
        $users = User::findOrFail($id);

        // logs for this user
        $logs = ActivityLog::where('id', $users->id)
                            ->latest()
                            ->get();

        // notifications
        $notifications = Notification::where('id', $users->id)->get();
        $unread = $notifications->where('read_at', null)->count();

        return view('activity.userlogs', compact('users', 'logs', 'notifications', 'unread'));
    }
}