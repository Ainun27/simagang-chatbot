@extends('layouts.app')

@section('title', 'Detail Divisi - ' . $divisi->nama_divisi)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/divisi-show.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="custom-card">
        <!-- Card Header -->
        <div class="custom-card-header">
            <div class="header-content">
                <div class="header-title-wrapper">
                    <div class="header-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <div>
                        <h2 class="divisi-title">{{ $divisi->nama_divisi }}</h2>
                        <span class="divisi-id-badge"><i class="fas fa-hashtag"></i> Divisi ID: {{ $divisi->id }}</span>
                    </div>
                </div>
                <div class="header-actions">
                    <a href="{{ route('admin.divisi.edit', $divisi->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Edit Divisi
                    </a>
                    <a href="{{ route('admin.divisi.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @php
                $terisi = $divisi->mahasiswa->count();
                $sisa = $divisi->kuota - $terisi;
                $percentage = $divisi->kuota > 0 ? ($terisi / $divisi->kuota) * 100 : 0;
            @endphp

            <!-- Status Banner -->
            <div class="status-container {{ $sisa > 0 ? 'status-available' : 'status-full' }}">
                <div class="status-info">
                    <div class="status-label">Status Kuota Divisi</div>
                    <div class="status-value">
                        <i class="fas fa-{{ $sisa > 0 ? 'check-circle' : 'exclamation-circle' }}"></i>
                        {{ $sisa > 0 ? 'KUOTA TERSEDIA' : 'KUOTA PENUH' }}
                    </div>
                    <div class="status-desc">
                        @if($sisa > 0)
                            Masih tersedia <strong>{{ $sisa }}</strong> kursi dari kapasitas total {{ $divisi->kuota }} mahasiswa
                        @else
                            Seluruh kuota telah terisi penuh ({{ $terisi }} dari {{ $divisi->kuota }} mahasiswa)
                        @endif
                    </div>
                </div>
                <div class="occupancy-badge-container">
                    <div class="occupancy-label">Tingkat Okupansi</div>
                    <div class="occupancy-pill">
                        <i class="fas fa-chart-pie"></i>
                        <span>{{ number_format($percentage, 0) }}% Terisi</span>
                    </div>
                </div>
            </div>

            <!-- Dark Slate Statistics Card -->
            <div class="statistics-card">
                <div class="statistics-header">
                    <h3><i class="fas fa-chart-pie"></i> Statistik Alokasi Kuota</h3>
                    <p class="statistics-subtitle">Monitoring kuota dan kapasitas penerimaan mahasiswa magang</p>
                </div>

                <div class="statistics-grid">
                    <!-- Stat 1: Total Kuota -->
                    <div class="stat-card stat-primary">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $divisi->kuota }}</span>
                            <span class="stat-label">Total Kuota</span>
                            <small class="stat-sub">Kapasitas Maksimal</small>
                        </div>
                    </div>

                    <!-- Stat 2: Terisi -->
                    <div class="stat-card stat-info">
                        <div class="stat-icon">
                            <i class="fas fa-user-check"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ $terisi }}</span>
                            <span class="stat-label">Mahasiswa Terisi</span>
                            <small class="stat-sub">Aktif Ditempatkan</small>
                        </div>
                    </div>

                    <!-- Stat 3: Sisa Kuota -->
                    <div class="stat-card {{ $sisa > 0 ? 'stat-success' : 'stat-danger' }}">
                        <div class="stat-icon">
                            <i class="fas fa-{{ $sisa > 0 ? 'chair' : 'ban' }}"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ max(0, $sisa) }}</span>
                            <span class="stat-label">Sisa Kuota</span>
                            <small class="stat-sub">{{ $sisa > 0 ? 'Kursi Tersedia' : 'Tidak Ada Sisa' }}</small>
                        </div>
                    </div>

                    <!-- Stat 4: Persentase -->
                    <div class="stat-card stat-warning">
                        <div class="stat-icon">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="stat-content">
                            <span class="stat-value">{{ number_format($percentage, 0) }}%</span>
                            <span class="stat-label">Persentase Pengisian</span>
                            <small class="stat-sub">Rasio Okupansi</small>
                        </div>
                    </div>
                </div>

                <!-- Integrated Dark Progress Bar -->
                <div class="progress-section-dark">
                    <div class="progress-header">
                        <span class="progress-label"><i class="fas fa-tasks"></i> Progres Pengisian Kuota</span>
                        <span class="progress-percentage-text">{{ $terisi }} / {{ $divisi->kuota }} Mahasiswa ({{ number_format($percentage, 1) }}%)</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" data-width="{{ min($percentage, 100) }}" style="width: {{ min($percentage, 100) }}%;"></div>
                    </div>
                </div>
            </div>

            <!-- Description Box -->
            <div class="description-box">
                <h3 class="box-title"><i class="fas fa-align-left"></i> Deskripsi Divisi</h3>
                <p class="description-text">{{ $divisi->deskripsi ?: 'Tidak ada deskripsi yang ditambahkan untuk divisi ini.' }}</p>
            </div>

            <!-- Metadata Info Grid -->
            <div class="info-grid-container">
                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-calendar-plus"></i>
                        <span>Tanggal Dibuat</span>
                    </div>
                    <div class="info-value">{{ $divisi->created_at ? $divisi->created_at->format('d F Y, H:i') : '-' }}</div>
                    <div class="info-subtext">{{ $divisi->created_at ? $divisi->created_at->diffForHumans() : '' }}</div>
                </div>

                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-clock"></i>
                        <span>Terakhir Diupdate</span>
                    </div>
                    <div class="info-value">{{ $divisi->updated_at ? $divisi->updated_at->format('d F Y, H:i') : '-' }}</div>
                    <div class="info-subtext">{{ $divisi->updated_at ? $divisi->updated_at->diffForHumans() : '' }}</div>
                </div>

                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-shield-alt"></i>
                        <span>Status Pendaftaran</span>
                    </div>
                    <div class="info-value">
                        @if($sisa > 0)
                            <span class="badge badge-success"><i class="fas fa-check-circle"></i> Menerima Mahasiswa</span>
                        @else
                            <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Pendaftaran Penuh</span>
                        @endif
                    </div>
                    <div class="info-subtext">{{ $sisa > 0 ? 'Dapat ditambahkan mahasiswa baru' : 'Kapasitas maksimal telah terpenuhi' }}</div>
                </div>
            </div>

            <!-- Mahasiswa Terdaftar Section -->
            @if($divisi->mahasiswa && $divisi->mahasiswa->count() > 0)
            <div class="mahasiswa-card">
                <div class="mahasiswa-header">
                    <div class="mahasiswa-header-title">
                        <i class="fas fa-user-graduate"></i>
                        <h3>Daftar Mahasiswa Terdaftar</h3>
                    </div>
                    <span class="count-badge">{{ $divisi->mahasiswa->count() }} Mahasiswa</span>
                </div>
                <div class="table-wrapper">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60px;" class="text-center">No</th>
                                <th>Mahasiswa</th>
                                <th>Universitas</th>
                                <th>Periode Magang</th>
                                <th>Status</th>
                                <th class="text-center" style="width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($divisi->mahasiswa as $index => $mhs)
                            <tr>
                                <td class="text-center">
                                    <span class="row-number">{{ $index + 1 }}</span>
                                </td>
                                <td>
                                    <div class="student-info">
                                        <div class="student-avatar">
                                            {{ strtoupper(substr($mhs->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <strong class="student-name">{{ $mhs->nama }}</strong>
                                            <div class="student-nim">NIM: {{ $mhs->nim }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="univ-info">
                                        <i class="fas fa-university text-indigo"></i>
                                        <span>{{ $mhs->universitas }}</span>
                                    </div>
                                </td>
                                <td>
                                    @if($mhs->tanggal_mulai && $mhs->tanggal_selesai)
                                        <div class="periode-badge">
                                            <i class="fas fa-calendar-alt"></i>
                                            {{ \Carbon\Carbon::parse($mhs->tanggal_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($mhs->tanggal_selesai)->format('d M Y') }}
                                        </div>
                                    @else
                                        <span class="text-muted"><i class="fas fa-calendar"></i> {{ $mhs->created_at->format('d M Y') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($mhs->is_active)
                                        <span class="badge badge-success"><i class="fas fa-check-circle"></i> Aktif</span>
                                    @else
                                        <span class="badge badge-danger"><i class="fas fa-times-circle"></i> Nonaktif</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.mahasiswa.show', $mhs->id) }}" class="btn-detail-sm" title="Lihat Detail Mahasiswa">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @else
            <div class="empty-mahasiswa">
                <div class="empty-icon"><i class="fas fa-user-graduate"></i></div>
                <h4>Belum Ada Mahasiswa Terdaftar</h4>
                <p>Saat ini belum ada mahasiswa yang ditempatkan pada divisi <strong>{{ $divisi->nama_divisi }}</strong>.</p>
                <div class="empty-actions">
                    <a href="{{ route('admin.mahasiswa.create') }}" class="btn btn-add-student">
                        <i class="fas fa-user-plus"></i> Tempatkan Mahasiswa Baru
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/divisi-show.js') }}"></script>
@endpush