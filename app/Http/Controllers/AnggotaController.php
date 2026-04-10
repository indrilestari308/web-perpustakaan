<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
        $userId = auth()->id();

        $semuaPinjaman = \App\Models\Peminjaman::where('user_id', $userId)->get();

        $totalPinjaman  = $semuaPinjaman->count();
        $sedangDipinjam = $semuaPinjaman->where('status', 'dipinjam')->count();
        $sudahKembali   = $semuaPinjaman->where('status', 'dikembalikan')->count();
        $totalDenda     = $semuaPinjaman->sum('denda');

        $peminjaman = \App\Models\Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_kembali'])
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
            'peminjaman', // 🔥 HARUS INI
            'riwayatTerakhir'
        ));return view('anggota.dashboard', compact(
            'totalPinjaman',
            'sedangDipinjam',
            'sudahKembali',
            'totalDenda',
            'peminjaman', // 🔥 HARUS INI
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
        ], [
            'name.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah digunakan akun lain.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('foto-profil', 'public');
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');

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
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.'])->withInput();
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
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
        'user_id' => Auth::id(),
        'buku_id' => $id,
        'tanggal_pinjam' => now(),
        'status' => 'menunggu'
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
