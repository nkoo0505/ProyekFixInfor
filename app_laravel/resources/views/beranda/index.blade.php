@extends('layouts.app')

@section('content')
<style>
    /* --- GLOBAL UTILS --- */
    body {
        font-family: 'Inter', 'Segoe UI', sans-serif;
        background-color: #f8f9fa;
    }

    .text-primary-dark {
        color: #003B73 !important;
    }

    /* --- HERO SECTION MODERN --- */
    .hero-section {
        position: relative;
        height: 100vh;
        min-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        color: white;
    }

    .bg-video {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        object-fit: cover;
        z-index: -2;
    }

    .hero-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%; height: 100%;
        /* Gradient lebih modern: Gelap di bawah agar teks terbaca */
        background: linear-gradient(to bottom, rgba(0, 59, 115, 0.5), rgba(0, 34, 77, 0.9));
        z-index: -1;
    }

    .hero-content {
        z-index: 1;
        text-align: center;
        max-width: 800px;
        padding: 0 20px;
    }

    .hero-title {
        font-size: 3.5rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    }

    /* --- GLASS SEARCH BAR --- */
    .glass-search {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        padding: 15px;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        display: flex;
        gap: 10px;
        margin-top: 30px;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
    }

    .glass-input {
        background: transparent;
        border: none;
        color: white;
        padding: 10px 20px;
        flex-grow: 1;
        outline: none;
        font-size: 1.1rem;
    }
    .glass-input::placeholder { color: rgba(255, 255, 255, 0.7); }

    /* --- HORIZONTAL SCROLL KEGIATAN --- */
    .kegiatan-scroll-wrapper {
        overflow-x: auto;
        padding-bottom: 20px;
        /* Hide Scrollbar */
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    .kegiatan-scroll-wrapper::-webkit-scrollbar {
        display: none;
    }
    
    .scroll-card {
        width: 280px;
        flex-shrink: 0;
        margin-right: 20px;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .scroll-card:hover {
        transform: translateY(-5px);
    }
    .scroll-img {
        width: 100%;
        height: 180px;
        object-fit: cover;
    }

    /* --- STATS SECTION --- */
    .stats-section {
        background-color: #003B73;
        color: white;
        padding: 60px 0;
        position: relative;
        overflow: hidden;
    }
    /* Pattern background tipis */
    .stats-section::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: radial-gradient(rgba(255,255,255,0.1) 1px, transparent 1px);
        background-size: 20px 20px;
        opacity: 0.3;
    }

    /* --- ORMAWA CARDS --- */
    .ormawa-card {
        background: white;
        border: none;
        border-radius: 16px;
        padding: 30px 20px;
        height: 100%;
        text-align: center;
        transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none !important; /* Hilangkan garis bawah link */
    }

    .ormawa-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 59, 115, 0.15);
    }

    .ormawa-logo-wrapper {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 20px;
        border-radius: 50%;
        background: #f8f9fa;
        padding: 15px;
    }

    .ormawa-logo {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .ormawa-title {
        font-weight: 800;
        color: #003B73;
        font-size: 1.25rem;
        margin-bottom: 5px;
    }

    .ormawa-desc {
        color: #6c757d;
        font-size: 0.9rem;
        line-height: 1.4;
    }

    /* Helper responsive */
    @media (max-width: 768px) {
        .hero-title { font-size: 2rem; }
        .glass-search { flex-direction: column; padding: 10px; border-radius: 20px;}
        .glass-input { width: 100%; text-align: center; }
        .btn-search { width: 100%; border-radius: 15px; }
    }
</style>

{{-- 1. HERO SECTION --}}
<div class="hero-section">
    <div class="hero-overlay"></div>
    <video autoplay muted loop playsinline class="bg-video">
         <source src="{{asset('images/background/PROFILE FST USD 2025.mp4')}}" type="video/mp4">
    </video>

    <div class="hero-content">
        <h1 class="hero-title animate__animated animate__fadeInDown">ORMAWA FST</h1>
        <p class="lead mb-4 animate__animated animate__fadeInUp">Pusat Informasi & Kegiatan Mahasiswa Fakultas Sains dan Teknologi</p>

        {{-- Search Bar Modern --}}
        <form action="{{ route('kegiatan.cari') }}" method="GET" class="animate__animated animate__fadeInUp" style="animation-delay: 0.3s;">
            <div class="glass-search">
                <input type="text" name="cari" class="glass-input" placeholder="Cari kegiatan, seminar, atau lomba..." value="{{ request('cari') }}">
                <button type="submit" class="btn btn-light rounded-pill px-4 fw-bold btn-search" style="color: #003B73;">
                    <i class="bi bi-search me-2"></i> Cari
                </button>
            </div>
        </form>
    </div>
</div>

{{-- 2. KEGIATAN TERBARU (Horizontal Scroll) --}}
<div class="container my-5 py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h6 class="text-uppercase text-muted fw-bold ls-2">Update Terbaru</h6>
            <h2 class="fw-bold text-primary-dark">Kegiatan Mendatang</h2>
        </div>
        {{-- Tombol Navigasi Manual jika diperlukan --}}
        <div class="d-none d-md-block">
            <button class="btn btn-outline-secondary rounded-circle" onclick="scrollKegiatan(-1)"><i class="bi bi-arrow-left"></i></button>
            <button class="btn btn-outline-secondary rounded-circle ms-2" onclick="scrollKegiatan(1)"><i class="bi bi-arrow-right"></i></button>
        </div>
    </div>

    <div class="d-flex kegiatan-scroll-wrapper" id="kegiatanScroll">
        @forelse($kegiatan as $item)
            <a href="{{ route('kegiatan.show', $item->kegiatan_id) }}" class="scroll-card text-decoration-none bg-white">
                @if($item->gambar_url)
                    <img src="{{ asset('images/kegiatan/' . $item->gambar_url) }}" class="scroll-img" alt="{{ $item->judul }}">
                @else
                    <img src="https://placehold.co/400x250/cccccc/000000?text=No+Image" class="scroll-img" alt="Placeholder">
                @endif
                <div class="p-3">
                    <small class="text-info fw-bold">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}</small>
                    <h6 class="text-dark fw-bold mt-1 text-truncate">{{ $item->judul }}</h6>
                </div>
            </a>
        @empty
            <div class="col-12 text-center py-5 bg-light rounded-3 w-100">
                <p class="text-muted mb-0">Belum ada kegiatan yang ditampilkan.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- 3. STATISTIK COUNTER --}}
