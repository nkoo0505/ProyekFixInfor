@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Profil ORMAWA</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama ORMAWA</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $ormawa->nama) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Singkatan</label>
            <input type="text" name="singkatan" class="form-control" value="{{ old('singkatan', $ormawa->singkatan) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi Singkat</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $ormawa->deskripsi) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Visi</label>
            <textarea name="visi" class="form-control" rows="3">{{ old('visi', $ormawa->visi) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Misi (pisahkan setiap poin dengan baris baru)</label>
            <textarea name="misi" class="form-control" rows="5">{{ old('misi', $ormawa->misi) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Periode</label>
            <input type="text" name="periode" class="form-control" value="{{ old('periode', $ormawa->periode) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Logo</label>
            <input type="file" name="logo_file" class="form-control">
            @if ($ormawa->logo)
                <div class="mt-2">
                    <span>Logo saat ini:</span>
                    <img src="{{ asset($ormawa->logo) }}" alt="Logo" style="max-height: 80px;" class="d-block mt-1">
                </div>
            @endif
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('beranda') }}" class="btn btn-secondary">Kembali</a>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </div>
    </form>
</div>
@if (session('success') || $errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if (session('success'))
                Swal.fire({
                    title: "Drag me!",
                    icon: "success",
                    draggable: true
                });
            @elseif ($errors->any())
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: @json($errors->first()),
                });
            @endif
        });
    </script>
@endif
@endsection
