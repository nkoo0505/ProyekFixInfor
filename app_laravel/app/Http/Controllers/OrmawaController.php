<?php

// app/Http/Controllers/OrmawaAuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrmawaController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (Auth::guard('ormawa')->attempt($credentials)) {
            return redirect()->route('ormawa.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    public function logout()
    {
        Auth::guard('ormawa')->logout();
        return redirect()->route('ormawa.login');
    }
}
