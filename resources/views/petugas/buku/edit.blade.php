@extends('petugas.layouts')

@section('title', 'Edit Buku')

@section('content')

<style>
    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-hover: #1d4ed8;
        --danger: #ef4444;
        --warning: #f59e0b;
        --warning-light: #fffbeb;
        --text-main: #111827;
        --text-muted: #6b7280;
        --border: #e5e7eb;
        --bg-page: #f8fafc;
        --bg-card: #ffffff;
        --radius: 14px;
        --shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.06);
    }

    body { background: var(--bg-page); }

    /* BREADCRUMB */
    .breadcrumb-bar {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: var(--text-muted);
        margin-bottom: 20px;
    }

    .breadcrumb-bar a {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-bar a:hover { text-decoration: underline; }
    .breadcrumb-bar i { font-size: 10px; }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 24px;
    }

    .page-title .icon-wrap {
        width: 38px; height: 38px;
        background: #fff7ed;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    .page-title .icon-wrap i { color: var(--warning); font-size: 16px; }

    /* LAYOUT GRID */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 20px;
        align-items: start;
    }

    @media (max-width: 900px) {
        .form-grid { grid-template-columns: 1fr; }
        .form-col-cover { order: -1; }
    }

    /* CARD */
    .card-section {
        background: var(--bg-card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
    }

    .card-section-header {
        padding: 16px 20px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-section-header .section-icon {
        width: 30px; height: 30px;
        background: var(--primary-light);
        border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
    }

    .card-section-header .section-icon i { color: var(--primary); font-size: 13px; }

    .card-section-header h6 {
        font-size: 14px;
        font-weight: 700;
        color: var(--text-main);
        margin: 0;
    }

    .card-section-body { padding: 20px; }

    /* FORM ELEMENTS */
    .form-group { margin-bottom: 16px; }
    .form-group:last-child { margin-bottom: 0; }

    .form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .form-label .req { color: var(--danger); margin-left: 2px; }

    .form-control, .form-select {
        width: 100%;
        padding: 9px 13px;
        border: 1.5px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        color: var(--text-main);
        background: #fff;
        transition: border 0.18s, box-shadow 0.18s;
        outline: none;
        box-sizing: border-box;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger);
    }

    .invalid-feedback {
        display: block;
        font-size: 11.5px;
        color: var(--danger);
        margin-top: 4px;
    }

    textarea.form-control { resize: vertical; min-height: 90px; }

    /* ROW */
    .row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 14px;
    }

    @media (max-width: 600px) {
        .row-2, .row-3 { grid-template-columns: 1fr; }
    }

    /* COVER */
    .current-cover-wrap {
        position: relative;
        margin-bottom: 14px;
    }

    .current-cover-img {
        width: 100%;
        max-height: 260px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        border: 1.5px solid var(--border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .cover-label {
        position: absolute;
        top: 8px;
        left: 8px;
        background: rgba(0,0,0,0.55);
        color: #fff;
        font-size: 10.5px;
        font-weight: 600;
        padding: 3px 9px;
        border-radius: 20px;
        letter-spacing: 0.03em;
    }

    .cover-upload-area {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 20px 16px;
        text-align: center;
        cursor: pointer;
        transition: border 0.18s, background 0.18s;
        position: relative;
        background: #fafafa;
    }

    .cover-upload-area:hover {
        border-color: var(--primary);
        background: var(--primary-light);
    }

    .cover-upload-area input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }

    .cover-preview-img {
        width: 100%;
        max-height: 260px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        margin-bottom: 12px;
        border: 1.5px solid var(--border);
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }

    .cover-placeholder-icon {
        width: 44px; height: 44px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 10px;
    }

    .cover-placeholder-icon i { font-size: 18px; color: #94a3b8; }

    .cover-upload-text { font-size: 13px; color: var(--text-muted); line-height: 1.5; }
    .cover-upload-text strong { color: var(--primary); font-weight: 600; }
    .cover-upload-text small { display: block; margin-top: 4px; font-size: 11.5px; }

    /* EDIT NOTICE */
    .edit-notice {
        display: flex;
        align-items: center;
        gap: 8px;
        background: var(--warning-light);
        border: 1px solid #fcd34d;
        color: #92400e;
        font-size: 12px;
        font-weight: 500;
        padding: 9px 14px;
        border-radius: 9px;
        margin-bottom: 18px;
    }

    /* BUTTONS */
    .form-actions {
        display: flex;
        gap: 10px;
        padding-top: 4px;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: var(--warning);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.18s, transform 0.15s;
        box-shadow: 0 2px 8px rgba(245,158,11,0.22);
    }

    .btn-submit:hover {
        background: #d97706;
        transform: translateY(-1px);
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 600;
        padding: 10px 20px;
        border-radius: 10px;
        border: 1.5px solid var(--border);
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s, color 0.15s;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: var(--text-main);
        text-decoration: none;
    }
</style>

<!-- BREADCRUMB -->
<div class="breadcrumb-bar">
    <a href="{{ route('buku.index') }}"><i class="fa-solid fa-book-open"></i> Data Buku</a>
    <i class="fa-solid fa-chevron-right"></i>
    <span>Edit Buku</span>
</div>

<h1 class="page-title">
    <span class="icon-wrap"><i class="fa-solid fa-pen"></i></span>
    Edit Buku
</h1>

<!-- NOTICE -->
<div class="edit-notice">
    <i class="fa-solid fa-triangle-exclamation"></i>
    Anda sedang mengedit data buku: <strong>&nbsp;{{ $buku->judul }}</strong>
</div>

<form action="{{ route('buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="form-grid">

        <!-- ======================== KOLOM KIRI ======================== -->
        <div>

            <!-- INFO UTAMA -->
            <div class="card-section" style="margin-bottom: 20px;">
                <div class="card-section-header">
                    <div class="section-icon"><i class="fa-solid fa-circle-info"></i></div>
                    <h6>Informasi Utama</h6>
                </div>
                <div class="card-section-body">

                    <div class="form-group">
                        <label class="form-label">Judul Buku <span class="req">*</span></label>
                        <input type="text" name="judul" value="{{ old('judul', $buku->judul) }}"
                               class="form-control @error('judul') is-invalid @enderror"
                               placeholder="Masukkan judul buku...">
                        @error('judul')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label class="form-label">Penulis <span class="req">*</span></label>
                            <input type="text" name="penulis" value="{{ old('penulis', $buku->penulis) }}"
                                   class="form-control @error('penulis') is-invalid @enderror"
                                   placeholder="Nama penulis...">
                            @error('penulis')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit', $buku->penerbit) }}"
                                   class="form-control @error('penerbit') is-invalid @enderror"
                                   placeholder="Nama penerbit...">
                            @error('penerbit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kategori</label>
                        <select name="kategori_id" class="form-select @error('kategori_id') is-invalid @enderror">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategori as $kat)
                                <option value="{{ $kat->id }}"
                                    {{ old('kategori_id', $buku->kategori_id) == $kat->id ? 'selected' : '' }}>
                                    {{ $kat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Deskripsi / Sinopsis</label>
                        <textarea name="sinopsis" class="form-control @error('sinopsis') is-invalid @enderror"
                                  placeholder="Ringkasan isi buku...">{{ old('sinopsis', $buku->sinopsis) }}</textarea>
                        @error('sinopsis')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
            </div>

            <!-- DETAIL BUKU -->
            <div class="card-section" style="margin-bottom: 20px;">
                <div class="card-section-header">
                    <div class="section-icon"><i class="fa-solid fa-list-ul"></i></div>
                    <h6>Detail Buku</h6>
                </div>
                <div class="card-section-body">

                    <div class="row-3">
                        <div class="form-group">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun_terbit"
                                   value="{{ old('tahun_terbit', $buku->tahun_terbit) }}"
                                   class="form-control @error('tahun_terbit') is-invalid @enderror"
                                   placeholder="2024" min="1900" max="{{ date('Y') }}">
                            @error('tahun_terbit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Bahasa</label>
                            <select name="bahasa" class="form-select @error('bahasa') is-invalid @enderror">
                                <option value="">-- Pilih --</option>
                                @foreach(['Indonesia','Inggris','Arab','Lainnya'] as $lang)
                                    <option value="{{ $lang }}"
                                        {{ old('bahasa', $buku->bahasa) == $lang ? 'selected' : '' }}>
                                        {{ $lang }}
                                    </option>
                                @endforeach
                            </select>
                            @error('bahasa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Halaman</label>
                            <input type="number" name="jumlah_halaman"
                                   value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}"
                                   class="form-control @error('jumlah_halaman') is-invalid @enderror"
                                   placeholder="0" min="1">
                            @error('jumlah_halaman')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label class="form-label">Stok <span class="req">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', $buku->stok) }}"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   placeholder="0" min="0">
                            @error('stok')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>
            </div>

            <!-- TOMBOL AKSI -->
            <div class="form-actions">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                </button>
                <a href="{{ route('buku.index') }}" class="btn-cancel">
                    <i class="fa-solid fa-xmark"></i> Batal
                </a>
            </div>

        </div>

        <!-- ======================== KOLOM KANAN – COVER ======================== -->
        <div class="form-col-cover">
            <div class="card-section">
                <div class="card-section-header">
                    <div class="section-icon"><i class="fa-solid fa-image"></i></div>
                    <h6>Cover Buku</h6>
                </div>
                <div class="card-section-body">

                    <!-- COVER SAAT INI -->
                    @if($buku->gambar)
                        <div class="current-cover-wrap" id="currentCoverWrap">
                            <img src="{{ asset('storage/' . $buku->gambar) }}"
                                 alt="Cover {{ $buku->judul }}"
                                 class="current-cover-img" id="currentCoverImg">
                            <span class="cover-label">Cover saat ini</span>
                        </div>
                    @endif

                    <!-- NEW PREVIEW (hidden by default) -->
                    <div id="newPreviewWrap" style="display:none; margin-bottom: 12px;">
                        <img id="newPreviewImg" src="" alt="Cover Baru" class="cover-preview-img">
                        <span style="display:block; font-size:11.5px; color:var(--primary); font-weight:600; text-align:center; margin-top:4px;">
                            <i class="fa-solid fa-check-circle"></i> Cover baru dipilih
                        </span>
                    </div>

                    <!-- UPLOAD AREA -->
                    <div class="cover-upload-area">
                        <input type="file" name="gambar" id="gambarInput"
                               accept="image/jpeg,image/png,image/webp"
                               onchange="previewCover(this)">

                        <div id="uploadPlaceholder">
                            <div class="cover-placeholder-icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div class="cover-upload-text">
                                @if($buku->gambar)
                                    <strong>Ganti cover</strong> atau drag & drop
                                @else
                                    <strong>Unggah cover</strong> atau drag & drop
                                @endif
                                <small>PNG, JPG, WEBP · Maks. 2 MB</small>
                            </div>
                        </div>

                        <div id="uploadReplace" style="display:none;">
                            <div class="cover-upload-text" style="color: var(--primary);">
                                <i class="fa-solid fa-arrows-rotate"></i>
                                <strong> Pilih lagi</strong>
                                <small style="color: var(--text-muted);">Klik untuk foto lain</small>
                            </div>
                        </div>
                    </div>

                    @error('gambar')
                        <span class="invalid-feedback" style="display:block; margin-top:6px;">{{ $message }}</span>
                    @enderror

                    @if($buku->gambar)
                        <p style="font-size: 11.5px; color: var(--text-muted); margin-top: 10px; text-align:center;">
                            Biarkan kosong jika tidak ingin mengganti cover.
                        </p>
                    @endif

                </div>
            </div>
        </div>

    </div>

</form>

<script>
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('newPreviewImg').src = e.target.result;
            document.getElementById('newPreviewWrap').style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
            document.getElementById('uploadReplace').style.display = 'block';

            const cur = document.getElementById('currentCoverWrap');
            if (cur) cur.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection