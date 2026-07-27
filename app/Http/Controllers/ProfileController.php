<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function index(): View
    {
        $users = Auth::user($id); // single user
        return view('userinfo.userprofile', compact('users'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'users' => $request->users(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->users()->fill($request->validated());

        if ($request->users()->isDirty('email')) {
            $request->users()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $users = $request->user($id);

        Auth::logout();

        $users->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    

    public function showProfile()
    {
        if (!auth()->user()->user) {
            User::create([
                'user_id' => auth()->id(),
                'email'   => auth()->user()->email,
            ]);
        }

        return view('profile.show', [
            'user' => auth()->user()
        ]);
    }
}
