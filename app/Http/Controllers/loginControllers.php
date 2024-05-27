<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class loginControllers extends Controller
{
    public function loginPage(Request $request){
        return view("login");
    }

    public function loginProses(Request $request){
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // // Jika pengguna berhasil login
            return redirect()->intended('/home')->with('success', 'Selamat datang! Anda telah berhasil login.');
        }

        // Jika pengguna gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

}
