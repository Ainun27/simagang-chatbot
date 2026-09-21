@auth
<nav class="navbar">
    <div class="navbar-container">
        <a href="{{ route('admin.dashboard') }}" class="navbar-brand">
            <i class="fas fa-city"></i>
            <span>Sistem Magang</span>
        </a>
        
        <button class="menu-toggle" id="menuToggle">
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
            
            <li class="nav-item d-mobile-only">
                <div class="navbar-user">
                    <div class="user-info">
                        <i class="fas fa-user-circle"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
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
                <button type="submit" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>
@endauth

@guest
<nav class="navbar">
    <div class="navbar-container">
        <a href="/" class="navbar-brand">
            <i class="fas fa-city"></i>
            <span>Sistem Magang</span>
        </a>
        <button class="menu-toggle" id="menuToggle"><i class="fas fa-bars"></i></button>
        <ul class="navbar-menu" id="navbarMenu">
            <li class="nav-item"><a href="/" class="nav-link"><i class="fas fa-home"></i><span>Home</span></a></li>
            <li class="nav-item"><a href="/informasi" class="nav-link"><i class="fas fa-info-circle"></i><span>Informasi</span></a></li>
            <li class="nav-item"><a href="/syarat" class="nav-link"><i class="fas fa-file-alt"></i><span>Syarat</span></a></li>
            <li class="nav-item"><a href="/alur" class="nav-link"><i class="fas fa-route"></i><span>Alur</span></a></li>
            <li class="nav-item"><a href="/login" class="nav-link"><i class="fas fa-sign-in-alt"></i><span>Login</span></a></li>
        </ul>
    </div>
</nav>
@endguest