<div class="stats-section">
    <div class="container position-relative z-1">
        <div class="row text-center g-4">
            <div class="col-md-4">
                <i class="bi bi-kanban fs-1 mb-3 d-block opacity-75"></i>
                <h2 class="display-4 fw-bold mb-0">
                    <span class="rtin-counter-num" data-num="120" data-rtspeed="3000"><span class="counter-value">0</span></span>
                </h2>
                <p class="fs-5 opacity-75">Program Kerja</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-calendar-check fs-1 mb-3 d-block opacity-75"></i>
                <h2 class="display-4 fw-bold mb-0">
                    <span class="rtin-counter-num" data-num="85" data-rtspeed="3000"><span class="counter-value">0</span></span>
                </h2>
                <p class="fs-5 opacity-75">Kegiatan Terlaksana</p>
            </div>
            <div class="col-md-4">
                <i class="bi bi-people fs-1 mb-3 d-block opacity-75"></i>
                <h2 class="display-4 fw-bold mb-0">
                    <span class="rtin-counter-num" data-num="250" data-rtspeed="3000"><span class="counter-value">0</span></span>+
                </h2>
                <p class="fs-5 opacity-75">Partisipan Mahasiswa</p>
            </div>
        </div>
    </div>
</div>

{{-- 4. DAFTAR ORMAWA (Professional Grid) --}}
<div class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mb-5">
            <h6 class="text-uppercase text-muted fw-bold">Keluarga Mahasiswa</h6>
            <h2 class="fw-bold text-primary-dark">Organisasi Mahasiswa FST</h2>
            <div class="mx-auto mt-3" style="width: 60px; height: 4px; background: #00bcd4; border-radius: 2px;"></div>
        </div>

        {{-- Menggunakan Grid System Bootstrap agar rapi --}}
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 g-4 justify-content-center">
            
            {{-- Item 1: BEM --}}
            <div class="col">
                <a href="{{ route('profil.show', 1) }}" class="ormawa-card">
                    <div class="ormawa-logo-wrapper">
                        <img src="{{ asset('images/logoKABINET.jpg') }}" alt="BEM FST" class="ormawa-logo">
                    </div>
                    <h5 class="ormawa-title">BEM FST</h5>
                    <p class="ormawa-desc">Badan Eksekutif Mahasiswa</p>
                </a>
            </div>

            {{-- Item 2: HMIF --}}
            <div class="col">
                <a href="{{ route('profil.show', 5) }}" class="ormawa-card">
                    <div class="ormawa-logo-wrapper">
                        <img src="{{ asset('images/logoHMIF.jpg') }}" alt="HMIF" class="ormawa-logo">
                    </div>
                    <h5 class="ormawa-title">HMIF</h5>
                    <p class="ormawa-desc">Himpunan Mahasiswa Informatika</p>
                </a>
            </div>

            {{-- Item 3: HMTE --}}
            <div class="col">
                <a href="{{ route('profil.show', 3) }}" class="ormawa-card">
                    <div class="ormawa-logo-wrapper">
                        <img src="{{ asset('images/logoHMTE.jpg') }}" alt="HMTE" class="ormawa-logo">
                    </div>
                    <h5 class="ormawa-title">HMTE</h5>
                    <p class="ormawa-desc">Himpunan Mahasiswa Elektro</p>
                </a>
            </div>

            {{-- Item 4: HMM --}}
            <div class="col">
                <a href="{{ route('profil.show', 2) }}" class="ormawa-card">
                    <div class="ormawa-logo-wrapper">
                        <img src="{{ asset('images/logoHMM.png') }}" alt="HMM" class="ormawa-logo">
                    </div>
                    <h5 class="ormawa-title">HMM</h5>
                    <p class="ormawa-desc">Himpunan Mahasiswa Matematika</p>
                </a>
            </div>

             {{-- Item 5: KMTM --}}
             <div class="col">
                <a href="{{ route('profil.show', 4) }}" class="ormawa-card">
                    <div class="ormawa-logo-wrapper">
                        <img src="{{ asset('images/logoKMTM.jpg') }}" alt="KMTM" class="ormawa-logo">
                    </div>
                    <h5 class="ormawa-title">KMTM</h5>
                    <p class="ormawa-desc">Keluarga Mahasiswa Teknik Mesin</p>
                </a>
            </div>

        </div>
    </div>
