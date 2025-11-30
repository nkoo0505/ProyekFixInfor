@extends('layouts.app')

@section('title', $kegiatan->judul)

@section('content')
<style>
    body {
        background-color: #f4f6f9;
        font-family: 'Segoe UI', sans-serif;
    }

    .event-container {
        background: white;
        border-radius: 20px;
        padding: 40px;
        max-width: 900px;
        margin: 50px auto;
        box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .event-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .event-header h2 {
        font-size: 2.2rem;
        color: #003B73;
        font-weight: bold;
        margin-bottom: 10px;
    }

    .event-header p {
        color: #666;
        font-size: 1rem;
    }

    .event-image {
        display: block;
        margin: 0 auto 30px auto;
        border-radius: 15px;
        max-height: 400px;
        width: 100%;
        object-fit: cover;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .event-details p {
        font-size: 1.1rem;
        color: #333;
        margin-bottom: 10px;
    }

    .event-details strong {
        color: #003B73;
    }

    .btn-section {
        text-align: center;
        margin-top: 40px;
    }

    .btn-section .btn {
        margin: 0 10px;
        border-radius: 30px;
        padding: 10px 25px;
        font-weight: bold;
        transition: all 0.3s ease;
    }

    .btn-info {
        background-color: #007bff;
        border: none;
        color: white;
    }

    .btn-info:hover {
        background-color: #0056b3;
    }

    .btn-primary {
        background-color: #003B73;
        border: none;
    }

    .btn-primary:hover {
        background-color: #00224D;
    }

    .divider {
        height: 2px;
        background: linear-gradient(to right, #003B73, #007bff);
        margin: 25px 0;
        border-radius: 5px;
    }
</style>

<div class="event-container">
    <div class="event-header">
        <h2>{{ $kegiatan->judul }}</h2>
        <p><i class="bi bi-calendar-event"></i> 
            {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }} 
            — 
            {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}
        </p>
    </div>

    @if($kegiatan->gambar_url)
        <img src="{{ asset('images/kegiatan/' . $kegiatan->gambar_url) }}" 
             alt="Poster {{ $kegiatan->judul }}" 
             class="event-image">
    @else
        <img src="https://placehold.co/800x400/cccccc/000000?text=Tidak+Ada+Gambar" 
             alt="Poster Tidak Tersedia" 
             class="event-image">
    @endif

    <div class="event-details">
        <p><strong>Ormawa:</strong> {{ $kegiatan->ormawa->nama_ormawa ?? 'Tidak diketahui' }}</p>
        <p><strong>Deskripsi:</strong> {{ $kegiatan->deskripsi}} </p>
        <!-- <p style="text-align: justify;">{!! nl2br(e($kegiatan->deskripsi)) !!}</p> -->
        <a href="{{ $kegiatan->linkPendaftaran_url }}" target="_blank" class="btn btn-info">
            <i class="bi bi-link-45deg"></i> Link Pendaftaran</a>
    </div>

    <div class="divider"></div>

    <div class="btn-section ">
        <a href="{{ route('beranda') }}" class="btn btn-primary">
            <i class="bi bi-arrow-left-circle"></i> Kembali</a>
    </div>
</div>
@endsection
