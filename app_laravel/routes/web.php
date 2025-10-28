<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\FaqController;
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
Route::get('/profil/{ormawa_id}', [ProfilController::class, 'show'])->name('profil.show');


//route sementara untuk memeriksa koneksi
use Illuminate\Support\Facades\DB;

Route::get('/cek-db', function () {
    return DB::connection()->getDatabaseName();
});



// Kegiatan, Pertanyaan, Galeri - Bebas akses (index dan show saja)
//kegiatan
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
Route::get('/kegiatan/{kegiatan}', [KegiatanController::class, 'show'])->name('kegiatan.show');
Route::get('/kegiatan', [KegiatanController::class, 'index'])->name('kegiatan.index');
Route::get('/', [DashboardController::class, 'beranda'])->name('beranda.index');

//pertanyaaan
Route::get('/pertanyaan', [FaqController::class, 'index'])->name('pertanyaan.index');
Route::get('/pertanyaan/{pertanyaan}', [FaqController::class, 'show'])->name('pertanyaan.show');

Route::get('/galeri', [GaleriController::class, 'index'])->name('galeri.index');
Route::get('/galeri/{galeri}', [GaleriController::class, 'show'])->name('galeri.show');

// Halaman CRUD (butuh login manual session)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Kegiatan
    Route::get('/kegiatan/create', [KegiatanController::class, 'create'])->name('kegiatan.create');
    Route::post('/kegiatan', [KegiatanController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{kegiatan}/edit', [KegiatanController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{kegiatan}', [KegiatanController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{kegiatan}', [KegiatanController::class, 'destroy'])->name('kegiatan.destroy');

    // Pertanyaan
    Route::get('/pertanyaan/create', [PertanyaanController::class, 'create'])->name('pertanyaan.create');
    Route::post('/pertanyaan', [PertanyaanController::class, 'store'])->name('pertanyaan.store');
    Route::get('/pertanyaan/{pertanyaan}/edit', [PertanyaanController::class, 'edit'])->name('pertanyaan.edit');
    Route::put('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'update'])->name('pertanyaan.update');
    Route::delete('/pertanyaan/{pertanyaan}', [PertanyaanController::class, 'destroy'])->name('pertanyaan.destroy');

    // Galeri
    Route::get('/galeri/create', [GaleriController::class, 'create'])->name('galeri.create');
    Route::post('/galeri', [GaleriController::class, 'store'])->name('galeri.store');
    Route::get('/galeri/{galeri}/edit', [GaleriController::class, 'edit'])->name('galeri.edit');
    Route::put('/galeri/{galeri}', [GaleriController::class, 'update'])->name('galeri.update');
    Route::delete('/galeri/{galeri}', [GaleriController::class, 'destroy'])->name('galeri.destroy');
});
