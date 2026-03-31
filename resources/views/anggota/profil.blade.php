@extends('anggota.layouts')

@section('title', 'Profil Saya')

@section('content')

<style>
/* CARD PROFIL */
.card-profil {
    background: #fff;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
}

/* FOTO */
.profil-img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    object-fit: cover;
    border: 4px solid #4e73df;
}

/* INPUT */
.form-control {
    border-radius: 10px;
    padding: 10px;
}

/* BUTTON */
.btn-save {
    background: #4e73df;
    color: white;
    border-radius: 10px;
}

.btn-save:hover {
    background: #2e59d9;
}
</style>

<div class="row">

    <!-- FOTO & INFO -->
    <div class="col-md-4">
        <div class="card-profil text-center">

            <img src="https://i.pravatar.cc/150" class="profil-img mb-3">

            <h5 class="fw-bold">Indri Lestari</h5>
            <p class="text-muted">Anggota Perpustakaan</p>

            <span class="badge bg-success">Aktif</span>

        </div>
    </div>

    <!-- FORM EDIT -->
    <div class="col-md-8">
        <div class="card-profil">

            <h5 class="fw-bold mb-4">Edit Profil</h5>

            <form>

                <div class="mb-3">
                    <label>Nama Lengkap</label>
                    <input type="text" class="form-control" value="Indri Lestari">
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" class="form-control" value="indri@email.com">
                </div>

                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" class="form-control" value="08123456789">
                </div>

                <div class="mb-3">
                    <label>Alamat</label>
                    <textarea class="form-control">Jakarta, Indonesia</textarea>
                </div>

                <div class="mb-3">
                    <label>Ganti Password</label>
                    <input type="password" class="form-control" placeholder="Kosongkan jika tidak diubah">
                </div>

                <button type="submit" class="btn btn-save">
                    Simpan Perubahan
                </button>

            </form>

        </div>
    </div>

</div>

@endsection
