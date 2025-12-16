@extends('layouts.app')

@section('content')

<!-- --- CUSTOM STYLING --- -->
<style>
    :root {
        --primary-color: #003B73;
        --primary-hover: #002a52;
        --bg-light: #f8f9fa;
    }

    body, html {
        height: 100%;
        background-color: var(--bg-light);
        overflow-x: hidden;
    }

    .login-wrapper {
        min-height: 100vh;
    }

    /* KOLOM KIRI: Banner / Branding */
    .login-banner {
        background: linear-gradient(135deg, rgba(0,59,115,0.9), rgba(0,188,212,0.8)), 
                    url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?q=80&w=1000&auto=format&fit=crop'); 
        background-size: cover;
        background-position: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
        color: white;
        animation: fadeInLeft 1s ease forwards;
    }

    .banner-content h1 {
        font-weight: 800;
        font-size: 3rem;
        margin-bottom: 15px;
    }

    .banner-content p {
        font-size: 1.2rem;
        line-height: 1.6;
        opacity: 0.9;
    }

    /* KOLOM KANAN: Form Login */
    .login-form-container {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background-color: white;
        animation: fadeInRight 1s ease forwards;
    }

    .login-card {
        width: 100%;
        max-width: 400px;
    }

    .brand-logo {
        width: 70px;
        height: 70px;
        background-color: var(--primary-color);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 15px;
        color: white;
        font-size: 1.8rem;
        transition: transform 0.3s;
    }

    .brand-logo:hover {
        transform: scale(1.1);
    }

    .form-label {
        font-weight: 600;
        font-size: 0.95rem;
        color: #495057;
    }

    .form-control {
        padding: 12px 15px;
        border-radius: 10px;
        border: 2px solid #e9ecef;
        transition: all 0.3s;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 4px rgba(0,59,115,0.1);
    }

    .password-group {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        background: none;
        border: none;
        padding: 0;
    }

    .toggle-password:hover {
        color: var(--primary-color);
    }

    .btn-login {
        background-color: var(--primary-color);
        color: white;
        width: 100%;
        padding: 14px;
        font-weight: 700;
        border-radius: 10px;
        border: none;
        font-size: 1rem;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .btn-login:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
    }

    .footer-text {
        text-align: center;
        margin-top: 25px;
        font-size: 0.9rem;
        color: #adb5bd;
    }

    @media (max-width: 992px) {
        .login-banner {
            display: none;
        }
        .login-wrapper {
            background: white;
        }
    }

    /* --- ANIMATIONS --- */
    @keyframes fadeInLeft {
        from {opacity: 0; transform: translateX(-50px);}
        to {opacity: 1; transform: translateX(0);}
    }
    @keyframes fadeInRight {
        from {opacity: 0; transform: translateX(50px);}
        to {opacity: 1; transform: translateX(0);}
    }
</style>

<div class="container-fluid p-0">
    <div class="row g-0 login-wrapper">
        
        {{-- KOLOM KIRI --}}
        <div class="col-lg-7 d-none d-lg-flex login-banner">
            <div class="banner-content">
                <h1>Sistem Informasi<br>ORMAWA FST</h1>
                <p>Selamat datang di portal resmi Organisasi Mahasiswa Fakultas Sains dan Teknologi. Silakan masuk untuk mengelola kegiatan dan administrasi.</p>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="col-lg-5 login-form-container">
            <div class="login-card shadow-lg p-4 rounded-4">

                <div class="d-flex align-items-center mb-4">
                    <div class="brand-logo shadow-sm">
                        <i class="bi bi-shield-lock-fill"></i>
                    </div>
                    <div class="ms-3">
                        <h3 class="fw-bold text-dark mb-0">Login Admin</h3>
                        <p class="text-muted mb-0">Masuk ke akun Anda</p>
                    </div>
                </div>

                {{-- Alert Error --}}
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm rounded-3 mb-4 d-flex align-items-center">
                        <i class="bi bi-exclamation-circle-fill me-2 fs-5"></i>
                        <div>{{ session('error') }}</div>
                    </div>
                @endif

                <form action="{{ route('login') }}" method="POST">
                    @csrf

                    <div class="form-group mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username admin" required autofocus>
                    </div>

                    <div class="form-group mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                            <button type="button" class="toggle-password" onclick="togglePassword()">
                                <i class="bi bi-eye-slash" id="eyeIcon"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="remember">
                            <label class="form-check-label text-muted small" for="remember">Ingat Saya</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-login btn btn-lg">
                        MASUK SEKARANG <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>

                <div class="footer-text">&copy; {{ date('Y') }} Fakultas Sains & Teknologi USD</div>
            </div>
        </div>

    </div>
</div>

<!-- --- SCRIPT --- -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Gagal Masuk',
        text: "{{ session('error') }}",
        confirmButtonColor: '#003B73',
        confirmButtonText: 'Coba Lagi'
    });
</script>
@endif

<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if(passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.classList.replace('bi-eye-slash','bi-eye');
        } else {
            passwordInput.type = 'password';
            eyeIcon.classList.replace('bi-eye','bi-eye-slash');
        }
    }
</script>

@endsection
