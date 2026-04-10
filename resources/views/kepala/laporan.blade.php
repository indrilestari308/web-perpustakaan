@extends('kepala.layouts')

@section('title', 'Laporan')

@section('content')

{{-- ─── FILTER ─── --}}
<div class="card mb-4">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-funnel"></i>
        <span class="fw-bold">Filter Laporan</span>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('kepala.laporan') }}" id="formFilter">
            <div class="row g-3 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="dari" class="form-control"
                           value="{{ request('dari') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="sampai" class="form-control"
                           value="{{ request('sampai') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="menunggu"     {{ request('status')=='menunggu'     ? 'selected':'' }}>Menunggu</option>
                        <option value="dipinjam"     {{ request('status')=='dipinjam'     ? 'selected':'' }}>Dipinjam</option>
                        <option value="dikembalikan" {{ request('status')=='dikembalikan' ? 'selected':'' }}>Dikembalikan</option>
                        <option value="terlambat"    {{ request('status')=='terlambat'    ? 'selected':'' }}>Terlambat</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Nama Anggota</label>
                    <input type="text" name="nama" class="form-control"
                           placeholder="Cari nama anggota..."
                           value="{{ request('nama') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i> Tampilkan
                    </button>
                    <a href="{{ route('kepala.laporan') }}" class="btn btn-outline-secondary">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- ─── SUMMARY CARDS ─── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body py-3">
                <div class="text-muted" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Total Data</div>
                <div class="fw-bold mt-1" style="font-size:22px;color:#1e293b;">{{ $total }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body py-3">
                <div class="text-muted" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Dikembalikan</div>
                <div class="fw-bold mt-1" style="font-size:22px;color:#2563eb;">{{ $totalKembali }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body py-3">
                <div class="text-muted" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Terlambat</div>
                <div class="fw-bold mt-1" style="font-size:22px;color:#ef4444;">{{ $totalTerlambat }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card h-100">
            <div class="card-body py-3">
                <div class="text-muted" style="font-size:11px;text-transform:uppercase;letter-spacing:.05em;font-weight:600;">Total Denda</div>
                <div class="fw-bold mt-1" style="font-size:18px;color:#dc2626;">
                    Rp {{ number_format($totalDenda, 0, ',', '.') }}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ─── TABEL ─── --}}
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <div>
            <span class="fw-bold">Data Laporan</span>
            <span class="text-muted ms-2" style="font-size:12px;">
                Menampilkan {{ $laporan->total() }} data
            </span>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('kepala.laporan.cetak', request()->all()) }}"
               target="_blank"
               class="btn btn-sm btn-success">
                <i class="bi bi-printer me-1"></i> Cetak PDF
            </a>
            <a href="{{ route('kepala.laporan.export', request()->all()) }}"
               class="btn btn-sm"
               style="border:1px solid #16a34a; color:#16a34a; background:white;">
                <i class="bi bi-file-earmark-excel me-1"></i> Export Excel
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Anggota</th>
                    <th>Buku Dipinjam</th>
                    <th>Tgl Pinjam</th>
                    <th>Jatuh Tempo</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                    <th>Denda</th>
                </tr>
            </thead>
            <tbody>
                @forelse($laporan as $i => $row)
                <tr>
                    <td class="text-muted">{{ $laporan->firstItem() + $i }}</td>
                    <td><strong>{{ $row->user->name ?? '-' }}</strong></td>
                    <td>{{ $row->buku->judul ?? '-' }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($row->tanggal_jatuh_tempo)->format('d M Y') }}</td>
                    <td>
                        @if($row->tanggal_kembali)
                            {{ \Carbon\Carbon::parse($row->tanggal_kembali)->format('d M Y') }}
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>
                    <td>

                        @php
                            $statusClass = match($row->status) {
                                'dikembalikan'     => 'badge-dikembalikan',
                                'terlambat'        => 'badge-terlambat',
                                'dipinjam'         => 'badge-dipinjam',
                                'menunggu_kembali' => 'badge-menunggu',
                                default            => 'badge-menunggu',
                            };

                            $statusLabel = match($row->status) {
                                'dikembalikan'     => 'Dikembalikan',
                                'terlambat'        => 'Terlambat',
                                'dipinjam'         => 'Dipinjam',
                                'menunggu_kembali' => 'Menunggu Konfirmasi',
                                default            => 'Menunggu',
                            };
                        @endphp


                        <span class="badge-status {{ $statusClass }}">{{ $statusLabel }}</span>
                    </td>
                    <td>
                        @if($row->denda > 0)
                            <span style="color:#dc2626;font-weight:600;">
                                Rp {{ number_format($row->denda, 0, ',', '.') }}
                            </span>
                        @else
                            <span class="text-muted">Rp 0</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">
                        <i class="bi bi-inbox me-2"></i>Tidak ada data ditemukan
                    </td>
                </tr>
                @endforelse
            </tbody>
            @if($laporan->count() > 0)
            <tfoot>
                <tr style="background:#f8fafc;">
                    <td colspan="7" class="text-end fw-bold text-muted pe-3">
                        Total Denda Keseluruhan
                    </td>
                    <td style="font-weight:700; color:#dc2626;">
                        Rp {{ number_format($totalDenda, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>
    </div>

    <div class="px-3 pb-3">
        {{ $laporan->withQueryString()->links() }}
    </div>
</div>

@endsection
