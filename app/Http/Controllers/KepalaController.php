<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;

class KepalaController extends Controller
{
    // 🔐 Proteksi akses
    public function __construct()
    {
        // Semua method hanya untuk user login
        $this->middleware('auth');

        // Opsional: batasi hanya role kepala
        $this->middleware(function ($request, $next) {
            if (Auth::user()->role != 'kepala') {
                // Kalau bukan kepala, redirect ke dashboard sesuai role
                $role = Auth::user()->role;
                if ($role == 'petugas') {
                    return redirect()->route('petugas.dashboard');
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
        $totalAnggota = User::where('role', 'anggota')->count();
        $bukuDipinjam = Peminjaman::where('status', 'dipinjam')->count();
        $pengembalian = Peminjaman::where('status', 'dikembalikan')->count();
        $totalDenda = Peminjaman::sum('denda');

        $aktivitas = Peminjaman::with(['user', 'buku'])
                        ->latest()
                        ->take(5)
                        ->get();

        return view('kepala.dashboard', compact(
            'totalAnggota',
            'bukuDipinjam',
            'pengembalian',
            'totalDenda',
            'aktivitas'
        ));
    }

    // LAPORAN
    public function laporan(Request $request)
    {
        // Buat base query sekali, dipakai untuk semua keperluan
        $query = Peminjaman::with(['user', 'buku'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_pinjam', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_pinjam', '<=', $request->sampai))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->nama,   fn($q) => $q->whereHas('user', fn($q2) =>
                $q2->where('nama', 'like', '%'.$request->nama.'%')
            ));

        // Hitung summary SEBELUM paginate (clone query biar tidak saling ganggu)
        $total          = (clone $query)->count();
        $totalKembali   = (clone $query)->where('status', 'dikembalikan')->count();
        $totalTerlambat = (clone $query)->where('status', 'terlambat')->count();
        $totalDenda     = (clone $query)->sum('denda');

        // Paginate terakhir
        $laporan = $query->latest()->paginate(15);

        return view('kepala.laporan', compact(
            'laporan', 'total', 'totalKembali', 'totalTerlambat', 'totalDenda'
        ));
    }

    public function laporanCetak(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_pinjam', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_pinjam', '<=', $request->sampai))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->nama,   fn($q) => $q->whereHas('user', fn($q2) =>
                $q2->where('nama', 'like', '%'.$request->nama.'%')
            ));

        $laporan        = (clone $query)->latest()->get();
        $total          = $laporan->count();
        $totalKembali   = $laporan->where('status', 'dikembalikan')->count();
        $totalTerlambat = $laporan->where('status', 'terlambat')->count();
        $totalDenda     = $laporan->sum('denda');

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('kepala.laporan_cetak', compact(
            'laporan', 'total', 'totalKembali', 'totalTerlambat', 'totalDenda'
        ));

        return $pdf->download('laporan-peminjaman.pdf');
    }

    public function laporanExport(Request $request)
    {
        $laporan = Peminjaman::with(['user', 'buku'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_pinjam', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_pinjam', '<=', $request->sampai))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->nama,   fn($q) => $q->whereHas('user', fn($q2) =>
                $q2->where('nama', 'like', '%'.$request->nama.'%')
            ))
            ->latest()->get();

        $filename = 'laporan-peminjaman-' . now()->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function () use ($laporan) {
            $file = fopen('php://output', 'w');

            // Header kolom
            fputcsv($file, [
                'No', 'Nama Anggota', 'Buku Dipinjam',
                'Tgl Pinjam', 'Jatuh Tempo', 'Tgl Kembali',
                'Status', 'Denda'
            ]);

            foreach ($laporan as $i => $row) {
                fputcsv($file, [
                    $i + 1,
                    $row->user->nama,
                    $row->buku->judul,
                    \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d/m/Y'),
                    \Carbon\Carbon::parse($row->batas_kembalikan)->format('d/m/Y'),
                    $row->tanggal_kembali
                        ? \Carbon\Carbon::parse($row->tanggal_kembalikan)->format('d/m/Y')
                        : '-',
                    ucfirst($row->status),
                    $row->denda,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    // HALAMAN PETUGAS
// 📋 TAMPILKAN DATA PETUGAS
public function petugasIndex()
{
    $petugas = User::where('role', 'petugas')
    ->orderBy('created_at', 'desc')
    ->paginate(10);
    return view('kepala.petugas.index', compact('petugas'));
}

// ➕ FORM CREATE PETUGAS
public function petugasCreate()
{
    return view('kepala.petugas.create');
}



// 💾 SIMPAN PETUGAS
public function petugasStore(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        'role' => 'petugas'
    ]);

    return redirect()->route('kepala.petugas.index')
        ->with('success', 'Petugas berhasil ditambahkan');
}

public function editPetugas($id)
{
    $petugas = User::findOrFail($id);
    return view('kepala.petugas.edit', compact('petugas'));
}

public function updatePetugas(Request $request, $id)
{
    $petugas = User::findOrFail($id);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'nullable|min:6|confirmed',
    ]);

        $data = [
        'name' => $request->name,
        'email' => $request->email,
    ];

        if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    }
    $petugas->update($data);

    return redirect()->route('kepala.petugas.index')
        ->with('success', 'Data petugas berhasil diupdate');
}


// 🗑️ HAPUS PETUGAS
public function petugasDestroy($id)
{
    $petugas = User::findOrFail($id);

    if ($petugas->role !== 'petugas') {
        return back()->with('error', 'Data bukan petugas!');
    }

    $petugas->delete();

    return redirect()->back()
        ->with('success', 'Petugas berhasil dihapus');
}

    // DATA BUKU
    public function buku()
    {
        $buku = Buku::with('kategori')->get(); // ✅ tambah with('kategori')
        return view('kepala.buku', compact('buku'));
    }
}
