<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // =====================
    // 🔐 LOGIN
    // =====================

    // tampil halaman login
        public function showLogin()
        {
            if (Auth::check()) {
                return redirect('/'); // atau ke dashboard sesuai role
            }

            return view('auth.login');
        }

        // proses login
    public function login(Request $request)
    {
        // 🚫 Cegah login kalau masih ada user aktif
        if (Auth::check()) {
            return back()->with('error', 'Silakan logout dulu sebelum login akun lain');
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role == 'kepala') {
                return redirect()->route('kepala.dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } else {
                return redirect()->route('anggota.dashboard');
            }
        }

        return back()->with('error', 'Email atau password salah');
    }
    // =====================
    // 📝 REGISTER
    // =====================

    // tampil halaman register
    public function showRegister()
    {
        // Jika user sudah login, redirect ke dashboard sesuai role
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->role == 'kepala') {
                return redirect()->route('kepala.dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } else {
                return redirect()->route('anggota.dashboard');
            }
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota'
        ]);

        // Auto login setelah register
        Auth::login($user);

        return redirect()->route('anggota.dashboard');
    }

    // =====================
    // 🚪 LOGOUT
    // =====================

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
