<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
         
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
      

        

        if (Auth::attempt($credentials)) {
            return redirect()->route('beranda')->with('sukses','Berhasil login!');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('suskses','Anda berhasil logout');
    }
}