</div>

{{-- JAVASCRIPT --}}
<script>
    // 1. Logic Scroll Horizontal
    function scrollKegiatan(direction) {
        const container = document.getElementById('kegiatanScroll');
        const scrollAmount = 320; // Lebar kartu + margin
        container.scrollBy({ left: direction * scrollAmount, behavior: 'smooth' });
    }

    // 2. Logic Counter Animation (Optimized)
    const counters = document.querySelectorAll(".rtin-counter-num");
    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                if (counter.dataset.started === "true") return;
                counter.dataset.started = "true";

                const target = +counter.dataset.num;
                const speed = +counter.dataset.rtspeed;
                const valueEl = counter.querySelector(".counter-value");
                let start = 0;
                
                // Menghitung increment step agar durasi animasi sesuai data-rtspeed
                const duration = speed; 
                const frameRate = 30; // ms per frame
                const totalFrames = duration / frameRate;
                const increment = target / totalFrames;

                const timer = setInterval(() => {
                    start += increment;
                    if (start >= target) {
                        start = target;
                        clearInterval(timer);
                    }
                    valueEl.textContent = Math.floor(start);
                }, frameRate);
            }
        });
    }, { threshold: 0.5 }); // Mulai animasi saat elemen 50% terlihat

    counters.forEach(counter => observer.observe(counter));
</script>

@endsection