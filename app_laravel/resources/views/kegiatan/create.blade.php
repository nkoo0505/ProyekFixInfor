@extends('layouts.app')

@section('content')
<style>
    .kegiatan-wrapper {
        max-width: 900px;         /* Agar form tidak terlalu melebar */
        margin: 40px auto;        /* Tengah + beri jarak atas bawah */
        padding: 30px 40px;       /* Biar konten tidak mepet */
        background: #ffffff;      /* Kotak putih bersih */
        border-radius: 12px;      /* Sudut melengkung */
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08); 
    }

    .kegiatan-wrapper h1 {
        font-weight: bold;
        color: #003B73;
        margin-bottom: 25px;
    }

    .kegiatan-wrapper label {
        font-weight: 600;
        margin-bottom: 5px;
    }

    .kegiatan-wrapper .form-control {
        margin-bottom: 15px; /* Konsisten antar input */
    }

    .btn-dark {
        margin-left: 10px;
        margin-top: 20px;
    }

    .btn-success {
        padding: 10px 25px;
        font-weight: bold;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="mt-4">
            <a href="{{ route('kegiatan.index') }}" class="btn btn-dark">Kembali</a>
        </div>
        
        <div class="mt-3">
            <h1>Tambah Kegiatan Baru</h1>
            
             @if ($errors->any())
            <script>
                @foreach ($errors->all() as $error)
                     Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: "{{ $error }}",
                    });
                @endforeach
            </script>
            @endif
        </div>
    </div>
    
    <div class="row">
        <div class="col">
            <form action="{{ route('kegiatan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mt-2">    
                    <label>Nama Kegiatan:</label>
                    <input required type="text" name="judul" value="{{ old('judul') }}" class="form-control" placeholder="Masukkan nama kegiatan">
                </div>

                <div class="mt-3">
                    <label>Deskripsi:</label>
                    <textarea class="form-control" name="deskripsi" placeholder="Deskripsikan kegiatan">{{ old('deskripsi') }}</textarea>
                </div>

                <div class="mt-3">
                    <label>Ormawa yang melaksanakan:</label>
                    <input class="form-control" 
                    value="{{ auth()->user()->nama_ormawa }}" 
                    readonly>
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
                    <input type="url" name="linkPendaftaran_url" placeholder="Masukkan tautan pendaftaran kegiatan" class="form-control" value="{{ old('linkPendaftaran_url') }}">
                </div>

                <div class="mt-3">
                    <label>Poster Kegiatan:</label>
                    <input type="file" accept="image/*" class="form-control" name="gambar_url">
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
