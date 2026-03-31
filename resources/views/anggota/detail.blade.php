@extends('anggota.layouts')

@section('title', 'Detail Buku')

@section('content')

<style>
    .detail-card {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    }

    .cover-img {
        width: 180px;
        height: 260px;
        object-fit: cover;
        border-radius: 15px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .detail-text p {
        font-size: 14px;
        margin-bottom: 6px;
    }
</style>

<div class="detail-card text-center">

    {{-- COVER DI ATAS 🔥 --}}
    <img src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/150' }}"
         class="cover-img mb-3">

    <h4 class="fw-bold">{{ $buku->judul }}</h4>

    <p class="text-muted">
        {{ $buku->penulis }} • {{ $buku->tahun_terbit }}
    </p>

    <hr>

    <div class="detail-text text-start">

        <p><strong>Kategori:</strong>
            {{ $buku->kategori->nama_kategori ?? '-' }}
        </p>

        <p><strong>Penerbit:</strong>
            {{ $buku->penerbit ?? '-' }}
        </p>

        <p><strong>Stok:</strong>
            {{ $buku->stok ?? 0 }}
        </p>

        <p><strong>Bahasa:</strong>
            {{ $buku->bahasa ?? '-' }}
        </p>

        <p><strong>Jumlah Halaman:</strong>
            {{ $buku->jumlah_halaman ?? '-' }}
        </p>

        <p><strong>Sinopsis:</strong></p>
        <p class="text-muted">
            {{ $buku->sinopsis ?? 'Tidak ada sinopsis' }}
        </p>

    </div>

    <div class="mt-3 d-flex justify-content-center gap-2">

        @if ($buku->stok > 0)
        <form action="{{ route('anggota.pinjam', $buku->id) }}" method="POST">
            @csrf
            <button class="btn btn-success btn-sm">
                Pinjam Buku
            </button>
        </form>
        @else
            <button class="btn btn-danger btn-sm" disabled>
                Stok Habis
            </button>
        @endif

        <a href="{{ url('/anggota/buku') }}" class="btn btn-secondary btn-sm">
            Kembali
        </a>

    </div>

</div>

@endsection
