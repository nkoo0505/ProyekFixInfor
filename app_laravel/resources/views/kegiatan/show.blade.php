@extends('layouts.app')

@section('title', $kegiatan->judul)

@section('content')
<style>
    /* --- VARIABLES --- */
    :root {
        --primary-color: #003B73;
        --secondary-color: #00bcd4;
    }

    body {
        background-color: #f8f9fa;
    }

    /* --- IMAGE HERO (MODIFIED FOR ZOOM) --- */
    .event-hero-wrapper {
        position: relative;
        border-radius: 16px;
        overflow: hidden;
        cursor: pointer; /* Menunjukkan gambar bisa diklik */
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        height: 400px; /* Tinggi tetap */
        background-color: #e2e8f0; /* Background abu-abu jika gambar tidak full */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .event-hero-img {
        width: 100%;
        height: 100%;
        object-fit: cover; /* Gambar memenuhi kotak */
        transition: transform 0.3s ease;
    }

    /* Efek Zoom saat Hover */
    .event-hero-wrapper:hover .event-hero-img {
        transform: scale(1.05); /* Gambar membesar sedikit */
    }

    /* Overlay Gelap + Teks saat Hover */
    .zoom-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .event-hero-wrapper:hover .zoom-overlay {
        opacity: 1;
    }

    /* --- CARDS --- */
    .event-card {
        background: white;
        border: none;
        border-radius: 16px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.05);
        padding: 30px;
        margin-bottom: 25px;
    }

    /* --- TYPOGRAPHY --- */
    .event-title {
        font-weight: 800;
        color: var(--primary-color);
        font-size: 2rem;
        margin-bottom: 15px;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 15px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-left: 4px solid var(--secondary-color);
        padding-left: 10px;
    }

    .event-desc {
        color: #475569;
        line-height: 1.8;
        font-size: 1rem;
        text-align: justify;
    }

    /* --- SIDEBAR WIDGETS --- */
    .info-box {
        display: flex;
        align-items: flex-start;
        margin-bottom: 20px;
    }

    .info-icon {
        background-color: rgba(0, 59, 115, 0.1);
        color: var(--primary-color);
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 1.2rem;
        margin-right: 15px;
        flex-shrink: 0;
    }

    .info-content h6 {
        font-weight: 700;
        margin-bottom: 2px;
        color: #1e293b;
    }

    .info-content p {
        margin: 0;
        color: #64748b;
        font-size: 0.9rem;
    }

    /* --- BUTTONS --- */
    .btn-register {
        background: var(--primary-color);
        color: white;
        border: none;
        padding: 12px;
        font-weight: 700;
        border-radius: 10px;
        width: 100%;
        transition: all 0.3s;
        box-shadow: 0 4px 15px rgba(0, 59, 115, 0.3);
    }

    .btn-register:hover {
        background-color: #002a52;
        transform: translateY(-2px);
    }

    .breadcrumb-custom a {
        color: #64748b;
        text-decoration: none;
        font-size: 0.9rem;
    }
    .breadcrumb-custom a:hover {
        color: var(--primary-color);
    }
    .breadcrumb-active {
        color: var(--primary-color);
        font-weight: 600;
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .event-hero-wrapper { height: 250px; }
        .event-title { font-size: 1.5rem; }
    }
</style>

