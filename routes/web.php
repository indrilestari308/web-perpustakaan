<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\KepalaController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
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

//Anggota//

Route::middleware('auth')->prefix('anggota')->group(function () {

    Route::get('/dashboard', [AnggotaController::class, 'dashboard'])
        ->name('anggota.dashboard');

    Route::get('/buku', [AnggotaController::class, 'buku'])
        ->name('anggota.buku');

    Route::get('/buku/{id}', [AnggotaController::class, 'detail'])
        ->name('anggota.buku.detail');

    Route::post('/pinjam/{id}', [AnggotaController::class, 'pinjam'])
        ->name('anggota.pinjam');

    Route::get('/profil', [AnggotaController::class, 'profil'])
        ->name('anggota.profil');

    Route::post('/profil/update', [AnggotaController::class, 'updateProfil'])
        ->name('anggota.profil.update');

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

    Route::get('/denda', [PetugasController::class, 'denda'])
        ->name('petugas.denda');

    Route::post('/peminjaman/{id}/konfirmasi', [PetugasController::class, 'konfirmasi'])
        ->name('peminjaman.konfirmasi');
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
