<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Segoe UI', sans-serif; font-size: 12px; color: #1e293b; padding: 30px; }

        .kop { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #1e293b; padding-bottom: 12px; }
        .kop h2 { font-size: 16px; font-weight: 700; }
        .kop p  { font-size: 12px; color: #475569; margin-top: 2px; }

        .meta { display: flex; justify-content: space-between; margin-bottom: 16px; font-size: 11.5px; color: #475569; }

        .summary { display: flex; gap: 20px; margin-bottom: 16px; }
        .sum-item { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 8px 14px; }
        .sum-item .val { font-size: 16px; font-weight: 700; color: #1e293b; }
        .sum-item .lbl { font-size: 10px; color: #64748b; text-transform: uppercase; letter-spacing: .04em; }

        table { width: 100%; border-collapse: collapse; font-size: 11.5px; }
        th { background: #1e293b; color: white; padding: 8px 10px; text-align: left; font-weight: 600; font-size: 10.5px; text-transform: uppercase; letter-spacing: .04em; }
        td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; vertical-align: middle; }
        tr:nth-child(even) td { background: #f8fafc; }
        tfoot td { background: #f1f5f9 !important; font-weight: 700; }

        .badge { display: inline-block; padding: 2px 8px; border-radius: 20px; font-size: 10px; font-weight: 600; }
        .b-dikembalikan { background: #d1fae5; color: #065f46; }
        .b-terlambat    { background: #fee2e2; color: #991b1b; }
        .b-dipinjam     { background: #dbeafe; color: #1e40af; }
        .b-menunggu     { background: #fef3c7; color: #92400e; }
        .denda-val { color: #dc2626; font-weight: 600; }

        .footer-print { margin-top: 30px; display: flex; justify-content: flex-end; }
        .ttd { text-align: center; width: 200px; }
        .ttd .label { font-size: 11px; margin-bottom: 60px; }
        .ttd .garis { border-top: 1px solid #1e293b; padding-top: 4px; font-size: 11px; font-weight: 600; }

        .summary-table {
            width: 100%;
            margin-bottom: 16px;
        }

        .summary-table td {
            padding: 5px;
            width: 25%;
        }

        @media print {
            body { padding: 20px; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>



<div class="kop">
    <h2>LAPORAN PEMINJAMAN BUKU</h2>
    <p>Perpustakaan — Dicetak oleh: {{ auth()->user()->name }}</p>
</div>

<div class="meta">
    <span>
        Periode:
        <strong>
            {{ request('dari') ? \Carbon\Carbon::parse(request('dari'))->format('d M Y') : 'Semua' }}
            –
            {{ request('sampai') ? \Carbon\Carbon::parse(request('sampai'))->format('d M Y') : 'Semua' }}
        </strong>
    </span>
    <span>Dicetak: {{ now()->format('d M Y, H:i') }} WIB</span>
</div>

<table class="summary-table">
    <tr>
        <td>
            <div class="sum-item">
                <div class="val">{{ $total }}</div>
                <div class="lbl">Total Data</div>
            </div>
        </td>
        <td>
            <div class="sum-item">
                <div class="val">{{ $totalKembali }}</div>
                <div class="lbl">Dikembalikan</div>
            </div>
        </td>
        <td>
            <div class="sum-item">
                <div class="val">{{ $totalTerlambat }}</div>
                <div class="lbl">Terlambat</div>
            </div>
        </td>
        <td>
            <div class="sum-item">
                <div class="val" style="color:#dc2626;">
                    Rp {{ number_format($totalDenda,0,',','.') }}
                </div>
                <div class="lbl">Total Denda</div>
            </div>
        </td>
    </tr>
</table>

<table>
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
        @foreach($laporan as $i => $row)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td><strong>{{ $row->user->name }}</strong></td>
            <td>{{ $row->buku->judul }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_pinjam)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($row->tanggal_jatuh_tempo)->format('d M Y') }}</td>
            <td>{{ $row->tanggal_kembali ? \Carbon\Carbon::parse($row->tanggal_kembali)->format('d M Y') : '—' }}</td>
            <td>
                @php
                    $cls = match($row->status) {
                        'dikembalikan' => 'b-dikembalikan',
                        'terlambat'    => 'b-terlambat',
                        'dipinjam'     => 'b-dipinjam',
                        default        => 'b-menunggu',
                    };
                @endphp
                <span class="badge {{ $cls }}">{{ ucfirst($row->status) }}</span>
            </td>
            <td class="{{ $row->denda > 0 ? 'denda-val' : '' }}">
                Rp {{ number_format($row->denda, 0, ',', '.') }}
            </td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="7" style="text-align:right; padding-right:12px;">Total Denda</td>
            <td class="denda-val">Rp {{ number_format($totalDenda, 0, ',', '.') }}</td>
        </tr>
    </tfoot>
</table>

<div class="footer-print">
    <div class="ttd">
        <div class="label">Kepala Perpustakaan,</div>
        <div class="garis">{{ auth()->user()->name }}</div>
    </div>
</div>

</body>
</html>
