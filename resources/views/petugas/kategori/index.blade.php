@extends('petugas.layouts')

@section('title', 'Data Kategori')

@section('content')

<div class="card-box">

    <h5 class="mb-3">📚 Data Kategori</h5>

    {{-- SUCCESS --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- ERROR --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif

    {{-- FORM TAMBAH --}}
    <form action="{{ route('kategori.store') }}" method="POST" class="d-flex gap-2 mb-3">
        @csrf
        <input type="text" name="nama_kategori" class="form-control"
               placeholder="Tambah kategori..."
               value="{{ old('nama_kategori') }}" required>

        <button class="btn btn-primary">Tambah</button>
    </form>

    {{-- TABLE --}}
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Kategori</th>
                <th>Jumlah Buku</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($kategoris as $index => $kategori)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>{{ $kategori->buku_count }}</td>
                <td>
                    <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-danger btn-sm"
                                onclick="return confirm('Yakin hapus?')">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Belum ada kategori</td>
            </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
