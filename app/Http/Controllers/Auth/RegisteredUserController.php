<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        // 1. Validasi dengan Aturan yang Lebih Ketat
        $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:50', 'alpha_dash', 'unique:users'],
            'phone' => [
                'required', 
                'string', 
                'min:9', 
                'max:15', 
                'unique:users', 
                'regex:/^(\+62|08)[0-9]{8,13}$/' 
            ],
            'password' => [
                'required', 
                'confirmed', 
                Rules\Password::min(8)->mixedCase()->numbers()->symbols()
            ],
        ], 
        [
            'name.required' => 'Nama pengguna (username) wajib diisi.',
            'name.min' => 'Nama pengguna harus memiliki minimal 3 karakter.',
            'name.max' => 'Nama pengguna tidak boleh lebih dari 50 karakter.',
            'name.alpha_dash' => 'Nama pengguna hanya boleh mengandung huruf, angka, garis bawah, dan tanda hubung.',
            'name.unique' => 'Nama pengguna ini sudah terdaftar. Mohon gunakan nama lain.',

            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.unique' => 'Nomor telepon ini sudah terdaftar.',
            'phone.min' => 'Nomor telepon minimal 9 digit.',
            'phone.max' => 'Nomor telepon maksimal 15 digit.',
            'phone.regex' => 'Format nomor telepon tidak valid. Gunakan format 08xx atau +62xx.',

            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok dengan password yang dimasukkan.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.mixed_case' => 'Password harus mengandung huruf besar dan huruf kecil.',
            'password.numbers' => 'Password harus mengandung setidaknya satu angka.',
            'password.symbols' => 'Password harus mengandung setidaknya satu simbol.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        // Setelah berhasil, arahkan ke login dengan pesan sukses
        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }
}