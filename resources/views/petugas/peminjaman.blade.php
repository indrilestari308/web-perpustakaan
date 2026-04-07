@extends('petugas.layouts')

@section('title', 'Manajemen Peminjaman')

@section('content')

<div class="d-flex align-items-center justify-content-between mb-4">
    <div>
        <p class="mb-0" style="font-size:13px; color:#64748b;">
            Konfirmasi peminjaman, pengembalian, dan riwayat anggota
        </p>
    </div>
</div>

<div class="card" style="border-radius:12px; overflow:hidden;">

    {{-- ─── TABS ─── --}}
    <div class="nav-tabs-custom">
        @foreach([
            ['tab' => 'menunggu',     'label' => 'Menunggu Konfirmasi', 'count' => $jumlahMenunggu,  'cls' => 'tab-count-warning'],
            ['tab' => 'dipinjam',     'label' => 'Sedang Dipinjam',     'count' => $jumlahDipinjam,  'cls' => 'tab-count-info'],
            ['tab' => 'terlambat',    'label' => 'Terlambat',           'count' => $jumlahTerlambat, 'cls' => 'tab-count-danger'],
            ['tab' => 'dikembalikan', 'label' => 'Selesai',             'count' => $jumlahSelesai,   'cls' => 'tab-count-success'],
        ] as $t)
        <a href="{{ request()->fullUrlWithQuery(['tab' => $t['tab'], 'page' => 1]) }}"
           class="nav-link {{ $activeTab === $t['tab'] ? 'active' : '' }}">
            {{ $t['label'] }}
            <span class="tab-count {{ $t['cls'] }}">{{ $t['count'] }}</span>
        </a>
        @endforeach
    </div>

    {{-- ─── FILTER ─── --}}
    <div class="card-header" style="border-radius:0; padding:12px 18px;">
        <form method="GET" action="{{ route('petugas.peminjaman') }}"
              class="d-flex gap-2 align-items-center flex-wrap">
            <input type="hidden" name="tab" value="{{ $activeTab }}">

            <div class="input-group" style="max-width:240px;">
                <span class="input-group-text bg-white" style="border-color:#e2e8f0;">
                    <i class="bi bi-search" style="font-size:12px; color:#94a3b8;"></i>
                </span>
                <input type="text" name="search" class="form-control"
                       placeholder="Cari anggota / buku..."
                       value="{{ request('search') }}"
                       style="border-left:none;">
            </div>

            <input type="date" name="tanggal" class="form-control" style="max-width:160px;"
                   value="{{ request('tanggal') }}">

            <button type="submit" class="btn btn-primary btn-sm px-3">
                <i class="bi bi-funnel me-1"></i> Filter
            </button>

            @if(request('search') || request('tanggal'))
                <a href="{{ route('petugas.peminjaman', ['tab' => $activeTab]) }}"
                   class="btn btn-outline-secondary btn-sm">
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
                    <th style="width:40px;">No</th>
                    <th>Anggota</th>
                    <th>Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    @if($activeTab === 'dikembalikan')
                        <th>Tgl Dikembalikan</th>
                        <th>Denda</th>
                    @endif
                    @if($activeTab === 'terlambat')
                        <th>Keterlambatan</th>
                        <th>Est. Denda</th>
                    @endif
                    <th>Status</th>
                    <th style="width:170px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                <tr>
                    <td style="color:#94a3b8; font-size:12px;">
                        {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                    </td>

                    {{-- Anggota --}}
                    <td>
                        <div style="font-size:13.5px; font-weight:500;">
                            {{ $item->user->name }}
                        </div>
                        <div style="font-size:11px; color:#94a3b8;">
                            {{ $item->user->email }}
                        </div>
                    </td>

                    {{-- Buku --}}
                    <td>
                        <div style="font-size:13.5px;">{{ $item->buku->judul }}</div>
                        <div style="font-size:11px; color:#94a3b8;">
                            {{ $item->buku->kategori->nama ?? '-' }}
                        </div>
                    </td>

                    {{-- Tgl Pinjam --}}
                    <td style="font-size:13px;">
                        {{ $item->tanggal_pinjam
                            ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y')
                            : '-' }}
                    </td>

                    {{-- Tgl Kembali --}}
                    <td style="font-size:13px;">
                        {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}
                    </td>

                    {{-- Kolom tambahan: Selesai --}}
                    @if($activeTab === 'dikembalikan')
                        <td style="font-size:13px;">
                            {{ $item->tanggal_dikembalikan
                                ? \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y')
                                : '-' }}
                        </td>
                        <td style="font-size:13px;">
                            @if($item->denda > 0)
                                <span style="color:#ef4444; font-weight:600;">
                                    Rp {{ number_format($item->denda, 0, ',', '.') }}
                                </span>
                            @else
                                <span style="color:#22c55e;">-</span>
                            @endif
                        </td>
                    @endif

                    {{-- Kolom tambahan: Terlambat --}}
                    @if($activeTab === 'terlambat')
                        @php
                            $hariTerlambat = \Carbon\Carbon::today()
                                ->diffInDays(\Carbon\Carbon::parse($item->tanggal_kembali));
                            $estDenda = $hariTerlambat * 1000;
                        @endphp
                        <td>
                            <span style="font-size:13px; color:#ef4444; font-weight:600;">
                                {{ $hariTerlambat }} hari
                            </span>
                        </td>
                        <td>
                            <span style="font-size:13px; color:#ef4444; font-weight:600;">
                                Rp {{ number_format($estDenda, 0, ',', '.') }}
                            </span>
                        </td>
                    @endif

                    {{-- Status Badge --}}
                    <td>
                        @php
                            $badgeMap = [
                                'menunggu'     => ['badge-menunggu',     'Menunggu'],
                                'dipinjam'     => ['badge-dipinjam',     'Dipinjam'],
                                'terlambat'    => ['badge-terlambat',    'Terlambat'],
                                'dikembalikan' => ['badge-dikembalikan', 'Dikembalikan'],
                                'ditolak'      => ['badge-terlambat',    'Ditolak'],
                            ];
                            [$badgeCls, $badgeLabel] = $badgeMap[$item->status] ?? ['badge-dipinjam', $item->status];
                        @endphp
                        <span class="badge-status {{ $badgeCls }}">{{ $badgeLabel }}</span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="d-flex gap-1 align-items-center flex-wrap">

                            @if($item->status === 'menunggu')
                                {{-- Setujui --}}
                                <form action="{{ route('peminjaman.konfirmasi', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm"
                                            onclick="return confirm('Setujui peminjaman ini?')">
                                        <i class="bi bi-check-lg"></i> Setujui
                                    </button>
                                </form>
                                {{-- Tolak --}}
                                <form action="{{ route('peminjaman.tolak', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-secondary btn-sm"
                                            onclick="return confirm('Tolak peminjaman ini?')"
                                            title="Tolak">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </form>

                            @elseif(in_array($item->status, ['dipinjam', 'terlambat']))
                                {{-- Kembalikan --}}
                                <form action="{{ route('peminjaman.kembalikan', $item->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm"
                                            onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                                        <i class="bi bi-arrow-return-left me-1"></i> Kembalikan
                                    </button>
                                </form>
                            @endif

                            {{-- Tombol Detail --}}
                            <button type="button"
                                    class="btn btn-outline-secondary btn-sm"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalDetail"
                                    title="Lihat detail"
                                    data-nama="{{ $item->user->name }}"
                                    data-email="{{ $item->user->email }}"
                                    data-buku="{{ $item->buku->judul }}"
                                    data-isbn="{{ $item->buku->isbn ?? '-' }}"
                                    data-kategori="{{ $item->buku->kategori->nama ?? '-' }}"
                                    data-pinjam="{{ $item->tanggal_pinjam ? \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d M Y') : '-' }}"
                                    data-kembali="{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}"
                                    data-dikembalikan="{{ $item->tanggal_dikembalikan ? \Carbon\Carbon::parse($item->tanggal_dikembalikan)->format('d M Y') : '-' }}"
                                    data-status="{{ $item->status }}"
                                    data-denda="{{ $item->denda > 0 ? 'Rp ' . number_format($item->denda, 0, ',', '.') : '-' }}"
                                    data-catatan="{{ $item->catatan ?? '-' }}">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-5" style="color:#94a3b8; font-size:13px;">
                        <i class="bi bi-inbox fa-2x mb-2 d-block" style="opacity:0.4;"></i>
                        Tidak ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($peminjaman->hasPages())
        <div style="padding:14px 18px; border-top:1px solid #f1f5f9;">
            {{ $peminjaman->appends(request()->query())->links() }}
        </div>
    @endif

</div>

{{-- ─── MODAL DETAIL ─── --}}
<div class="modal fade" id="modalDetail" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered" style="max-width:460px;">
        <div class="modal-content" style="border-radius:14px; border:none; box-shadow:0 20px 60px rgba(0,0,0,0.12);">

            <div class="modal-header" style="border-bottom:1px solid #f1f5f9; padding:16px 20px;">
                <h6 class="modal-title fw-bold mb-0" style="color:#0f172a; font-size:14px;">
                    <i class="bi bi-file-text me-2" style="color:#3b82f6;"></i>
                    Detail Peminjaman
                </h6>
                <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body" style="padding:20px;">

                {{-- Info Anggota --}}
                <div class="mb-3 pb-3" style="border-bottom:1px solid #f8fafc;">
                    <div class="section-label">Informasi Anggota</div>
                    <div class="d-flex align-items-center gap-3">
                        <div id="modal-avatar"
                             style="width:42px;height:42px;border-radius:50%;background:#dbeafe;color:#1e40af;
                                    font-size:14px;font-weight:700;display:flex;align-items:center;justify-content:center;
                                    flex-shrink:0;">
                            ?
                        </div>
                        <div>
                            <div style="font-size:14px;font-weight:600;color:#0f172a;" id="modal-nama">-</div>
                            <div style="font-size:12px;color:#64748b;" id="modal-email">-</div>
                        </div>
                    </div>
                </div>

                {{-- Info Buku --}}
                <div class="mb-3 pb-3" style="border-bottom:1px solid #f8fafc;">
                    <div class="section-label">Informasi Buku</div>
                    <table style="width:100%;font-size:13px;border-collapse:collapse;">
                        <tr>
                            <td style="color:#64748b;padding:3px 0;width:110px;">Judul</td>
                            <td style="color:#0f172a;font-weight:500;" id="modal-buku">-</td>
                        </tr>
                        <tr>
                            <td style="color:#64748b;padding:3px 0;">ISBN</td>
                            <td style="color:#0f172a;" id="modal-isbn">-</td>
                        </tr>
                        <tr>
                            <td style="color:#64748b;padding:3px 0;">Kategori</td>
                            <td style="color:#0f172a;" id="modal-kategori">-</td>
                        </tr>
                    </table>
                </div>

                {{-- Jadwal --}}
                <div class="mb-3 pb-3" style="border-bottom:1px solid #f8fafc;">
                    <div class="section-label">Jadwal Peminjaman</div>
                    <div class="d-flex gap-2">
                        <div style="flex:1;background:#f8fafc;border-radius:8px;padding:10px 12px;">
                            <div style="font-size:11px;color:#64748b;margin-bottom:2px;">Tgl Pinjam</div>
                            <div style="font-size:13px;font-weight:600;color:#0f172a;" id="modal-pinjam">-</div>
                        </div>
                        <div style="flex:1;background:#f8fafc;border-radius:8px;padding:10px 12px;">
                            <div style="font-size:11px;color:#64748b;margin-bottom:2px;">Tgl Kembali</div>
                            <div style="font-size:13px;font-weight:600;color:#0f172a;" id="modal-kembali">-</div>
                        </div>
                        <div style="flex:1;background:#f8fafc;border-radius:8px;padding:10px 12px;" id="wrap-dikembalikan">
                            <div style="font-size:11px;color:#64748b;margin-bottom:2px;">Dikembalikan</div>
                            <div style="font-size:13px;font-weight:600;color:#22c55e;" id="modal-dikembalikan">-</div>
                        </div>
                    </div>
                </div>

                {{-- Status & Denda --}}
                <div>
                    <div class="section-label">Status & Denda</div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div id="modal-status-wrap"></div>
                        <div id="modal-denda-wrap" style="font-size:13px;font-weight:600;color:#ef4444;"></div>
                    </div>
                    <div style="font-size:12px;color:#64748b;background:#f8fafc;border-radius:8px;padding:10px 12px;margin-top:10px;"
                         id="modal-catatan">-</div>
                </div>

            </div>

            <div class="modal-footer" style="border-top:1px solid #f1f5f9; padding:12px 20px;">
                <button type="button" class="btn btn-outline-secondary btn-sm" data-bs-dismiss="modal">
                    Tutup
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .section-label {
        font-size: 10.5px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.07em;
        color: #94a3b8;
        margin-bottom: 10px;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modalEl = document.getElementById('modalDetail');

    modalEl.addEventListener('show.bs.modal', function (e) {
        const btn = e.relatedTarget;

        const nama        = btn.dataset.nama;
        const email       = btn.dataset.email;
        const buku        = btn.dataset.buku;
        const isbn        = btn.dataset.isbn;
        const kategori    = btn.dataset.kategori;
        const pinjam      = btn.dataset.pinjam;
        const kembali     = btn.dataset.kembali;
        const dikembalikan = btn.dataset.dikembalikan;
        const status      = btn.dataset.status;
        const denda       = btn.dataset.denda;
        const catatan     = btn.dataset.catatan;

        // Isi data
        document.getElementById('modal-avatar').textContent  = nama.substring(0, 2).toUpperCase();
        document.getElementById('modal-nama').textContent    = nama;
        document.getElementById('modal-email').textContent   = email;
        document.getElementById('modal-buku').textContent    = buku;
        document.getElementById('modal-isbn').textContent    = isbn;
        document.getElementById('modal-kategori').textContent = kategori;
        document.getElementById('modal-pinjam').textContent  = pinjam;
        document.getElementById('modal-kembali').textContent = kembali;
        document.getElementById('modal-dikembalikan').textContent = dikembalikan;
        document.getElementById('modal-catatan').textContent = catatan === '-' ? 'Tidak ada catatan' : catatan;

        // Sembunyikan kolom dikembalikan kalau belum
        document.getElementById('wrap-dikembalikan').style.display =
            dikembalikan === '-' ? 'none' : 'block';

        // Badge status
        const statusMap = {
            'menunggu':     ['badge-menunggu',     'Menunggu Konfirmasi'],
            'dipinjam':     ['badge-dipinjam',     'Sedang Dipinjam'],
            'terlambat':    ['badge-terlambat',    'Terlambat'],
            'dikembalikan': ['badge-dikembalikan', 'Sudah Dikembalikan'],
            'ditolak':      ['badge-terlambat',    'Ditolak'],
        };
        const [cls, label] = statusMap[status] ?? ['badge-dipinjam', status];
        document.getElementById('modal-status-wrap').innerHTML =
            `<span class="badge-status ${cls}">${label}</span>`;

        // Denda
        const dendaWrap = document.getElementById('modal-denda-wrap');
        dendaWrap.textContent = denda !== '-' ? `Denda: ${denda}` : '';
    });
});
</script>
@endpush
