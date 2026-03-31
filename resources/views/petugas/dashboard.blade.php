@extends('petugas.layouts')

@section('title', 'Dashboard')

@section('content')

<style>
    .dashboard-box {
        background: #dbeafe;
        border-radius: 15px;
        padding: 30px;
    }

    .card-custom {
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        background: white;
        box-shadow: 0 5px 12px rgba(0,0,0,0.08);
        transition: 0.3s;
    }

    .card-custom:hover {
        transform: translateY(-5px);
    }
</style>

<div class="dashboard-box">
    <h4 class="mb-4">Dashboard</h4>

    <div class="row g-4">

        <div class="col-md-3">
            <div class="card-custom">
                <h6>Total Buku</h6>
                <h3 class="text-primary">120</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-custom">
                <h6>Buku Dipinjam</h6>
                <h3 class="text-primary">35</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-custom">
                <h6>Total Anggota</h6>
                <h3 class="text-primary">80</h3>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card-custom">
                <h6>Total Denda</h6>
                <h3 class="text-primary">Rp 250.000</h3>
            </div>
        </div>

    </div>
</div>

@endsection