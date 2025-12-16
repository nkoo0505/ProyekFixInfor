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
        background: #003B73;
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

    .img-preview-container {
        position: relative;
        width: 150px;
        height: 150px;
        border-radius: 10px;
        overflow: hidden;
        border: 2px dashed #ced4da;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }
    
    .img-preview {
        width: 100%;
        height: 100%;
        object-fit: cover;
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
                    <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i> Edit Kegiatan</h4>
                    <span class="badge bg-white text-primary px-3 py-2 rounded-pill">Mode Edit</span>
                </div>

                <div class="card-body p-4 p-md-5">

                        {{-- Form Edit Kegiatan --}}
                    <form action="{{ route('kegiatan.update', $kegiatan->kegiatan_id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Input: Judul --}}
                        <div class="mb-4">
                            <label class="form-label">Nama Kegiatan <span class="text-danger">*</span></label>
                            <input type="text" name="judul" value="{{ old('judul', $kegiatan->judul) }}" class="form-control form-control-lg" placeholder="Contoh: Seminar Nasional Teknologi 2025" required>
                        </div>

                        {{-- Input: Deskripsi --}}
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea class="form-control" name="deskripsi" rows="5" placeholder="Jelaskan detail kegiatan, tujuan, dan sasaran peserta...">{{ old('deskripsi', $kegiatan->deskripsi) }}</textarea>
                        </div>

                        {{-- Row: Ormawa & Link --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Penyelenggara (Ormawa)</label>
                                <input type="text" class="form-control bg-light" value="{{ auth()->user()->nama_ormawa }}" readonly>
                                <small class="text-muted"><i class="bi bi-lock-fill me-1"></i> Tidak dapat diubah</small>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Link Pendaftaran <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-white"><i class="bi bi-link-45deg"></i></span>
                                    <input type="url" name="linkPendaftaran_url" value="{{ old('linkPendaftaran_url', $kegiatan->linkPendaftaran_url) }}" class="form-control" placeholder="https://" required>
                                </div>
                            </div>
                        </div>

                        {{-- Row: Tanggal --}}
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', $kegiatan->tanggal_mulai) }}" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Tanggal Selesai <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', $kegiatan->tanggal_selesai) }}" class="form-control" required>
                            </div>
                        </div>

                        <hr class="my-4 text-muted">

                        {{-- Input: Gambar --}}
                        <div class="mb-4">
                            <label class="form-label d-block">Poster Kegiatan</label>
                            <div class="d-flex align-items-start gap-4">
                                {{-- Preview Gambar Lama --}}
                                <div class="img-preview-container shadow-sm">
                                    @if($kegiatan->gambar_url)
                                        <img src="{{ asset('images/kegiatan/'.$kegiatan->gambar_url) }}" class="img-preview" alt="Poster Lama">
                                    @else
                                        <div class="text-center text-muted p-2 small">Tidak ada poster</div>
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <input type="file" name="gambar_url" class="form-control mb-2" accept="image/*">
                                    <div class="small text-muted">
                                        <i class="bi bi-info-circle me-1"></i> Biarkan kosong jika tidak ingin mengubah poster.
                                        <br>Format: JPG, PNG, JPEG. Maks: 2MB.
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('kegiatan.index') }}" class="btn btn-light border px-4">Batal</a>
                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-sm">
                                <i class="bi bi-save me-2"></i> Simpan Perubahan
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert Script (Jika diperlukan) --}}
@if ($errors->any())
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
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