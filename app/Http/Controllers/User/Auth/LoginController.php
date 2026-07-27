<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    

public function showLoginForm() {
    return view('user.auth.login');
}

public function login(Request $request) {
    if (Auth::guard('user')->attempt($request->only('staff_id', 'password'))) {
        return redirect()->route('loan.index');
    }
    return back()->withErrors(['staff_id' => 'Invalid Credentials']);
}
}
