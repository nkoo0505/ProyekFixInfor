@extends('layouts.app')

@section('content')
<style>
    body { background-color: #f4f6f9; }
    
    .form-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
        border: none;
        overflow: hidden;
    }

    .form-header {
        background: #003B73; /* Warna Primary Konsisten */
        padding: 25px;
        color: white;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 8px;
    }

    .form-control:focus {
        border-color: #003B73;
        box-shadow: 0 0 0 0.2rem rgba(0, 59, 115, 0.15);
    }

    .btn-back {
        background-color: transparent;
        color: #6c757d;
        border: 1px solid #ced4da;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background-color: #e9ecef;
        color: #495057;
    }

    /* Area Upload Gambar Sederhana */
    .upload-area {
        border: 2px dashed #ced4da;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        background: #f8f9fa;
        transition: border-color 0.3s;
    }
    .upload-area:hover {
        border-color: #003B73;
    }
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            {{-- Tombol Kembali --}}
            <div class="mb-4">
                <a href="{{ route('kegiatan.index') }}" class="btn btn-back rounded-pill px-4">
                    <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>

            {{-- Kartu Form --}}
            <div class="card form-card">
                
                {{-- Header Biru --}}
                <div class="form-header d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 fw-bold"><i class="bi bi-plus-circle me-2"></i> Tambah Kegiatan Baru</h4>
                </div>

                <div class="card-body p-4 p-md-5">


                    <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Input: Judul --}}
                        <div class="mb-4">
                            <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul') }}" class="form-control form-control-lg" placeholder="Contoh: Seminar Nasional Teknologi 2025" required>
                        </div>

                        {{-- Input: Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea class="form-control" name="deskripsi" rows="5" placeholder="Jelaskan detail kegiatan, tujuan, dan sasaran peserta...">{{ old('deskripsi') }}</textarea>
                        </div>

                        {{-- Row: Ormawa & Link --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Penyelenggara (Ormawa)</label>
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->nama_ormawa }}" readonly>
                                <small class="text-muted"><i class="bi bi-lock-fill me-1"></i> Otomatis terisi</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Link Pendaftaran <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-link-45deg"></i></span>
                                    <input type="url" name="linkPendaftaran_url" value="{{ old('linkPendaftaran_url') }}" class="form-control" placeholder="https://" required>
                                </div>
                            </div>
                        </div>

                        {{-- Row: Tanggal --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" class="form-control" required>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        {{-- Input: Gambar --}}
                        <div class="mb-4">
                            <label class="form-label d-block">Poster Kegiatan</label>
                            <div class="upload-area">
                                <input type="file" name="gambar_url" class="form-control mb-2" accept="image/*">
                                <div class="small text-muted">
                                    <i class="bi bi-info-circle me-1"></i> Format: JPG, PNG, JPEG. Maks: 2MB. (Opsional)
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('kegiatan.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-success px-5 fw-bold shadow-sm">
                                <i class="bi bi-check-lg me-2"></i> Simpan Kegiatan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert Script --}}
@if ($errors->any())
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Validasi Gagal',
        text: 'Mohon periksa kembali isian formulir Anda.',
        confirmButtonColor: '#003B73'
    });
</script>
@endif

@endsection