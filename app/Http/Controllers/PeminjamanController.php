<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // BUKU SAYA - Peminjaman aktif
    public function index()
    {
        $userId = auth()->id();

        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        $hariIni = Carbon::today();

        $sedangDipinjam = $peminjaman->count();

        $terlambat = $peminjaman->filter(function ($item) use ($hariIni) {
            return $hariIni->gt(Carbon::parse($item->tanggal_kembali));
        })->count();

        $totalDenda = $peminjaman->sum(function ($item) use ($hariIni) {
            $batas = Carbon::parse($item->tanggal_kembali);
            $hari  = $hariIni->gt($batas) ? $hariIni->diffInDays($batas) : 0;
            return $hari * 1000;
        });

        return view('anggota.peminjaman', compact(
            'peminjaman',
            'sedangDipinjam',
            'terlambat',
            'totalDenda'
        ));
    }

    // KEMBALIKAN BUKU
    public function kembali($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Buku ini sudah dikembalikan.');
        }

        $hariIni   = Carbon::today();
        $batas     = Carbon::parse($peminjaman->tanggal_kembali);
        $terlambat = $hariIni->gt($batas) ? $hariIni->diffInDays($batas) : 0;
        $denda     = $terlambat * 1000;

        $peminjaman->update([
            'status'               => 'dikembalikan',
            'tanggal_dikembalikan' => $hariIni,
            'denda'                => $denda,
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        $pesan = 'Buku berhasil dikembalikan.';
        if ($denda > 0) {
            $pesan .= ' Denda: Rp ' . number_format($denda, 0, ',', '.');
        }

        return redirect()->back()->with('success', $pesan);
    }

    // RIWAYAT PEMINJAMAN
    public function riwayat(Request $request)
    {
        $userId = auth()->id();

        $query = Peminjaman::with('buku')->where('user_id', $userId);

        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->where('status', 'dikembalikan')
                      ->whereColumn('tanggal_dikembalikan', '>', 'tanggal_kembali');
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->filled('cari')) {
            $query->whereHas('buku', function ($q) use ($request) {
                $q->where('judul', 'like', '%' . $request->cari . '%');
            });
        }

        $riwayat = $query->orderBy('created_at', 'desc')->paginate(10);

        $semuaRiwayat      = Peminjaman::where('user_id', $userId)->get();
        $totalDendaDibayar = $semuaRiwayat->sum('denda');

        $pernahTerlambat = $semuaRiwayat->filter(function ($item) {
            if (!$item->tanggal_dikembalikan) return false;
            return Carbon::parse($item->tanggal_dikembalikan)
                         ->gt(Carbon::parse($item->tanggal_kembali));
        })->count();

        return view('anggota.riwayat', compact(
            'riwayat',
            'totalDendaDibayar',
            'pernahTerlambat'
        ));
    }


    // ─── PETUGAS ────────────────────────────────────────────

    public function indexPetugas(Request $request)
    {
        $activeTab = $request->get('tab', 'menunggu');
        $hariIni   = Carbon::today();

        $query = Peminjaman::with(['user', 'buku.kategori']);

        // Filter tab
        if ($activeTab === 'terlambat') {
            $query->where('status', 'dipinjam')
                  ->where('tanggal_kembali', '<', $hariIni);
        } else {
            $query->where('status', $activeTab);
        }

        // Filter search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%$search%"));
            });
        }

        // Filter tanggal
        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }

        $peminjaman = $query->orderBy('created_at', 'desc')->paginate(10);

        // Hitung jumlah tiap tab
        $jumlahMenunggu  = Peminjaman::where('status', 'menunggu')->count();
        $jumlahDipinjam  = Peminjaman::where('status', 'dipinjam')
                               ->where('tanggal_kembali', '>=', $hariIni)->count();
        $jumlahTerlambat = Peminjaman::where('status', 'dipinjam')
                               ->where('tanggal_kembali', '<', $hariIni)->count();
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

    public function konfirmasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'status'        => 'dipinjam',
            'tanggal_pinjam' => Carbon::today(),
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update(['status' => 'ditolak']);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $hariIni    = Carbon::today();
        $batas      = Carbon::parse($peminjaman->tanggal_kembali);
        $terlambat  = $hariIni->gt($batas) ? $hariIni->diffInDays($batas) : 0;
        $denda      = $terlambat * 1000;

        $peminjaman->update([
            'status'               => 'dikembalikan',
            'tanggal_dikembalikan' => $hariIni,
            'denda'                => $denda,
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return redirect()->back()->with('success', 'Buku berhasil dikembalikan.' .
            ($denda > 0 ? ' Denda: Rp ' . number_format($denda, 0, ',', '.') : ''));
    }


}
