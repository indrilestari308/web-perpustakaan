<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class KepalaController extends Controller
{
    // 🔐 Proteksi akses
    public function __construct()
    {
        // Semua method hanya untuk user login
        $this->middleware('auth');

        // Opsional: batasi hanya role kepala
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role != 'kepala') {
                // Kalau bukan kepala, redirect ke dashboard sesuai role
                $role = Auth::user()->role;
                if ($role == 'petugas') {
                    return redirect()->route('petugas.dashboard');
                } elseif ($role == 'anggota') {
                    return redirect()->route('anggota.dashboard');
                }
            }
            return $next($request);
        });
    }

    // DASHBOARD
    public function dashboard()
    {
        $totalAnggota = User::where('role', 'anggota')->count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $pengembalian = Peminjaman::where('status', 'dikembalikan')->count();
        $totalDenda = Peminjaman::sum('denda');

        $aktivitas = Peminjaman::with(['user', 'buku'])
                        ->latest()
                        ->take(5)
                        ->get();

        return view('kepala.dashboard', compact(
            'totalAnggota',
            'bukuDipinjam',
            'pengembalian',
            'totalDenda',
            'aktivitas'
        ));
    }

    // LAPORAN
    public function laporan()
    {
        $data = Peminjaman::with(['user', 'buku'])->get();
        return view('kepala.laporan', compact('data'));
    }

    // HALAMAN PETUGAS
    public function petugas()
    {
        $petugas = User::where('role', 'petugas')->get();
        return view('kepala.petugas', compact('petugas'));
    }

    // SIMPAN PETUGAS
    public function storePetugas(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'petugas'
        ]);

        return redirect()->back()->with('success', 'Petugas berhasil ditambahkan');
    }

    // DATA BUKU
    public function buku()
    {
        $buku = Buku::all();
        return view('kepala.buku', compact('buku'));
    }
}
