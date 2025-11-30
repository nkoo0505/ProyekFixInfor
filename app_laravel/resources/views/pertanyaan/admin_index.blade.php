@extends('layouts.app')

@section('content')
    <div class="container py-5" style="min-height: 90vh;">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="fw-bold mb-4" style="color: #004b93;">Admin: Kelola Aspirasi & Pertanyaan</h2>

                @if (session('success'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                position: "center",
                                icon: "success",
                                title: "{{ session('success') }}",
                                showConfirmButton: false,
                                timer: 1500
                            });
                        });
                    </script>
                @endif

                @forelse ($semuaPendapat as $pendapat)
                    @php $balasanTerbaru = $pendapat->balasan->last(); @endphp
                    <div class="card mb-4 shadow-sm border-0 rounded-4" style="box-shadow: 0 10px 24px rgba(0, 75, 147, 0.06); border-left: 4px solid #004b93; background-color: #ffffff;">
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3 pb-2 border-bottom">
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

                                @if ($pendapat->STATUS === 'SELESAI' && $balasanTerbaru)
                                    <span class="badge bg-success text-white p-2">SUDAH DIJAWAB</span>
                                @else
                                    <span class="badge bg-danger text-white p-2">BARU / Pending</span>
                                @endif
                            </div>

                            <div class="mt-3">
                                <h6 class="fw-bold mb-2" style="color: #004b93;">
                                    {{ $balasanTerbaru ? 'Edit Jawaban Anda' : 'Tulis Balasan' }}</h6>

                                <div class="d-flex justify-content-between align-items-end">
                                    <form action="{{ route('admin.pertanyaan.balas') }}" method="POST"
                                        class="flex-grow-1 me-3">
                                        @csrf
                                        <input type="hidden" name="pendapat_id" value="{{ $pendapat->pendapat_id }}">

                                        <div class="mb-3">
                                            <textarea name="isi_balasan" class="form-control" rows="3" required
                                                placeholder="Tulis balasan resmi dari ORMAWA di sini...">{{ $balasanTerbaru->isi_balasan ?? '' }}</textarea>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-sm px-3"
                                            style="background-color: #004b93; border-color: #004b93;">
                                            <i class="bi bi-save-fill me-1"></i> Simpan Jawaban
                                        </button>
                                    </form>

                                    <div>
                                        <form action="{{ route('admin.pertanyaan.destroy', $pendapat->pendapat_id) }}"
                                            method="POST" class="d-inline"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus aspirasi ini? Menghapus akan menghapus jawaban terkait juga.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger px-3">
                                                <i class="bi bi-trash-fill"></i> Hapus Aspirasi
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                @if ($balasanTerbaru)
                                    @php
                                        $namaAdmin = $balasanTerbaru->dibalas_oleh ?? 'Admin';
                                        if (!\Illuminate\Support\Str::startsWith($namaAdmin, 'Admin')) {
                                            $namaAdmin = 'Admin ' . $namaAdmin;
                                        }
                                    @endphp
                                    <div class="d-flex align-items-center mt-3 text-success fst-italic">
                                        <div class="me-2 rounded-circle d-flex align-items-center justify-content-center bg-success-subtle"
                                            style="width: 28px; height: 28px;">
                                            <i class="bi bi-person-check-fill"></i>
                                        </div>
                                        <small>
                                            Jawaban terakhir oleh: {{ $namaAdmin }}
                                            pada
                                            {{ $balasanTerbaru->waktu_kirim ? \Carbon\Carbon::parse($balasanTerbaru->waktu_kirim)->isoFormat('D MMM Y') : '' }}
                                        </small>
                                    </div>
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
