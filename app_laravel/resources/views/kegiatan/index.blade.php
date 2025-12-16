@extends('layouts.app')
@section('title', 'Daftar Kegiatan')

@section('content')

<style>
    /* --- EXISTING CSS --- */
    .hover-top { transition: transform 0.3s ease, box-shadow 0.3s ease; }
    .hover-top:hover { transform: translateY(-5px); box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important; }
    .zoom-effect { transition: transform 0.5s ease; }
    .hover-top:hover .zoom-effect { transform: scale(1.05); }
    .object-fit-cover { object-fit: cover; }

    /* --- FEATURE: HEADER MODAL ZOOMABLE --- */
    .modal-header-zoomable { cursor: pointer; position: relative; }
    
    .zoom-icon-overlay {
        position: absolute; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.3);
        display: flex; align-items: center; justify-content: center;
        opacity: 0; transition: opacity 0.3s ease; z-index: 5;
    }
    .modal-header-zoomable:hover .zoom-icon-overlay { opacity: 1; }

    /* --- NEW: PROFESSIONAL ZOOM UI --- */
    
    /* 1. Background Blur (Glassmorphism) */
    .zoom-backdrop {
        background-color: rgba(15, 23, 42, 0.95) !important; /* Biru gelap sangat pekat */
        backdrop-filter: blur(10px); /* Efek blur pada background di belakangnya */
    }

    /* 2. Tombol Close Pro */
    .btn-close-pro {
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        color: white;
        border-radius: 50%;
        width: 45px; height: 45px;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.3s ease;
        text-decoration: none;
    }
    .btn-close-pro:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: rotate(90deg);
        color: white;
    }

    /* 3. Image Styling */
    .zoom-img-pro {
        border-radius: 8px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5); /* Bayangan dalam */
        border: 1px solid rgba(255, 255, 255, 0.1); /* Border tipis elegan */
    }

    /* 4. Caption di Bawah */
    .zoom-caption {
        background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
        padding-top: 40px;
    }
</style>

