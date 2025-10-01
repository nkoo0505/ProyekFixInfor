@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="mt-4">
            <a href="{{ route('kegiatan.index') }}" class="btn btn-dark">Kembali</a>
        </div>
        
        <div class="mt-3">
            <h1>Tambah Kegiatan Baru</h1>
            
            @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mt-2">    
                    <label>Nama Kegiatan:</label>
                    <input required type="text" name="nama_kegiatan" value="{{ old('nama_kegiatan') }}" class="form-control" placeholder="Masukkan nama kegiatan">
                </div>

                <div class="mt-3">
                    <label>Deskripsi:</label>
                    <textarea class="form-control" placeholder="Deskripsikan kegiatan" name="deskripsi">{{ old('deskripsi') }}</textarea>
                
                </div>
                
                <div class="mt-3">    
                    <label>Tanggal Mulai:</label>
                    <input required type="date" name="tanggal_mulai" class="form-control" value="{{ old('tanggal_mulai') }}">
                </div>

                <div class="mt-3">    
                    <label>Tanggal Selesai:</label>
                    <input required type="date" name="tanggal_selesai" class="form-control" value="{{ old('tanggal_selesai') }}">
                </div>

                <div class="mt-3">    
                    <label>Tautan Pendaftaran:</label>
                    <input required type="url" name="link_daftar" placeholder="Masukkan tautan pendaftaran kegiatan" class="form-control" value="{{ old('link_daftar') }}">
                </div>

                <div class="mt-3">
                    <label>Poster Kegiatan:</label>
                    <input type="file" accept="images/*" class="form-control" name="poster">
                    <span class="text-secondary">Gambar kegiatan tidak wajib diisi</span>
                </div>
                
                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-success px-4"><strong>SIMPAN</strong></button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
