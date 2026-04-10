<?php

namespace App\Http\Controllers\Kepala;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LaporanController extends Controller
{
    // ─── Helper: base query dengan filter ────────────────────

    private function baseQuery(Request $request)
    {
        return Peminjaman::with(['user', 'buku'])
            ->when($request->dari,   fn($q) => $q->whereDate('tanggal_pinjam', '>=', $request->dari))
            ->when($request->sampai, fn($q) => $q->whereDate('tanggal_pinjam', '<=', $request->sampai))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->nama,   fn($q) => $q->whereHas('user',
                fn($u) => $u->where('name', 'like', "%{$request->nama}%")
            ))
            ->latest('tanggal_pinjam');
    }

    // ─── Halaman laporan (dengan pagination) ─────────────────

    public function index(Request $request)
    {
        $laporan = $this->baseQuery($request)->paginate(20);

        // Summary stats (tanpa pagination, pakai clone query)
        $allData       = $this->baseQuery($request)->get();
        $total         = $allData->count();
        $totalKembali  = $allData->where('status', 'dikembalikan')->count();
        $totalTerlambat = $allData->filter(fn($p) => $p->denda > 0)->count();
        $totalDenda    = $allData->sum('denda');

        return view('kepala.laporan.index', compact(
            'laporan', 'total', 'totalKembali', 'totalTerlambat', 'totalDenda'
        ));
    }

    // ─── Cetak PDF (tanpa pagination, semua data) ─────────────

    public function cetak(Request $request)
    {
        $laporan       = $this->baseQuery($request)->get();
        $total         = $laporan->count();
        $totalKembali  = $laporan->where('status', 'dikembalikan')->count();
        $totalTerlambat = $laporan->filter(fn($p) => $p->denda > 0)->count();
        $totalDenda    = $laporan->sum('denda');

        return view('kepala.laporan.cetak', compact(
            'laporan', 'total', 'totalKembali', 'totalTerlambat', 'totalDenda'
        ));
    }

    // ─── Export Excel (CSV sederhana) ─────────────────────────

    public function export(Request $request)
    {
        $laporan = $this->baseQuery($request)->get();

        $filename = 'laporan-peminjaman-' . now()->format('Ymd-His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($laporan) {
            $handle = fopen('php://output', 'w');

            // BOM agar Excel terbaca UTF-8
            fputs($handle, "\xEF\xBB\xBF");

            // Header kolom
            fputcsv($handle, [
                'No', 'Nama Anggota', 'Email', 'Buku Dipinjam',
                'Tgl Pinjam', 'Jatuh Tempo', 'Tgl Kembali', 'Status', 'Denda'
            ]);

            foreach ($laporan as $i => $row) {
                fputcsv($handle, [
                    $i + 1,
                    $row->user->name ?? '-',
                    $row->user->email ?? '-',
                    $row->buku->judul ?? '-',
                    $row->tanggal_pinjam     ? Carbon::parse($row->tanggal_pinjam)->format('d/m/Y')     : '-',
                    $row->batas_kembali      ? Carbon::parse($row->batas_kembali)->format('d/m/Y')      : '-',
                    $row->tanggal_kembalikan ? Carbon::parse($row->tanggal_kembalikan)->format('d/m/Y') : '-',
                    ucfirst($row->status),
                    $row->denda,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