<div class="container py-5">
    
    <!-- {{-- BREADCRUMB --}}
    <div class="d-flex align-items-center mb-4 breadcrumb-custom">
        <a href="{{ route('beranda') }}"><i class="bi bi-house-door me-1"></i> Beranda</a>
        <span class="mx-2 text-muted">/</span>
        <span class="breadcrumb-active">Detail Kegiatan</span>
    </div> -->

    <div class="row g-4">
        
        {{-- KOLOM KIRI (Konten Utama) --}}
        <div class="col-lg-8">
            
            {{-- GAMBAR UTAMA (DIBUNGKUS WRAPPER UNTUK KLIK) --}}
            <div class="mb-4">
                <div class="event-hero-wrapper" data-bs-toggle="modal" data-bs-target="#imageModal">
                    @if($kegiatan->gambar_url)
                        <img src="{{ asset('images/kegiatan/' . $kegiatan->gambar_url) }}" alt="{{ $kegiatan->judul }}" class="event-hero-img">
                    @else
                        <img src="https://placehold.co/800x400/e2e8f0/1e293b?text=Tidak+Ada+Gambar" alt="Placeholder" class="event-hero-img">
                    @endif

                    {{-- Overlay Teks saat Hover --}}
                    <div class="zoom-overlay">
                        <span class="badge bg-white text-dark px-3 py-2 rounded-pill shadow-sm">
                            <i class="bi bi-arrows-fullscreen me-2"></i> Klik untuk memperbesar
                        </span>
                    </div>
                </div>
            </div>

            {{-- Kartu Deskripsi --}}
            <div class="event-card">
                <h1 class="event-title">{{ $kegiatan->judul }}</h1>
                
                {{-- Tags Mobile Only --}}
                <div class="d-md-none mb-4 pb-3 border-bottom">
                    <span class="badge bg-primary bg-opacity-10 text-primary mb-2">
                        {{ $kegiatan->ormawa->nama_ormawa ?? 'Ormawa FST' }}
                    </span>
                    <div class="small text-muted">
                        <i class="bi bi-calendar-event me-1"></i> {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}
                    </div>
                </div>

                <h5 class="section-title">Tentang Kegiatan Ini</h5>
                <div class="event-desc">
                    {!! nl2br(e($kegiatan->deskripsi)) !!}
                </div>
            </div>

            {{-- Tombol Kembali --}}
            <div class="mt-3">
                <a href="{{ route('beranda') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Beranda
                </a>
            </div>
        </div>

        {{-- KOLOM KANAN (Sidebar Informasi - Sticky) --}}
        <div class="col-lg-4">
            <div class="sticky-top" style="top: 20px; z-index: 1;">
                
                {{-- Kartu Info Pendaftaran --}}
                <div class="event-card">
                    <h5 class="mb-4 fw-bold" style="color: #003B73;">Info Pelaksanaan</h5>
                    
                    {{-- Item: Tanggal --}}
                    <div class="info-box">
                        <div class="info-icon"><i class="bi bi-calendar-check"></i></div>
                        <div class="info-content">
                            <h6>Tanggal Mulai</h6>
                            <p>{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Item: Selesai --}}
                    <div class="info-box">
                        <div class="info-icon"><i class="bi bi-calendar-x"></i></div>
                        <div class="info-content">
                            <h6>Tanggal Selesai</h6>
                            <p>{{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d F Y') }}</p>
                        </div>
                    </div>

                    {{-- Item: Penyelenggara --}}
                    <div class="info-box">
                        <div class="info-icon"><i class="bi bi-people-fill"></i></div>
                        <div class="info-content">
                            <h6>Penyelenggara</h6>
                            <p class="fw-bold text-dark">{{ $kegiatan->ormawa->nama_ormawa ?? 'Organisasi Mahasiswa' }}</p>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Tombol Aksi --}}
                    @if($kegiatan->linkPendaftaran_url)
                        <a href="{{ $kegiatan->linkPendaftaran_url }}" target="_blank" class="btn btn-register mb-2">
                            Daftar Sekarang <i class="bi bi-box-arrow-up-right ms-2"></i>
                        </a>
                        <small class="text-muted d-block text-center" style="font-size: 0.8rem;">*Anda akan diarahkan ke form pendaftaran</small>
                    @else
                        <button class="btn btn-secondary w-100 disabled" disabled>Pendaftaran Ditutup</button>
                    @endif
                </div>

                {{-- Kartu Share (Opsional) --}}
                <div class="text-center mt-3">
                    <small class="text-muted">Bagikan kegiatan ini:</small>
                    <div class="mt-2 d-flex justify-content-center gap-2">
                        <button class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-whatsapp text-success"></i></button>
                        <button class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-instagram text-danger"></i></button>
                        <button class="btn btn-light btn-sm rounded-circle border"><i class="bi bi-link-45deg"></i></button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

{{-- MODAL UNTUK GAMBAR FULL (Tambahan Baru) --}}
<div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-transparent border-0 shadow-none">
            <div class="modal-body p-0 position-relative text-center">
                {{-- Tombol Close X --}}
                <button type="button" class="btn-close btn-close-white position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close" style="background-color: white; opacity: 1; padding: 10px; border-radius: 50%;"></button>
                
                {{-- Gambar Ukuran Penuh --}}
                @if($kegiatan->gambar_url)
                    <img src="{{ asset('images/kegiatan/' . $kegiatan->gambar_url) }}" class="img-fluid rounded" style="max-height: 90vh;">
                @else
                     <img src="https://placehold.co/800x400/e2e8f0/1e293b?text=Tidak+Ada+Gambar" class="img-fluid rounded">
                @endif
            </div>
        </div>
    </div>
</div>

@endsection