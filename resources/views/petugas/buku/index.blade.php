@extends('petugas.layouts')

@section('title', 'Data Buku')

@section('content')

@php use Illuminate\Support\Str; @endphp

<style>
.card-box {
    background: #ffffff;
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.06);
}

/* HEADER */
.card-box h5 {
    font-weight: 600;
    color: #0f172a;
}

/* TABEL */
.table {
    font-size: 13px;
    border-collapse: separate;
    border-spacing: 0 6px;
}

.table thead th {
    background: #f8fafc;
    font-size: 11.5px;
    text-transform: uppercase;
    color: #64748b;
    border: none;
}

.table tbody tr {
    background: #ffffff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.04);
    border-radius: 10px;
}

.table td {
    border: none;
    padding: 10px 8px;
}

/* COVER */
.table img {
    width: 50px;
    height: 70px;
    object-fit: cover;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
}

/* BADGE */
.badge {
    font-size: 11px;
    padding: 6px 10px;
    border-radius: 20px;
}

/* ACTION */
.action-icon a, 
.action-icon button {
    font-size: 16px;
    transition: 0.2s;
    border: none;
    background: none;
}

.icon-edit { color: #2563eb; }
.icon-edit:hover { transform: scale(1.2); }

.icon-delete { color: #ef4444; }
.icon-delete:hover { transform: scale(1.2); }

/* RESPONSIVE */
@media(max-width:768px){
    .table {
        font-size: 12px;
    }
}
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
