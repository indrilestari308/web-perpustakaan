<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\PeminjamanController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $bukuTerbaru = \App\Models\Buku::with('kategori')->latest()->limit(4)->get();
    return view('welcome', compact('bukuTerbaru'));
});

/*
|--------------------------------------------------------------------------
| AUTH (LOGIN & REGISTER)
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| ANGGOTA
|--------------------------------------------------------------------------
*/
Route::prefix('anggota')->middleware(['auth'])->group(function () {

    Route::get('/dashboard', [AnggotaController::class, 'dashboard'])->name('anggota.dashboard');

    Route::get('/buku',           [BukuController::class, 'indexAnggota'])->name('anggota.buku');
    Route::get('/buku/{id}',      [BukuController::class, 'detail'])->name('anggota.buku.detail');
    Route::post('/buku/{id}/pinjam', [BukuController::class, 'pinjam'])->name('anggota.pinjam');

    Route::get('/peminjaman',              [PeminjamanController::class, 'index'])->name('anggota.peminjaman');
    Route::put('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('anggota.peminjaman.kembali');
    Route::get('/riwayat',                 [PeminjamanController::class, 'riwayat'])->name('anggota.riwayat');

    Route::get('/profil',        [AnggotaController::class, 'profil'])->name('anggota.profil');
    Route::put('/profil/update', [AnggotaController::class, 'updateProfil'])->name('anggota.profil.update');

});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('petugas')->group(function () {

    Route::get('/dashboard', [PetugasController::class, 'dashboard'])
        ->name('petugas.dashboard');

    Route::resource('/buku', BukuController::class);
    Route::resource('/kategori', KategoriController::class);

    Route::get('/anggota', [PetugasController::class, 'anggota'])
        ->name('petugas.anggota');

    // ── Peminjaman ──
    Route::get('/peminjaman', [PeminjamanController::class, 'indexPetugas'])
        ->name('petugas.peminjaman');

    Route::post('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasi'])
        ->name('peminjaman.konfirmasi');

    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
        ->name('peminjaman.tolak');

    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');
});

/*
|--------------------------------------------------------------------------
| KEPALA
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('kepala')->group(function () {

    Route::get('/dashboard', [KepalaController::class, 'dashboard'])
        ->name('kepala.dashboard');

    Route::get('/laporan', [KepalaController::class, 'laporan'])
        ->name('kepala.laporan');

    Route::get('/petugas', [KepalaController::class, 'petugas'])
        ->name('kepala.petugas');

    Route::post('/petugas', [KepalaController::class, 'storePetugas'])
        ->name('kepala.petugas.store');

    Route::get('/buku', [KepalaController::class, 'buku'])
        ->name('kepala.buku');

});
