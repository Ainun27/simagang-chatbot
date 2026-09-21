@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mahasiswa.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="statistics-card">
        <div class="statistics-header">
            <h3><i class="fas fa-chart-bar"></i> Statistik Mahasiswa Magang</h3>
            <div class="statistics-subtitle">Data Terkini Sistem Magang</div>
        </div>
        
        <div class="statistics-grid">
            <div class="stat-card stat-primary"><div class="stat-icon"><i class="fas fa-users"></i></div><div class="stat-content"><div class="stat-value">{{ $totalMahasiswa }}</div><div class="stat-label">Total Mahasiswa</div></div></div>
            <div class="stat-card stat-secondary"><div class="stat-icon"><i class="fas fa-user-check"></i></div><div class="stat-content"><div class="stat-value">{{ $mahasiswaAktif }}</div><div class="stat-label">Mahasiswa Aktif</div></div></div>
            <div class="stat-card stat-secondary"><div class="stat-icon"><i class="fas fa-user-slash"></i></div><div class="stat-content"><div class="stat-value">{{ $mahasiswaNonaktif }}</div><div class="stat-label">Mahasiswa Nonaktif</div></div></div>
            <div class="stat-card stat-secondary"><div class="stat-icon"><i class="fas fa-graduation-cap"></i></div><div class="stat-content"><div class="stat-value">{{ $mahasiswaSelesai }}</div><div class="stat-label">Selesai Magang</div></div></div>
        </div>
    </div>

    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper"><div class="title-icon"><i class="fas fa-user-graduate"></i></div><div class="title-text"><h1 class="main-title">Data Mahasiswa Magang</h1><p class="subtitle">Kelola data mahasiswa magang dengan mudah</p></div></div>
            <a href="{{ route('admin.mahasiswa.create') }}" class="btn-add"><i class="fas fa-plus"></i><span>Tambah Mahasiswa</span></a>
        </div>

        <div class="toolbar-section">
            <form method="GET" action="{{ route('admin.mahasiswa.index') }}" class="filter-form">
                <div class="form-row">
                    <div class="form-group">
                        <label class="filter-label"><i class="fas fa-filter"></i> Filter Status:</label>
                        <select name="status" class="form-select">
                            <option value="semua" {{ request('status') == 'semua' ? 'selected' : '' }}>Semua Status</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>
                
                    <div class="form-actions">
                        <button type="submit" class="btn-filter"><i class="fas fa-eye"></i> Tampilkan</button>
                        <a href="{{ route('admin.mahasiswa.index') }}" class="btn-reset"><i class="fas fa-redo"></i> Reset</a>
                    </div>
                </div>
            </form>
        </div>

        @if($mahasiswa->count() > 0)
        <div class="table-container">
            <div class="table-responsive">
                <table class="data-table">
                    <thead><tr><th class="text-center">No</th><th>NIM</th><th>Nama Mahasiswa</th><th>Universitas</th><th>Divisi</th><th>Status</th><th>Tanggal Daftar</th><th class="text-center">Aksi</th></tr></thead>
                    <tbody>
                        @foreach($mahasiswa as $index => $mhs)
                        <tr>
                            <td class="text-center"><span class="row-number">{{ $mahasiswa->firstItem() + $index }}</span></td>
                            <td><span class="nim-badge">{{ $mhs->nim }}</span></td>
                            <td><div class="student-info"><div class="student-details"><strong class="student-name">{{ $mhs->nama }}</strong><small class="student-university">{{ $mhs->email }}</small></div></div></td>
                            <td>{{ $mhs->universitas }}</td>
                            <td><span class="divisi-badge">{{ $mhs->divisi->nama_divisi ?? '-' }}</span></td>
                            <td>
                                @if($mhs->is_active)
                                    <span class="status-badge active"><i class="fas fa-check-circle"></i> Aktif</span>
                                @else
                                    <span class="status-badge inactive"><i class="fas fa-times-circle"></i> Nonaktif</span>
                                @endif
                            </td>
                            <td><span class="date-badge"><i class="fas fa-calendar"></i> {{ $mhs->created_at->format('d M Y') }}</span></td>
                            <td class="text-center">
                                <div class="action-group">
                                    <a href="{{ route('admin.mahasiswa.edit', $mhs->id) }}" class="action-btn warning-btn" title="Edit Mahasiswa"><i class="fas fa-edit"></i></a>
                                    <form action="{{ route('admin.mahasiswa.destroy', $mhs->id) }}" method="POST" class="action-form" onsubmit="return confirm('Hapus {{ $mhs->nama }}?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="action-btn danger-btn" title="Hapus Mahasiswa"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="pagination-wrapper">{{ $mahasiswa->appends(request()->query())->links() }}</div>
        @else
        <div class="empty-state"><div class="empty-icon"><i class="fas fa-users"></i></div><h3>Belum Ada Data Mahasiswa</h3><p>Mulai dengan menambahkan data mahasiswa pertama</p><a href="{{ route('admin.mahasiswa.create') }}" class="btn-add"><i class="fas fa-plus"></i>Tambah Mahasiswa Pertama</a></div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/mahasiswa.js') }}"></script>
@endpush