<div class="py-5" style="background-color: #f1f5f9;">
    <div class="container">
        
        {{-- HEADER SECTION --}}
        <div class="text-center mb-5">
            <h1 class="fw-bold text-dark text-uppercase ls-2" style="letter-spacing: 2px;">Kegiatan Kami</h1>
            <div class="mx-auto mt-2" style="width: 60px; height: 4px; background-color: #0dcaf0; border-radius: 2px;"></div>
        </div>

        {{-- BUTTON ADD (ADMIN) --}}
        @auth
        <div class="d-flex justify-content-end mb-4">
            <a class="btn btn-primary rounded-pill px-4 shadow-sm" href="{{ route('kegiatan.create') }}">
                <i class="bi bi-plus-lg me-2"></i> Tambah Kegiatan
            </a>
        </div>
        @endauth

        {{-- ALERT --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- GRID SYSTEM --}}
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @forelse($kegiatans as $kegiatan)
            <div class="col">
                {{-- CARD UTAMA --}}
                <div class="card h-100 border-0 shadow-sm hover-top overflow-hidden">
                    <div class="position-relative overflow-hidden" style="height: 220px;">
                        @if($kegiatan->gambar_url)
                            <img src="{{ asset('images/kegiatan/'.$kegiatan->gambar_url) }}" class="card-img-top w-100 h-100 object-fit-cover zoom-effect" alt="{{ $kegiatan->judul }}">
                        @else
                            <img src="https://placehold.co/600x400/1e293b/FFFFFF?text=Event" class="card-img-top w-100 h-100 object-fit-cover zoom-effect" alt="Placeholder">
                        @endif

                        <div class="position-absolute top-0 start-0 m-3 bg-white rounded-3 shadow-sm text-center p-2" style="min-width: 55px;">
                            <span class="d-block fw-bold fs-5 text-dark lh-1">{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d') }}</span>
                            <span class="d-block small text-muted text-uppercase" style="font-size: 10px;">{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('M') }}</span>
                        </div>
                    </div>

                    <div class="card-body d-flex flex-column p-4">
                        <div class="mb-2">
                            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 rounded-pill px-3">
                                <i class="bi bi-people-fill me-1"></i> {{ $kegiatan->ormawa->nama_ormawa ?? 'HMIF' }}
                            </span>
                        </div>

                        <h5 class="card-title fw-bold text-dark mb-3">
                            <a href="#" class="text-decoration-none text-dark stretched-link" data-bs-toggle="modal" data-bs-target="#modalKegiatan{{ $kegiatan->kegiatan_id }}">
                                {{ $kegiatan->judul }}
                            </a>
                        </h5>

                        <p class="card-text text-muted small flex-grow-1">
                            {{ Str::limit($kegiatan->deskripsi, 90) }}
                        </p>

                        <div class="mt-3 pt-3 border-top d-flex justify-content-between align-items-center">
                            <small class="text-primary fw-semibold">Lihat Detail <i class="bi bi-arrow-right ms-1"></i></small>
                            @auth
                            <div class="position-relative" style="z-index: 2;"> 
                                <a href="{{ route('kegiatan.edit', $kegiatan->kegiatan_id) }}" class="btn btn-sm btn-outline-warning border-0"><i class="bi bi-pencil-square"></i></a>
                                <form action="{{ route('kegiatan.destroy', $kegiatan->kegiatan_id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus?')"><i class="bi bi-trash"></i></button>
                                </form>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================= --}}
            {{-- MODAL 1: DETAIL KEGIATAN --}}
            {{-- ======================================================= --}}
            <div class="modal fade" id="modalKegiatan{{ $kegiatan->kegiatan_id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content border-0 shadow-lg rounded-4">
                        
                        {{-- HEADER MODAL (GAMBAR & OVERLAY) --}}
                        <div class="modal-header border-0 p-0 position-relative overflow-hidden" style="height: 250px;">
                            
                            {{-- Area Klik Zoom --}}
                            <div class="w-100 h-100 modal-header-zoomable position-relative"
                                 data-bs-toggle="modal" 
                                 data-bs-target="#zoomImageModal{{ $kegiatan->kegiatan_id }}">
                                 
                                @if($kegiatan->gambar_url)
                                    <img src="{{ asset('images/kegiatan/'.$kegiatan->gambar_url) }}" class="w-100 h-100 object-fit-cover">
                                @endif
                                
                                <div class="zoom-icon-overlay">
                                    <span class="badge bg-dark bg-opacity-75 rounded-pill px-3 py-2 fs-6">
                                        <i class="bi bi-zoom-in me-2"></i> Perbesar Gambar
                                    </span>
                                </div>

                                <div class="position-absolute bottom-0 start-0 w-100 p-4" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent); z-index: 4;">
                                    <h3 class="text-white fw-bold mb-0">{{ $kegiatan->judul }}</h3>
                                </div>
                            </div>

                            {{-- Tombol Close (Menutup Detail) --}}
                            <div class="position-absolute top-0 end-0 m-3" style="z-index: 10;">
                                <button type="button" class="btn-close bg-white p-2 rounded-circle opacity-100 shadow-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                        </div>

                        {{-- BODY MODAL DETAIL --}}
                        <div class="modal-body p-4 p-lg-5">
                            <div class="row mb-4 g-3">
                                <div class="col-6 col-md-4">
                                    <div class="p-3 bg-light rounded-3 h-100 text-center border">
                                        <i class="bi bi-calendar-event fs-3 text-primary mb-2"></i>
                                        <div class="small text-muted">Mulai</div>
                                        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-4">
                                    <div class="p-3 bg-light rounded-3 h-100 text-center border">
                                        <i class="bi bi-calendar-check fs-3 text-success mb-2"></i>
                                        <div class="small text-muted">Selesai</div>
                                        <div class="fw-bold text-dark">{{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="p-3 bg-light rounded-3 h-100 text-center border">
                                        <i class="bi bi-people fs-3 text-info mb-2"></i>
                                        <div class="small text-muted">Penyelenggara</div>
                                        <div class="fw-bold text-dark">{{ $kegiatan->ormawa->nama_ormawa ?? '-' }}</div>
                                    </div>
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark border-bottom pb-2 mb-3">Deskripsi Kegiatan</h5>
                            <div class="text-secondary lh-lg mb-4">
                                {!! nl2br(e($kegiatan->deskripsi)) !!}
                            </div>
                            
                            @if($kegiatan->linkPendaftaran_url)
                                <div class="d-grid">
                                    <a href="{{ $kegiatan->linkPendaftaran_url }}" target="_blank" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                        Daftar Sekarang <i class="bi bi-box-arrow-up-right ms-2"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- ======================================================= --}}
            {{-- MODAL 2: ZOOM FULL IMAGE (UI PROFESIONAL) --}}
            {{-- ======================================================= --}}
            <div class="modal fade" id="zoomImageModal{{ $kegiatan->kegiatan_id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen"> 
                    <div class="modal-content zoom-backdrop border-0 shadow-none">
                        
                        {{-- NAVBAR TOOLS ATAS --}}
                        <div class="position-absolute top-0 w-100 d-flex justify-content-between align-items-center p-4" style="z-index: 1057;">
                            <div class="text-white opacity-50 small">
                                <i class="bi bi-image me-1"></i> Preview Mode
                            </div>
                            
                            {{-- Tombol Close Elegan --}}
                            <button type="button" class="btn-close-pro" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalKegiatan{{ $kegiatan->kegiatan_id }}" 
                                    aria-label="Back">
                                <i class="bi bi-x-lg fs-5"></i>
                            </button>
                        </div>

                        {{-- AREA GAMBAR UTAMA --}}
                        <div class="modal-body d-flex justify-content-center align-items-center p-0 w-100 h-100">
                            @if($kegiatan->gambar_url)
                                <img src="{{ asset('images/kegiatan/'.$kegiatan->gambar_url) }}" 
                                     class="img-fluid zoom-img-pro" 
                                     style="max-height: 85vh; max-width: 90vw; object-fit: contain;">
                            @else
                                <img src="https://placehold.co/800x600/1e293b/FFFFFF?text=Tidak+Ada+Gambar" class="img-fluid rounded">
                            @endif
                        </div>

                        {{-- CAPTION/JUDUL DI BAWAH --}}
                        <div class="position-absolute bottom-0 w-100 p-4 pb-5 text-center zoom-caption">
                            <h3 class="text-white fw-bold mb-1">{{ $kegiatan->judul }}</h3>
                            <p class="text-white-50 mb-0 small">
                                {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d F Y') }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>

            @empty
            <div class="col-12 text-center py-5">
                <div class="text-muted">Belum ada kegiatan yang tersedia.</div>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection