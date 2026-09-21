<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Administrator - SIMAGANG Diskominfosantik</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #7c3aed;
            --accent: #06b6d4;
            --success: #10b981;
            --danger: #ef4444;
            --dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 50%, #312e81 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #1e293b;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient Glowing Background Blobs */
        .bg-shapes {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
            pointer-events: none;
        }

        .shape {
            position: absolute;
            border-radius: 50%;
            filter: blur(70px);
            opacity: 0.35;
        }

        .shape:nth-child(1) {
            width: 400px;
            height: 400px;
            background: #6366f1;
            top: -100px;
            left: -100px;
        }

        .shape:nth-child(2) {
            width: 450px;
            height: 450px;
            background: #a855f7;
            bottom: -120px;
            right: -120px;
        }

        /* WIDE LANDSCAPE CARD CONTAINER */
        .login-wrapper {
            width: 100%;
            max-width: 880px;
            position: relative;
            z-index: 10;
        }

        .login-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.45), 0 0 0 1px rgba(255, 255, 255, 0.15);
            display: grid;
            grid-template-columns: 1fr 1.15fr;
            overflow: hidden;
            min-height: 460px;
        }

        /* LEFT BRANDING SIDE */
        .login-banner-side {
            background: linear-gradient(135deg, #4338ca 0%, #6366f1 50%, #7c3aed 100%);
            color: #ffffff;
            padding: 2.5rem 2rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .login-banner-side::after {
            content: '';
            position: absolute;
            top: -30%;
            right: -30%;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.12) 0%, transparent 70%);
            pointer-events: none;
        }

        .banner-top {
            position: relative;
            z-index: 2;
        }

        .brand-icon-box {
            width: 58px;
            height: 58px;
            background: rgba(255, 255, 255, 0.18);
            border: 2px solid rgba(255, 255, 255, 0.35);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: #ffffff;
            margin-bottom: 1.25rem;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
            backdrop-filter: blur(8px);
        }

        .brand-title {
            font-size: 1.75rem;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 0.25rem;
            color: #ffffff;
            line-height: 1.2;
        }

        .brand-subtitle {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.4;
            font-weight: 400;
        }

        .banner-features {
            margin: 1.75rem 0;
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
            position: relative;
            z-index: 2;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 0.65rem;
            font-size: 0.825rem;
            color: rgba(255, 255, 255, 0.95);
            font-weight: 500;
            background: rgba(255, 255, 255, 0.08);
            padding: 0.5rem 0.85rem;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .feature-item i {
            color: #67e8f9;
            font-size: 0.9rem;
        }

        .banner-footer {
            position: relative;
            z-index: 2;
            font-size: 0.75rem;
            color: rgba(255, 255, 255, 0.75);
            line-height: 1.4;
        }

        .banner-footer strong {
            color: #ffffff;
        }

        /* RIGHT FORM SIDE */
        .login-form-side {
            padding: 2.5rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #ffffff;
        }

        .form-header {
            margin-bottom: 1.5rem;
        }

        .form-title {
            font-size: 1.4rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.25rem;
            letter-spacing: -0.01em;
        }

        .form-subtitle {
            font-size: 0.85rem;
            color: #64748b;
        }

        .form-group {
            margin-bottom: 1.15rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            margin-bottom: 0.4rem;
            font-weight: 600;
            color: #1e293b;
            font-size: 0.85rem;
        }

        .form-label i {
            color: #4f46e5;
            font-size: 0.85rem;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: #94a3b8;
            font-size: 0.95rem;
            pointer-events: none;
            transition: color 0.2s ease;
            z-index: 2;
        }

        .form-control {
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.6rem;
            border: 1.5px solid #cbd5e1;
            border-radius: 12px;
            font-size: 0.9rem;
            font-family: inherit;
            color: #0f172a;
            background: #f8fafc;
            transition: all 0.25s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            outline: none;
            background: #ffffff;
            border-color: #4f46e5;
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.15);
        }

        .input-group:focus-within .input-icon {
            color: #4f46e5;
        }

        .toggle-password {
            position: absolute;
            right: 0.75rem;
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 0.4rem;
            font-size: 0.95rem;
            transition: color 0.2s;
            z-index: 2;
        }

        .toggle-password:hover {
            color: #475569;
        }

        .is-invalid {
            border-color: var(--danger) !important;
            background-color: #fff5f5 !important;
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.78rem;
            margin-top: 0.35rem;
            display: flex;
            align-items: center;
            gap: 0.35rem;
            font-weight: 500;
        }

        .alert {
            padding: 0.75rem 1rem;
            border-radius: 12px;
            margin-bottom: 1.25rem;
            display: flex;
            align-items: flex-start;
            gap: 0.6rem;
            font-size: 0.85rem;
            line-height: 1.4;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-danger i {
            color: #ef4444;
            font-size: 1rem;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .btn-login {
            width: 100%;
            padding: 0.8rem 1.5rem;
            background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 0.925rem;
            font-weight: 600;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            margin-top: 0.75rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.45);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        .form-bottom-actions {
            margin-top: 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-top: 1rem;
            border-top: 1px solid #f1f5f9;
        }

        .btn-back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 0.825rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            transition: color 0.2s ease;
        }

        .btn-back-link:hover {
            color: #4f46e5;
        }

        .version-badge {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
        }

        /* RESPONSIVE LAYOUT */
        @media (max-width: 768px) {
            body {
                padding: 16px;
            }

            .login-card {
                grid-template-columns: 1fr;
                border-radius: 20px;
            }

            .login-banner-side {
                padding: 1.75rem 1.5rem;
            }

            .brand-title {
                font-size: 1.4rem;
            }

            .banner-features {
                margin: 1rem 0;
            }

            .login-form-side {
                padding: 1.75rem 1.5rem;
            }
        }
    </style>
</head>
<body>

    <!-- Ambient Glowing Blobs -->
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    <div class="login-wrapper">
        <div class="login-card">
            <!-- Left Branding Side -->
            <div class="login-banner-side">
                <div class="banner-top">
                    <div class="brand-icon-box">
                        <i class="fas fa-building-columns"></i>
                    </div>
                    <h1 class="brand-title">SIMAGANG</h1>
                    <p class="brand-subtitle">Sistem Informasi Manajemen Magang Diskominfosantik Kabupaten Bekasi</p>
                </div>

                <div class="banner-features">
                    <div class="feature-item">
                        <i class="fas fa-shield-halved"></i>
                        <span>Sistem Otentikasi Administrator</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-chart-pie"></i>
                        <span>Monitoring Kuota Divisi Real-Time</span>
                    </div>
                    <div class="feature-item">
                        <i class="fas fa-file-invoice"></i>
                        <span>Pusat Cetak & Export Laporan</span>
                    </div>
                </div>

                <div class="banner-footer">
                    <div><strong>Pemerintah Kabupaten Bekasi</strong></div>
                    <div>Dinas Komunikasi, Informatika, Persandian & Statistik</div>
                </div>
            </div>

            <!-- Right Form Side -->
            <div class="login-form-side">
                <div class="form-header">
                    <h2 class="form-title">Portal Masuk</h2>
                    <p class="form-subtitle">Silakan login menggunakan akun administrator Anda</p>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger" role="alert">
                        <i class="fas fa-circle-exclamation"></i>
                        <div>{{ $errors->first() }}</div>
                    </div>
                @endif

                @if (session('status'))
                    <div class="alert" style="background:#f0fdf4; color:#166534; border:1px solid #bbf7d0;" role="alert">
                        <i class="fas fa-circle-check" style="color:#22c55e;"></i>
                        <div>{{ session('status') }}</div>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" id="loginForm">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label class="form-label" for="email">
                            <i class="fas fa-envelope"></i> Email Administrator
                        </label>
                        <div class="input-group">
                            <i class="fas fa-envelope input-icon"></i>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                class="form-control @error('email') is-invalid @enderror" 
                                value="{{ old('email') }}"
                                placeholder="admin@diskominfo.com"
                                required
                                autocomplete="email"
                                autofocus
                            >
                        </div>
                        @error('email')
                            <span class="invalid-feedback">
                                <i class="fas fa-triangle-exclamation"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="form-label" for="password">
                            <i class="fas fa-lock"></i> Password
                        </label>
                        <div class="input-group">
                            <i class="fas fa-lock input-icon"></i>
                            <input 
                                type="password" 
                                id="password"
                                name="password" 
                                class="form-control @error('password') is-invalid @enderror" 
                                placeholder="Masukkan password"
                                required
                                autocomplete="current-password"
                            >
                            <button type="button" class="toggle-password" id="togglePassword" aria-label="Lihat Password">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">
                                <i class="fas fa-triangle-exclamation"></i> {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="btn-login" id="btnLogin">
                        <i class="fas fa-arrow-right-to-bracket"></i>
                        <span>Masuk ke Dashboard</span>
                    </button>
                </form>

                <div class="form-bottom-actions">
                    <a href="{{ url('/') }}" class="btn-back-link">
                        <i class="fas fa-arrow-left"></i>
                        <span>Kembali ke Beranda</span>
                    </a>
                    <span class="version-badge">v1.0 &bull; {{ date('Y') }}</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Password Visibility Toggle
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (togglePassword && passwordInput && toggleIcon) {
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                toggleIcon.classList.toggle('fa-eye');
                toggleIcon.classList.toggle('fa-eye-slash');
            });
        }

        // Form Submit Loading State
        const loginForm = document.getElementById('loginForm');
        const btnLogin = document.getElementById('btnLogin');

        if (loginForm && btnLogin) {
            loginForm.addEventListener('submit', function() {
                btnLogin.disabled = true;
                btnLogin.innerHTML = '<i class="fas fa-spinner fa-spin"></i> <span>Memverifikasi...</span>';
                btnLogin.style.opacity = '0.85';
            });
        }
    </script>
</body>
</html>