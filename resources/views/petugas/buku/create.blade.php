@extends('petugas.layouts')

@section('title', 'Tambah Buku')

@section('content')

<style>
    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-hover: #1d4ed8;
        --danger: #ef4444;
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
        background: var(--primary-light);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    .page-title .icon-wrap i { color: var(--primary); font-size: 16px; }

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

    /* ROW 2-COL */
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

    /* COVER UPLOAD */
    .cover-upload-area {
        border: 2px dashed var(--border);
        border-radius: 12px;
        padding: 24px 16px;
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
        width: 56px; height: 56px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 12px;
    }

    .cover-placeholder-icon i { font-size: 22px; color: #94a3b8; }

    .cover-upload-text { font-size: 13px; color: var(--text-muted); line-height: 1.5; }
    .cover-upload-text strong { color: var(--primary); font-weight: 600; }
    .cover-upload-text small { display: block; margin-top: 4px; font-size: 11.5px; }

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
        background: var(--primary);
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
        transition: background 0.18s, transform 0.15s;
        box-shadow: 0 2px 8px rgba(37,99,235,0.18);
    }

    .btn-submit:hover {
        background: var(--primary-hover);
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
    <span>Tambah Buku</span>
</div>

<h1 class="page-title">
    <span class="icon-wrap"><i class="fa-solid fa-plus"></i></span>
    Tambah Buku Baru
</h1>

<form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

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
                        <input type="text" name="judul" value="{{ old('judul') }}"
                               class="form-control @error('judul') is-invalid @enderror"
                               placeholder="Masukkan judul buku...">
                        @error('judul')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label class="form-label">Penulis <span class="req">*</span></label>
                            <input type="text" name="penulis" value="{{ old('penulis') }}"
                                   class="form-control @error('penulis') is-invalid @enderror"
                                   placeholder="Nama penulis...">
                            @error('penulis')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Penerbit</label>
                            <input type="text" name="penerbit" value="{{ old('penerbit') }}"
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
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id }}" {{ old('kategori_id') == $kat->id ? 'selected' : '' }}>
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
                        <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                  placeholder="Ringkasan isi buku...">{{ old('deskripsi') }}</textarea>
                        @error('deskripsi')
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
                            <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}"
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
                                <option value="Indonesia" {{ old('bahasa') == 'Indonesia' ? 'selected' : '' }}>Indonesia</option>
                                <option value="Inggris" {{ old('bahasa') == 'Inggris' ? 'selected' : '' }}>Inggris</option>
                                <option value="Arab" {{ old('bahasa') == 'Arab' ? 'selected' : '' }}>Arab</option>
                                <option value="Lainnya" {{ old('bahasa') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                            @error('bahasa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Jumlah Halaman</label>
                            <input type="number" name="jumlah_halaman" value="{{ old('jumlah_halaman') }}"
                                   class="form-control @error('jumlah_halaman') is-invalid @enderror"
                                   placeholder="0" min="1">
                            @error('jumlah_halaman')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="row-2">
                        <div class="form-group">
                            <label class="form-label">ISBN</label>
                            <input type="text" name="isbn" value="{{ old('isbn') }}"
                                   class="form-control @error('isbn') is-invalid @enderror"
                                   placeholder="978-xxx-xxx-xxx-x">
                            @error('isbn')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label">Stok <span class="req">*</span></label>
                            <input type="number" name="stok" value="{{ old('stok', 1) }}"
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
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Buku
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

                    <!-- PREVIEW -->
                    <div id="previewWrap" style="display:none; margin-bottom: 12px;">
                        <img id="previewImg" src="" alt="Preview Cover" class="cover-preview-img">
                    </div>

                    <!-- UPLOAD AREA -->
                    <div class="cover-upload-area" id="uploadArea">
                        <input type="file" name="gambar" id="gambarInput"
                               accept="image/jpeg,image/png,image/webp"
                               onchange="previewCover(this)">

                        <div id="uploadPlaceholder">
                            <div class="cover-placeholder-icon">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                            <div class="cover-upload-text">
                                <strong>Klik untuk unggah</strong> atau drag & drop<br>
                                gambar ke sini
                                <small>PNG, JPG, WEBP · Maks. 2 MB</small>
                            </div>
                        </div>

                        <div id="uploadReplace" style="display:none;">
                            <div class="cover-upload-text" style="color: var(--primary);">
                                <i class="fa-solid fa-arrows-rotate"></i>
                                <strong> Ganti foto</strong>
                                <small style="color: var(--text-muted);">Klik untuk memilih foto baru</small>
                            </div>
                        </div>
                    </div>

                    @error('gambar')
                        <span class="invalid-feedback" style="display:block; margin-top:6px;">{{ $message }}</span>
                    @enderror

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
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewWrap').style.display = 'block';
            document.getElementById('uploadPlaceholder').style.display = 'none';
            document.getElementById('uploadReplace').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection