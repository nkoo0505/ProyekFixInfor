@extends('layouts.app')

@section('title', 'Profil Organisasi')

@section('content')
<style>
    /* --- HERO SECTION --- */
    .profil-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        color: white;
        position: relative;
        overflow: hidden;
        padding: 80px 0;
    }
    
    /* Pola background halus untuk Hero */
    .profil-hero::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255, 255, 255, 0.1) 1px, transparent 1px);
        background-size: 30px 30px;
        opacity: 0.3;
    }

    /* --- PROFILE CARD MODERN --- */
    .ormawa-card {
        border: none;
        border-radius: 16px;
        background: #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .ormawa-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 59, 115, 0.15);
    }

    /* Bagian Atas Kartu (Cover) */
    .card-banner {
        height: 100px;
        background: linear-gradient(to right, #003B73, #00bcd4); /* Warna Navy ke Cyan */
        position: relative;
    }

    /* Wrapper Logo (Agar Bulat & Menabrak Banner) */
    .card-logo-wrapper {
        width: 100px;
        height: 100px;
        margin: -50px auto 15px; /* Negative margin top is key! */
        background: #fff;
        padding: 5px;
        border-radius: 50%;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        position: relative;
        z-index: 2;
    }

    .card-logo-wrapper img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover; /* atau contain tergantung bentuk logo */
        background-color: #f8f9fa; 
    }

    .btn-profile {
        background-color: transparent;
        color: #003B73;
        border: 1px solid #003B73;
        transition: all 0.3s;
    }

    .ormawa-card:hover .btn-profile {
        background-color: #003B73;
        color: white;
    }
</style>

{{-- HERO SECTION --}}
<div class="profil-hero text-center">
    <div class="container position-relative z-1">
        <h1 class="fw-bold display-5 mb-3">Organisasi Mahasiswa</h1>
        <p class="lead opacity-75 mx-auto" style="max-width: 600px;">
            Wadah pengembangan diri, kepemimpinan, dan kreativitas mahasiswa Fakultas Sains & Teknologi.
        </p>
    </div>
</div>

{{-- CONTENT SECTION --}}
<div class="py-5 bg-light">
    <div class="container">
        
        {{-- Section Header --}}
        <div class="d-flex justify-content-between align-items-end mb-5 border-bottom pb-3">
            <div>
                <h6 class="text-uppercase text-muted fw-bold ls-1">Daftar Ormawa</h6>
                <h2 class="fw-bold text-dark mb-0">Eksplorasi Komunitas Kami</h2>
            </div>
            {{-- Hiasan Jumlah --}}
            <div class="text-end d-none d-md-block">
                <span class="display-6 fw-bold text-primary">{{ count($ormawaList) }}</span>
                <span class="text-muted d-block small">Organisasi Aktif</span>
            </div>
        </div>

        {{-- Grid System --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($ormawaList as $ormawa)
                <div class="col">
                    <div class="ormawa-card position-relative">
                        
                        {{-- 1. Banner Atas --}}
                        <div class="card-banner"></div>

                        {{-- 2. Logo Overlap --}}
                        <div class="card-logo-wrapper">
                            {{-- Cek apakah logo ada --}}
                            @if(isset($ormawa['logo_src']) && $ormawa['logo_src'])
                                <img src="{{ $ormawa['logo_src'] }}" alt="{{ $ormawa['singkatan'] }}">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ $ormawa['singkatan'] }}&background=random" alt="Logo">
                            @endif
                        </div>

                        {{-- 3. Body Content --}}
                        <div class="card-body text-center pt-0 px-4 pb-4 d-flex flex-column">
                            <h4 class="fw-bold text-dark mb-1">{{ $ormawa['singkatan'] }}</h4>
                            <p class="text-primary small fw-semibold text-uppercase mb-3">{{ $ormawa['nama'] }}</p>
                            
                            <p class="text-muted small mb-4 flex-grow-1">
                                {{ Str::limit($ormawa['deskripsi_singkat'], 100) }}
                            </p>

                            {{-- Stretched Link untuk UX yang lebih baik --}}
                            <a href="{{ route('profil.show', $ormawa['id']) }}" class="btn btn-profile rounded-pill w-100 fw-bold stretched-link">
                                Kunjungi Profil <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <div class="text-muted">Data organisasi belum tersedia.</div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection