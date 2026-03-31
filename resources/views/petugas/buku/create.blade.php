@extends('petugas.layouts')

@section('title', 'Tambah Buku')

@section('content')

<style>
    .form-box {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 5px 12px rgba(0,0,0,0.08);
    }
</style>

<div class="container mt-4">
    <div class="form-box">

        <h4 class="mb-4">📚 Tambah Buku</h4>

        {{-- ERROR VALIDATION --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">

                {{-- JUDUL --}}
                <div class="col-md-6 mb-3">
                    <label>Judul Buku</label>
                    <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
                </div>

                {{-- PENULIS --}}
                <div class="col-md-6 mb-3">
                    <label>Penulis</label>
                    <input type="text" name="penulis" class="form-control" value="{{ old('penulis') }}">
                </div>

                {{-- KATEGORI (DINAMIS 🔥) --}}
                <div class="col-md-6 mb-3">
                    <label>Kategori</label>
                    <select name="kategori_id" class="form-control">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- TAHUN --}}
                <div class="col-md-6 mb-3">
                    <label>Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" class="form-control" value="{{ old('tahun_terbit') }}">
                </div>

                {{-- STOK --}}
                <div class="col-md-6 mb-3">
                    <label>Stok</label>
                    <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
                </div>

                {{-- STATUS --}}
                <div class="col-md-6 mb-3">
                    <label>Status</label>
                    <select name="status" class="form-control">
                        <option value="tersedia" {{ old('status') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                        <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                    </select>
                </div>

                {{-- PENERBIT --}}
                <div class="col-md-6 mb-3">
                    <label>Penerbit</label>
                    <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
                </div>

                {{-- HALAMAN --}}
                <div class="col-md-6 mb-3">
                    <label>Jumlah Halaman</label>
                    <input type="number" name="jumlah_halaman" class="form-control" value="{{ old('jumlah_halaman') }}">
                </div>

                {{-- BAHASA --}}
                <div class="col-md-6 mb-3">
                    <label>Bahasa</label>
                    <input type="text" name="bahasa" class="form-control" value="{{ old('bahasa') }}">
                </div>

                {{-- GAMBAR --}}
                <div class="col-md-6 mb-3">
                    <label>Cover Buku</label>
                    <input type="file" name="gambar" class="form-control">
                </div>

                {{-- SINOPSIS --}}
                <div class="col-12 mb-3">
                    <label>Sinopsis</label>
                    <textarea name="sinopsis" class="form-control" rows="4">{{ old('sinopsis') }}</textarea>
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="d-flex justify-content-between">
                <a href="{{ route('buku.index') }}" class="btn btn-secondary">Kembali</a>
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
            </div>

        </form>

    </div>
</div>

@endsection
