<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    // 📚 BUKU SAYA (Anggota)
    public function index()
    {
        $userId = auth()->id();

        $peminjaman = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam', 'menunggu_kembali'])
            ->orderBy('created_at', 'desc')
            ->get();

        $hariIni = Carbon::now();

        $sedangDipinjam = $peminjaman->where('status', 'dipinjam')->count();

        $terlambat = $peminjaman->filter(function ($item) use ($hariIni) {
            return $item->status == 'dipinjam' &&
                   $hariIni->gt(Carbon::parse($item->batas_kembali)); // ✅ fix
        })->count();

        $totalDenda = $peminjaman->sum(function ($item) use ($hariIni) {
            if ($item->status != 'dipinjam') return 0;

            $batas = Carbon::parse($item->batas_kembali); // ✅ fix
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

    // 🔥 STORE PINJAM
    public function store(Request $request)
    {
        Peminjaman::create([
            'user_id'      => auth()->id(),
            'buku_id'      => $request->buku_id,
            'tanggal_pinjam' => null,
            'batas_kembali'  => now()->addDays(7), // ✅ fix (sesuai kolom DB)
            'status'         => 'menunggu',
        ]);

        return back()->with('success', 'Pengajuan peminjaman menunggu konfirmasi');
    }

    // 🔁 KEMBALIKAN (Anggota)
public function kembali($id)
{
    $peminjaman = Peminjaman::where('id', $id)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($peminjaman->status !== 'dipinjam') {
        return back()->with('error', 'Status tidak valid.');
    }

    $hariIni = Carbon::now();
    $batas   = Carbon::parse($peminjaman->batas_kembali);
    $terlambat = $hariIni->gt($batas) ? $hariIni->diffInDays($batas) : 0;

    $peminjaman->update([
        'status'             => 'menunggu_kembali',
        'tanggal_kembalikan' => $hariIni,
        'denda'              => $terlambat * 1000,
    ]);

    // ❌ HAPUS buku->increment('stok') dari sini

    return back()->with('success', 'Permintaan pengembalian terkirim, menunggu konfirmasi petugas.' .
        ($terlambat > 0 ? ' | Estimasi denda: Rp ' . number_format($terlambat * 1000, 0, ',', '.') : '')
    );
}

    // 📜 RIWAYAT
    public function riwayat(Request $request)
    {
        $userId = auth()->id();

        $query = Peminjaman::with('buku')
            ->where('user_id', $userId)
            ->whereIn('status', ['dipinjam', 'dikembalikan', 'ditolak']);

        if ($request->filled('status')) {
            if ($request->status === 'terlambat') {
                $query->where('status', 'dikembalikan')
                      ->whereColumn('tanggal_kembalikan', '>', 'batas_kembali'); // ✅ fix
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
            if (!$item->tanggal_kembalikan) return false;
            return Carbon::parse($item->tanggal_kembalikan)
                ->gt(Carbon::parse($item->batas_kembali)); // ✅ fix
        })->count();

        return view('anggota.riwayat', compact(
            'riwayat',
            'totalDendaDibayar',
            'pernahTerlambat'
        ));
    }

    // 👮 PETUGAS - INDEX
    public function indexPetugas(Request $request)
    {
        $activeTab = $request->get('tab', 'menunggu');
        $hariIni   = Carbon::now();

        $query = Peminjaman::with(['user', 'buku']);

        if ($activeTab === 'terlambat') {
            $query->where('status', 'dipinjam')
                  ->where('batas_kembali', '<', $hariIni); // ✅ fix
        } else {
            $query->where('status', $activeTab);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%$search%"))
                  ->orWhereHas('buku', fn($b) => $b->where('judul', 'like', "%$search%"));
            });
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_pinjam', $request->tanggal);
        }

        $peminjaman = $query->latest()->paginate(10);

        $jumlahMenunggu  = Peminjaman::where('status', 'menunggu')->count();
        $jumlahDipinjam  = Peminjaman::where('status', 'dipinjam')->count();
        $jumlahTerlambat = Peminjaman::where('status', 'dipinjam')
                                     ->where('batas_kembali', '<', $hariIni) // ✅ fix
                                     ->count();
        $jumlahKembali   = Peminjaman::where('status', 'menunggu_kembali')->count();
        $jumlahSelesai   = Peminjaman::where('status', 'dikembalikan')->count();

        return view('petugas.peminjaman', compact(
            'peminjaman',
            'activeTab',
            'jumlahMenunggu',
            'jumlahDipinjam',
            'jumlahTerlambat',
            'jumlahKembali',
            'jumlahSelesai'
        ));
    }

    // ✅ KONFIRMASI PINJAM (Petugas)
    public function konfirmasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Status tidak valid');
        }

        $peminjaman->update([
            'status'         => 'dipinjam',
            'tanggal_pinjam' => Carbon::now(),
            'batas_kembali'  => Carbon::now()->addDays(7), // ✅ set saat dikonfirmasi
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

    // 🔁 TERIMA KEMBALI (Petugas)
public function konfirmasiPengembalian($id)
{
    $peminjaman = Peminjaman::findOrFail($id);

    // ✅ Cek status menunggu_kembali, bukan dipinjam
    if ($peminjaman->status !== 'menunggu_kembali') {
        return back()->with('error', 'Status tidak valid.');
    }

    $peminjaman->update([
        'status' => 'dikembalikan',
    ]);

    // ✅ Stok bertambah di sini, saat petugas konfirmasi
    if ($peminjaman->buku) {
        $peminjaman->buku->increment('stok');
    }

    return back()->with('success', 'Pengembalian dikonfirmasi.' .
        ($peminjaman->denda > 0 ? ' | Denda: Rp ' . number_format($peminjaman->denda, 0, ',', '.') : '')
    );
}
}
