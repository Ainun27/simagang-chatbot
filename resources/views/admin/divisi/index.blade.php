@extends('layouts.app')

@section('title', 'Daftar Divisi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/divisi.css') }}">
@endpush

@section('content')
<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dashboard">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button type="button" class="close-alert">&times;</button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dashboard">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
            <button type="button" class="close-alert">&times;</button>
        </div>
    @endif

    <div class="statistics-card">
        <div class="statistics-header">
            <h3><i class="fas fa-chart-pie"></i> Statistik Divisi Magang</h3>
            <div class="statistics-subtitle">Data Terkini Sistem Magang</div>
        </div>
        
        <div class="statistics-grid">
            <div class="stat-card stat-primary">
                <div class="stat-icon"><i class="fas fa-layer-group"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $divisi->count() }}</div>
                    <div class="stat-label">Total Divisi</div>
                </div>
            </div>
            
            <div class="stat-card stat-success">
                <div class="stat-icon"><i class="fas fa-users"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalKuota }}</div>
                    <div class="stat-label">Total Kuota</div>
                </div>
            </div>
            
            <div class="stat-card stat-danger">
                <div class="stat-icon"><i class="fas fa-user-check"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalMahasiswaAktif }}</div>
                    <div class="stat-label">Mahasiswa Aktif</div>
                </div>
            </div>
            
            <div class="stat-card stat-warning">
                <div class="stat-icon"><i class="fas fa-hourglass-half"></i></div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalSisaKuota }}</div>
                    <div class="stat-label">Sisa Kuota</div>
                </div>
            </div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper">
                <div class="title-icon"><i class="fas fa-th-large"></i></div>
                <div class="title-text">
                    <h1 class="main-title">Data Divisi Magang</h1>
                    <p class="subtitle">Kelola informasi divisi magang dengan mudah</p>
                </div>
            </div>
            
            <a href="{{ route('admin.divisi.create') }}" class="btn-add">
                <i class="fas fa-plus"></i><span>Tambah Divisi</span>
            </a>
        </div>

        @if($divisi->count() > 0)
        <div class="table-container">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Divisi</th>
                            <th>Deskripsi</th>
                            <th class="text-center">Kuota</th>
                            <th class="text-center">Terisi</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($divisi as $index => $d)
                        @php
                            $kuotaTerisi = $d->mahasiswa_aktif_count;
                            $persentase = $d->kuota > 0 ? round(($kuotaTerisi / $d->kuota) * 100) : 0;
                            $isFull = $d->sisa_kuota == 0;
                        @endphp
                        <tr class="{{ $isFull ? 'row-full' : '' }}">
                            <td class="text-center"><span class="row-number">{{ $index + 1 }}</span></td>
                            <td>
                                <div class="divisi-info">
                                    <div class="divisi-avatar {{ $isFull ? 'full' : 'available' }}">
                                        {{ strtoupper(substr($d->nama_divisi, 0, 1)) }}
                                    </div>
                                    <div class="divisi-details">
                                        <div class="divisi-name-container">
                                            <strong class="divisi-name">{{ $d->nama_divisi }}</strong>
                                            <span class="divisi-date-badge">
                                                <i class="fas fa-calendar"></i>
                                                {{ $d->created_at->format('d M Y') }}
                                            </span>
                                        </div>
                                        <small class="divisi-info-text">
                                            <i class="fas fa-clock"></i> Dibuat {{ $d->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td><span class="deskripsi-text">{{ Str::limit($d->deskripsi, 80) }}</span></td>
                            <td class="text-center"><code class="kuota-text">{{ $d->kuota }}</code></td>
                            <td class="text-center">
                                <div class="terisi-info">
                                    <div class="terisi-value {{ $isFull ? 'full' : 'available' }}">{{ $kuotaTerisi }}</div>
                                    <div class="progress-container">
                                        <div class="progress-bar" style="width: {{ min($persentase, 100) }}%;"></div>
                                    </div>
                                    <small class="sisa-text {{ $isFull ? 'text-danger' : 'text-success' }}">Sisa: {{ $d->sisa_kuota }}</small>
                                </div>
                            </td>
                            <td class="text-center">
                                <div class="action-group">
                                    <a href="{{ route('admin.divisi.edit', $d->id) }}" class="action-btn warning-btn" title="Edit Divisi"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.divisi.destroy', $d->id) }}" method="POST" class="action-form" onsubmit="return confirm('Hapus {{ $d->nama_divisi }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn danger-btn" title="Hapus Divisi"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon"><i class="fas fa-th-large"></i></div>
            <h3>Belum Ada Data Divisi</h3>
            <p>Mulai dengan menambahkan data divisi pertama</p>
            <a href="{{ route('admin.divisi.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i>Tambah Divisi Pertama</a>
        </div>
        @endif
    </div>

    <div class="info-box">
        <div class="info-content">
            <i class="fas fa-info-circle"></i>
            <div class="info-text">
                <h6>Informasi Sistem Divisi Magang</h6>
                <p>Pastikan deskripsi divisi jelas dan informatif. Divisi dengan mahasiswa tidak dapat dihapus. Kuota tidak dapat dikurangi jika sudah ada mahasiswa terdaftar.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/divisi.js') }}"></script>
@endpush