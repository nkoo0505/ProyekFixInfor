@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Pengurus</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="form-edit-pengurus" action="{{ route('pengurus.update', $pengurus->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $pengurus->nama) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pengurus->jabatan) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nama Panggilan</label>
            <input type="text" name="nama_panggilan" class="form-control" value="{{ old('nama_panggilan', $pengurus->nama_panggilan) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tahun Jabatan</label>
            <input type="text" name="tahun_jabatan" class="form-control" value="{{ old('tahun_jabatan', $pengurus->tahun_jabatan) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Foto Baru (opsional)</label>
            <input type="file" name="foto_file" class="form-control">
            @if ($pengurus->foto)
                <div class="mt-2">
                    <span>Foto saat ini:</span>
                    <img src="{{ asset('storage/' . $pengurus->foto) }}" alt="{{ $pengurus->nama }}" style="height: 80px; width: 80px; object-fit: cover;" class="rounded-circle d-block mt-1">
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('pengurus.index') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
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
        const form = document.getElementById('form-edit-pengurus');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin Sudah sesuai?',
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
</script>
@endsection
