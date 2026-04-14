<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnggotaController extends Controller
{
    // Middleware auth di constructor
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
        $userId = auth()->id();

        $semuaPinjaman = \App\Models\Peminjaman::where('user_id', $userId)->get();

        $totalPinjaman  = $semuaPinjaman->count();
        $sedangDipinjam = $semuaPinjaman->where('status', 'dipinjam')->count();
        $sudahKembali   = $semuaPinjaman->where('status', 'dikembalikan')->count();
        $totalDenda = $semuaPinjaman->sum(function ($item) {
            // Buku sudah selesai → pakai denda dari DB
            if ($item->status === 'dikembalikan') {
                return $item->denda;
            }

            // Buku masih dipinjam/terlambat → hitung realtime
            if (in_array($item->status, ['dipinjam', 'menunggu_kembali'])) {
                $batas = \Carbon\Carbon::parse($item->batas_kembali)->startOfDay();
                $hari  = \Carbon\Carbon::today()->gt($batas)
                    ? (int) $batas->diffInDays(\Carbon\Carbon::today())
                    : 0;
                return $hari * 1000;
            }

            return 0;
        });

        $peminjamanAktif = \App\Models\Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->whereIn('status', ['dipinjam', 'menunggu_kembali'])
            ->orderBy('tanggal_pinjam', 'desc')
            ->get();

        $riwayatTerakhir = \App\Models\Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->where('status', 'dikembalikan')
            ->latest()
            ->limit(3)
            ->get();

        return view('anggota.dashboard', compact(
            'totalPinjaman',
            'sedangDipinjam',
            'sudahKembali',
            'totalDenda',
            'peminjamanAktif',
            'riwayatTerakhir'
        ));
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
            ->whereIn('status', ['dipinjam', 'terlambat', 'menunggu_kembali'])
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
    $tab  = $request->input('tab', 'profil');

    if ($tab === 'profil') {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'foto'  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('foto')) {
            if ($user->foto) Storage::disk('public')->delete($user->foto);
            $user->foto = $request->file('foto')->store('foto-profil', 'public');
        }

        $user->save();
        return redirect()->route('anggota.profil')->with('success', 'Profil berhasil diperbarui!')->with('tab', 'profil');

    } elseif ($tab === 'keamanan') {
        $request->validate([
            'password_lama' => 'required',
            'password'      => 'required|string|min:6|confirmed',
        ], [
            'password_lama.required' => 'Password lama wajib diisi.',
            'password.required'      => 'Password baru wajib diisi.',
            'password.min'           => 'Password minimal 6 karakter.',
            'password.confirmed'     => 'Konfirmasi password tidak cocok.',
        ]);

        if (!\Hash::check($request->password_lama, $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.'])
                         ->withInput()->with('tab', 'keamanan');
        }

        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('anggota.profil')->with('success', 'Password berhasil diperbarui!')->with('tab', 'keamanan');
    }

    return redirect()->back();
}


    // PINJAM BUKU
public function pinjam($id)
{
    $buku = Buku::findOrFail($id);

    if ($buku->stok <= 0) {
        return back()->with('error', 'Stok buku habis!');
    }

    // CEK: biar user tidak spam pinjam buku yang sama
    $sudahPinjam = Peminjaman::where('user_id', Auth::id())
        ->where('buku_id', $id)
        ->whereIn('status', ['menunggu', 'dipinjam'])
        ->exists();

    if ($sudahPinjam) {
        return back()->with('error', 'Kamu sudah mengajukan atau sedang meminjam buku ini.');
    }




    //SIMPAN SEBAGAI MENUNGGU
    Peminjaman::create([
        'user_id'        => Auth::id(),
        'buku_id'        => $id,
        'tanggal_pinjam' => null, // ← null dulu
        'batas_kembali'  => null,
        'status'         => 'menunggu'
    ]);



    return back()->with('success', 'Permintaan peminjaman dikirim, tunggu konfirmasi petugas.');
}

        // KEMBALIKAN BUKU
    public function kembali($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status !== 'dipinjam') {
            return back()->with('error', 'Status tidak valid.');
        }

        $pinjam->update([
            'status' => 'menunggu_kembali'
        ]);

        return back()->with('success', 'Menunggu konfirmasi petugas.');
    }
}
