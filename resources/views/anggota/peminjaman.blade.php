@extends('anggota.layouts')

@section('content')

<div class="card-dashboard">

<h5>Riwayat Peminjaman</h5>

<table class="table mt-3">
    <tr>
        <th>Buku</th>
        <th>Tanggal Pinjam</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @foreach ($data as $d)
    <tr>
        <td>{{ $d->buku->judul }}</td>
        <td>{{ $d->tanggal_pinjam }}</td>

        <td>
            @if($d->status == 'dipinjam')
                <span class="badge bg-warning">Dipinjam</span>
            @else
                <span class="badge bg-success">Selesai</span>
            @endif
        </td>

        <td>
            @if($d->status == 'dipinjam')
            <form action="{{ route('anggota.kembali', $d->id) }}" method="POST">
                @csrf
                <button class="btn btn-success btn-sm">
                    Kembalikan
                </button>
            </form>
            @endif
        </td>
    </tr>
    @endforeach

</table>

</div>

@endsection
