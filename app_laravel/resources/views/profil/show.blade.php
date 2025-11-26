@extends('layouts.app')

@section('content')
    {{-- HERO SECTION --}}
    <div class="position-relative py-5" style="background: linear-gradient(135deg, #004b93 0%, #0069d9 100%); color: white;">
        <div class="container text-center position-relative z-2">
            {{-- Logo Besar --}}
            @php
                $logoValue = $data['logo'] ?? '';
                $logoSrc = \Illuminate\Support\Str::startsWith($logoValue, 'images/')
                    ? asset('storage/' . $logoValue)
                    : asset('images/' . ltrim($logoValue, '/'));
            @endphp
            <div class="bg-white p-1 rounded-circle d-inline-block shadow mb-3">
                <img src="{{ $logoSrc }}" alt="Logo {{ $data['nama'] }}" class="rounded-circle"
                    style="width: 140px; height: 140px; object-fit: cover;">
            </div>
            <h1 class="fw-bold mb-2">{{ $data['nama'] }}</h1>
            <h4 class="fw-light opacity-75">{{ $data['singkatan'] }} USD</h4>
        </div>
        {{-- Hiasan Background --}}
        <div class="position-absolute top-0 start-0 w-100 h-100"
            style="background-image: url('{{ asset('images/bluebackground.jpg') }}'); opacity: 0.1; background-size: cover;">
        </div>
    </div>

    <div class="container my-5">

        {{-- VISI & MISI --}}
        <div class="row g-4 mb-5">
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

        {{-- STRUKTUR PENGURUS (Horizontal Scroll) --}}
        {{-- STRUKTUR PENGURUS (Horizontal Scroll) --}}
        <div class="mb-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: #004b93;">Struktur Kepengurusan {{ $data['singkatan'] }}</h3>
                {{-- 🔥 Tambahkan Periode, jika ada di data ormawa --}}
                <h5 class="fw-light text-muted">Periode {{ $data['periode'] ?? '20XX/20XX' }}</h5>
                <hr class="mx-auto" style="width: 50px; height: 3px; background-color: #004b93;">
            </div>

            @if ($data['pengurus_list']->isNotEmpty())
                {{-- Kontainer dengan Horizontal Scroll --}}
                <div class="d-flex overflow-auto pb-3" style="scrollbar-width: thin; scrollbar-color: #004b93 #f1f1f1;">
                    <div class="d-flex flex-row flex-nowrap gap-4 px-2">

                        @foreach ($data['pengurus_list'] as $pengurus)
                            {{-- Kartu Pengurus --}}
                            <div class="card shadow-sm border-0 rounded-4 flex-shrink-0 text-center hover-card"
                                style="width: 250px;">
                                <div class="p-3">
                                    {{-- Foto Pengurus --}}
                                    <div class="mx-auto rounded-circle overflow-hidden mb-3 shadow"
                                        style="width: 150px; height: 150px;">
                                        @php
                                            $fotoPath = $pengurus['foto_url'] ?? null;
                                            $fotoSrc = $fotoPath ? asset('storage/' . $fotoPath) : asset('images/placeholder_profile.png');
                                        @endphp
                                        <img src="{{ $fotoSrc }}"
                                            alt="{{ $pengurus['nama'] }}" class="img-fluid w-100 h-100"
                                            style="object-fit: cover;">
                                    </div>

                                    <h5 class="fw-bold mb-0 text-truncate" style="color: #004b93;">
                                        {{-- 🔥 Tampilkan Nama Panggilan jika ada, atau Nama Lengkap --}}
                                        {{ $pengurus['nama_panggilan'] ? $pengurus['nama_panggilan'] : $pengurus['nama'] }}
                                    </h5>

                                    <p class="text-muted mb-1" style="font-size: 0.9rem;">
                                        {{ $pengurus['jabatan'] }}
                                    </p>

                                    {{-- 🔥 Tampilkan Nama Lengkap dan Tahun Jabatan sebagai detail --}}
                                    <small class="text-secondary d-block mt-2">
                                        {{ $pengurus['nama'] }}
                                    </small>
                                    <small class="text-primary fw-semibold d-block">
                                        {{ $pengurus['tahun_jabatan'] }}
                                    </small>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @else
                <div class="text-center text-muted card shadow-sm p-5">Data struktur kepengurusan belum tersedia.</div>
            @endif
        </div>

        {{-- GALERI / POSTER KEGIATAN --}}
        <div class="mb-5">
            <div class="text-center mb-4">
                <h3 class="fw-bold" style="color: #004b93;">Galeri Kegiatan</h3>
                <hr class="mx-auto" style="width: 50px; height: 3px; background-color: #004b93;">
            </div>

            <div class="row g-3 justify-content-center">
                @forelse($data['galeri'] as $img)
                    <div class="col-md-4 col-6">
                        <div class="card border-0 shadow-sm rounded-3 overflow-hidden h-100 group-hover-zoom">
                            {{-- Menggunakan asset() untuk URL gambar --}}
                            <img src="{{ asset($img) }}" alt="Kegiatan" class="img-fluid w-100 h-100"
                                style="object-fit: cover; min-height: 250px;">
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Belum ada dokumentasi kegiatan.</div>
                @endforelse
            </div>

            <div class="text-center mt-4">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-outline-primary rounded-pill px-4">
                    Lihat Semua Kegiatan
                </a>
            </div>
        </div>
    </div>

    <style>
        /* Import icon bootstrap */
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");

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

        /* CSS untuk Scrollbar Custom (Webkit browsers) */
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
@endsection
