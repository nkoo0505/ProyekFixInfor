@extends('layouts.app')

@section('content')
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .hero {
            background: linear-gradient(to right, #003B73, #0059b3);
            color: white;
            padding: 100px 20px;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.25rem;
            margin-bottom: 30px;
        }

        .hero .btn {
            background-color: #ffffff;
            color: #003B73;
            font-weight: bold;
            padding: 10px 25px;
            border-radius: 50px;
            transition: 0.3s ease;
        }

        .hero .btn:hover {
            background-color: #e6e6e6;
            color: #00224D;
        }

        .section {
            padding:0;
            background-size: cover;
            background-color: #dfd6d6ff;
            position: relative;
            z-index: 1;
        }

        .section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.9);
            z-index: -1;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 40px;
            margin-top:40px;
            color: #003B73;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 25px;
            padding: 25px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #003B73;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
        }

        .card img.logo {
            display: block;
            margin: 0 auto; /* 🔹 ini memastikan gambar benar-benar berada di tengah */
            width: 80px; /* opsional, biar proporsional */
            height: auto;
        }

        .carousel-inner img {
            height: 400px;
            object-fit: cover;
            border-radius: 20px;
        }

        .stats {
            background-color: #003B73;
            color: white;
            display: flex;
            justify-content: space-around;
            padding: 50px 20px;
            flex-wrap: wrap;
        }

        .stat {
            text-align: center;
            margin: 10px 20px;
        }

        .stat h2 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .stat p {
            font-size: 1.2rem;
        }

        <style>.kegiatan-wrapper {
            position: relative;
            overflow: hidden;
            padding: 10px 40px;
        }

        .kegiatan-scroll {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding-bottom: 10px;
        }

        .kegiatan-scroll img {
            height: 250px;
            border-radius: 15px;
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .kegiatan-scroll img:hover {
            transform: scale(1.05);
            cursor: pointer;
        }

        .scroll-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 10;
            background-color: rgba(0, 59, 115, 0.8);
            border: none;
            color: white;
            font-size: 2rem;
            padding: 5px 15px;
            cursor: pointer;
            border-radius: 10px;
        }

        .scroll-btn.left {
            left: 0;
        }

        .scroll-btn.right {
            right: 0;
        }


  
    </style>


    </style>

    <div class="hero">
        
        <h1>Selamat Datang di Website ORMAWA FST</h1>
        <p>Berita acara, kegiatan, dan informasi seputar organisasi mahasiswa Fakultas Sains dan Teknologi</p>
        <a href="{{ route('kegiatan.index') }}" class="btn">Lihat Kegiatan</a>

      <form action="{{ route('kegiatan.cari') }}" method="GET" class="mb-3 p-3">
        <input type="text" name="cari" value="{{ request('cari') }}"
           placeholder="Cari kegiatan..."
           class="form-control d-inline-block me-2 p-2"
           style="width: 300px;">
        <button type="submit" class="btn btn-primary px-4 py-2">Cari</button>
    </form>

           
    </div>


    <div class="container my-5 position-relative">
        <h2 class="text-center mb-4" style="color: #003B73; font-weight: bold;">Kegiatan Fakultas Sains & Teknologi</h2>

        <div class="kegiatan-wrapper">
            
                
            </button>

        <div class="kegiatan-scroll" id="kegiatanScroll">
            @forelse($kegiatan as $item)
            <a href="{{ route('kegiatan.show', $item->kegiatan_id) }}">
                @if($item->gambar_url)
                    <img src="{{ asset('images/kegiatan/' . $item->gambar_url) }}" 
                         alt="Poster {{ $item->judul }}" 
                        title="{{ $item->judul }}">
                @else
                     <img src="https://placehold.co/400x250/cccccc/000000?text=Tidak+ada+gambar" 
                        alt="Tidak ada gambar">
                 @endif
                </a>
             @empty
                 <p class="text-center">Belum ada kegiatan tersedia.</p>
            @endforelse
        </div>

           
                
            </button>
        </div>
    </div>

    

    <div class="stats">
        <div class="stat">
            <h2>120+</h2>
            <p>Program Kerja</p>
        </div>
        <div class="stat">
            <h2>30+</h2>
            <p>Kegiatan Tahunan</p>
        </div>
        <div class="stat">
            <h2>100%</h2>
            <p>Partisipasi Aktif</p>
        </div>
    </div>

    <div class="section">
        <h2 class="section-title">Organisasi Kami</h2>
        <div class="card-container">
            <a href="{{ route('profil.show', 'bem') }}" class="card">
                <img src="{{ asset('images/logoKABINET.jpg') }}" alt="BEM FST Logo" class="logo">
                <h3>BEM FST</h3>
                <p>Kepengurusan aktif dan kegiatan mahasiswa Fakultas Sains & Teknologi</p>
            </a>
            <a href="{{ route('profil.show', 'hmif') }}" class="card">
                <img src="{{ asset('images/logoHMIF.jpg') }}" alt="HMIF Logo" class="logo">
                <h3>HMIF</h3>
                <p>Himpunan Mahasiswa Informatika</p>
            </a>
            <a href="{{ route('profil.show', 'hmte') }}" class="card">
                <img src="{{ asset('images/logoHMTE.jpg') }}" alt="HMTE Logo" class="logo">
                <h3>HMTE</h3>
                <p>Himpunan Mahasiswa Elektro</p>
            </a>
            <a href="{{ route('profil.show', 'hmm') }}" class="card">
                <img src="{{ asset('images/logoHMM.png') }}" alt="HMM Logo" class="logo">
                <h3>HMM</h3>
                <p>Himpunan Mahasiswa Matematika</p>
            </a>
            <a href="{{ route('profil.show', 'kmtm') }}" class="card">
                <img src="{{ asset('images/logoKMTM.jpg') }}" alt="KMTM Logo" class="logo">
                <h3>KMTM</h3>
                <p>Keluarga Mahasiswa Teknik Mesin</p>
            </a>
        </div>
    </div>

    <script>
        function scrollKegiatan(direction) {
            const scrollContainer = document.getElementById('kegiatanScroll');
            const scrollAmount = 300;
            scrollContainer.scrollBy({
                left: direction * scrollAmount,
                behavior: 'smooth'
            });
        }
    </script>

@endsection