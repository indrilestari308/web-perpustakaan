<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // ================= LOGIN =================
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // bisa login pakai email atau username
        $login = $request->input('email'); // field dari form

        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if (Auth::attempt([$field => $login, 'password' => $request->password])) {

            $user = Auth::user();

            // redirect berdasarkan role
            if ($user->role == 'anggota') {
                return redirect('/anggota/dashboard');
            } elseif ($user->role == 'petugas') {
                return redirect('/petugas/dashboard');
            } elseif ($user->role == 'kepala') {
                return redirect('/kepala/dashboard');
            }
        }

        return back()->with('error', 'Email/Username atau password salah!');
    }

    // ================= REGISTER =================
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // validasi
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5'
        ]);

        // simpan user
        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota' // default
        ]);

        return redirect('/login')->with('success', 'Berhasil daftar!');
    }

    // ================= LOGOUT =================
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
