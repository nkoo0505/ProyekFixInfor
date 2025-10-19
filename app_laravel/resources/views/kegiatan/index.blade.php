@extends('layouts.app')

{{-- Menambahkan judul halaman dinamis untuk tab browser --}}
@section('title', 'Daftar Kegiatan')

@section('content')
<div class="kegiatan-page-container">
    <div class="container">
        <div class="kegiatan-container">
            <div class="text-center mb-5 kegiatan-header">
                <h1><strong>KEGIATAN KAMI</strong></h1>
            </div>

            @auth
            <div class="text-center mb-5">
                <a class="btn btn-light" href="{{ route('kegiatan.create') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16" style="margin-right: 5px; margin-top: -2px;">
                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                    </svg>
                    Tambah Kegiatan Baru
                </a>
            </div>
            @endauth
            
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="kegiatan-grid">
                @forelse($kegiatans as $kegiatan)
                    <div class="kegiatan-card">
                        <div class="kegiatan-card-image-wrapper">
                            @if($kegiatan->gambar_url)
                                <img src="{{ asset('images/kegiatan/'.$kegiatan->gambar_url) }}" alt="Poster {{ $kegiatan->judul }}">
                            @else
                                <img src="https://placehold.co/600x400/003366/FFFFFF?text=Poster" alt="Tidak ada gambar">
                            @endif
                        </div>
                        
                        {{-- Konten kartu sekarang menggunakan Flexbox untuk mengatur tinggi --}}
                        <div class="kegiatan-card-content">
                            <h3>{{ $kegiatan->judul }}</h3>
                            <p class="kegiatan-card-description">{{ Str::limit($kegiatan->deskripsi, 120) }}</p>
                            
                            {{-- mt-auto akan mendorong tombol ini ke bagian paling bawah --}}
                            <button class="btn btn-selengkapnya mt-auto" data-bs-toggle="modal" data-bs-target="{{ '#kegiatan'.$kegiatan->kegiatan_id }}">
                                Selengkapnya
                            </button>

                            @auth
                            <div class="admin-actions">
                                <a class="btn btn-primary btn-sm" href="{{ route('kegiatan.edit', $kegiatan->kegiatan_id) }}">Edit</a> 
                                <form action="{{ route('kegiatan.destroy', $kegiatan->kegiatan_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus?')" type="submit">Hapus</button>
                                </form>
                            </div>
                            @endauth
                        </div>
                    </div>

                    {{-- Definisi Modal untuk setiap kegiatan --}}
                    <div class="modal fade" id="{{'kegiatan'.$kegiatan->kegiatan_id}}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">{{ $kegiatan->judul }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @if($kegiatan->gambar_url)
                                        <img class="img-fluid rounded mb-3" src="{{ asset('images/kegiatan/'.$kegiatan->gambar_url) }}">
                                    @endif
                                    <p><strong>Ormawa:</strong> {{ $kegiatan->ormawa->nama_ormawa }}</p>
                                    <p><strong>Mulai:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_mulai)->format('d M Y') }}</p>
                                    <p><strong>Selesai:</strong> {{ \Carbon\Carbon::parse($kegiatan->tanggal_selesai)->format('d M Y') }}</p>
                                    <hr>
                                    <p><strong>Deskripsi:</strong><br>{!! nl2br(e($kegiatan->deskripsi)) !!}</p>
                                    <hr>
                                    <a href="{{ $kegiatan->linkPendaftaran_url }}" class="btn btn-info" >Link Pendaftaran</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-warning text-center" style="grid-column: 1 / -1;">
                        Belum ada kegiatan yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

