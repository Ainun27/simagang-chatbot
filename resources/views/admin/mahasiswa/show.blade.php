@extends('layouts.app')

@section('title', 'Detail Mahasiswa - ' . $mahasiswa->nama)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mahasiswa-show.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="custom-card">
        <div class="custom-card-header">
            <div class="header-content">
                <h2 class="mahasiswa-title">
                    <i class="fas fa-user-graduate"></i>
                    {{ $mahasiswa->nama }}
                </h2>
                <div class="header-actions">
                    <a href="{{ route('admin.mahasiswa.edit', $mahasiswa->id) }}" class="btn btn-edit">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Status Mahasiswa -->
            <div class="status-container {{ $mahasiswa->is_active ? 'status-active' : 'status-inactive' }}">
                <div class="status-info">
                    <div class="status-label">Status Mahasiswa</div>
                    <div class="status-value">
                        <i class="fas fa-{{ $mahasiswa->is_active ? 'check-circle' : 'times-circle' }}"></i>
                        {{ $mahasiswa->is_active ? 'AKTIF' : 'NONAKTIF' }}
                    </div>
                </div>
                
                @if($mahasiswa->tanggal_mulai && $mahasiswa->tanggal_selesai)
                <div class="periode-info">
                    <div class="periode-label">
                        <i class="fas fa-calendar-alt"></i> Periode Magang
                    </div>
                    <div class="periode-value">
                        {{ \Carbon\Carbon::parse($mahasiswa->tanggal_mulai)->format('d M Y') }} 
                        - 
                        {{ \Carbon\Carbon::parse($mahasiswa->tanggal_selesai)->format('d M Y') }}
                    </div>
                    @php
                        $today = \Carbon\Carbon::today();
                        $selesai = \Carbon\Carbon::parse($mahasiswa->tanggal_selesai);
                        $selisih_hari = $today->diffInDays($selesai, false);
                    @endphp
                    @if($selisih_hari >= 0)
                        <small class="hari-sisa">{{ $selisih_hari }} hari lagi</small>
                    @else
                        <small class="hari-lewat">Selesai {{ abs($selisih_hari) }} hari lalu</small>
                    @endif
                </div>
                @endif
            </div>

            <!-- Profile Info Grid -->
            <div class="info-grid-container">
                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-id-card"></i>
                        <span>NIM</span>
                    </div>
                    <div class="info-value">{{ $mahasiswa->nim }}</div>
                </div>

                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-user"></i>
                        <span>Nama Lengkap</span>
                    </div>
                    <div class="info-value">{{ $mahasiswa->nama }}</div>
                </div>

                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-envelope"></i>
                        <span>Email</span>
                    </div>
                    <div class="info-value email-value">{{ $mahasiswa->email }}</div>
                </div>

                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-phone"></i>
                        <span>No HP</span>
                    </div>
                    <div class="info-value">{{ $mahasiswa->no_hp }}</div>
                </div>

                <div class="info-card-detail">
                    <div class="info-header">
                        <i class="fas fa-university"></i>
                        <span>Universitas</span>
                    </div>
                    <div class="info-value">{{ $mahasiswa->universitas }}</div>
                </div>

                <div class="divisi-card">
                    <div class="info-header">
                        <i class="fas fa-briefcase"></i>
                        <span>Divisi Magang</span>
                    </div>
                    <div class="info-value">
                        <span class="badge-divisi">{{ $mahasiswa->divisi->nama_divisi }}</span>
                    </div>
                </div>
            </div>

            <!-- Divisi Detail Container -->
            <div class="divisi-detail-container">
                <h3 class="divisi-title">
                    <i class="fas fa-th-large"></i> Detail Divisi
                </h3>
                <div class="divisi-content">
                    <div class="divisi-header">
                        <div class="divisi-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="divisi-text">
                            <h4 class="divisi-nama">{{ $mahasiswa->divisi->nama_divisi }}</h4>
                            <p class="divisi-deskripsi">{{ $mahasiswa->divisi->deskripsi }}</p>
                        </div>
                    </div>
                    
                    @php
                        $terisi_aktif = $mahasiswa->divisi->mahasiswa()->where('is_active', true)->count();
                        $sisa_kuota = $mahasiswa->divisi->kuota - $terisi_aktif;
                        $total_mahasiswa = $mahasiswa->divisi->mahasiswa()->count();
                    @endphp
                    
                    <div class="stats-grid-container">
                        <div class="stat-card">
                            <div class="stat-label">Kuota Total</div>
                            <div class="stat-value">{{ $mahasiswa->divisi->kuota }}</div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Terisi (Aktif)</div>
                            <div class="stat-value">{{ $terisi_aktif }}</div>
                            <small class="stat-note">Total: {{ $total_mahasiswa }}</small>
                        </div>
                        <div class="stat-card">
                            <div class="stat-label">Sisa Kuota</div>
                            <div class="stat-value {{ $sisa_kuota > 0 ? 'sisa-positif' : 'sisa-negatif' }}">
                                {{ $sisa_kuota }}
                            </div>
                        </div>
                    </div>
                    
                    <div class="info-note">
                        <small>
                            <i class="fas fa-info-circle"></i>
                            <strong>Info perhitungan kuota:</strong> Hanya mahasiswa dengan status <strong>Aktif</strong> yang dihitung dalam kuota terisi. 
                            Total semua mahasiswa yang pernah terdaftar: {{ $total_mahasiswa }} (termasuk yang nonaktif).
                        </small>
                    </div>
                </div>
            </div>

            <!-- Date Metadata Container -->
            <div class="date-grid-container">
                <div class="date-card">
                    <div class="date-icon"><i class="fas fa-calendar-plus"></i></div>
                    <div class="date-info">
                        <div class="date-label">Terdaftar</div>
                        <div class="date-value">{{ $mahasiswa->created_at->format('d F Y, H:i') }}</div>
                        <div class="date-relative">{{ $mahasiswa->created_at->diffForHumans() }}</div>
                    </div>
                </div>

                <div class="date-card">
                    <div class="date-icon"><i class="fas fa-clock"></i></div>
                    <div class="date-info">
                        <div class="date-label">Terakhir Update</div>
                        <div class="date-value">{{ $mahasiswa->updated_at->format('d F Y, H:i') }}</div>
                        <div class="date-relative">{{ $mahasiswa->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/mahasiswa-show.js') }}"></script>
@endpush