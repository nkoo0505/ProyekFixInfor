@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <img src="{{ asset($profil->logo_url) }}" alt="Logo {{ $profil->nama_ormawa }}" class="img-fluid" style="max-height: 150px;">
        <h2 class="mt-3">{{ $profil->nama_ormawa }}</h2>
    </div>

    <div class="mb-4">
        <h4>Visi</h4>
        <p>{{ $profil->visi }}</p>
    </div>

    <div class="mb-4">
        <h4>Misi</h4>
        <ul>
            @foreach(explode("\n", $profil->misi) as $misi)
                <li>{{ $misi }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mb-4">
        <h4>Deskripsi Profil</h4>
        <p>{{ $profil->deskripsi_profil }}</p>
    </div>

    <div class="mb-4">
        <h4>Kontak Person</h4>
        <p>{{ $profil->kontak_person }}</p>
    </div>

    <div class="mb-4">
        <h4>Galeri Kegiatan</h4>
        <img src="{{ asset($profil->gambar_kegiatan) }}" class="img-fluid rounded">
        <br>
        <a href="{{ url('/galeri/' . strtolower($profil->nama_ormawa)) }}" class="btn btn-primary mt-2">Lihat Selengkapnya</a>
    </div>

    <div class="mb-4">
        <h4>Poster Kegiatan</h4>
        {{-- Jika kamu nanti menambahkan kolom poster_kegiatan di database --}}
        {{-- <img src="{{ asset($profil->poster_kegiatan) }}" class="img-fluid rounded"> --}}
        <br>
        <a href="{{ url('/kegiatan/' . strtolower($profil->nama_ormawa)) }}" class="btn btn-primary mt-2">Lihat Selengkapnya</a>
    </div>
</div>
@endsection
