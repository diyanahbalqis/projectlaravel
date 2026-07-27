<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Traits\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{

    use ActivityLogger; 
    
    public function index(Request $request)
{

    $users = Auth::user();

    return view('settings.index', compact('users'));
}

public function roleIndex(Request $request)
{
$user = auth()->user();

        // Ensure only admin can access
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }

        // Base query for all users
        $query = User::query();

        // Handle search by email (or change to 'name' if preferred)
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->search . '%'); // Searches email
            // If you want to search by name instead: $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Paginate for performance (adjust or remove if needed)
        $users = $query->paginate(10);

        return view('settings.role', compact('users'));

}
    public function updatePassword(Request $request)
    {
        
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        $this->logActivity('Update Password', "Password updated for {$user->name}");

        return redirect()->route('settings.index')->with('success', 'User updated successfully!');
    }

    // Admin changes password for any user
    public function adminUpdatePassword(Request $request, $id)
    {
        $request->validate([
            'new_password' => 'required|min:5|confirmed',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        $this->logActivity('Admin Update Password', "Password updated for {$user->name}");

        return redirect()->route('settings.role')->with('success', 'User updated successfully!');
    }

    // Admin updates role
    public function updateRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,user',
        ]);

        $user = User::findOrFail($id);
        $user->role = $request->role;
        $user->save();

        return redirect()->route('settings.role')->with('success', 'Role updated for ' . $user->name);
        
        $this->logActivity('Update Role', "Role updated for {$user->name}");
    }

}
