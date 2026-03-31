@extends('petugas.layouts')

@section('title', 'Tambah Kategori')

@section('content')

<style>
    .form-box {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 12px rgba(0,0,0,0.08);
    }

    .title-icon i {
        font-size: 20px;
    }
</style>

<div class="form-box">

    <!-- TITLE -->
    <h5 class="mb-4 d-flex align-items-center gap-2 title-icon">
        <i class="fa-solid fa-layer-group text-primary"></i>
        Tambah Kategori
    </h5>

        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" placeholder="Masukkan nama kategori">
            </div>

            <div class="mt-3">
                <button class="btn btn-primary">
                    <i class="fa fa-save"></i> Simpan
                </button>

                <a href="/petugas/kategori" class="btn btn-secondary">
                    Kembali
                </a>
            </div>
        </form>

</div>

@endsection
