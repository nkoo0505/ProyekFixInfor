@extends('layouts.app')

@section('content')
    <div class="container py-5" style="min-height: 90vh;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="fw-bold mb-4" style="color: #004b93;">Admin: Kelola Aspirasi & Pertanyaan</h2>

                {{-- Tampilkan notifikasi sukses --}}
                @if (session('success'))
                    <script>
                        // Pastikan kode dijalankan setelah halaman siap
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "{{ session('success') }}", // Ambil pesan dari session PHP
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                    </script>
                @endif
    


                {{-- Loop untuk setiap pendapat yang masuk --}}
                @forelse ($semuaPendapat as $pendapat)
                    <div class="card mb-3 shadow-sm border-0 rounded-3">
                        <div class="card-body p-4">
                            
                            {{-- Header dan Status --}}
                            <div
                                class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
                                <div>
                                    <h5 class="fw-bold mb-0 text-dark">
                                        {{ $pendapat->pesan }}
                                        </h5>
                                    <small class="text-muted">Dari:
                                        
                                        <strong>{{ $pendapat->nama ?: 'Anonim' }}</strong>
                                        pada
                                        {{ $pendapat->waktu_kirim ? \Carbon\Carbon::parse($pendapat->waktu_kirim)->isoFormat('D MMM Y, HH:mm') : 'N/A' }}
                                        </small>
                                    </div>
                                
                                {{-- Badge Status --}}
                                @if ($pendapat->status == 'pending' || !$pendapat->balasan)
                                    <span class="badge bg-danger text-white p-2">BARU / Pending</span>
                                @else
                                    <span class="badge bg-success text-white p-2">SUDAH DIJAWAB</span>
                                @endif
                                </div>
                            

                            {{-- =============================================== --}}
                            {{-- Tampilkan Form Balas / Edit Jawaban --}}
                            {{-- =============================================== --}}
                            <div class="mt-3">
                                <h6 class="fw-bold mb-2" style="color: #004b93;">
                                    {{ $pendapat->balasan ? 'Edit Jawaban Anda' : 'Tulis Balasan' }}</h6>
                                
                                {{-- 🔥 DIV FLEX BARU: Membungkus kedua form agar bersebelahan --}}
                                <div class="d-flex justify-content-between align-items-end">

                                    {{-- 🔥 FORM BALAS: HANYA BERISI INPUT DAN TOMBOL SIMPAN (method POST) --}}
                                    <form action="{{ route('admin.aspirasi.store') }}" method="POST"
                                        class="flex-grow-1 me-3">
                                        @csrf
                                        {{-- Kirim ID pendapat yang mau dibalas --}}
                                        <input type="hidden" name="pendapat_id" value="{{ $pendapat->pendapat_id }}">

                                        <div class="mb-3">
                                            <textarea name="isi_balasan" class="form-control" rows="3" required
                                                placeholder="Tulis balasan resmi dari ORMAWA di sini...">{{ $pendapat->balasan->isi_balasan ?? '' }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm px-3"
                                            style="background-color: #004b93; border-color: #004b93;">
                                            <i class="bi bi-save-fill me-1"></i> Simpan Jawaban
                                        </button>
                                    </form>

                                    {{-- 🔥 FORM HAPUS: TERPISAH (method DELETE) --}}
                                    <div>
                                        <form action="{{ route('admin.aspirasi.destroy', $pendapat->pendapat_id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini? Menghapus akan menghapus jawaban terkait juga.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                                <i class="bi bi-trash-fill"></i> Hapus Aspirasi
                                            </button>
                                        </form>
                                    </div>
                                </div> {{-- AKHIR DIV FLEX BARU --}}

                                {{-- Info Jawaban Lama (jika ada) --}}
                                @if ($pendapat->balasan)
                                    <small class="text-success mt-3 d-block fst-italic">
                                        Jawaban terakhir oleh:
                                        {{ $pendapat->balasan->dibalas_oleh ?? 'Admin' }}
                                        ({{ $pendapat->balasan->ormawa->singkatan ?? 'ORMAWA' }})
                                        pada
                                        {{ $pendapat->balasan->waktu_kirim ? \Carbon\Carbon::parse($pendapat->balasan->waktu_kirim)->isoFormat('D MMM Y') : '' }}
                                    </small>
                                @endif
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center shadow-sm border-0">
                        <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                        Belum ada pertanyaan atau pendapat baru yang masuk.
                    </div>
                @endforelse

            </div>
        </div>
    </div>
    <style>
        @import url("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css");
    </style>
@endsection
