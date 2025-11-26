<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Website ORMAWA FST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/kegiatan.css') }}" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        main {
            flex: 1;
        }

        footer {
            background-color: #002b5b;
            color: white;
            text-align: center;
            padding: 1.5rem;
            margin-top: auto;
        }
    </style>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-light">
            <div class="container-fluid">
                {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('beranda') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('beranda') }}">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Profil
                            </a>
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Profil</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('/profil/bem') }}">BEMF</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/hmif') }}">HMIF</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/hmte') }}">HMTE</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/hmm') }}">HMM</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/kmtm') }}">KMTM</a></li>
                                @auth
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.profil.edit') }}">Kelola Profil Saya</a></li>
                                    <li><a class="dropdown-item" href="{{ route('pengurus.index') }}">Struktur Kepengurusan Saya</a></li>
                                @endauth
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kegiatan') ? 'active' : '' }}" aria-current="page"
                                href="{{ route('kegiatan.index') }}">Kegiatan</a>
                        </li>
                        <li class="nav-item">
                            @auth
                                {{-- Jika LOGIN (Admin/Pengurus): Arahkan ke halaman pengelolaan aspirasi --}}
                                <a class="nav-link {{ request()->is('admin/aspirasi*') ? 'active' : '' }}"
                                    href="{{ route('admin.aspirasi.index') }}">
                                    Kelola Aspirasi
                                </a>
                            @else
                                {{-- Jika BELUM LOGIN (Publik): Arahkan ke halaman FAQ publik --}}
                                <a class="nav-link {{ request()->is('faq*') ? 'active' : '' }}"
                                    href="{{ route('faq.index') }}">
                                    Pertanyaan & FAQ
                                </a>
                            @endauth
                        </li>

                        {{-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('galeri.index') }}">Galeri</a>
                        </li> --}}
                    </ul>
                    <div>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-primary"><strong>Login</strong></a>
                        @else
                            <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="btn btn-danger"><strong>Logout</strong></button>
                            </form>
                        @endguest
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="position: relative; bottom: 0;">
        <p>&copy; {{ date('Y') }} ORMAWA FST</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
