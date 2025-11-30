@extends('layouts.app')

@section('content')
{{-- HERO BIRU --}}
<div class="profil-hero py-5" style="background: linear-gradient(135deg, #004b93 0%, #0069d9 100%); color: white;">
    <div class="container text-center">
        <h1 class="fw-bold mb-3">Profil Organisasi Mahasiswa FST</h1>
        <p class="lead mb-4" style="max-width: 640px; margin: 0 auto;">
            Berkenalan dengan organisasi mahasiswa di Fakultas Sains & Teknologi dan struktur kepengurusan setiap ORMAWA.
        </p>
    </div>
    </div>

<div class="profil-page py-5" style="background-color: #f4f6f9; min-height: 100vh;">
    <div class="container">

        {{-- Header --}}
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #004b93;">Organisasi Mahasiswa FST</h2>
            <p class="text-muted">Mengenal lebih dekat penggerak kegiatan mahasiswa di Fakultas Sains & Teknologi.</p>
            <hr class="mx-auto" style="width: 60px; height: 3px; background-color: #004b93; opacity: 1;">
        </div>

        {{-- Grid Ormawa --}}
        <div class="row g-4 justify-content-center">
            @foreach($ormawaList as $ormawa)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-card">
                        <div class="card-body text-center p-4">
                            {{-- Logo Lingkaran --}}
                            <div class="mx-auto mb-3 d-flex align-items-center justify-content-center bg-white rounded-circle shadow-sm"
                                 style="width: 120px; height: 120px; border: 4px solid #f8f9fa;">
                                <img src="{{ $ormawa['logo_src'] }}" alt="{{ $ormawa['singkatan'] }}"
                                     class="img-fluid rounded-circle" style="width: 100%; height: 100%; object-fit: cover;">
                            </div>

                            <h4 class="fw-bold mb-1" style="color: #004b93;">{{ $ormawa['singkatan'] }}</h4>
                            <h6 class="text-muted mb-3" style="font-size: 0.9rem;">{{ $ormawa['nama'] }}</h6>

                            <p class="card-text text-secondary mb-4" style="font-size: 0.95rem;">
                                {{ \Illuminate\Support\Str::limit($ormawa['deskripsi_singkat'], 80) }}
                            </p>

                            <a href="{{ route('profil.show', $ormawa['id']) }}" class="btn btn-outline-primary rounded-pill px-4 fw-semibold stretched-link">
                                Lihat Profil
                            </a>
                        </div>
                        <div class="card-footer bg-transparent border-0 pb-3"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .profil-hero {
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection

