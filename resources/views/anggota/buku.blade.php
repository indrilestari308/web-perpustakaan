@extends('anggota.layouts')

@section('title', 'Daftar Buku')

@section('content')

<div class="row g-4">

    @foreach ($buku as $buku)
    <div class="col-md-4">
        <div class="card-box text-center p-3">

            {{-- GAMBAR --}}
            <img src="{{ $buku->gambar ? asset('storage/'.$buku->gambar) : 'https://via.placeholder.com/150' }}"
                 class="img-fluid mb-3"
                 style="height:220px; object-fit:cover; border-radius:10px;">

            {{-- JUDUL --}}
            <h5 class="fw-bold">{{ $buku->judul }}</h5>

            {{-- PENULIS & TAHUN --}}
            <p class="text-muted">
                {{ $buku->penulis }} • {{ $buku->tahun_terbit }}
            </p>

            {{-- STATUS --}}
            @if ($buku->stok > 0)
                <span class="badge bg-success mb-2">Tersedia</span>
            @else
                <span class="badge bg-danger mb-2">Habis</span>
            @endif

            <div class="d-flex justify-content-center gap-2 mt-2">

                {{-- DETAIL --}}
                <a href="{{ route('anggota.buku.detail', $buku->id) }}"
                class="btn btn-primary btn-sm">
                    Lihat Detail
                </a>

                {{-- PINJAM --}}
                @if ($buku->stok > 0)
                <form action="{{ route('anggota.pinjam', $buku->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-sm">
                        Pinjam
                    </button>
                </form>
                @endif

            </div>

        </div>
    </div>
    @endforeach

</div>

@endsection
