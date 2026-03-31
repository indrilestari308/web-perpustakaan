<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    // DASHBOARD
    public function dashboard()
    {
        return view('anggota.dashboard');
    }

    // HALAMAN DAFTAR BUKU
    public function buku()
    {
        $buku = Buku::with('kategori')->latest()->get();
        return view('anggota.buku', compact('buku'));
    }

    // DETAIL BUKU
    public function detail($id)
    {
        $buku = Buku::with('kategori')->findOrFail($id);
        return view('anggota.detail', compact('buku'));
    }

    // DATA PEMINJAMAN USER
    public function peminjaman()
    {
        $data = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('anggota.peminjaman', compact('data'));
    }

    // PROFIL
    public function profil()
    {
        return view('anggota.profil');
    }

    // PINJAM BUKU 🔥 (FIX ERROR user_id NULL)
    public function pinjam($id)
    {
        // 🔥 CEK LOGIN
        if (!Auth::check()) {
            return redirect('/login')->with('error', 'Silakan login dulu!');
        }

        $buku = Buku::findOrFail($id);

        // 🔥 CEK STOK
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // 🔥 SIMPAN PEMINJAMAN
        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam'
        ]);

        // 🔥 KURANGI STOK
        $buku->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    // KEMBALIKAN BUKU 🔥
    public function kembali($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        // tambah stok lagi
        $pinjam->buku->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
