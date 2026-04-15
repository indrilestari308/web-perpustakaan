@extends('petugas.layouts')

@section('title', 'Data Anggota')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <h5 class="fw-bold mb-1" style="color:#0f172a;">Data Anggota</h5>
        <p class="mb-0" style="font-size:13px; color:#64748b;">
            Daftar seluruh anggota perpustakaan beserta status peminjaman
        </p>
    </div>
</div>

<div class="card" style="border-radius:12px; overflow:hidden;">

    {{-- ─── FILTER ─── --}}
    <div class="card-header" style="border-radius:0; padding:12px 18px;">
        <form method="GET" action="{{ route('petugas.anggota') }}"
              class="d-flex gap-2 align-items-center flex-wrap">
            <div class="input-group" style="max-width:260px;">
                <span class="input-group-text bg-white" style="border-color:#e2e8f0;">
                    <i class="bi bi-search" style="font-size:12px; color:#94a3b8;"></i>
                </span>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari nama / email..."
                       value="{{ request('search') }}"
                       style="border-left:none;">
            </div>
            <button type="submit" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>
            @if(request('search'))
                <a href="{{ route('petugas.anggota') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-x me-1"></i> Reset
                </a>
            @endif
        </form>
    </div>

    {{-- ─── TABLE ─── --}}
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th style="width:40px;">#</th>
                    <th>Anggota</th>
                    <th>Kontak</th>
                    <th>Buku Dipinjam</th>
                    <th style="width:100px; text-align:center;">Total Pinjam</th>
                    <th style="width:80px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $u)
                @php
                    $pinjamAktif = $u->peminjaman->whereIn('status', ['dipinjam', 'terlambat']);
                @endphp
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">{{ $loop->iteration }}</td>

                    {{-- Foto + Nama --}}
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            {{-- Avatar --}}
                            @if($u->foto)
                                <img src="{{ asset('storage/' . $u->foto) }}"
                                     style="width:40px;height:40px;border-radius:50%;object-fit:cover;
                                            border:2px solid #e2e8f0; flex-shrink:0;">
                            @else
                                <div style="width:40px;height:40px;border-radius:50%;
                                            background:linear-gradient(135deg,#4e73df,#224abe);
                                            color:#fff;font-size:14px;font-weight:700;
                                            display:flex;align-items:center;justify-content:center;
                                            flex-shrink:0;">
                                    {{ strtoupper(substr($u->name, 0, 2)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-size:13.5px;font-weight:600;color:#0f172a;">
                                    {{ $u->name }}
                                </div>
                                <div style="font-size:11px;color:#94a3b8;">
                                    Bergabung {{ $u->created_at->format('M Y') }}
                                </div>
                            </div>
                        </div>
                    </td>

                    {{-- Email --}}
                    <td>
                        <div style="font-size:13px;color:#475569;">{{ $u->email }}</div>
                    </td>

                    {{-- Buku sedang dipinjam --}}
                    <td>
                        @if($pinjamAktif->isEmpty())
                            <span style="font-size:12px;color:#94a3b8;">— Tidak ada</span>
                        @else
                            <div class="d-flex flex-column gap-1">
                                @foreach($pinjamAktif as $p)
                                @php
                                    $terlambat = \Carbon\Carbon::today()
                                        ->gt(\Carbon\Carbon::parse($p->tanggal_kembali));
                                @endphp
                                <div style="display:flex;align-items:center;gap:6px;">
                                    <i class="bi bi-book"
                                       style="font-size:11px;color:{{ $terlambat ? '#ef4444' : '#3b82f6' }};"></i>
                                    <span style="font-size:12.5px;color:#1e293b;">
                                        {{ $p->buku->judul }}
                                    </span>
                                    @if($terlambat)
                                        <span style="font-size:10px;background:#fee2e2;color:#991b1b;
                                                     padding:1px 6px;border-radius:10px;font-weight:600;">
                                            Terlambat
                                        </span>
                                    @else
                                        <span style="font-size:10px;color:#94a3b8;">
                                            s/d {{ \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M') }}
                                        </span>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        @endif
                    </td>

                    {{-- Total pinjam --}}
                    <td style="text-align:center;">
                        <span style="font-size:13px;font-weight:600;color:#4e73df;">
                            {{ $u->peminjaman->where('status', 'dipinjam')->count() }}
                        </span>
                        <span style="font-size:11px;color:#94a3b8;"> buku</span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <button type="button"
                                class="btn btn-outline-secondary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#modalAnggota"
                                data-id="{{ $u->id }}"
                                data-nama="{{ $u->name }}"
                                data-email="{{ $u->email }}"
                                data-foto="{{ $u->foto ? asset('storage/' . $u->foto) : '' }}"
                                data-bergabung="{{ $u->created_at->format('d M Y') }}"
                                data-total="{{ $u->peminjaman->count() }}"
                                data-aktif="{{ $pinjamAktif->count() }}"
                                data-pinjaman="{{ $pinjamAktif->map(fn($p) => [
                                    'judul'   => $p->buku->judul,
                                    'kembali' => \Carbon\Carbon::parse($p->tanggal_kembali)->format('d M Y'),
                                    'terlambat' => \Carbon\Carbon::today()->gt(\Carbon\Carbon::parse($p->tanggal_kembali)) ? '1' : '0',
                                ])->toJson() }}"
                                title="Lihat detail">
                            <i class="bi bi-eye"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5" style="color:#94a3b8; font-size:13px;">
                        <i class="bi bi-people d-block mb-2" style="font-size:24px;opacity:0.4;"></i>
                        Tidak ada data anggota
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(method_exists($users, 'hasPages') && $users->hasPages())
        <div style="padding:14px 18px; border-top:1px solid #f1f5f9;">
            {{ $users->appends(request()->query())->links() }}
        </div>
    @endif

</div>

{{-- ─── MODAL DETAIL ANGGOTA ─── --}}
<div class="modal fade" id="modalAnggota" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content" style="border-radius:14px;border:none;box-shadow:0 20px 60px rgba(0,0,0,0.12);">

            <div class="modal-header" style="border-bottom:1px solid #f1f5f9;padding:16px 20px;">
                <h6 class="modal-title fw-bold mb-0" style="color:#0f172a;font-size:14px;">
                    <i class="bi bi-person-circle me-2" style="color:#3b82f6;"></i>
                    Detail Anggota
                </h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="padding:20px;">

                {{-- Profil --}}
                <div class="d-flex align-items-center gap-3 mb-4 pb-3"
                     style="border-bottom:1px solid #f8fafc;">
                    <div id="modal-foto-wrap">
                        {{-- diisi JS --}}
                    </div>
                    <div>
                        <div style="font-size:15px;font-weight:700;color:#0f172a;" id="modal-nama">-</div>
                        <div style="font-size:12px;color:#64748b;" id="modal-email">-</div>
                        <div style="font-size:11px;color:#94a3b8;margin-top:2px;">
                            Bergabung <span id="modal-bergabung">-</span>
                        </div>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="d-flex gap-2 mb-4">
                    <div style="flex:1;background:#f8fafc;border-radius:8px;padding:10px 14px;text-align:center;">
                        <div style="font-size:20px;font-weight:700;color:#4e73df;" id="modal-total">0</div>
                        <div style="font-size:11px;color:#64748b;">Total Pinjam</div>
                    </div>
                    <div style="flex:1;background:#f8fafc;border-radius:8px;padding:10px 14px;text-align:center;">
                        <div style="font-size:20px;font-weight:700;color:#3b82f6;" id="modal-aktif">0</div>
                        <div style="font-size:11px;color:#64748b;">Sedang Dipinjam</div>
                    </div>
                </div>

                {{-- Buku aktif --}}
                <div>
                    <div class="section-label">Buku Sedang Dipinjam</div>
                    <div id="modal-daftar-buku">
                        <div style="font-size:13px;color:#94a3b8;text-align:center;padding:12px 0;">
                            Tidak ada buku dipinjam
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer" style="border-top:1px solid #f1f5f9;padding:12px 20px;">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('modalAnggota').addEventListener('show.bs.modal', function (e) {
        const btn      = e.relatedTarget;
        const nama     = btn.dataset.nama;
        const email    = btn.dataset.email;
        const foto     = btn.dataset.foto;
        const bergabung = btn.dataset.bergabung;
        const total    = btn.dataset.total;
        const aktif    = btn.dataset.aktif;
        const pinjaman = JSON.parse(btn.dataset.pinjaman || '[]');

        // Foto / inisial
        const fotoWrap = document.getElementById('modal-foto-wrap');
        if (foto) {
            fotoWrap.innerHTML = `<img src="${foto}"
                style="width:52px;height:52px;border-radius:50%;object-fit:cover;
                       border:2px solid #e2e8f0;flex-shrink:0;">`;
        } else {
            const inisial = nama.substring(0, 2).toUpperCase();
            fotoWrap.innerHTML = `<div style="width:52px;height:52px;border-radius:50%;
                background:linear-gradient(135deg,#4e73df,#224abe);color:#fff;
                font-size:16px;font-weight:700;display:flex;align-items:center;
                justify-content:center;flex-shrink:0;">${inisial}</div>`;
        }

        document.getElementById('modal-nama').textContent     = nama;
        document.getElementById('modal-email').textContent    = email;
        document.getElementById('modal-bergabung').textContent = bergabung;
        document.getElementById('modal-total').textContent    = total;
        document.getElementById('modal-aktif').textContent    = aktif;

        // Daftar buku
        const daftarEl = document.getElementById('modal-daftar-buku');
        if (pinjaman.length === 0) {
            daftarEl.innerHTML = `<div style="font-size:13px;color:#94a3b8;text-align:center;padding:12px 0;">
                Tidak ada buku sedang dipinjam
            </div>`;
        } else {
            daftarEl.innerHTML = pinjaman.map(p => `
                <div style="display:flex;align-items:center;justify-content:space-between;
                            padding:9px 12px;border-radius:8px;background:#f8fafc;margin-bottom:6px;">
                    <div style="display:flex;align-items:center;gap:8px;">
                        <i class="bi bi-book" style="color:${p.terlambat === '1' ? '#ef4444' : '#3b82f6'};font-size:13px;"></i>
                        <span style="font-size:13px;color:#1e293b;font-weight:500;">${p.judul}</span>
                    </div>
                    ${p.terlambat === '1'
                        ? `<span style="font-size:10px;background:#fee2e2;color:#991b1b;
                                        padding:2px 8px;border-radius:10px;font-weight:600;">Terlambat</span>`
                        : `<span style="font-size:11px;color:#94a3b8;">s/d ${p.kembali}</span>`
                    }
                </div>
            `).join('');
        }
    });
});
</script>
@endpush
