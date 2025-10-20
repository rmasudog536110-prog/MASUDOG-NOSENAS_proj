<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
 

class UserController extends Controller
{
    
    public function showRegister() {
        return view('auth.register');
    }
 
 
    public function register(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone_number' => 'required|max:10|unique:users',
            'password' => 'required|min:6|confirmed'
            
        ]);
 
 
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            
        ]);
 
 
        return redirect('/login')->with('success', 'Registered successfully. Please login.');
    }
 
 
    public function showLogin() {
        return view('auth.login');
    }
 
 
    public function login(Request $request) {
    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return view('index.dashboard'); 
    }

    return back()->withErrors([
        'email' => 'Invalid credentials.',
    ]);
}

 
 
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('auth.login');
    }

}
