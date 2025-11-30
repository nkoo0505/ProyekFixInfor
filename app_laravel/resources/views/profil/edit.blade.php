@extends('layouts.app')

@section('content')
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-primary text-white rounded-top-4">
                        <h4 class="mb-0">Edit Profil ORMAWA</h4>
                    </div>
                    <div class="card-body p-4">
                        @if (session('sukses'))
                            <div class="alert alert-success mb-4">{{ session('sukses') }}</div>
                        @endif

                        @if ($errors->any())
                            <div class="alert alert-danger mb-4">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('profilku.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Nama ORMAWA</label>
                                <input type="text" name="nama_ormawa" class="form-control"
                                       value="{{ old('nama_ormawa', $ormawa->nama_ormawa) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Periode</label>
                                <input type="text" name="periode" class="form-control"
                                       value="{{ old('periode', $ormawa->periode) }}" placeholder="contoh: 2025/2026">
                                <small class="text-muted d-block mt-1">
                                    Gunakan format tahunA/tahunB, contoh: 2025/2026. Tahun awal tidak boleh lebih besar dari tahun akhir.
                                </small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Kontak Person</label>
                                <input type="text" name="kontak_person" class="form-control"
                                       value="{{ old('kontak_person', $ormawa->kontak_person) }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Visi</label>
                                <textarea name="visi" class="form-control" rows="3">{{ old('visi', $ormawa->visi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Misi (pisahkan tiap poin dengan enter)</label>
                                <textarea name="misi" class="form-control" rows="4">{{ old('misi', $ormawa->misi) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Profil</label>
                                <textarea name="deskripsi_profil" class="form-control" rows="4">{{ old('deskripsi_profil', $ormawa->deskripsi_profil) }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Logo ORMAWA</label>
                                <input type="file" name="logo" class="form-control">
                                <small class="text-muted d-block mt-1">
                                    Format: JPG, PNG, WEBP. Maks 2 MB. Disarankan rasio 1:1 (contoh 800 x 800 piksel).
                                </small>
                                <div class="mt-2">
                                    <img src="{{ $logoSrc }}" alt="Logo sekarang" style="height: 80px; width: 80px; object-fit: cover;" class="rounded-circle border">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Foto Highlight Profil (maks. 5 gambar)</label>
                                <input type="file" name="highlight_gallery[]" class="form-control" multiple>
                                <small class="text-muted d-block mt-1">
                                    Format: JPG, PNG, WEBP. Maks 4 MB per gambar. Disarankan rasio lebar:tinggi sekitar 4:1 (contoh 1600 x 400 piksel). Anda dapat memilih hingga 5 gambar, yang akan ditampilkan sebagai slider banner di halaman profil ORMAWA.
                                </small>
                                @if(!empty($highlightGallery))
                                    <div class="mt-2 d-flex flex-wrap gap-2">
                                        @foreach($highlightGallery as $img)
                                            @php
                                                $url = is_array($img) ? ($img['url'] ?? null) : $img;
                                            @endphp
                                            @if($url)
                                                <img src="{{ $url }}" alt="Highlight" style="height: 80px; width: 160px; object-fit: cover;" class="rounded border">
                                            @endif
                                        @endforeach
                                    </div>
                                @elseif(isset($highlightSrc))
                                    <div class="mt-2">
                                        <img src="{{ $highlightSrc }}" alt="Highlight sekarang" style="height: 80px; width: 160px; object-fit: cover;" class="rounded border">
                                    </div>
                                @endif
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('profil.show', $ormawa->ormawa_id) }}" class="btn btn-outline-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>

                        <hr class="my-4">

                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="mb-0">Struktur Kepengurusan</h5>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="btnTambahPengurus">
                                    Tambah Pengurus
                                </button>
                            </div>

                            @if(isset($pengurusList) && $pengurusList->isNotEmpty())
                                <div class="table-responsive">
                                    <table class="table align-middle">
                                        <thead>
                                            <tr>
                                                <th>Pengurus</th>
                                                <th>Jabatan</th>
                                                <th class="text-end">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pengurusList as $pengurus)
                                                @php
                                                    $fotoPath = $pengurus->foto ?? null;
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
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="rounded-circle overflow-hidden me-3" style="width: 48px; height: 48px;">
                                                                <img src="{{ $fotoSrc }}" alt="{{ $pengurus->nama }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                                            </div>
                                                            <div>
                                                                <div class="fw-semibold">{{ $pengurus->nama }}</div>
                                                                @if(!empty($pengurus->tahun_jabatan))
                                                                    <div class="text-muted small">{{ $pengurus->tahun_jabatan }}</div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge text-bg-primary">{{ $pengurus->jabatan }}</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <button type="button" class="btn btn-sm btn-outline-secondary me-1" data-bs-toggle="modal" data-bs-target="#modalEditPengurus{{ $pengurus->id }}">
                                                            Edit
                                                        </button>
                                                        <form action="{{ route('pengurus.destroy', $pengurus->id) }}" method="POST" class="d-inline form-delete-pengurus">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-muted small">Belum ada data struktur kepengurusan.</div>
                            @endif
                        </div>

                        <div class="modal fade" id="modalTambahPengurus" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Tambah Pengurus</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('pengurus.store') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama Lengkap</label>
                                                    <input type="text" name="nama" class="form-control" required pattern="^[A-Za-z\s]+$" title="Nama tidak boleh mengandung angka.">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Nama Panggilan (opsional)</label>
                                                    <input type="text" name="nama_panggilan" class="form-control" pattern="^[A-Za-z\s]+$" title="Nama panggilan tidak boleh mengandung angka.">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Jabatan</label>
                                                    <input type="text" name="jabatan" class="form-control" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">Tahun Angkatan</label>
                                                    <input type="number" name="tahun_jabatan" class="form-control" min="1900" max="2100" step="1" placeholder="2023">
                                                </div>
                                                <div class="col-12">
                                                    <label class="form-label">Foto Pengurus</label>
                                                    <input type="file" name="foto" class="form-control">
                                                    <small class="text-muted">Format: JPG, PNG, WEBP. Maks 2 MB.</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if(isset($pengurusList) && $pengurusList->isNotEmpty())
                            @foreach($pengurusList as $pengurus)
                                <div class="modal fade" id="modalEditPengurus{{ $pengurus->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Pengurus</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="{{ route('pengurus.update', $pengurus->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row g-3">
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nama Lengkap</label>
                                                            <input type="text" name="nama" class="form-control" value="{{ $pengurus->nama }}" required pattern="^[A-Za-z\s]+$" title="Nama tidak boleh mengandung angka.">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Nama Panggilan (opsional)</label>
                                                            <input type="text" name="nama_panggilan" class="form-control" value="{{ $pengurus->nama_panggilan }}" pattern="^[A-Za-z\s]+$" title="Nama panggilan tidak boleh mengandung angka.">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Jabatan</label>
                                                            <input type="text" name="jabatan" class="form-control" value="{{ $pengurus->jabatan }}" required>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label">Tahun Angkatan</label>
                                                            <input type="number" name="tahun_jabatan" class="form-control" value="{{ $pengurus->tahun_jabatan }}" min="1900" max="2100" step="1" placeholder="2023">
                                                        </div>
                                                        <div class="col-12">
                                                            <label class="form-label">Foto Pengurus</label>
                                                            <input type="file" name="foto" class="form-control">
                                                            <small class="text-muted d-block mb-1">Format: JPG, PNG, WEBP. Maks 2 MB.</small>
                                                            <small class="text-muted d-block mb-2">Biarkan kosong jika tidak ingin mengubah foto.</small>
                                                            @php
                                                                $fotoPath = $pengurus->foto ?? null;
                                                                if ($fotoPath) {
                                                                    $cleanFoto = ltrim($fotoPath, '/');
                                                                    if (\Illuminate\Support\Str::startsWith($cleanFoto, 'images/')) {
                                                                        $editFotoSrc = asset($cleanFoto);
                                                                    } else {
                                                                        $editFotoSrc = asset('storage/' . $cleanFoto);
                                                                    }
                                                                } else {
                                                                    $editFotoSrc = asset('images/placeholder_profile.png');
                                                                }
                                                            @endphp
                                                            <img src="{{ $editFotoSrc }}" alt="{{ $pengurus->nama }}" style="height: 70px; width: 70px; object-fit: cover;" class="rounded-circle border mt-2">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tambahBtn = document.getElementById('btnTambahPengurus');
        const modalTambahEl = document.getElementById('modalTambahPengurus');

        if (tambahBtn && modalTambahEl && window.bootstrap && bootstrap.Modal) {
            const tambahModal = new bootstrap.Modal(modalTambahEl);
            tambahBtn.addEventListener('click', function () {
                tambahModal.show();
            });
        }

        const deleteForms = document.querySelectorAll('.form-delete-pengurus');

        deleteForms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda Yakin Menghapus Data ini?',
                    text: "Data Anda tidak bisa kembali lagi",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#5b5d5bff',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Saya Yakin.',
                    cancelButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if (session('hapus_pengurus'))
            Swal.fire({
                title: 'Deleted!',
                text: '{{ session('hapus_pengurus') }}',
                icon: 'success'
            });
        @endif
    });
</script>
@endsection
