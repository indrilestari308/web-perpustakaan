@extends('kepala.layouts')

@section('title', 'Tambah Petugas')

@section('content')

<h3>Tambah Petugas</h3>

<div class="card-box mt-3">
    <form>
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" class="form-control">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" class="form-control">
        </div>

        <div class="mb-3">
            <label>Password</label>
            <input type="password" class="form-control">
        </div>

        <button class="btn btn-success">Simpan</button>
    </form>
</div>

@endsection
