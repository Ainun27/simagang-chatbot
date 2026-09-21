<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SIMAGANG') }} - @yield('title')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <link rel="stylesheet" href="{{ asset('css/layout.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="bg-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>

    @auth
    <nav class="navbar">
        <div class="navbar-container">
            <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
                <i class="fas fa-city"></i>
                <span>Sistem Magang</span>
            </a>
            
            <button class="menu-toggle" id="menuToggle" aria-label="Toggle Menu">
                <i class="fas fa-bars"></i>
            </button>
            
            <ul class="navbar-menu" id="navbarMenu">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home"></i><span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.divisi.index') }}" class="nav-link {{ request()->routeIs('admin.divisi.*') ? 'active' : '' }}">
                        <i class="fas fa-th-large"></i><span>Divisi</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="nav-link {{ request()->routeIs('admin.mahasiswa.*') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate"></i><span>Mahasiswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i><span>Laporan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.knowledge-base.index') }}" class="nav-link {{ request()->routeIs('admin.knowledge-base.*') ? 'active' : '' }}">
                        <i class="fas fa-robot"></i><span>Knowledge Base</span>
                    </a>
                </li>
                
                <li class="nav-item d-mobile-only">
                    <div class="navbar-user">
                        <div class="user-info">
                            <i class="fas fa-user-circle"></i>
                            <span>{{ Auth::user()->name }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST" class="w-100">
                            @csrf
                            <button type="submit" class="btn-logout w-100">
                                <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
            
            <div class="navbar-user d-desktop-only">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span>{{ Auth::user()->name }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>
    @endauth

    <main class="main-container">
        @yield('content')
    </main>

    <script src="{{ asset('js/layout.js') }}"></script>
    
    @stack('scripts')
</body>
</html>