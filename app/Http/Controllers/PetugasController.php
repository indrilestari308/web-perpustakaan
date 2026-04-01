<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // 🔐 Proteksi akses
    public function __construct()
    {
        // Semua method hanya untuk user login
        $this->middleware('auth');

        // Batasi hanya role petugas
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role != 'petugas') {
                $role = Auth::user()->role;
                if ($role == 'kepala') {
                    return redirect()->route('kepala.dashboard');
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
        return view('petugas.dashboard');
    }

    // HALAMAN ANGGOTA
    public function anggota()
    {
        $users = User::where('role', 'anggota')->get(); // hanya anggota
        return view('petugas.anggota', compact('users'));
    }

    // HALAMAN DENDA
    public function denda()
    {
        $peminjaman = Peminjaman::with('buku', 'user')->get();
        return view('petugas.denda', compact('peminjaman'));
    }

    // KONFIRMASI PENGEMBALIAN
    public function konfirmasi($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status != 'dipinjam') {
            return back()->with('error', 'Buku sudah dikembalikan!');
        }

        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        // tambah stok buku kembali
        $pinjam->buku->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
