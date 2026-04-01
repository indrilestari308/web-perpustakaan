@extends('anggota.layouts')

@section('title', 'Dashboard Anggota')

@section('content')

<!-- NOTE ATURAN -->
<div class="alert alert-info mb-4">
    <h5 class="mb-2">📌 Aturan Peminjaman Buku</h5>
    <ul class="mb-0">
        <li>Maksimal meminjam <b>3 buku</b> sekaligus</li>
        <li>Lama peminjaman <b>7 hari</b></li>
        <li>Denda keterlambatan <b>Rp 1.000 / hari</b></li>
        <li>Tidak bisa meminjam jika masih ada buku yang belum dikembalikan</li>
        <li>Jaga buku dengan baik, jika hilang wajib mengganti</li>
    </ul>
</div>

<div class="row mb-4">

    <div class="col-md-3">
        <div class="card-box">
            <h6>Total Pinjaman</h6>
            <h4><b>5 Buku</b></h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h6>Sedang Dipinjam</h6>
            <h4><b>2 Buku</b></h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h6>Sudah Dikembalikan</h6>
            <h4><b>3 Buku</b></h4>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card-box">
            <h6>Denda</h6>
            <h4><b>Rp 0</b></h4>
        </div>
    </div>

</div>

<!-- BUKU DIPINJAM -->
<div class="card-box mb-4">
    <h5 class="mb-3"><b>Buku Sedang Dipinjam</b></h5>

    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal Pinjam</th>
                <th>Jatuh Tempo</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Pemrograman Web</td>
                <td>10 Jan 2026</td>
                <td>17 Jan 2026</td>
                <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
            </tr>
            <tr>
                <td>Basis Data</td>
                <td>12 Jan 2026</td>
                <td>19 Jan 2026</td>
                <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
            </tr>
        </tbody>
    </table>
</div>

<!-- RIWAYAT -->
<div class="card-box">
    <h5 class="mb-3"><b>Riwayat Peminjaman</b></h5>

    <table class="table">
        <thead>
            <tr>
                <th>Judul</th>
                <th>Tanggal</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Algoritma</td>
                <td>01 Jan 2026</td>
                <td><span class="badge bg-success">Dikembalikan</span></td>
            </tr>
            <tr>
                <td>Jaringan Komputer</td>
                <td>05 Jan 2026</td>
                <td><span class="badge bg-success">Dikembalikan</span></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
