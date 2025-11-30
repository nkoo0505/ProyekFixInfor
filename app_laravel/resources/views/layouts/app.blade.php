<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Website ORMAWA FST</title>
    
    <!-- 1. KITA PAKAI BOOTSTRAP DARI CDN SAJA (HAPUS app.css agar tidak bentrok) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons untuk semua ikon (kirim, user, profil, dll.) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Jika style.css adalah buatan sendiri, boleh tetap ada -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    
    <!-- Pastikan file ini ada, jika error 404, hapus baris ini -->
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
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm">
            <div class="container-fluid">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">Ormawa</a>
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
                                <a class="nav-link {{ request()->is('pertanyaan') || request()->is('faq') ? 'active' : '' }}" href="{{ route('pertanyaan.index') }}">Pertanyaan &amp; FAQ</a>
                            </li>
                        @endguest
                        @auth
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('pertanyaan') || request()->is('faq') || request()->is('admin/pertanyaan*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Pertanyaan &amp; FAQ
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('pertanyaan.index') }}">Lihat Pertanyaan &amp; FAQ</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('admin.pertanyaan.index') }}">Kelola Aspirasi</a></li>
                                </ul>
                            </li>
                        @endauth
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

    <footer>
        <p>&copy; {{ date('Y') }} ORMAWA FST</p>
    </footer>

    <!-- 2. SCRIPT BOOTSTRAP CUKUP SATU INI SAJA -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var dropdownTriggerList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));

            if (window.bootstrap && bootstrap.Dropdown) {
                dropdownTriggerList.forEach(function (dropdownToggleEl) {
                    new bootstrap.Dropdown(dropdownToggleEl);
                });
            } else {
                dropdownTriggerList.forEach(function (dropdownToggleEl) {
                    dropdownToggleEl.addEventListener('click', function (event) {
                        event.preventDefault();
                        var menu = dropdownToggleEl.nextElementSibling;
                        if (menu && menu.classList.contains('dropdown-menu')) {
                            menu.classList.toggle('show');
                        }
                    });
                });
            }
        });
    </script>
</body>
</html>