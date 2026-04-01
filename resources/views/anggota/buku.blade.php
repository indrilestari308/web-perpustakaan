@extends('anggota.layouts')

@section('title', 'Daftar Buku')

@section('content')

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        ✅ Permintaan peminjaman berhasil dikirim!
        Silakan tunggu konfirmasi dari petugas.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('info'))
    <div class="alert alert-info alert-dismissible fade show">
        ℹ️ Permintaan Anda sedang diproses oleh petugas.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="alert alert-warning mb-3">
    Setelah klik <b>Pinjam</b>, permintaan akan dikirim ke petugas.
    Silakan tunggu konfirmasi sebelum buku bisa diambil.
</div>

<div class="row g-4">

    @forelse ($buku as $item)
    <div class="col-md-4">
        <div class="card-box text-center p-3">

            {{-- GAMBAR --}}
            <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/150' }}"
                 class="img-fluid mb-3"
                 style="height:220px; object-fit:cover; border-radius:10px;">

            {{-- JUDUL --}}
            <h5 class="fw-bold">{{ $item->judul }}</h5>

            {{-- PENULIS & TAHUN --}}
            <p class="text-muted">
                {{ $item->penulis }} • {{ $item->tahun_terbit }}
            </p>

            {{-- STATUS --}}
            @if ($item->stok > 0)
                <span class="badge bg-success mb-2">Tersedia</span>
            @else
                <span class="badge bg-danger mb-2">Habis</span>
            @endif

            <div class="d-flex justify-content-center gap-2 mt-2">

                {{-- DETAIL --}}
                <a href="{{ route('anggota.buku.detail', $item->id) }}"
                   class="btn btn-primary btn-sm">
                    Lihat Detail
                </a>

                {{-- PINJAM --}}
                @if ($item->stok > 0)
                <form action="{{ route('anggota.pinjam', $item->id) }}" method="POST">
                    @csrf
                    <button class="btn btn-success btn-sm">
                        Pinjam
                    </button>
                </form>
                @endif

            </div>

        </div>
    </div>

    @empty
        <div class="col-12 text-center">
            <p class="text-muted">Belum ada data buku</p>
        </div>
    @endforelse

</div>

@endsection
