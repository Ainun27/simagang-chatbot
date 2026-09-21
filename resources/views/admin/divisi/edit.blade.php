@extends('layouts.app')

@section('title', 'Edit Divisi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/divisi-edit.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper">
                <div class="title-icon"><i class="fas fa-edit"></i></div>
                <div class="title-text">
                    <h1 class="main-title">Edit Divisi: {{ $divisi->nama_divisi }}</h1>
                    <p class="subtitle">Perbarui informasi divisi magang</p>
                </div>
            </div>
            <a href="{{ route('admin.divisi.index') }}" class="btn-add"><i class="fas fa-arrow-left"></i><span>Kembali</span></a>
        </div>

        <div class="form-container">
            <form action="{{ route('admin.divisi.update', $divisi->id) }}" method="POST" id="formEditDivisi">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="nama_divisi"><i class="fas fa-building"></i> Nama Divisi <span class="text-danger">*</span></label>
                    <input type="text" id="nama_divisi" name="nama_divisi" class="form-control @error('nama_divisi') is-invalid @enderror" value="{{ old('nama_divisi', $divisi->nama_divisi) }}" required autofocus>
                    @error('nama_divisi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="nama_error" class="text-danger" style="font-size: 0.8rem; margin-top: 0.25rem; display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi"><i class="fas fa-align-left"></i> Deskripsi <span class="text-danger">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" required>{{ old('deskripsi', $divisi->deskripsi) }}</textarea>
                    @error('deskripsi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="kuota"><i class="fas fa-users"></i> Kuota Mahasiswa <span class="text-danger">*</span></label>
                    <input type="number" id="kuota" name="kuota" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota', $divisi->kuota) }}" min="{{ $divisi->mahasiswa_count ?? 0 }}" max="50" required>
                    @error('kuota')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror

                    @php $terisi = $divisi->mahasiswa_count ?? 0; @endphp
                    @if($terisi > 0)
                        <small class="text-warning"><i class="fas fa-exclamation-triangle"></i> Sudah ada {{ $terisi }} mahasiswa terdaftar. Kuota minimal: {{ $terisi }}</small>
                    @else
                        <small class="text-muted"><i class="fas fa-info-circle"></i> Belum ada mahasiswa terdaftar</small>
                    @endif
                </div>

                <div class="status-box">
                    <h4 class="status-title"><i class="fas fa-info-circle"></i> Status Divisi</h4>
                    <div class="status-grid">
                        <div><div class="status-label">Kuota Total</div><div class="status-value primary">{{ $divisi->kuota }}</div></div>
                        <div><div class="status-label">Terisi</div><div class="status-value success">{{ $terisi }}</div></div>
                        <div><div class="status-label">Sisa</div><div class="status-value {{ $divisi->kuota - $terisi > 0 ? 'success' : 'danger' }}">{{ $divisi->kuota - $terisi }}</div></div>
                        <div><div class="status-label">Dibuat</div><div class="status-value dark">{{ $divisi->created_at->format('d M Y') }}</div></div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.divisi.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="fas fa-save"></i> Update Divisi</button>
                </div>
            </form>
        </div>
    </div>

    @if($terisi > 0)
    <div class="alert-warning-custom">
        <i class="fas fa-exclamation-triangle"></i> <strong>Perhatian!</strong>
        <ul class="warning-list">
            <li>Divisi ini memiliki {{ $terisi }} mahasiswa yang sedang magang</li>
            <li>Kuota tidak dapat dikurangi di bawah jumlah mahasiswa yang sudah terdaftar</li>
            <li>Perubahan nama dan deskripsi tidak akan mempengaruhi mahasiswa yang sudah terdaftar</li>
        </ul>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/divisi-edit.js') }}"></script>
@endpush