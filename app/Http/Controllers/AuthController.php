<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Layar "Selamat Datang": pilih Admin atau Pengguna
    public function pilihPeran()
    {
        if (Auth::check()) {
            return redirect()->route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'user.beranda');
        }

        return view('auth.pilih');
    }

    public function formLogin(string $role)
    {
        return view('auth.login', compact('role'));
    }

    // Login memakai email ATAU nomor HP, dan harus cocok dengan peran yang dipilih
    public function login(Request $request, string $role)
    {
        $data = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = User::where('role', $role)
            ->where(fn ($q) => $q->where('email', $data['identifier'])->orWhere('phone', $data['identifier']))
            ->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()->withErrors(['identifier' => 'Email/nomor HP atau kata sandi salah.'])->onlyInput('identifier');
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route($role === 'admin' ? 'admin.dashboard' : 'user.beranda');
    }

    public function formDaftar()
    {
        return view('auth.register');
    }

    // Daftar sebagai Pengguna (role selalu "user", tidak diambil dari input form)
    public function daftar(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'phone' => 'required|string|max:20|unique:users,phone',
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'birth_date' => 'required|date|before:today',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create($data + ['role' => 'user']);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('user.beranda')->with('success', 'Akun berhasil dibuat. Selamat datang!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
