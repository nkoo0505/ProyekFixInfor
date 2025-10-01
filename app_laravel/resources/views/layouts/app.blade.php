<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Website ORMAWA FST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg bg-body-light">
            <div class="container-fluid">
                {{-- <a class="navbar-brand" href="#">Navbar</a> --}}
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('beranda') ? 'active' : '' }}" aria-current="page" href="{{ route('beranda') }}">Beranda</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle " href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Profil
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ url('/profil/bem') }}">BEMF</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/hmif') }}">HMIF</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/hmte') }}">HMTE</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/hmm') }}">HMM</a></li>
                                <li><a class="dropdown-item" href="{{ url('/profil/kmtm') }}">KMTM</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('kegiatan') ? 'active' : '' }}" aria-current="page" href="{{ route('kegiatan.index') }}">Kegiatan</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('galeri.index') }}">Galeri</a>
                        </li> --}}
                    </ul>
                    <div class="">
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
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</html>
