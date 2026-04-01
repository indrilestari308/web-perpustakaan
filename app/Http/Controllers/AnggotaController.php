<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class AnggotaController extends Controller
{
    // 🔐 Middleware auth di constructor
    public function __construct()
    {
        // Semua method hanya untuk user login
        $this->middleware('auth');

        // Opsional: jika ingin batasi hanya role anggota
        // $this->middleware('role:anggota'); // nanti buat middleware role
    }

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

    public function updateProfil(Request $request)
    {
        $user = auth()->user();

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    // PINJAM BUKU
    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        Peminjaman::create([
            'user_id' => Auth::id(),
            'buku_id' => $id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam'
        ]);

        $buku->decrement('stok');

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    // KEMBALIKAN BUKU
    public function kembali($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        $pinjam->buku->increment('stok');

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
