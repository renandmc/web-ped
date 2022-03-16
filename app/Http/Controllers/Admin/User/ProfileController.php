<?php

namespace App\Http\Controllers\Admin\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display profile of user logged in
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = User::find(Auth::id(), ['name', 'email', 'created_at']);
        return view('admin.user.profile', [
            'user' => $user,
        ]);
    }

    /**
     * Show form to change profile
     *
     * @return \Illuminate\View\View
     */
    public function editProfile()
    {
        $user = User::find(Auth::id(), ['name', 'email']);
        return view('admin.user.edit-profile', [
            'user' => $user
        ]);
    }

    /**
     * Update password of user logged in
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
        ]);
        $user = User::find($request->user()->id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        Auth::setUser($user);
        return redirect()->route('user.profile');
    }

    /**
     * Show form to change password
     *
     * @return \Illuminate\View\View
     */
    public function editPassword()
    {
        $user = User::find(Auth::id(), ['password']);
        return view('admin.user.edit-password', [
            'user' => $user,
        ]);
    }

    /**
     * Update password of user logged in
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password'  => 'required|current_password',
            'new_password'      => 'required|string|min:6|different:current_password|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        Auth::setUser($user);
        return redirect()->route('user.profile');
    }
}
