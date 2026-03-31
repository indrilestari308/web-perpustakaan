<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\KategoriController;

Route::prefix('petugas')->group(function () {

    Route::get('/dashboard', [PetugasController::class, 'dashboard'])
        ->name('petugas.dashboard'); // ✅ INI FIX


    // CRUD BUKU (FULL)
    Route::resource('/buku', BukuController::class);

    // kategori
    Route::resource('/kategori', KategoriController::class);

    // lainnya
    Route::get('/anggota', [PetugasController::class, 'anggota'])
        ->name('petugas.anggota');

    Route::get('/denda', [PetugasController::class, 'denda'])
        ->name('petugas.denda');

    Route::post('/peminjaman/{id}/konfirmasi', [PetugasController::class, 'konfirmasi'])
    ->name('peminjaman.konfirmasi');
});

Route::get('/', function () {
    return view('welcome');
} );



Route::get('/login', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/logout', [AuthController::class, 'logout']);



// GROUP ANGGOTA
Route::prefix('anggota')->group(function () {

    Route::get('/dashboard', [AnggotaController::class, 'dashboard'])->name('anggota.dashboard');

    Route::get('/buku', [AnggotaController::class, 'buku'])->name('anggota.buku');

    Route::get('/buku/{id}', [AnggotaController::class, 'detail'])
    ->name('anggota.buku.detail');


    //  PINJAM
    Route::post('/pinjam/{id}', [AnggotaController::class, 'pinjam'])->name('anggota.pinjam');


    //  RIWAYAT
    Route::get('/peminjaman', [AnggotaController::class, 'peminjaman'])->name('anggota.peminjaman');

    //  KEMBALIKAN
    Route::post('/kembali/{id}', [AnggotaController::class, 'kembali'])->name('anggota.kembali');

    //  PROFIL
    Route::get('/profil', [AnggotaController::class, 'profil'])->name('anggota.profil');


});



