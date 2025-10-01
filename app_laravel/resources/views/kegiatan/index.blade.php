@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="mt-4">
            <h1><strong>Daftar Kegiatan</strong></h1>
            
            <a class="btn btn-primary my-3" href="{{ route('kegiatan.create') }}">Tambah Kegiatan Baru</a>
            
            @if(session('success'))
            <div>{{ session('success') }}</div>
            @endif
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Ormawa</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        @auth <th>Aksi</th> @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($kegiatans as $kegiatan)
                    <tr>
                        <td>{{ $kegiatan->nama_kegiatan }}</td>
                        <td>{{ $kegiatan->ormawa->nama }}</td>
                        <td>{{ $kegiatan->tanggal_mulai }}</td>
                        <td>{{ $kegiatan->tanggal_selesai }}</td>
                        @auth()

                        <td>
                            <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="{{ '#kegiatan'.$kegiatan->id }}">Detail</button> |
                            <div class="modal fade" id="{{'kegiatan'.$kegiatan->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="height: 90vh; overflow-y: auto;">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $kegiatan->nama_kegiatan }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            @if($kegiatan->poster)
                                            <div class="w-100" style="height: 50vh">
                                                <img class="object-fit-cover bg-secondary h-100 w-100 rounded" src="{{ asset('images/kegiatan/'.$kegiatan->poster) }}">
                                            </div>
                                            @endif

                                            <div>
                                                <a href="{{ $kegiatan->link_daftar }}">{{ $kegiatan->link_daftar }}</a>
                                                <p><strong>Ormawa:</strong> {{ $kegiatan->ormawa->nama }}</p>
                                                <p><strong>Mulai:</strong> {{ date('d M Y', strtotime($kegiatan->tanggal_mulai)) }}</p>
                                                <p><strong>Selesai:</strong> {{ date('d M Y', strtotime($kegiatan->tanggal_selesai)) }}</p>
                                            
                                                <br>
                                                <hr>
                                                
                                                <strong>Deskripsi</strong>
                                                <p>{{$kegiatan->deskripsi}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-primary" href="{{ route('kegiatan.edit', $kegiatan->id) }}">Edit</a> |
                            <form  action="{{ route('kegiatan.destroy', $kegiatan->id) }}" method="POST" style="display:inline-block">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" onclick="return confirm('Yakin ingin hapus?')" type="submit">Hapus</button>
                            </form>
                        </td>
                        @endauth
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
