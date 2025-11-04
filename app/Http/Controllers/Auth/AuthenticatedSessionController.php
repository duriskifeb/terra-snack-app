<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function store(Request $request)
{
    $credentials = $request->validate([
        'name' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard')->with('success', 'Login berhasil!');
    }

    // Kalau username atau password salah
    return back()->with('error', 'Username atau password salah!')->withInput();
}

public function destroy(Request $request)
{
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'Logout berhasil!');
}
}
