<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>{{ config('app.name', 'ORMAWA FST') }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @if(file_exists(public_path('css/style.css')))
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @endif
    @if(file_exists(public_path('css/kegiatan.css')))
        <link href="{{ asset('css/kegiatan.css') }}" rel="stylesheet">
    @endif

    <style>
        /* --- GLOBAL STYLES --- */
        :root {
            --primary-color: #002b5b; /* Navy Blue USD */
            --accent-color: #ffc107;  /* Yellow/Gold */
            --bg-light: #f8f9fa;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: var(--bg-light);
        }

        main {
            flex: 1;
        }

        /* --- NAVBAR MODERN --- */
        .navbar {
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.95) !important;
            transition: all 0.3s ease;
        }

        .nav-link {
            font-weight: 500;
            color: #444 !important;
            transition: color 0.3s ease;
            margin: 0 5px;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
            font-weight: 600;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
        }

        .btn-brand {
            background-color: var(--primary-color);
            color: white;
            border-radius: 50px;
            padding: 8px 24px;
            transition: all 0.3s;
        }

        .btn-brand:hover {
            background-color: #001f42;
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 4px 10px rgba(0, 43, 91, 0.3);
        }

        /* --- FOOTER --- */
        footer {
            background: linear-gradient(135deg, #002b5b 0%, #001a38 100%);
            color: white;
            padding-top: 3rem;
            font-size: 0.95rem;
        }

        .footer-title {
            font-weight: 700;
            margin-bottom: 1.2rem;
            color: var(--accent-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 1.1rem;
        }

        .footer-link {
            color: #e0e0e0;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .footer-link:hover {
            color: var(--accent-color);
            transform: translateX(5px);
        }

        .social-btn {
            width: 40px;
            height: 40px;
            background: rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s;
            color: white;
            text-decoration: none;
        }

        .social-btn:hover {
            background: var(--accent-color);
            color: var(--primary-color);
            transform: scale(1.1);
        }
    </style>
</head>
<body>

    <header>
        <nav class="navbar navbar-expand-lg fixed-top shadow-sm py-3">
            <div class="container">
                <a class="navbar-brand fw-bold text-primary" href="{{ route('beranda') }}" style="color: var(--primary-color) !important;">
                    <i class="bi bi-mortarboard-fill me-2"></i>ORMAWA FST
                </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                        </li>
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle {{ request()->is('profil*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Ormawa
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('profil.index') }}">Semua ORMAWA</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('profil.show', 1) }}">BEMF</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.show', 5) }}">HMIF</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.show', 3) }}">HMTE</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.show', 2) }}">HMM</a></li>
                                <li><a class="dropdown-item" href="{{ route('profil.show', 4) }}">KMTM</a></li>
                                @auth
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('profilku.edit') }}">Profilku</a></li>
                                @endauth
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kegiatan') ? 'active' : '' }}" href="{{ route('kegiatan.index') }}">Kegiatan</a>
                        </li>

                        @guest
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('pertanyaan') || request()->is('faq') ? 'active' : '' }}" href="{{ route('pertanyaan.index') }}">FAQ & Apirasi</a>
                            </li>
                        @else
                             <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('pertanyaan*') || request()->is('admin/pertanyaan*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown">
                                    FAQ & Aspirasi
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pertanyaan.index') }}">Lihat FAQ</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.pertanyaan.index') }}">Kelola Aspirasi</a></li>
                                </ul>
                            </li>
                        @endauth

                        <li class="nav-item ms-lg-3 mt-2 mt-lg-0">
                            @guest
                                <a href="{{ route('login') }}" class="btn btn-brand btn-sm px-4">
                                    <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
                                </a>
                            @else
                                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger btn-sm px-4 rounded-pill">
                                        <i class="bi bi-box-arrow-right me-1"></i> Keluar
                                    </button>
                                </form>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main style="padding-top: 80px;">
        @yield('content')
    </main>

    <footer>
        <div class="container pb-4">
            <div class="row gy-4 justify-content-between">
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">ORMAWA FST USD</h5>
                    <p class="text-white-50 mb-4">
                        Wadah pengembangan minat, bakat, dan organisasi mahasiswa Fakultas Sains dan Teknologi Universitas Sanata Dharma.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="https://www.instagram.com/fstsanatadharma/" target="_blank" class="social-btn">
                            <i class="bi bi-instagram"></i>
                        </a>
                        <a href="https://www.youtube.com/@fakultassainsdanteknologiu4131" target="_blank" class="social-btn">
                            <i class="bi bi-youtube"></i>
                        </a>
                        <a href="mailto:fst@usd.ac.id" class="social-btn">
                            <i class="bi bi-envelope"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <ul class="list-unstyled text-white-50">
                        <li class="mb-3 d-flex">
                            <i class="bi bi-geo-alt-fill text-warning me-3 mt-1"></i>
                            <span>Jl. Krodan, Maguwoharjo, Kec. Depok, Sleman, DIY 55281</span>
                        </li>
                        <li class="mb-3 d-flex">
                            <i class="bi bi-whatsapp text-warning me-3 mt-1"></i>
                            <a href="https://api.whatsapp.com/message/ATETL3NMJWOHO1?autoload=1&app_absent=0" target="_blank" class="text-white-50 text-decoration-none hover-white">
                                +62 851-7439-5215
                            </a>
                        </li>
                        <li class="d-flex">
                            <i class="bi bi-envelope-fill text-warning me-3 mt-1"></i>
                            <span>fst@usd.ac.id</span>
                        </li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-12">
                    <h5 class="footer-title">Tautan Cepat</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('beranda') }}" class="footer-link"><i class="bi bi-chevron-right me-2 small"></i>Beranda</a></li>
                        <li class="mb-2"><a href="{{ route('profil.index') }}" class="footer-link"><i class="bi bi-chevron-right me-2 small"></i>Profil Ormawa</a></li>
                        <li class="mb-2"><a href="{{ route('kegiatan.index') }}" class="footer-link"><i class="bi bi-chevron-right me-2 small"></i>Kegiatan</a></li>
                        <li class="mb-2"><a href="{{ route('pertanyaan.index') }}" class="footer-link"><i class="bi bi-chevron-right me-2 small"></i>FAQ</a></li>
                    </ul>
                </div>
            </div>

            <hr class="my-4 border-secondary opacity-50">

            <div class="text-center text-white-50 small">
                &copy; {{ date('Y') }} <strong>ORMAWA FST</strong>. Fakultas Sains dan Teknologi, Universitas Sanata Dharma.
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    </body>
</html>