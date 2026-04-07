<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class PetugasController extends Controller
{
    // 🔐 Proteksi akses
    public function __construct()
    {
        $this->middleware('auth');

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

    // ─── DASHBOARD ───────────────────────────────────────────
public function dashboard()
{
    $now = Carbon::now();

    // Stat cards
    $totalBuku       = \App\Models\Buku::count();
    $totalAnggota    = User::where('role', 'anggota')->count();
    $totalDipinjam   = Peminjaman::whereIn('status', ['dipinjam', 'terlambat'])->count();
    $totalDenda      = Peminjaman::sum('denda');

    // Sub-info kartu
    $bukuBaru        = \App\Models\Buku::whereMonth('created_at', $now->month)
                           ->whereYear('created_at', $now->year)->count();

    $anggotaBaru     = User::where('role', 'anggota')
                           ->whereMonth('created_at', $now->month)
                           ->whereYear('created_at', $now->year)->count();

    $totalTerlambat  = Peminjaman::where('status', 'terlambat')->count();

    $dendaBelumBayar = Peminjaman::where('denda', '>', 0)
                           ->where('status', '!=', 'dikembalikan')->count();

    $stokHabis       = \App\Models\Buku::where('stok', '<=', 1)->count();

    // Tabel peminjaman terbaru
    $peminjamanTerbaru = Peminjaman::with(['user', 'buku'])
                           ->latest()->take(6)->get();

    return view('petugas.dashboard', compact(
        'totalBuku', 'totalAnggota', 'totalDipinjam', 'totalDenda',
        'bukuBaru', 'anggotaBaru', 'totalTerlambat', 'dendaBelumBayar',
        'stokHabis', 'peminjamanTerbaru'
    ));
}

    // ─── DATA ANGGOTA ────────────────────────────────────────

    public function anggota(Request $request)
    {
        $query = User::where('role', 'anggota')
                    ->with(['peminjaman.buku']); // ← tambahkan ini

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $users = $query->latest()->paginate(10);

        return view('petugas.anggota', compact('users'));
    }

    // ─── MANAJEMEN PEMINJAMAN ────────────────────────────────
    public function peminjamanIndex(Request $request)
    {
        $activeTab = $request->get('tab', 'menunggu');
        $hariIni   = Carbon::today();

        // Auto-update status terlambat
        Peminjaman::where('status', 'dipinjam')
            ->where('tanggal_kembali', '<', $hariIni)
            ->update(['status' => 'terlambat']);

        $query = Peminjaman::with(['user', 'buku.kategori'])
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('user', fn($q) =>
                    $q->where('name', 'like', '%' . $request->search . '%')
                )->orWhereHas('buku', fn($q) =>
                    $q->where('judul', 'like', '%' . $request->search . '%')
                );
            })
            ->when($request->filled('tanggal'), function ($q) use ($request) {
                $q->whereDate('tanggal_pinjam', $request->tanggal);
            });

        // Filter per tab
        $peminjaman = (clone $query)
            ->where('status', $activeTab)
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->appends($request->query());

        // Hitung jumlah tiap tab untuk badge
        $jumlahMenunggu  = Peminjaman::where('status', 'menunggu')->count();
        $jumlahDipinjam  = Peminjaman::where('status', 'dipinjam')->count();
        $jumlahTerlambat = Peminjaman::where('status', 'terlambat')->count();
        $jumlahSelesai   = Peminjaman::where('status', 'dikembalikan')->count();

        return view('petugas.peminjaman', compact(
            'peminjaman',
            'activeTab',
            'jumlahMenunggu',
            'jumlahDipinjam',
            'jumlahTerlambat',
            'jumlahSelesai'
        ));
    }

    // ─── KONFIRMASI PEMINJAMAN (setujui pengajuan) ───────────
    public function konfirmasi($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        // Cek stok buku
        if ($pinjam->buku->stok < 1) {
            return back()->with('error', 'Stok buku tidak tersedia.');
        }

        $pinjam->update([
            'status'        => 'dipinjam',
            'tanggal_pinjam' => Carbon::today(),
        ]);

        // Kurangi stok buku
        $pinjam->buku->decrement('stok');

        return back()->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    // ─── TOLAK PEMINJAMAN ────────────────────────────────────
    public function tolak($id)
    {
        $pinjam = Peminjaman::findOrFail($id);

        if ($pinjam->status !== 'menunggu') {
            return back()->with('error', 'Peminjaman ini sudah diproses.');
        }

        $pinjam->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    // ─── KONFIRMASI PENGEMBALIAN ─────────────────────────────
    public function kembalikan($id)
    {
        $pinjam  = Peminjaman::findOrFail($id);
        $hariIni = Carbon::today();

        if (!in_array($pinjam->status, ['dipinjam', 'terlambat'])) {
            return back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        // Hitung denda jika terlambat
        $batas     = Carbon::parse($pinjam->tanggal_kembali);
        $terlambat = $hariIni->gt($batas) ? $hariIni->diffInDays($batas) : 0;
        $denda     = $terlambat * 1000;

        $pinjam->update([
            'status'               => 'dikembalikan',
            'tanggal_dikembalikan' => $hariIni,
            'denda'                => $denda,
        ]);

        // Tambah stok buku kembali
        $pinjam->buku->increment('stok');

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return back()->with('success', $pesan);
    }
}
