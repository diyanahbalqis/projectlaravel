<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\File;
use App\Models\Loan;
use App\Models\Equipment;
use App\Models\ActivityLog;
use App\Traits\ActivityLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; 

class UserController extends Controller
{

 use ActivityLogger;
 
    public function dashboard()
    {

        $user = Auth::user();

        $totalUsers = User::count();

        $totalLoan = Loan::count();

       $availableEquipment = Equipment::where('status', 'available')->count();



        return view('userinfo.userdashboard', [
        'user' => $user,
        'totalUsers' => $totalUsers,
        'totalLoan'=> $totalLoan,
        'availableEquipment'=>$availableEquipment,
    ]);
    }

    public function index()
    {
        $authUser = Auth::user();
        $user = Auth::user();

        if ($authUser->role === 'admin') {
            $user = User::all();
        } else {
            $user = User::where('id', $authUser->id)->get();
        }

        return view('userinfo.index', compact('user'));
    }

//     public function show($id)
// {

//     // dd(User::all());
//     // Get user or show 404 if not found
//     $users = User::findOrFail($id);

//     // Get all files that belong to this user
//     // $files = File::where('user_id', $id)->get();

//     // Log activity with user info
//     $this->logActivity('View Details', "Viewed profile of {$users->name}");

//     // Return the profile view with both datasets
//     return view('userinfo.userprofile', compact('users'));
// }
 

    public function create()
    {

        $users = User::all();
        
        return view('userinfo.create');
    }

   public function store(Request $request)
{
    $user = new User();
    $user->name = $request->name;
    $user->staff_id = $request->staff_id;
    $user->email = $request->email ?? 'temp@example.com';
    $user->password = bcrypt($request->password ?? 'password123');
    $user->role = $request->role ?? 'user';
    $user->phone = $request->phone;
    $user->address = $request->address;
    $user->department = $request->department;
    $user->approval = $request->input('approval'); // ✅ Fix variable

    if ($request->hasFile('profile_picture')) {
        $file = $request->file('profile_picture');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $filename);
        $user->profile_picture = $filename;
    }

    $user->save();

    return redirect()->route('userinfo.index')->with('success', 'User added successfully');
}


    public function edit($id)
    {
        
        $users = User::findOrFail($id);

        $this->logActivity('Edit data', "Profile edited for {$users->name}");

        return view('userinfo.edit', compact('users'));
    }


    public function update(Request $request, $id)
{  
    $users = User::findOrFail($id);
 
    $data = $request->validate([
        'name' => 'required',
        'staff_id' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'address' => 'nullable',
        'department' => 'nullable',
        'approval' => 'required|integer|in:0,1,2', // ✅ Add approval validation
        'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    // Handle profile picture
    if ($request->hasFile('profile_picture')) {
        if ($users->profile_picture && file_exists(public_path('uploads/profile/'.$users->profile_picture))) {
            unlink(public_path('uploads/profile/'.$users->profile_picture));
        }

        $file = $request->file('profile_picture');
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/profile'), $filename);

        $data['profile_picture'] = $filename;
    }

    // Update user, including approval
    $users->update($data);

    $this->logActivity('Update Profile', "Profile updated for {$users->name}", $users);

    return redirect()->route('userinfo.index')->with('success', 'User updated successfully!');
}


    public function destroy($id)
    {

        $users = User::findOrFail($id);

        $users->delete();

        $this->logActivity('delete', "User deleted loan ID {$users->id}", $users
        );

        return redirect()->route('userinfo.index')->with('success', 'User deleted successfully.');
    }

    public function datatable()
    {
        $users = User::all();
        return view('userinfo.datatable', compact('users'));
    }

    public function userprofile()
    {
        $user = Auth::user();
        $users = User::where('id', $user->id)->first();

        $this->logActivity('View User profile', "User view user profile for {$users->name}");

        return view('userinfo.userprofile', compact('users'));
    }

    public function updateApproval(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $users->approval = $request->input('approval');
        $users->save();

        $this->logActivity('Updated Approval', "Admin updated  Approval for {$users->name}");

        return redirect()->back()->with('success', 'Approval status updated successfully!');
    }

}

