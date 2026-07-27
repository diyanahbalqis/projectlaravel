<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Loan;
use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login'); // Make sure you have resources/views/admin/login.blade.php
    }

    public function login(Request $request)
    {
        $credentials = $request->only('staff_id', 'password');

        if (Auth::attempt($credentials)) {
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors('Access denied.');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function dashboard()
{

        $user = Auth::user();

        // Total users
        $totalUsers = User::count();

        // Total rentals / loans
        $totalLoan = Loan::count();

        $availableEquipment = Equipment::where('status', 'available')->count();

        // Reports (dummy / nanti ambil dari model jika ada)
        // $totalReports = 35;

        // // Settings updated (dummy / boleh ambil dari audit log jika ada)
        // $totalSettings = 5;

        // // Equipment status (contoh menggunakan model Equipment)
        // $availableEquipment = Equipment::where('status', 'available')->count();
        // $currentlyRented = Equipment::where('status', 'rented')->count();
        // $underMaintenance = Equipment::where('status', 'maintenance')->count();

        return view('admin.dashboard', compact(
            'user',
            'totalUsers',
            'totalLoan',
        'availableEquipment',
            // 'totalReports',
            // 'totalSettings',
            // 'availableEquipment',
            // 'currentlyRented',
            // 'underMaintenance'
        ));

    // $totalUsers = User::count();

    // return view('userinfo.userdashboard');

    // return view('userinfo.userdashboard', [
    //     'user' => $user,
    //     'totalUsers' => $totalUsers
    // ]);
}

    public function index()
    {

        $logs = ActivityLog::latest()->get();
        return view('admin.index', compact('logs'));
    }

    public function show($id)
{
    if(auth()->user()->role === 'admin'){
        $user = User::all();
    } else {
        $user = User::where('id', auth()->id())->get();
    }
    return view('admin.index', compact('user'));
}

}