@extends('anggota.layouts')

@section('title', 'Profil Saya')

@section('content')
<style>
.page-profil {
    display: grid;
    grid-template-columns: 280px minmax(0, 1fr);
    gap: 20px;
    padding: 1.5rem 0;
}
@media (max-width: 768px) { .page-profil { grid-template-columns: 1fr; } }
.card-profil {
    background: #fff;
    border: 1px solid #e8ecf0;
    border-radius: 16px;
    padding: 1.5rem;
}
.avatar-wrap { position: relative; width: 90px; margin: 0 auto 1rem; }
.avatar-img {
    width: 90px; height: 90px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
    border: 3px solid #4e73df;
}
.badge-aktif {
    display: inline-block;
    font-size: 11px;
    padding: 3px 10px;
    border-radius: 20px;
    background: #d1fae5;
    color: #065f46;
    font-weight: 500;
}
.info-row {
    display: flex;
    justify-content: space-between;
    font-size: 13px;
    padding: 7px 0;
    border-bottom: 1px solid #f0f0f0;
}
.info-row:last-child { border-bottom: none; }
.tab-bar {
    display: flex;
    border-bottom: 1px solid #e8ecf0;
    margin-bottom: 1.5rem;
}
.tab-bar button {
    padding: 8px 16px;
    font-size: 13px;
    color: #6c757d;
    background: none;
    border: none;
    border-bottom: 2px solid transparent;
    margin-bottom: -1px;
    cursor: pointer;
}
.tab-bar button.active {
    color: #4e73df;
    border-bottom-color: #4e73df;
    font-weight: 500;
}
.form-label-sm {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    color: #6c757d;
    display: block;
    margin-bottom: 6px;
}
.input-field {
    width: 100%;
    background: #f8f9fc;
    border: 1px solid #e8ecf0;
    border-radius: 10px;
    padding: 9px 12px;
    font-size: 14px;
    color: #333;
    outline: none;
    transition: border-color 0.15s, box-shadow 0.15s;
}
.input-field:focus {
    border-color: #4e73df;
    box-shadow: 0 0 0 3px rgba(78,115,223,0.12);
    background: #fff;
}
.file-drop {
    border: 1.5px dashed #d1d5db;
    border-radius: 10px;
    padding: 16px;
    text-align: center;
    cursor: pointer;
    transition: background 0.15s;
}
.file-drop:hover { background: #f8f9fc; }
.form-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding-top: 1rem;
    border-top: 1px solid #f0f0f0;
    margin-top: 1rem;
}
.btn-save {
    padding: 9px 20px;
    font-size: 13px;
    background: #4e73df;
    border: none;
    border-radius: 10px;
    color: white;
    font-weight: 500;
    cursor: pointer;
}
.btn-save:hover { background: #3a5fcd; }
.form-row-2 {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}
@media (max-width: 480px) { .form-row-2 { grid-template-columns: 1fr; } }
.tab-content { display: none; }
.tab-content.active { display: block; }
</style>

<div class="page-profil">

    {{-- SIDEBAR --}}
    <div class="card-profil text-center">
        <div class="avatar-wrap">
            <img class="avatar-img"
                 src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&background=4e73df&color=fff' }}"
                 alt="foto profil">
        </div>
        <p style="font-size:15px;font-weight:600;margin-bottom:4px;">{{ auth()->user()->name }}</p>
        <p style="font-size:13px;color:#6c757d;margin-bottom:12px;">{{ auth()->user()->email }}</p>
        <span class="badge-aktif">Aktif</span>
        <hr style="margin: 1.25rem 0; border-color: #f0f0f0;">
        <div>
            <div class="info-row">
                <span style="color:#6c757d;">No. Anggota</span>
                <span style="font-weight:600;">{{ auth()->user()->id }}</span>
            </div>
            <div class="info-row">
                <span style="color:#6c757d;">Bergabung</span>
                <span style="font-weight:600;">{{ auth()->user()->created_at->format('M Y') }}</span>
            </div>
            <div class="info-row">
                <span style="color:#6c757d;">Role</span>
                <span style="font-weight:600;">{{ ucfirst(auth()->user()->role ?? 'Anggota') }}</span>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="card-profil">

        <div class="tab-bar">
            <button type="button" class="tab-btn {{ session('tab', 'profil') === 'profil' ? 'active' : '' }}" data-tab="tab-profil">Edit Profil</button>
            <button type="button" class="tab-btn {{ session('tab') === 'keamanan' ? 'active' : '' }}" data-tab="tab-keamanan">Keamanan</button>
        </div>

        {{-- NOTIF --}}
        @if(session('success'))
            <div class="alert alert-success mb-3" style="font-size:13px;border-radius:10px;">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger mb-3" style="font-size:13px;border-radius:10px;">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        {{-- TAB: EDIT PROFIL --}}
        <div id="tab-profil" class="tab-content {{ session('tab', 'profil') === 'profil' ? 'active' : '' }}">
            <form action="{{ route('anggota.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="profil">

                <div class="form-row-2 mb-3">
                    <div>
                        <label class="form-label-sm">Nama Lengkap</label>
                        <input type="text" name="name" class="input-field" value="{{ old('name', auth()->user()->name) }}" required>
                    </div>
                    <div>
                        <label class="form-label-sm">Email</label>
                        <input type="email" name="email" class="input-field" value="{{ old('email', auth()->user()->email) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label-sm">Foto Profil</label>
                    <div class="file-drop" onclick="document.getElementById('fotoInput').click()">
                        <p style="font-size:13px;color:#6c757d;margin:0;">
                            <span style="color:#4e73df;font-weight:500;">Pilih file</span> atau seret ke sini
                        </p>
                        <p style="font-size:12px;color:#adb5bd;margin:4px 0 0;">JPG, PNG · Maks 2MB</p>
                        <p id="namaFile" style="font-size:12px;color:#4e73df;margin:4px 0 0;display:none;"></p>
                    </div>
                    <input type="file" id="fotoInput" name="foto" accept="image/*" style="display:none;"
                           onchange="document.getElementById('namaFile').textContent=this.files[0]?.name; document.getElementById('namaFile').style.display='block'">
                </div>

                <div class="form-footer">
                    <a href="{{ url()->previous() }}" class="btn btn-light" style="font-size:13px;border-radius:10px;">Batal</a>
                    <button type="submit" class="btn-save">Simpan Perubahan</button>
                </div>
            </form>
        </div>

        {{-- TAB: KEAMANAN --}}
        <div id="tab-keamanan" class="tab-content {{ session('tab') === 'keamanan' ? 'active' : '' }}">
            <form action="{{ route('anggota.profil.update') }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="tab" value="keamanan">

                <div class="mb-3">
                    <label class="form-label-sm">Password Lama</label>
                    <input type="password" name="password_lama" class="input-field" placeholder="Masukkan password lama">
                </div>

                <div class="form-row-2 mb-3">
                    <div>
                        <label class="form-label-sm">Password Baru</label>
                        <input type="password" name="password" class="input-field" placeholder="Minimal 6 karakter">
                    </div>
                    <div>
                        <label class="form-label-sm">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="input-field" placeholder="Ulangi password baru">
                    </div>
                </div>

                <div class="form-footer">
                    <button type="submit" class="btn-save">Ubah Password</button>
                </div>
            </form>
        </div>

    </div>
</div>


<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content').forEach(c => c.classList.remove('active'));
        this.classList.add('active');
        document.getElementById(this.dataset.tab).classList.add('active');
    });
});

// Buka tab yang error otomatis
@if($errors->any() && session('tab') === 'keamanan')
    document.querySelector('[data-tab="tab-keamanan"]').click();
@endif
</script>

@endsection
