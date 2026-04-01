@extends('petugas.layouts')

@section('title', 'Data Buku')

@section('content')

@php use Illuminate\Support\Str; @endphp

<style>
.card-box {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 12px rgba(0,0,0,0.08);
}

/* 🔥 TABEL COMPACT */
.table {
    font-size: 13px;
}

.table th,
.table td {
    padding: 8px;
    vertical-align: middle;
}

.table th {
    background: #f1f5f9;
    font-size: 12px;
    text-transform: uppercase;
}

/* GAMBAR */
.table img {
    width: 45px;
    height: 65px;
    object-fit: cover;
    border-radius: 6px;
}

/* BADGE */
.badge {
    font-size: 11px;
    padding: 5px 8px;
}

/* ICON */
.action-icon a, .action-icon button {
    font-size: 15px;
    transition: 0.2s;
    border: none;
    background: none;
}

.icon-edit { color: #275194; }
.icon-edit:hover { color: #143caa; transform: scale(1.2); }

.icon-delete { color: #ef4444; }
.icon-delete:hover { color: #b91c1c; transform: scale(1.2); }
</style>

<div class="card-box">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="mb-0">
            <i class="fa-solid fa-book-open text-primary"></i>
            Data Buku
        </h5>

        <a href="{{ route('buku.create') }}" class="btn btn-primary btn-sm">
            <i class="fa fa-plus"></i> Tambah Buku
        </a>
    </div>

    <!-- ALERT -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-hover align-middle text-center table-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Cover</th>
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Penerbit</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>Bahasa</th>
                    <th>Hal</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($bukus as $buku)
                <tr>

                    <!-- NOMOR -->
                    <td>
                        {{ $loop->iteration + ($bukus->firstItem() ?? 1) - 1 }}
                    </td>

                    <!-- COVER -->
                    <td>
                        @if($buku->gambar)
                            <img src="{{ asset('storage/'.$buku->gambar) }}">
                        @else
                            <img src="https://via.placeholder.com/50x70">
                        @endif
                    </td>

                    <!-- JUDUL -->
                    <td style="max-width:150px;">
                        {{ Str::limit($buku->judul, 30) }}
                    </td>

                    <td>{{ $buku->penulis }}</td>
                    <td>{{ $buku->penerbit }}</td>

                    <!-- KATEGORI -->
                    <td>
                        {{ optional($buku->kategori)->nama_kategori ?? '-' }}
                    </td>

                    <td>{{ $buku->tahun_terbit }}</td>

                    <!-- 🔥 DATA BARU -->
                    <td>{{ $buku->bahasa ?? '-' }}</td>
                    <td>{{ $buku->jumlah_halaman ?? '-' }}</td>

                    <!-- STOK -->
                    <td>
                        <span class="badge bg-success">{{ $buku->stok }}</span>
                    </td>

                    <!-- AKSI -->
                    <td>
                        <div class="d-flex justify-content-center gap-3 action-icon">

                            <!-- EDIT -->
                            <a href="{{ route('buku.edit', $buku->id) }}" class="icon-edit" title="Edit">
                                <i class="fa fa-pen-to-square"></i>
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin hapus buku ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="icon-delete" title="Hapus">
                                    <i class="fa fa-trash-can"></i>
                                </button>
                            </form>

                        </div>
                    </td>

                </tr>

                @empty
                <tr>
                    <td colspan="11">Data buku belum ada</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    @if(method_exists($buku, 'links'))
    <div class="d-flex justify-content-end mt-3">
        {{ $bukus->links() }}
    </div>
    @endif

</div>

@endsection
