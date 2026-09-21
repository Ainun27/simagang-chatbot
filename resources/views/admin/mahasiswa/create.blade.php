@extends('layouts.app')

@section('title', 'Tambah Mahasiswa')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mahasiswa-create.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper">
                <div class="title-icon"><i class="fas fa-user-plus"></i></div>
                <div class="title-text">
                    <h1 class="main-title">Tambah Mahasiswa Baru</h1>
                    <p class="subtitle">Isi form berikut untuk menambahkan data mahasiswa magang</p>
                </div>
            </div>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn-add"><i class="fas fa-arrow-left"></i><span>Kembali</span></a>
        </div>

        <div class="form-container">
            <form action="{{ route('admin.mahasiswa.store') }}" method="POST" id="mahasiswaForm">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nim"><i class="fas fa-id-card"></i> NIM <span class="text-danger">*</span></label>
                    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim') }}" placeholder="Contoh: 210101001" required autofocus>
                    @error('nim')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="nim_error" class="text-danger" style="font-size: 0.8rem; margin-top: 0.25rem; display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nama"><i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" placeholder="Contoh: Ahmad Fauzi" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email"><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Contoh: ahmad@example.com" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="email_error" class="text-danger" style="font-size: 0.8rem; margin-top: 0.25rem; display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_hp"><i class="fas fa-phone"></i> Nomor HP <span class="text-danger">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp') }}" placeholder="Contoh: 081234567890" required>
                    @error('no_hp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="universitas"><i class="fas fa-university"></i> Universitas <span class="text-danger">*</span></label>
                    <input type="text" id="universitas" name="universitas" class="form-control @error('universitas') is-invalid @enderror" value="{{ old('universitas') }}" placeholder="Contoh: Universitas Mulawarman" required>
                    @error('universitas')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="divisi_id"><i class="fas fa-briefcase"></i> Divisi Magang <span class="text-danger">*</span></label>
                    <select name="divisi_id" id="divisi_id" class="form-control @error('divisi_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Divisi --</option>
                        @foreach($divisi as $d)
                            @php
                                $terisi = $d->mahasiswa()->where('is_active', true)->count();
                                $sisa = $d->kuota - $terisi;
                            @endphp
                            <option value="{{ $d->id }}" 
                                    {{ old('divisi_id') == $d->id ? 'selected' : '' }}
                                    {{ $sisa <= 0 ? 'disabled' : '' }}
                                    data-kuota="{{ $d->kuota }}"
                                    data-terisi="{{ $terisi }}"
                                    data-sisa="{{ $sisa }}">
                                {{ $d->nama_divisi }} - 
                                @if($sisa > 0)
                                    (Sisa Kuota: {{ $sisa }}/{{ $d->kuota }})
                                @else
                                    (PENUH)
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('divisi_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="divisi-info" style="margin-top: 1rem; display: none;"></div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="tanggal_mulai"><i class="fas fa-calendar-plus"></i> Tanggal Mulai Magang <span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', date('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tanggal_selesai"><i class="fas fa-calendar-minus"></i> Tanggal Selesai Magang <span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai') }}" required>
                        @error('tanggal_selesai')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="info-masa-magang">
                    <div class="info-masa-magang-header">
                        <div>
                            <i class="fas fa-calculator"></i> <strong>Estimasi Durasi Magang</strong>
                        </div>
                        <div class="info-masa-magang-durasi">
                            <strong>Durasi:</strong>
                            <span id="masa-magang-text" class="durasi-value">-</span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="fas fa-save"></i> Simpan Mahasiswa</button>
                </div>
            </form>
        </div>
    </div>

    <div class="help-card">
        <h4><i class="fas fa-question-circle"></i> Informasi Penting</h4>
        <ul>
            <li><i class="fas fa-check"></i> <strong>NIM harus unik:</strong> Tidak boleh ada NIM yang sama antar mahasiswa</li>
            <li><i class="fas fa-check"></i> <strong>Email harus unik:</strong> Tidak boleh ada email yang sama yang terdaftar</li>
            <li><i class="fas fa-check"></i> <strong>Masa Magang Otomatis:</strong> Sistem akan menghitung estimasi durasi magang dari tanggal mulai dan selesai</li>
            <li><i class="fas fa-check"></i> <strong>Validasi Tanggal:</strong> Tanggal selesai harus setelah tanggal mulai</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/mahasiswa-create.js') }}"></script>
@endpush