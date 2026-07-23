<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {
    public function showLogin() {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role . '.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $request->session()->regenerate();
            return redirect()->route($user->role . '.dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password. Please try again.'])->withInput();
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function showRegister() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'confirmed'],
            'batch' => ['nullable', 'string']
        ]);

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'student',
            'avatar' => 'dist/img/avatar.png',
            'title' => 'Student Apprentice',
            'batch' => $data['batch'] ?: 'Full Stack Batch'
        ]);

        return redirect()->route('login')->with('success', 'Registration submitted. Please log in.');
    }

    public function showForgot() {
        return view('auth.forgot-password');
    }
}
