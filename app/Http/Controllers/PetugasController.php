<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;

class PetugasController extends Controller
{
    public function dashboard()
    {
        return view('petugas.dashboard');
    }

    public function anggota()
    {
        $users = User::all();
        return view('petugas.anggota', compact('users'));
    }

    public function denda()
    {
        $peminjaman = Peminjaman::with('buku', 'user')->get();
        return view('petugas.denda', compact('peminjaman'));
    }

    public function konfirmasi($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        $pinjam->update([
            'status' => 'dikembalikan',
            'tanggal_kembali' => now()
        ]);

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
