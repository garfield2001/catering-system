<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\AdminUser;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin_users')->attempt($credentials)) {
            return redirect()->route('dashboard.index')->with([
                'success' => 'Login successful.',
            ]);
        }

        return redirect()->route('login.show')->with('error', 'Invalid login credentials.');
    }

    public function logout(Request $request)
    {
        Auth::guard('admin_users')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('success', 'Logged out successfully.');
    }

    public function showLoginForm()
    {
        if (Auth::guard('admin_users')->check()) {
            return redirect()->route('dashboard.index')->with('message', 'You are already logged in');
        }

        return view("Admin.auth.login");
    }

    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:5',
            'password' => 'required|min:5|confirmed',
        ]);

        AdminUser::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login.show')->with('success', 'Registration successful. You can now login.');
    }

    public function showRegisterForm()
    {
        return view("Admin.auth.register");
    }


    public function showLockScreen()
    {

    }
}
