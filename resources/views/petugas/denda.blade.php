@extends('petugas.layouts')

@section('title', 'Konfirmasi Peminjaman')

@section('content')

<div class="card-dashboard">

    <h5 class="mb-3">Konfirmasi Peminjaman</h5>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Nama User</th>
                <th>Buku</th>
                <th>Tanggal Pinjam</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($peminjaman as $p)
            <tr>
                <td>{{ $p->user->name }}</td>
                <td>{{ $p->buku->judul }}</td>
                <td>{{ $p->tanggal_pinjam }}</td>

                <td>
                    @if ($p->status == 'dipinjam')
                        <span class="badge bg-warning">Dipinjam</span>
                    @else
                        <span class="badge bg-success">Dikembalikan</span>
                    @endif
                </td>

                <td>
                    @if ($p->status == 'dipinjam')
                    <form action="{{ route('peminjaman.konfirmasi', $p->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-sm">
                            Konfirmasi
                        </button>
                    </form>
                    @else
                        -
                    @endif
                </td>

            </tr>
            @endforeach
        </tbody>

    </table>

</div>

@endsection
