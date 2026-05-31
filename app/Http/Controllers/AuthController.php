<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

    public function showLogin() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return auth()->user()->is_admin
                ? redirect()->route('admin.dashboard')->with('success', 'Welcome back, ' . auth()->user()->name . '!')
                : redirect()->route('dashboard')->with('success', 'Welcome back, ' . auth()->user()->name . '!');
        }
        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'gender'   => 'nullable|in:Male,Female,Prefer not to say',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'gender'   => $data['gender'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        return redirect()->route('login')->with('success', 'Account created! You can now log in.');
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully.');
    }
}
