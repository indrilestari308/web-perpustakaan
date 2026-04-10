<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
| AUTH
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->middleware('auth')->name('logout');


/*
|--------------------------------------------------------------------------
| ANGGOTA
|--------------------------------------------------------------------------
*/
Route::prefix('anggota')->middleware(['auth', 'role:anggota'])->group(function () {

    Route::get('/dashboard', [AnggotaController::class, 'dashboard'])->name('anggota.dashboard');

    Route::get('/buku', [BukuController::class, 'indexAnggota'])->name('anggota.buku');
    Route::get('/buku/{id}', [BukuController::class, 'detail'])->name('anggota.buku.detail');
    Route::post('/buku/{id}/pinjam', [BukuController::class, 'pinjam'])->name('anggota.pinjam');

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('anggota.peminjaman');
    Route::put('/peminjaman/{id}/kembali', [PeminjamanController::class, 'kembali'])->name('anggota.peminjaman.kembali');
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('anggota.riwayat');

    Route::get('/profil', [AnggotaController::class, 'profil'])->name('anggota.profil');
    Route::put('/profil/update', [AnggotaController::class, 'updateProfil'])->name('anggota.profil.update');
});


/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')->middleware(['auth', 'role:petugas'])->group(function () {

    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');

    Route::resource('/buku', BukuController::class);
    Route::resource('/kategori', KategoriController::class);

    Route::get('/anggota', [PetugasController::class, 'anggota'])->name('petugas.anggota');

    Route::get('/peminjaman', [PeminjamanController::class, 'indexPetugas'])
        ->name('petugas.peminjaman');

    Route::put('/peminjaman/{id}/konfirmasi',
        [PeminjamanController::class, 'konfirmasi']
    )->name('peminjaman.konfirmasi');

    Route::put('/peminjaman/{id}/konfirmasi-pengembalian',
        [PeminjamanController::class, 'konfirmasiPengembalian']
    )->name('konfirmasiPengembalian');
});


/*
|--------------------------------------------------------------------------
| KEPALA
|--------------------------------------------------------------------------
*/
Route::prefix('kepala')->middleware(['auth', 'role:kepala'])->group(function () {

    Route::get('/dashboard', [KepalaController::class, 'dashboard'])->name('kepala.dashboard');

    Route::get('/laporan', [KepalaController::class, 'laporan'])->name('kepala.laporan');
    Route::get('/laporan/cetak', [KepalaController::class, 'laporanCetak'])->name('kepala.laporan.cetak');
    Route::get('/laporan/export', [KepalaController::class, 'laporanExport'])->name('kepala.laporan.export');

    Route::get('/petugas', [KepalaController::class, 'petugasIndex'])->name('kepala.petugas.index');
    Route::get('/petugas/create', [KepalaController::class, 'petugasCreate'])->name('kepala.petugas.create');
    Route::post('/petugas', [KepalaController::class, 'petugasStore'])->name('kepala.petugas.store');

    Route::get('/petugas/{id}/edit', [KepalaController::class, 'editPetugas'])->name('kepala.petugas.edit');
    Route::put('/petugas/{id}', [KepalaController::class, 'updatePetugas'])->name('kepala.petugas.update');
    Route::delete('/petugas/{id}', [KepalaController::class, 'petugasDestroy'])->name('kepala.petugas.destroy');

    Route::get('/buku', [KepalaController::class, 'buku'])->name('kepala.buku');
});
