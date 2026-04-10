@extends('kepala.layouts')

@section('title', 'Tambah Petugas')

@section('content')

<style>
    :root {
        --primary: #2563eb;
        --primary-light: #eff6ff;
        --primary-hover: #1d4ed8;
        --danger: #ef4444;
        --danger-light: #fef2f2;
        --success: #22c55e;
        --success-light: #f0fdf4;
        --text-main: #111827;
        --text-muted: #6b7280;
        --border: #e5e7eb;
        --bg-page: #f8fafc;
        --bg-card: #ffffff;
        --radius: 14px;
        --shadow: 0 1px 3px rgba(0,0,0,0.07), 0 4px 16px rgba(0,0,0,0.06);
    }

    body { background: var(--bg-page); }

    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-title {
        font-size: 20px;
        font-weight: 700;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0;
    }

    .page-title .icon-wrap {
        width: 38px; height: 38px;
        background: var(--primary-light);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
    }

    .page-title .icon-wrap i { color: var(--primary); font-size: 18px; }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #fff;
        color: var(--text-muted);
        font-size: 13px;
        font-weight: 600;
        padding: 9px 16px;
        border-radius: 10px;
        text-decoration: none;
        border: 1px solid var(--border);
        transition: all 0.15s;
    }

    .btn-back:hover {
        background: #f8fafc;
        color: var(--text-main);
        border-color: #d1d5db;
        text-decoration: none;
    }

    .card-box {
        background: var(--bg-card);
        border-radius: var(--radius);
        box-shadow: var(--shadow);
        overflow: hidden;
        max-width: 900px;
        margin: 0 auto;
    }

    .card-header-section {
        padding: 18px 24px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .card-header-section i {
        color: var(--primary);
        font-size: 16px;
    }

    .card-header-section span {
        font-size: 14px;
        font-weight: 600;
        color: var(--text-main);
    }

    .card-body-section {
        padding: 28px 32px;
    }

    .form-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
    }

    .form-grid .col-full { grid-column: 1 / -1; }

    .form-group { display: flex; flex-direction: column; gap: 6px; }

    .form-label {
        font-size: 12.5px;
        font-weight: 600;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .form-label .required {
        color: var(--danger);
        font-size: 13px;
    }

    .form-control {
        padding: 9px 13px;
        border: 1px solid var(--border);
        border-radius: 9px;
        font-size: 13px;
        color: var(--text-main);
        background: var(--bg-page);
        outline: none;
        transition: border 0.18s, box-shadow 0.18s;
        width: 100%;
        box-sizing: border-box;
    }

    .form-control:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(37,99,235,0.10);
        background: #fff;
    }

    .form-control.is-invalid {
        border-color: var(--danger);
        box-shadow: 0 0 0 3px rgba(239,68,68,0.09);
    }

    .invalid-feedback {
        font-size: 11.5px;
        color: var(--danger);
        display: flex;
        align-items: center;
        gap: 4px;
        margin-top: 2px;
    }

    .input-hint {
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    .input-wrap {
        position: relative;
    }

    .input-wrap .form-control {
        padding-right: 40px;
    }

    .toggle-pw {
        position: absolute;
        right: 12px; top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        font-size: 15px;
        padding: 0;
        line-height: 1;
        transition: color 0.15s;
    }

    .toggle-pw:hover { color: var(--primary); }

    .form-divider {
        border: none;
        border-top: 1px solid var(--border);
        margin: 6px 0 20px;
    }

    .section-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        color: var(--text-muted);
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
        margin-bottom: 16px;
    }

    .section-label::after {
        content: '';
        flex: 1;
        height: 1px;
        background: var(--border);
    }

    .form-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        padding: 16px 24px;
        border-top: 1px solid var(--border);
        background: #fafbfc;
    }

    .btn-cancel {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        border: 1px solid var(--border);
        background: #fff;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        text-decoration: none;
        transition: all 0.15s;
    }

    .btn-cancel:hover {
        background: #f1f5f9;
        color: var(--text-main);
        text-decoration: none;
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 9px 22px;
        background: var(--primary);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(37,99,235,0.18);
        transition: background 0.18s, transform 0.15s;
    }

    .btn-submit:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    .alert-danger-custom {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        background: var(--danger-light);
        border: 1px solid #fecaca;
        color: #991b1b;
        font-size: 13px;
        font-weight: 500;
        padding: 12px 16px;
        border-radius: 10px;
        margin-bottom: 20px;
    }

    .alert-danger-custom ul {
        margin: 4px 0 0;
        padding-left: 16px;
        font-weight: 400;
        font-size: 12.5px;
    }

    @media (max-width: 768px) {
        .card-box { max-width: 100%; }
        .card-body-section { padding: 20px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-grid .col-full { grid-column: 1; }
    }
</style>

<!-- HEADER -->
<div class="page-header">
    <h1 class="page-title">
        <span class="icon-wrap"><i class="bi bi-person-plus"></i></span>
        Tambah Petugas
    </h1>
    <a href="{{ route('kepala.petugas.index') }}" class="btn-back">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- VALIDATION ERRORS -->
@if($errors->any())
    <div class="alert-danger-custom">
        <i class="bi bi-exclamation-circle-fill" style="margin-top:1px;flex-shrink:0;"></i>
        <div>
            <strong>Terdapat beberapa kesalahan:</strong>
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<!-- FORM CARD -->
<form action="{{ route('kepala.petugas.store') }}" method="POST">
    @csrf

    <div class="card-box">

        <!-- Card Header -->
        <div class="card-header-section">
            <i class="bi bi-person-vcard"></i>
            <span>Informasi Petugas</span>
        </div>

        <div class="card-body-section">

            <!-- Section: Data Diri -->
            <p class="section-label">Data Diri</p>

            <div class="form-grid">

                <!-- Nama Lengkap -->
                <div class="form-group">
                    <label class="form-label" for="name">
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="Masukkan nama lengkap"
                           autocomplete="off">
                    @error('name')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="form-group col-full">
                    <label class="form-label" for="email">
                        Email <span class="required">*</span>
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="contoh@email.com"
                           autocomplete="off">
                    @error('email')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

            </div>

            <hr class="form-divider">

            <!-- Section: Keamanan -->
            <p class="section-label">Keamanan Akun</p>

            <div class="form-grid">

                <!-- Password -->
                <div class="form-group">
                    <label class="form-label" for="password">
                        Password <span class="required">*</span>
                    </label>
                    <div class="input-wrap">
                        <input type="password"
                               id="password"
                               name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Min. 6 karakter"
                               autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                    <span class="input-hint">Minimal 6 karakter</span>
                </div>

                <!-- Konfirmasi Password -->
                <div class="form-group">
                    <label class="form-label" for="password_confirmation">
                        Konfirmasi Password <span class="required">*</span>
                    </label>
                    <div class="input-wrap">
                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               class="form-control"
                               placeholder="Ulangi password"
                               autocomplete="new-password">
                        <button type="button" class="toggle-pw" onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Form Footer -->
        <div class="form-footer">
            <a href="{{ route('kepala.petugas.index') }}" class="btn-cancel">
                <i class="bi bi-x-lg"></i> Batal
            </a>
            <button type="submit" class="btn-submit">
                <i class="bi bi-person-plus-fill"></i> Tambah Petugas
            </button>
        </div>

    </div>
</form>

@endsection

@push('scripts')
<script>
    function togglePassword(fieldId, btn) {
        const input = document.getElementById(fieldId);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.replace('bi-eye-slash', 'bi-eye');
        } else {
            input.type = 'password';
            icon.classList.replace('bi-eye', 'bi-eye-slash');
        }
    }
</script>
@endpush
