@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="text-center mb-4">
        <img src="{{ asset($data['logo']) }}" alt="Logo {{ $data['nama'] }}" class="img-fluid" style="max-height: 150px;">
        <h2 class="mt-3">{{ $data['nama'] }}</h2>
    </div>

    <div class="mb-4">
        <h4>Visi</h4>
        <p>{{ $data['visi'] }}</p>
    </div>

    <div class="mb-4">
        <h4>Misi</h4>
        <ul>
            @foreach($data['misi'] as $misi)
                <li>{{ $misi }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mb-4">
        <h4>Pengurus</h4>
        <img src="{{ asset($data['pengurus']) }}" class="img-fluid rounded shadow">
    </div>

    <div class="mb-4">
        <h4>Poster Kegiatan</h4>
        {{-- <img src="{{ asset($data['poster_kegiatan']) }}" class="img-fluid rounded"> --}}
        <br>
        <a href="{{ url('/kegiatan/' . strtolower($data['nama'])) }}" class="btn btn-primary mt-2">Lihat Selengkapnya</a>
    </div>

    <div class="mb-4">
        <h4>Galeri Kegiatan</h4>
        <img src="{{ asset($data['galeri']) }}" class="img-fluid rounded">
        <br>
        <a href="{{ url('/galeri/' . strtolower($data['nama'])) }}" class="btn btn-primary mt-2">Lihat Selengkapnya</a>
    </div>
</div>
@endsection
