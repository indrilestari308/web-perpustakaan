@extends('anggota.layouts')

@section('title', 'Profil Saya')

@section('content')

<style>
.card-profil {
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

.profil-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #4e73df;
}

.form-control {
    border-radius: 10px;
    padding: 10px;
}

.btn-save {
    background: #4e73df;
    color: white;
    border-radius: 10px;
}
</style>

<div class="row">

    <!-- FOTO & INFO -->
    <div class="col-md-4">
        <div class="card-profil text-center">

            <img src="{{ auth()->user()->foto ? asset('storage/'.auth()->user()->foto) : 'https://i.pravatar.cc/150' }}"
                 class="profil-img mb-3">

            <h5 class="fw-bold">{{ auth()->user()->name }}</h5>
            <p class="text-muted">{{ auth()->user()->email }}</p>

            <span class="badge bg-success">Aktif</span>

        </div>
    </div>

    <!-- FORM EDIT -->
    <div class="col-md-8">
        <div class="card-profil">

            <h5 class="fw-bold mb-4">Edit Profil</h5>

            {{-- NOTIF --}}
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('anggota.profil.update') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ auth()->user()->name }}">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ auth()->user()->email }}">
                </div>

                <div class="mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control"
                           placeholder="Kosongkan jika tidak diubah">
                </div>

                <button type="submit" class="btn btn-save">
                    Simpan Perubahan
                </button>

            </form>

        </div>
    </div>

</div>

@endsection
