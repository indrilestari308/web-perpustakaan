@extends('petugas.layouts')

@section('title', 'Kelola Kategori')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    
    <button class="btn btn-primary btn-sm px-3"
            data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-1"></i> Tambah Kategori
    </button>
</div>

{{-- ─── TABLE ─── --}}
<div class="card" style="border-radius:12px; overflow:hidden;">

    <div class="card-header" style="padding:14px 18px;">
        <span style="font-size:13.5px; font-weight:600; color:#0f172a;">
            <i class="bi bi-grid me-2" style="color:#4e73df;"></i>
            Daftar Kategori
            <span style="font-size:12px; font-weight:400; color:#64748b; margin-left:6px;">
                ({{ $kategoris->count() }} kategori)
            </span>
        </span>
    </div>

    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">No</th>
                    <th>Nama Kategori</th>
                    <th style="width:140px; text-align:center;">Jumlah Buku</th>
                    <th style="width:120px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kategori)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $loop->iteration }}</td>

                    <td>
                        <div style="font-size:13.5px; font-weight:500; color:#0f172a;">
                            {{ $kategori->nama_kategori }}
                        </div>
                    </td>

                    <td style="text-align:center;">
                        <span style="display:inline-flex; align-items:center; gap:4px;
                                     font-size:12px; font-weight:600;
                                     background:#dbeafe; color:#1e40af;
                                     padding:3px 12px; border-radius:20px;">
                            <i class="bi bi-book" style="font-size:11px;"></i>
                            {{ $kategori->buku_count }} buku
                        </span>
                    </td>

                    <td>
                        <div class="d-flex gap-1">
                            {{-- Tombol Edit --}}
                            <button type="button"
                                    class="btn btn-outline-primary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEdit"
                                    data-id="{{ $kategori->id }}"
                                    data-nama="{{ $kategori->nama_kategori }}"
                                    title="Edit">
                                <i class="bi bi-pencil"></i>
                            </button>

                            {{-- Tombol Hapus --}}
                            <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="btn btn-outline-danger btn-sm"
                                        onclick="return confirm('Yakin hapus kategori \'{{ $kategori->nama_kategori }}\'?')"
                                        {{ $kategori->buku_count > 0 ? 'disabled' : '' }}
                                        title="{{ $kategori->buku_count > 0 ? 'Tidak bisa dihapus, masih ada buku' : 'Hapus' }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-5" style="color:#94a3b8; font-size:13px;">
                        <i class="bi bi-grid d-block mb-2" style="font-size:24px; opacity:0.4;"></i>
                        Belum ada kategori
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- ─── MODAL TAMBAH ─── --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:16px 20px;">
                <h6 class="modal-title fw-bold mb-0" style="color:#0f172a; font-size:14px;">
                    <i class="bi bi-plus-circle me-2" style="color:#4e73df;"></i>
                    Tambah Kategori
                </h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body" style="padding:20px;">
                    <label style="font-size:12px; font-weight:600; color:#64748b; margin-bottom:6px; display:block;">
                        NAMA KATEGORI
                    </label>
                    <input type="text" name="nama_kategori" class="form-control"
                           placeholder="Contoh: Fiksi, Sains, Sejarah..."
                           value="{{ old('nama_kategori') }}" required autofocus>
                    @error('nama_kategori')
                        <div style="font-size:12px; color:#ef4444; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:12px 20px;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-plus me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ─── MODAL EDIT ─── --}}
<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:400px;">
        <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.12);">
            <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:16px 20px;">
                <h6 class="modal-title fw-bold mb-0" style="color:#0f172a; font-size:14px;">
                    <i class="bi bi-pencil me-2" style="color:#4e73df;"></i>
                    Edit Kategori
                </h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>
            <form id="formEdit" action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body" style="padding:20px;">
                    <label style="font-size:12px; font-weight:600; color:#64748b; margin-bottom:6px; display:block;">
                        NAMA KATEGORI
                    </label>
                    <input type="text" name="nama_kategori" id="editNamaKategori"
                           class="form-control" required>
                </div>
                <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:12px 20px;">
                    <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary btn-sm px-4">
                        <i class="bi bi-check me-1"></i> Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Isi data modal edit
    document.getElementById('modalEdit').addEventListener('show.bs.modal', function (e) {
        const btn  = e.relatedTarget;
        const id   = btn.dataset.id;
        const nama = btn.dataset.nama;

        document.getElementById('editNamaKategori').value = nama;
        document.getElementById('formEdit').action = `/petugas/kategori/${id}`;
    });

    // Buka modal tambah otomatis kalau ada error validasi (bukan dari edit)
    @if($errors->any() && old('_method') !== 'PUT')
        new bootstrap.Modal(document.getElementById('modalTambah')).show();
    @endif

});
</script>
@endpush
