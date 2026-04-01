@extends('petugas.layouts')

@section('title', 'Edit Buku')

@section('content')

<style>
    .form-box {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 12px rgba(0,0,0,0.08);
    }

    .preview-img {
        width: 100px;
        height: 140px;
        object-fit: cover;
        border-radius: 10px;
        margin-top: 10px;
    }
</style>

<div class="form-box">


    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">

            {{-- JUDUL --}}
            <div class="col-md-6 mb-3">
                <label>Judul Buku</label>
                <input type="text" name="judul" class="form-control"
                    value="{{ old('judul', $buku->judul) }}">
            </div>

            {{-- PENULIS --}}
            <div class="col-md-6 mb-3">
                <label>Penulis</label>
                <input type="text" name="penulis" class="form-control"
                    value="{{ old('penulis', $buku->penulis) }}">
            </div>

            {{-- KATEGORI --}}
            <div class="col-md-6 mb-3">
                <label>Kategori</label>
                <select name="kategori_id" class="form-control">
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id }}"
                            {{ $buku->kategori_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- STOK --}}
            <div class="col-md-6 mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control"
                    value="{{ old('stok', $buku->stok) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Penerbit</label>
                <input type="text" name="penerbit" class="form-control"
                    value="{{ old('penerbit', $buku->penerbit) }}">
            </div>

            <div class="col-md-6 mb-3">
                <label>Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control"
                    value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
            </div>

            {{-- COVER --}}
            <div class="col-md-6 mb-3">
                <label>Cover Buku</label>
                <input type="file" name="gambar" class="form-control">

                {{-- PREVIEW GAMBAR --}}
                @if ($buku->gambar)
                    <img src="{{ asset('storage/' . $buku->gambar) }}" class="preview-img">
                @else
                    <img src="https://via.placeholder.com/100x140" class="preview-img">
                @endif
            </div>

        </div>

        <div class="mt-3">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-save"></i> Update
            </button>

            <a href="{{ route('buku.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </form>

</div>

@endsection
