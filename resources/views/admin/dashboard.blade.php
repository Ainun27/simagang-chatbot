@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/dashboard.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="welcome-banner">
        <div class="welcome-content">
            <div class="welcome-icon">
                <i class="fas fa-hand-sparkles"></i>
            </div>
            <div>
                <h1 class="welcome-title">Selamat Datang, {{ Auth::user()->name }}!</h1>
                <p class="welcome-subtitle">
                    Sistem Manajemen Magang Diskominfosantik Kabupaten Bekasi
                </p>
            </div>
        </div>
    </div>

    @if($divisi_hampir_penuh->count() > 0 || $divisi_penuh->count() > 0)
    <div class="alert-section">
        @if($divisi_hampir_penuh->count() > 0)
        <div class="alert alert-warning">
            <div class="alert-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="alert-content">
                <h3 class="alert-title">⚠️ Peringatan Kuota!</h3>
                <p class="alert-text">
                    Ada {{ $divisi_hampir_penuh->count() }} divisi yang kuotanya hampir penuh:
                </p>
                <ul class="alert-list">
                    @foreach($divisi_hampir_penuh as $divisi)
                    <li>
                        <strong>{{ $divisi->nama_divisi }}</strong> - Sisa {{ $divisi->sisa }} kuota
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif

        @if($divisi_penuh->count() > 0)
        <div class="alert alert-danger">
            <div class="alert-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="alert-content">
                <h3 class="alert-title">🚫 Kuota Penuh!</h3>
                <p class="alert-text">
                    {{ $divisi_penuh->count() }} divisi sudah mencapai kuota maksimal:
                </p>
                <ul class="alert-list">
                    @foreach($divisi_penuh as $divisi)
                    <li>
                        <strong>{{ $divisi->nama_divisi }}</strong> ({{ $divisi->kuota }}/{{ $divisi->kuota }})
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
        @endif
    </div>
    @endif

    <div class="statistics-grid">
        <div class="stat-card stat-primary">
            <div class="stat-bg-icon">
                <i class="fas fa-th-large"></i>
            </div>
            <div class="stat-content">
                <div class="stat-meta">
                    <span class="stat-label">Total Divisi</span>
                    <div class="stat-status">
                        <i class="fas fa-check-circle"></i>
                        <span>Aktif</span>
                    </div>
                </div>
                <h2 class="counter" data-target="{{ $total_divisi }}">0</h2>
            </div>
            <div class="stat-icon">
                <i class="fas fa-th-large"></i>
            </div>
        </div>

        <div class="stat-card stat-secondary">
            <div class="stat-bg-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-meta">
                    <span class="stat-label">Total Kuota</span>
                    <div class="stat-status">
                        <i class="fas fa-users"></i>
                        <span>Mahasiswa</span>
                    </div>
                </div>
                <h2 class="counter" data-target="{{ $total_kuota }}">0</h2>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="stat-card stat-info">
            <div class="stat-bg-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stat-content">
                <div class="stat-meta">
                    <span class="stat-label">Total Mahasiswa</span>
                    <div class="stat-status">
                        <i class="fas fa-check-circle"></i>
                        <span>Terdaftar</span>
                    </div>
                </div>
                <h2 class="counter" data-target="{{ $total_mahasiswa_aktif }}">0</h2>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>

        <div class="stat-card stat-{{ $sisa_kuota_class }}">
            <div class="stat-bg-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
            <div class="stat-content">
                <div class="stat-meta">
                    <span class="stat-label">Sisa Kuota</span>
                    <div class="stat-status">
                        <i class="fas fa-{{ $sisa_kuota_icon }}"></i>
                        <span>{{ $sisa_kuota_text }}</span>
                    </div>
                </div>
                <h2 class="counter" data-target="{{ $sisa_kuota }}">0</h2>
            </div>
            <div class="stat-icon">
                <i class="fas fa-clipboard-check"></i>
            </div>
        </div>
    </div>

    <div class="card monitoring-card">
        <div class="card-header monitoring-header">
            <div class="header-title-group">
                <h2 class="card-title" style="color: #ffffff;">
                    <i class="fas fa-chart-pie" style="color: #4cc9f0;"></i>
                    Monitoring Kuota per Divisi
                </h2>
                <p class="monitoring-header-subtitle">Pemantauan kapasitas dan keterisian peserta magang aktif</p>
            </div>
            <div class="header-badge-tag">
                <i class="fas fa-sync-alt fa-spin"></i> Data Real-Time
            </div>
        </div>
        <div class="card-body monitoring-body">
            <div class="monitoring-grid-container">
                @foreach($divisi_list as $divisi)
                @php
                    $isPenuh = $divisi->sisa == 0;
                    $isHampirPenuh = !$isPenuh && $divisi->mahasiswa_count > 0 && ($divisi->persentase >= 75 || ($divisi->sisa <= 2 && $divisi->persentase >= 50));
                    $progressClass = $isPenuh ? 'danger' : ($isHampirPenuh ? 'warning' : 'success');
                    $statusIcon = $isPenuh ? 'fa-times-circle' : ($isHampirPenuh ? 'fa-exclamation-triangle' : 'fa-check-circle');
                    $statusLabel = $isPenuh ? 'PENUH' : ($isHampirPenuh ? 'HAMPIR PENUH' : 'TERSEDIA');
                @endphp
                <div class="monitoring-item-card status-border-{{ $progressClass }}">
                    <div class="monitoring-item-header">
                        <div class="divisi-title-wrap">
                            <div class="divisi-icon-pill icon-{{ $progressClass }}">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <h4 class="monitoring-divisi-name">{{ $divisi->nama_divisi }}</h4>
                                <span class="monitoring-meta-text">
                                    <i class="fas fa-users"></i> Kapasitas: <strong>{{ $divisi->kuota }}</strong> Mahasiswa
                                </span>
                            </div>
                        </div>
                        <div class="monitoring-status-pill pill-{{ $progressClass }}">
                            <i class="fas {{ $statusIcon }}"></i>
                            <span>{{ $statusLabel }}</span>
                        </div>
                    </div>

                    <!-- Metrics row -->
                    <div class="monitoring-metrics-row">
                        <div class="metric-box">
                            <span class="metric-label">Terisi (Aktif)</span>
                            <strong class="metric-val metric-filled">{{ $divisi->mahasiswa_count }}</strong>
                        </div>
                        <div class="metric-box">
                            <span class="metric-label">Sisa Kuota</span>
                            <strong class="metric-val metric-remaining val-{{ $progressClass }}">{{ $divisi->sisa }}</strong>
                        </div>
                        <div class="metric-box">
                            <span class="metric-label">Persentase</span>
                            <strong class="metric-val metric-percent">{{ number_format($divisi->persentase, 0) }}%</strong>
                        </div>
                    </div>

                    <!-- Progress bar -->
                    <div class="monitoring-progress-wrapper">
                        <div class="monitoring-progress-track">
                            <div class="monitoring-progress-bar bar-{{ $progressClass }}" style="width: {{ min($divisi->persentase, 100) }}%;"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/dashboard.js') }}"></script>
@endpush