<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login
     */
    public function create()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        // Coba login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect berdasarkan role
            $role = Auth::user()->role;

            if ($role === 'admin') {
                return redirect('/admin')->with('success', 'Selamat datang, Admin!');
            }

            if ($role === 'stand_staff') {
                return redirect('/stand')->with('success', 'Selamat datang, Stand Staff!');
            }

            // Default: customer
            return redirect()->intended('/products')->with('success', 'Login berhasil! Selamat datang kembali');
        }

        // Jika gagal login → kirim pesan error ke SweetAlert
        return back()->with('error', 'Masukkan Username dan Password anda dengan benar!');
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout!');
    }
}
