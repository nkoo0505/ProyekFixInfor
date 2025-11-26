@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Struktur Kepengurusan {{ $ormawa->singkatan ?? '' }}</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="mb-3 d-flex justify-content-between align-items-center">
        <div>
            <strong>Nama ORMAWA:</strong> {{ $ormawa->nama ?? '-' }}<br>
            <strong>Periode:</strong> {{ $ormawa->periode ?? '-' }}
        </div>
        <a href="{{ route('pengurus.create') }}" class="btn btn-primary">Tambah Pengurus</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 80px;">Foto</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>Nama Panggilan</th>
                    <th>Tahun Jabatan</th>
                    <th style="width: 150px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pengurusList as $item)
                    <tr>
                        <td>
                            @if ($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}" style="height: 60px; width: 60px; object-fit: cover;" class="rounded-circle">
                            @endif
                        </td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->jabatan }}</td>
                        <td>{{ $item->nama_panggilan }}</td>
                        <td>{{ $item->tahun_jabatan }}</td>
                        <td>
                            <a href="{{ route('pengurus.edit', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('pengurus.destroy', $item->id) }}" method="POST" class="d-inline form-delete-pengurus">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data pengurus.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@if (session('success') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: @json(session('success')),
                });
            @elseif ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: @json($errors->first()),
                });
            @endif
        });
    </script>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const forms = document.querySelectorAll('.form-delete-pengurus');
        forms.forEach(function (form) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah Anda Yakin Menghapus data ini?',
                    text: "Data yang dihapus tidak dapat dikembalikan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, saya yakin',
                    cancelButtonText: 'Coba saya cek kembali'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
