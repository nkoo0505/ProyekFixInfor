<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\PengurusController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\AdminProfilController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\PertanyaanController;
use App\Http\Controllers\GaleriController;

// Halaman Beranda
Route::get('/', [DashboardController::class, 'beranda'])->name('beranda');
Route::get('/beranda', [DashboardController::class, 'beranda'])->name('beranda');

// Login & Logout ORMAWA
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman PROFIL
Route::get('/profil', [ProfilController::class, 'index'])->name('profil.index');
Route::get('/profil/{ormawa_id}', [ProfilController::class, 'show'])->name('profil.show');

// Kegiatan & Galeri - bebas akses
Route::resource('kegiatan', KegiatanController::class)->only(['index', 'show']);
Route::resource('galeri', GaleriController::class)->only(['index', 'show']);

// ----------------------------------------------------
// 🔥 PUBLIC ASPIRASI & FAQ (Hanya Menggunakan FAQController)
// ----------------------------------------------------
Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
Route::get('/faq/{faq}', [FAQController::class, 'show'])->name('faq.show');

// Kirim aspirasi dari user umum (menggunakan store di FAQController)
Route::post('/aspirasi/kirim', [FAQController::class, 'store'])->name('aspirasi.store'); 


// ----------------------------------------------------
// CRUD HANYA UNTUK ADMIN/ORMAWA YANG LOGIN
// ----------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Kegiatan (Selain index dan show yang sudah di atas)
    Route::resource('kegiatan', KegiatanController::class)->except(['index', 'show']); 

    // CRUD Galeri (Selain index dan show yang sudah di atas)
    Route::resource('galeri', GaleriController::class)->except(['index', 'show']);

    // CRUD Pengurus
    Route::resource('pengurus', PengurusController::class)
        ->parameters(['pengurus' => 'pengurus'])
        ->except(['show']);
    
    // CRUD Profil Admin
    Route::get('/admin/profil/edit', [AdminProfilController::class, 'edit'])->name('admin.profil.edit');
    Route::post('/admin/profil', [AdminProfilController::class, 'update'])->name('admin.profil.update');

    // ----------------------------------------------------
    // 🔥 PENGELOLAAN ASPIRASI ADMIN (Menggunakan PertanyaanController)
    // ----------------------------------------------------
    Route::prefix('admin/aspirasi')->name('admin.aspirasi.')->group(function () {
        
        // Menampilkan SEMUA aspirasi masuk (admin index)
        Route::get('/', [PertanyaanController::class, 'index'])->name('index'); 
        
        // Menyimpan/Mengupdate balasan (admin store)
        Route::post('/', [PertanyaanController::class, 'store'])->name('store'); 
        
        // Menghapus aspirasi
        Route::delete('/{id}', [PertanyaanController::class, 'destroy'])->name('destroy');
        
        // Route untuk Pertanyaan Internal Antar-Pengurus
        Route::get('/kirim-internal', [PertanyaanController::class, 'createInternal'])->name('createInternal');
        Route::post('/kirim-internal/store', [PertanyaanController::class, 'storeInternal'])->name('storeInternal');
    });

});