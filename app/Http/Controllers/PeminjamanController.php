<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;


class PeminjamanController extends Controller
{
    // 📚 BUKU SAYA
    public function index()
    {
        $userId = auth()->id();

        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam']) // ✅ FIX
            ->orderBy('created_at', 'desc') // 🔥 lebih relevan dari tanggal_kembali
            ->get();

        $hariIni = Carbon::today();

        // 🔥 hitung hanya yang benar-benar dipinjam
        $sedangDipinjam = $peminjaman->where('status', 'dipinjam')->count();

        $terlambat = $peminjaman->filter(function ($item) use ($hariIni) {
            return $item->status == 'dipinjam' &&
                   $hariIni->gt(Carbon::parse($item->tanggal_kembali));
        })->count();

        $totalDenda = $peminjaman->sum(function ($item) use ($hariIni) {
            if ($item->status != 'dipinjam') return 0;

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

    // 🔥 TAMBAHAN WAJIB (STORE PINJAM)
    public function store(Request $request)
    {
        Peminjaman::create([
            'user_id' => auth()->id(),
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => null, // belum aktif
            'tanggal_kembali' => now()->addDays(7),
            'status' => 'menunggu' // 🔥 KUNCI UTAMA
        ]);

        return back()->with('success', 'Pengajuan peminjaman menunggu konfirmasi');
    }

    // 🔁 KEMBALIKAN (ANGGOTA)
    public function kembali($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Status tidak valid.');
        }

        $hariIni   = Carbon::today();
        $batas     = Carbon::parse($peminjaman->tanggal_kembali);
        $terlambat = $hariIni->gt($batas) ? $hariIni->diffInDays($batas) : 0;
        $denda     = $terlambat * 1000;

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $hariIni,
            'denda' => $denda,
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return back()->with('success', 'Buku dikembalikan' .
            ($denda > 0 ? ' | Denda: Rp ' . number_format($denda, 0, ',', '.') : '')
        );
    }

    // 📜 RIWAYAT
    public function riwayat(Request $request)
    {
        $userId = auth()->id();

        $query = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->whereIn('status', ['dipinjam', 'dikembalikan', 'ditolak']); // ✅ FIX

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

        $semua = Peminjaman::where('user_id', $userId)->get();

        $totalDendaDibayar = $semua->sum('denda');

        $pernahTerlambat = $semua->filter(function ($item) {
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

    // 👮 PETUGAS


public function indexPetugas(Request $request)
{
    $activeTab = $request->get('tab', 'menunggu');
    $hariIni   = Carbon::today();

    $query = Peminjaman::with(['user', 'buku']);

    // FILTER TAB
    if ($activeTab === 'terlambat') {
        $query->where('status', 'dipinjam')
              ->where('tanggal_kembali', '<', $hariIni);
    } else {
        $query->where('status', $activeTab);
    }

    // SEARCH
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function ($q) use ($search) {
            $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
              ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%$search%"));
        });
    }

    // FILTER TANGGAL
    if ($request->filled('tanggal')) {
        $query->whereDate('tanggal_pinjam', $request->tanggal);
    }

    $peminjaman = $query->latest()->paginate(10);

    // 🔥 TAMBAHAN WAJIB (BIAR GAK ERROR)
    $jumlahMenunggu  = Peminjaman::where('status', 'menunggu')->count();
    $jumlahDipinjam  = Peminjaman::where('status', 'dipinjam')->count();
    $jumlahTerlambat = Peminjaman::where('status', 'dipinjam')
                                ->where('tanggal_kembali', '<', $hariIni)
                                ->count();
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

    // ✅ KONFIRMASI
    public function konfirmasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        // 🔥 pastikan hanya dari menunggu
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Status tidak valid');
        }

        $peminjaman->update([
            'status' => 'dipinjam',
            'tanggal_pinjam' => Carbon::today(),
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->decrement('stok');
        }

        return back()->with('success', 'Peminjaman dikonfirmasi');
    }

    // ❌ TOLAK
    public function tolak($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Tidak bisa ditolak');
        }

        $peminjaman->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman ditolak');
    }

    // 🔁 KEMBALIKAN (PETUGAS)
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'dipinjam') {
            return back()->with('error', 'Status tidak valid');
        }

        $hariIni = Carbon::today();
        $batas   = Carbon::parse($peminjaman->tanggal_kembali);

        $terlambat = $hariIni->gt($batas)
            ? $hariIni->diffInDays($batas)
            : 0;

        $denda = $terlambat * 1000;

        $peminjaman->update([
            'status' => 'dikembalikan',
            'tanggal_dikembalikan' => $hariIni,
            'denda' => $denda,
        ]);

        if ($peminjaman->buku) {
            $peminjaman->buku->increment('stok');
        }

        return back()->with('success', 'Buku dikembalikan' .
            ($denda ? ' | Denda: Rp ' . number_format($denda, 0, ',', '.') : '')
        );
    }
}