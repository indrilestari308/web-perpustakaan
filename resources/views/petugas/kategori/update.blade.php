@extends('petugas.layouts')

@section('title', 'Edit Kategori')

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
        Edit Kategori
    </h5>

    <form>

        <div class="mb-3">
            <label>Nama Kategori</label>
            <input type="text" class="form-control" value="Programming">
        </div>

        <div class="mt-3">
            <button class="btn btn-success">
                <i class="fa fa-save"></i> Update
            </button>

            <a href="/petugas/kategori" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

@endsection