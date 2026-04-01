@extends('kepala.layouts')

@section('title', 'Dashboard Kepala')

@section('content')

<div class="container-fluid">
    <h3 class="mb-4">Dashboard Kepala Perpustakaan</h3>

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card-box text-center">
                <h4>120</h4>
                <small>Total Anggota</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box text-center">
                <h4>75</h4>
                <small>Buku Dipinjam</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box text-center">
                <h4>30</h4>
                <small>Pengembalian</small>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-box text-center">
                <h4>Rp 250.000</h4>
                <small>Total Denda</small>
            </div>
        </div>

    </div>

    <div class="card-box">
        <h5 class="mb-3">Rekap Aktivitas Anggota</h5>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Anggota</th>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Indri Lestari</td>
                        <td>Laskar Pelangi</td>
                        <td>10 Jan 2026</td>
                        <td><span class="badge bg-success">Kembali</span></td>
                        <td>Rp 0</td>
                    </tr>

                    <tr>
                        <td>Budi Santoso</td>
                        <td>Bumi Manusia</td>
                        <td>12 Jan 2026</td>
                        <td><span class="badge bg-danger">Terlambat</span></td>
                        <td>Rp 6.000</td>
                    </tr>

                    <tr>
                        <td>Siti Aminah</td>
                        <td>Atomic Habits</td>
                        <td>15 Jan 2026</td>
                        <td><span class="badge bg-warning text-dark">Dipinjam</span></td>
                        <td>Rp 0</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
