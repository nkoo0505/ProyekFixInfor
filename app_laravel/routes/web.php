<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\GaleriController;


// Halaman Beranda
Route::get('/', [DashboardController::class, 'beranda'])->name('beranda');
Route::get('/beranda', [DashboardController::class, 'beranda'])->name('beranda');


// Login ORMAWA
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman PROFIL (bebas diakses tanpa login)
// ** 
// Halaman PROFIL (bebas diakses tanpa login)
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/{ormawa_id}', [ProfilController::class, 'show'])->name('profil.show');
// Route::get('/profil/{ormawa_id}', [ProfilController::class, 'show'])->name('profil.show');


//route sementara untuk memeriksa koneksi
use Illuminate\Support\Facades\DB;

Route::get('/cek-db', function () {
    return DB::connection()->getDatabaseName();
});



// Kegiatan, Pertanyaan, Galeri - Bebas akses (index dan show saja)
//kegiatan
Route::get('/', [DashboardController::class, 'beranda'])->name('beranda.index');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/cari', [KegiatanController::class, 'cari'])->name('kegiatan.cari'); 
Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
Route::get('/kegiatan/{kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');


//pertanyaaan (publik: FAQ + form aspirasi)
Route::get('/pertanyaan', [FAQController::class, 'index'])->name('pertanyaan.index');
Route::post('/pertanyaan', [FAQController::class, 'store'])->name('aspirasi.store');

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{galeri}', [GaleriController::class, 'show'])->name('galeri.show');

// Halaman CRUD (butuh login manual session)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profil ORMAWA yang sedang login
    Route::get('/profilku', [ProfilController::class, 'editSelf'])->name('profilku.edit');
    Route::put('/profilku', [ProfilController::class, 'updateSelf'])->name('profilku.update');

    // Struktur kepengurusan ORMAWA yang sedang login
    Route::post('/pengurus', [PengurusController::class, 'store'])->name('pengurus.store');
    Route::put('/pengurus/{pengurus}', [PengurusController::class, 'update'])->name('pengurus.update');
    Route::delete('/pengurus/{pengurus}', [PengurusController::class, 'destroy'])->name('pengurus.destroy');

    // Kegiatan
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // Pertanyaan (admin: kelola pendapat & balasan)
    Route::prefix('admin/pertanyaan')->name('admin.pertanyaan.')->group(function () {
        Route::get('/', [PertanyaanController::class, 'index'])->name('index');
        Route::post('/balas', [PertanyaanController::class, 'store'])->name('balas');
        Route::delete('/{id}', [PertanyaanController::class, 'destroy'])->name('destroy');
    });

    // Galeri
    Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{galeri}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
});
