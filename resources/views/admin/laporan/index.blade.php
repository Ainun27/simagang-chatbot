@extends('layouts.app')

@section('title', 'Laporan Mahasiswa Magang')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/laporan.css') }}">
@endpush

@section('content')
<div class="laporan-wrapper">
    <!-- ===== HEADER STATISTIK ===== -->
    <div class="statistics-card">
        <div class="statistics-header">
            <div class="stat-title-group">
                <h3><i class="fas fa-chart-line"></i> Ringkasan Eksekutif Mahasiswa Magang</h3>
                <p class="statistics-subtitle">Pemantauan data, kapasitas, dan status magang terkini</p>
            </div>
        </div>

        <div class="statistics-grid">
            <div class="stat-card stat-total">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $total }}</span>
                    <span class="stat-label">Total Terdaftar</span>
                </div>
            </div>
            <div class="stat-card stat-active">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $total_aktif }}</span>
                    <span class="stat-label">Mahasiswa Aktif</span>
                </div>
            </div>
            <div class="stat-card stat-inactive">
                <div class="stat-icon"><i class="fas fa-user-clock"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $total_nonaktif }}</span>
                    <span class="stat-label">Selesai / Nonaktif</span>
                </div>
            </div>
            <div class="stat-card stat-month">
                <div class="stat-icon"><i class="fas fa-calendar-plus"></i></div>
                <div class="stat-content">
                    <span class="stat-value">{{ $bulan_ini }}</span>
                    <span class="stat-label">Terdaftar Bulan Ini</span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== CARD UTAMA LAPORAN ===== -->
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper">
                <div class="title-icon"><i class="fas fa-file-invoice"></i></div>
                <div class="title-text">
                    <h1 class="main-title">Laporan Data Mahasiswa Magang</h1>
                    <p class="subtitle">Filter dan unduh arsip data mahasiswa Diskominfosantik</p>
                </div>
            </div>

            <div class="header-export-actions">
                <a href="{{ route('admin.laporan.export.page') }}" class="btn-setting-export">
                    <i class="fas fa-sliders-h"></i><span>Pusat Cetak & Export</span>
                </a>
            </div>
        </div>

        <!-- ===== TOOLBAR FILTER MULTI-DIMENSI ===== -->
        <div class="toolbar-section">
            <form method="GET" action="{{ route('admin.laporan.index') }}" class="filter-form">
                <div class="filter-grid">
                    <!-- Search Input -->
                    <div class="form-group-item search-item">
                        <label class="filter-label"><i class="fas fa-search"></i> Cari Mahasiswa:</label>
                        <div class="input-icon-wrapper">
                            <i class="fas fa-search input-icon"></i>
                            <input type="text" name="search" class="form-input" placeholder="NIM, Nama, Kampus..." value="{{ request('search') }}">
                        </div>
                    </div>

                    <!-- Divisi Filter -->
                    <div class="form-group-item">
                        <label class="filter-label"><i class="fas fa-building"></i> Divisi:</label>
                        <select name="divisi_id" class="form-select">
                            <option value="">Semua Divisi</option>
                            @foreach($divisi as $d)
                                <option value="{{ $d->id }}" {{ request('divisi_id') == $d->id ? 'selected' : '' }}>{{ $d->nama_divisi }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Status Filter -->
                    <div class="form-group-item">
                        <label class="filter-label"><i class="fas fa-toggle-on"></i> Status:</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Aktif</option>
                            <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>

                    <!-- Bulan Filter -->
                    <div class="form-group-item">
                        <label class="filter-label"><i class="fas fa-calendar-alt"></i> Bulan:</label>
                        <select name="bulan" class="form-select">
                            <option value="">Semua Bulan</option>
                            @foreach(range(1, 12) as $m)
                                <option value="{{ $m }}" {{ request('bulan') == $m ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tahun Filter -->
                    <div class="form-group-item">
                        <label class="filter-label"><i class="fas fa-calendar-check"></i> Tahun:</label>
                        <select name="tahun" class="form-select">
                            <option value="">Semua Tahun</option>
                            @foreach($tahun_list as $t)
                                <option value="{{ $t }}" {{ request('tahun') == $t ? 'selected' : '' }}>{{ $t }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="filter-footer-actions">
                    <div class="filter-buttons">
                        <button type="submit" class="btn-filter">
                            <i class="fas fa-filter"></i><span>Terapkan Filter</span>
                        </button>
                        @if(request()->hasAny(['search', 'divisi_id', 'status', 'bulan', 'tahun']))
                        <a href="{{ route('admin.laporan.index') }}" class="btn-reset">
                            <i class="fas fa-redo"></i><span>Reset Filter</span>
                        </a>
                        @endif
                    </div>
                    <div class="filter-counter-badge">
                        <span>Menampilkan <strong>{{ $mahasiswas->total() }}</strong> data</span>
                    </div>
                </div>
            </form>
        </div>

        <!-- ===== TABEL LAPORAN DATA ===== -->
        @if($mahasiswas->count() > 0)
        <div class="table-container">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">No</th>
                            <th>NIM</th>
                            <th>Mahasiswa & Kampus</th>
                            <th>Divisi Magang</th>
                            <th>Periode Magang</th>
                            <th class="text-center">Status</th>
                            <th>Tanggal Terdaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mahasiswas as $index => $mhs)
                        <tr>
                            <td class="text-center">
                                <span class="row-number">{{ $mahasiswas->firstItem() + $index }}</span>
                            </td>
                            <td>
                                <span class="nim-badge">{{ $mhs->nim }}</span>
                            </td>
                            <td>
                                <div class="student-info">
                                    <div class="student-avatar-placeholder">
                                        {{ strtoupper(substr($mhs->nama, 0, 1)) }}
                                    </div>
                                    <div class="student-details">
                                        <strong class="student-name">{{ $mhs->nama }}</strong>
                                        <span class="student-university"><i class="fas fa-graduation-cap"></i> {{ $mhs->universitas }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="divisi-badge">
                                    <i class="fas fa-building"></i> {{ $mhs->divisi->nama_divisi ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="period-info">
                                    <span class="period-dates">
                                        {{ $mhs->tanggal_mulai ? $mhs->tanggal_mulai->format('d M Y') : '-' }} s/d {{ $mhs->tanggal_selesai ? $mhs->tanggal_selesai->format('d M Y') : '-' }}
                                    </span>
                                    <small class="period-duration">
                                        <i class="fas fa-clock"></i> {{ $mhs->masa_magang_text }}
                                    </small>
                                </div>
                            </td>
                            <td class="text-center">
                                @if($mhs->is_active)
                                    <span class="status-badge active"><i class="fas fa-check-circle"></i> Aktif</span>
                                @else
                                    <span class="status-badge inactive"><i class="fas fa-times-circle"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td>
                                <span class="date-badge">
                                    <i class="fas fa-calendar-alt"></i> {{ $mhs->created_at->format('d M Y') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="pagination-wrapper">
            {{ $mahasiswas->links() }}
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-search-minus"></i></div>
            <h3>Tidak Ada Data Mahasiswa Ditemukan</h3>
            <p>Silakan sesuaikan kata kunci pencarian atau kombinasi filter Anda.</p>
            <a href="{{ route('admin.laporan.index') }}" class="btn-filter" style="margin-top: 1rem; display: inline-flex;">
                <i class="fas fa-redo"></i><span>Tampilkan Semua Data</span>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/laporan.js') }}"></script>
@endpush