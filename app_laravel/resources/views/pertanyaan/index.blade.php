@extends('layouts.app')

@section('content')
<div class="faq-page py-5">
    <div class="container">
        {{-- 1. FORM KIRIM ASPIRASI --}}
        <div class="row justify-content-center mb-5">
            <div class="col-lg-8">
                <div class="bg-white rounded-4 shadow-lg p-4 p-md-5 position-relative overflow-hidden border-0">
                    <h3 class="fw-bold mb-2 text-center" style="color: #004b93; letter-spacing: -0.5px;">
                        Sampaikan Aspirasimu
                    </h3>
                    <p class="text-muted text-center mb-4">
                        Suara Anda sangat berarti bagi kemajuan ORMAWA FST.
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success shadow-sm border-0 rounded-3 mb-4">
                            <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('aspirasi.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-uppercase" style="color: #004b93;">Nama (Opsional)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 text-primary"><i class="bi bi-person"></i></span>
                                    <input type="text" name="nama" class="form-control bg-light border-0 py-2" placeholder="Anonim" value="{{ old('nama') }}">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small text-uppercase" style="color: #004b93;">Aspirasi / Pertanyaan</label>
                                <textarea name="pesan" class="form-control bg-light border-0" rows="3" required placeholder="Tuliskan pendapat atau pertanyaanmu di sini...">{{ old('pesan') }}</textarea>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm" 
                                    style="background-color: #004b93; border-color: #004b93;">
                                <i class="bi bi-send-fill me-1"></i> Kirim Aspirasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- 2. SEARCH BAR & JUDUL SEKSI --}}
        <div class="row justify-content-center mb-4">
            <div class="col-lg-6 text-center">
                <h3 class="fw-bold mb-3 text-white" style="letter-spacing: -1px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                    Aspirasi Terjawab
                </h3>
                <form action="{{ route('pertanyaan.index') }}" method="GET">
                    <div class="input-group shadow rounded-pill overflow-hidden bg-white border-0 p-1">
                        <span class="input-group-text bg-white border-0 ps-3 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-0 shadow-none" 
                               placeholder="Cari topik pertanyaan..." value="{{ request('search') }}">
                        <button class="btn btn-primary px-4 rounded-pill" type="submit" 
                                style="background-color: #004b93; border-color: #004b93;">Cari</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- 3. GRID KOTAK-KOTAK --}}
        <div class="aspirasi-grid">
            @forelse($pendapats as $pendapat)
                @php $balasanTerbaru = $pendapat->balasan->last(); @endphp
                <div class="aspirasi-card bg-white shadow rounded-4 overflow-hidden position-relative" 
                     style="height: 320px; transition: transform 0.3s ease; border-top: 4px solid #004b93; box-shadow: 0 6px 14px rgba(0,0,0,0.06);">

                    {{-- LAYER 1: PERTANYAAN --}}
                    <div class="card-content p-4 d-flex flex-column h-100">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" 
                                     style="width: 40px; height: 40px; background-color: #004b93; border: 2px solid #ffffff;">
                                    <span class="fw-bold">{{ substr($pendapat->nama ?: 'A', 0, 1) }}</span>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-0" style="font-size: 0.9rem; color: #004b93;">
                                        {{ $pendapat->nama ?: 'Anonim' }}
                                    </h6>
                                    <small class="text-muted" style="font-size: 0.7rem;">
                                        {{ $pendapat->waktu_kirim ? \Carbon\Carbon::parse($pendapat->waktu_kirim)->isoFormat('D MMM Y') : '' }}
                                    </small>
                                </div>
                            </div>
                            <i class="bi bi-quote fs-1 text-secondary opacity-25"></i>
                        </div>

                        <div class="flex-grow-1 overflow-hidden">
                            <p class="card-text fw-medium" style="font-size: 1.1rem; line-height: 1.5; color: #004b93;">
                                "{{ \Illuminate\Support\Str::limit($pendapat->pesan, 110) }}"
                            </p>
                        </div>
                        <div class="mt-auto text-center">
                            <small class="text-muted bg-light px-3 py-1 rounded-pill border">
                                <i class="bi bi-cursor-fill me-1 text-primary"></i> Sorot untuk jawaban
                            </small>
                        </div>
                    </div>

                    {{-- LAYER 2: JAWABAN (Hover) --}}
                    @if($balasanTerbaru)
                    <div class="admin-reply-overlay position-absolute top-0 start-0 w-100 h-100 p-4 d-flex flex-column justify-content-center text-white text-center"
                         style="background: rgba(0, 75, 147, 0.98); opacity: 0; transition: all 0.4s ease;">

                        <div class="mb-3">
                            <div class="mx-auto bg-white rounded-circle d-flex align-items-center justify-content-center mb-2 shadow" 
                                 style="width: 50px; height: 50px; color: #004b93 !important;">
                                <i class="bi bi-person-fill fs-4"></i> 
                            </div>
                            <h6 class="fw-bold text-uppercase letter-spacing-1 text-white-50" style="font-size: 0.8rem;">Jawaban Admin</h6>
                        </div>

                        <div class="overflow-auto custom-scroll" style="max-height: 150px;">
                            <p class="mb-0 fw-light" style="font-size: 1rem; line-height: 1.6;">
                                {{ $balasanTerbaru->isi_balasan }}
                            </p>
                        </div>

                        <hr class="border-light opacity-25 my-3">

                        @php
                            $namaAdmin = $balasanTerbaru->dibalas_oleh ?? 'Admin';
                            if (!\Illuminate\Support\Str::startsWith($namaAdmin, 'Admin')) {
                                $namaAdmin = 'Admin ' . $namaAdmin;
                            }
                        @endphp
                        <div class="d-flex justify-content-center align-items-center gap-2">
                            <span class="badge bg-white rounded-pill px-3 py-2 fw-normal shadow-sm" style="color: #004b93;">
                                <i class="bi bi-person-check-fill me-1"></i>
                                {{ $namaAdmin }}
                            </span>
                        </div>
                    </div>
                    @endif

                </div>
            @empty
                <div class="empty-state-full-width text-center py-5">
                    <div class="d-inline-block p-4 rounded-circle mb-3" 
                         style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">
                        <i class="bi bi-inbox text-white" style="font-size: 3rem;"></i>
                    </div>
                    <p class="text-white-50 fs-5">Belum ada aspirasi yang ditemukan.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

<style>
    body {
        background-color: #004b93 !important;
        background-image: linear-gradient(to bottom, 
            #ffffff 0px, 
            #ffffff 150px, 
            #004b93 150px, 
            #004b93 100%
        ) !important;
        background-attachment: scroll !important;
        background-repeat: no-repeat !important;
        min-height: 100vh;
        margin: 0;
    }

    footer p {
        color: rgba(255, 255, 255, 0.9) !important;
    }

    .aspirasi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 1.5rem;
        padding-bottom: 5rem;
    }

    .empty-state-full-width {
        grid-column: 1 / -1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 300px;
    }

    .aspirasi-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.2) !important;
        z-index: 10;
    }

    .aspirasi-card:hover .admin-reply-overlay {
        opacity: 1 !important;
    }

    .custom-scroll::-webkit-scrollbar { width: 4px; }
    .custom-scroll::-webkit-scrollbar-track { background: rgba(255,255,255,0.1); }
    .custom-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.3); border-radius: 10px; }
    @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
</style>
@endsection
