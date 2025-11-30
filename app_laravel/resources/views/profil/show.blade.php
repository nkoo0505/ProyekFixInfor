@extends('layouts.app')

@section('content')
    {{-- HERO SECTION: SLIDER HIGHLIGHT --}}
    @php
        $highlightImages = $data['highlight_images'] ?? [];
        if (empty($highlightImages)) {
            $highlightImages = [$data['highlight_src'] ?? $data['logo_src']];
        }
    @endphp

    <div id="profilHighlightCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="7000">
        <div class="carousel-inner">
            @foreach($highlightImages as $index => $img)
                @php
                    $imgUrl = is_array($img) ? ($img['url'] ?? null) : $img;
                    $imgHref = is_array($img) ? ($img['href'] ?? null) : null;
                @endphp
                @if($imgUrl)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        @if($imgHref)
                            <a href="{{ $imgHref }}" class="d-block">
                                <div class="profile-banner" style="background-image: url('{{ $imgUrl }}');"></div>
                            </a>
                        @else
                            <div class="profile-banner" style="background-image: url('{{ $imgUrl }}');"></div>
                        @endif
                    </div>
                @endif
            @endforeach
        </div>
        @if(count($highlightImages) > 1)
            <button class="carousel-control-prev" type="button" data-bs-target="#profilHighlightCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#profilHighlightCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        @endif
    </div>

    {{-- IDENTITAS & LOGO DI BAWAH BANNER --}}
    <div class="container text-center mb-5">
        <div class="profile-logo-container">
            <img src="{{ $data['logo_src'] }}" alt="Logo {{ $data['nama'] }}" class="profile-logo rounded-circle">
        </div>

        <div class="mt-4">
            <h2 class="fw-bold text-uppercase" style="color: #004b93; letter-spacing: 1px;">
                {{ $data['nama'] }}
            </h2>
            <h5 class="text-secondary fst-italic">{{ $data['singkatan'] }}</h5>
        </div>
    </div>

    <div class="container py-5">

        {{-- VISI & MISI --}}
        <div class="row g-4 bg-white shadow rounded-4 px-4 py-5" style="margin-top: 0; margin-bottom: 4rem;">
            {{-- Kartu Visi --}}
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 text-center pt-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-opacity-10 text-primary rounded-circle mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-lightbulb fs-3"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #004b93;">VISI</h3>
                    </div>
                    <div class="card-body text-center px-4 pb-5">
                        <p class="lead text-dark" style="font-style: italic;">
                            "{{ $data['visi'] }}"
                        </p>
                    </div>
                </div>
            </div>

            {{-- Kartu Misi --}}
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-header bg-white border-0 text-center pt-4">
                        <div class="d-inline-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-circle mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="bi bi-list-check fs-3"></i>
                        </div>
                        <h3 class="fw-bold" style="color: #004b93;">MISI</h3>
                    </div>
                    <div class="card-body px-4 pb-5">
                        <ul class="list-group list-group-flush">
                            @foreach ($data['misi'] as $misi)
                                <li class="list-group-item border-0 px-0 d-flex bg-transparent">
                                    <i class="bi bi-check-circle-fill text-success me-3 mt-1"></i>
                                    <span class="text-secondary">{{ $misi }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STRUKTUR KEPENGURUSAN (Background Biru) --}}
    <div class="structure-section">
        <div class="container position-relative">
                <div class="text-center mb-4">
                    <h3 class="fw-bold mb-1">STRUKTUR KEPENGURUSAN {{ $data['singkatan'] }}</h3>
                    <p class="opacity-75">Periode {{ $data['periode'] ?? '20XX/20XX' }}</p>
                </div>

                {{-- Tombol Navigasi Kiri --}}
                <button class="slider-btn left d-none d-md-flex" onclick="scrollStructure(-1)">
                    <i class="bi bi-chevron-left fs-4"></i>
                </button>

                {{-- Container Scroll --}}
                <div class="d-flex justify-content-center">
                    <div style="width: 90%; overflow: hidden;">
                        <div class="pengurus-scroll" id="structureScroll">
                            @if (collect($data['pengurus_list'])->isNotEmpty())
                                @foreach ($data['pengurus_list'] as $pengurus)
                                    <div class="pengurus-card shadow-sm text-center pb-4">
                                        @php
                                            $fotoPath = $pengurus['foto_url'] ?? null;
                                            if ($fotoPath) {
                                                $cleanFoto = ltrim($fotoPath, '/');
                                                if (\Illuminate\Support\Str::startsWith($cleanFoto, 'images/')) {
                                                    $fotoSrc = asset($cleanFoto);
                                                } else {
                                                    $fotoSrc = asset('storage/' . $cleanFoto);
                                                }
                                            } else {
                                                $fotoSrc = asset('images/placeholder_profile.png');
                                            }
                                        @endphp

                                        <img src="{{ $fotoSrc }}" alt="{{ $pengurus['nama'] }}" class="pengurus-img mb-3">

                                        <div class="px-3">
                                            <h6 class="fw-bold text-primary mb-1 text-truncate">
                                                {{ $pengurus['nama_panggilan'] ? $pengurus['nama_panggilan'] : $pengurus['nama'] }}
                                            </h6>
                                            <small class="text-muted d-block fw-semibold mb-2" style="font-size: 0.85rem;">
                                                {{ $pengurus['jabatan'] }}
                                            </small>
                                            <small class="text-secondary d-block text-truncate" style="font-size: 0.75rem;">
                                                {{ $pengurus['nama'] }}
                                            </small>
                                            @if(!empty($pengurus['tahun_jabatan']))
                                                <small class="text-light d-block mt-1" style="font-size: 0.75rem;">
                                                    {{ $pengurus['tahun_jabatan'] }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-white text-center w-100 py-5">
                                    <i class="bi bi-people fs-1 opacity-50"></i>
                                    <p class="mt-2">Belum ada data pengurus.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tombol Navigasi Kanan --}}
                <button class="slider-btn right d-none d-md-flex" onclick="scrollStructure(1)">
                    <i class="bi bi-chevron-right fs-4"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- GALERI / POSTER KEGIATAN --}}
    @if(count($data['galeri']) > 0)
        <div class="container my-5">
            <div class="text-center mb-4">
                <h4 class="fw-bold text-primary">Galeri Kegiatan</h4>
            </div>
            <div class="row g-3 justify-content-center">
                @foreach(array_slice($data['galeri'], 0, 3) as $img)
                    <div class="col-md-4">
                        <div class="rounded-3 overflow-hidden shadow-sm ratio ratio-4x3">
                            <img src="{{ asset($img) }}" class="w-100 h-100 object-fit-cover" alt="Kegiatan">
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center mt-3">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-link text-decoration-none">Lihat Selengkapnya &rarr;</a>
            </div>
        </div>
    @endif

    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

        /* Banner highlight penuh */
        .profile-banner {
            height: 350px;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .profile-banner::before {
            content: '';
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.2);
        }

        /* Logo overlap di bawah banner */
        .profile-logo-container {
            margin-top: -75px;
            position: relative;
            z-index: 10;
        }

        .profile-logo {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            background-color: #ffffff;
        }

        /* Section struktur biru */
        .structure-section {
            background-color: #0d47a1;
            color: #ffffff;
            padding-top: 3rem;
            padding-bottom: 3rem;
            position: relative;
            margin-top: 1rem;
        }

        .pengurus-card {
            background: #ffffff;
            color: #333333;
            border-radius: 8px;
            width: 220px;
            flex-shrink: 0;
            transition: transform 0.2s;
        }

        .pengurus-card:hover {
            transform: translateY(-5px);
        }

        .pengurus-img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            margin-top: 1.5rem;
            border: 3px solid #f0f0f0;
        }

        .pengurus-scroll {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 20px 0;
            scrollbar-width: none;
        }

        .pengurus-scroll::-webkit-scrollbar {
            display: none;
        }

        .slider-btn {
            background: rgba(255,255,255,0.2);
            color: #ffffff;
            border: none;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.3s;
            position: absolute;
            top: 60%;
            transform: translateY(-50%);
            z-index: 5;
        }

        .slider-btn:hover {
            background: rgba(255,255,255,0.4);
        }

        .slider-btn.left {
            left: 20px;
        }

        .slider-btn.right {
            right: 20px;
        }

        .group-hover-zoom,
        .hover-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .group-hover-zoom:hover,
        .hover-card:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        .overflow-auto::-webkit-scrollbar {
            height: 8px;
        }

        .overflow-auto::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .overflow-auto::-webkit-scrollbar-thumb {
            background: #004b93;
            border-radius: 10px;
        }

        .overflow-auto::-webkit-scrollbar-thumb:hover {
            background: #003366;
        }
    </style>

    <script>
        function scrollStructure(direction) {
            const container = document.getElementById('structureScroll');
            const scrollAmount = 240; // lebar kartu + gap
            if (container) {
                container.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        }
    </script>
@endsection

