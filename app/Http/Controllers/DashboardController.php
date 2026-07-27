<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userinfo;

class DashboardController extends Controller


{
    public function index()

    {
    $totalUsers = User::count();

        
        return view('userinfo.userdashboard', [
            'totalUsers' => $totalUsers,
            ]);

        
    }
}
