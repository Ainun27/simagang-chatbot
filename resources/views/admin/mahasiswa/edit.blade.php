@extends('layouts.app')

@section('title', 'Edit Mahasiswa - ' . $mahasiswa->nama)

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/mahasiswa-edit.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper">
                <div class="title-icon"><i class="fas fa-user-edit"></i></div>
                <div class="title-text">
                    <h1 class="main-title">Edit Data Mahasiswa</h1>
                    <p class="subtitle">{{ $mahasiswa->nama }}</p>
                </div>
            </div>
            <a href="{{ route('admin.mahasiswa.index') }}" class="btn-add"><i class="fas fa-arrow-left"></i><span>Kembali</span></a>
        </div>

        <div class="form-container">
            @if ($errors->any())
                <div class="error-alert">
                    <div class="error-alert-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="error-alert-content">
                        <strong>Terjadi Kesalahan!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.mahasiswa.update', $mahasiswa->id) }}" method="POST" id="mahasiswaForm">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label" for="nim"><i class="fas fa-id-card"></i> NIM <span class="text-danger">*</span></label>
                    <input type="text" id="nim" name="nim" class="form-control @error('nim') is-invalid @enderror" value="{{ old('nim', $mahasiswa->nim) }}" placeholder="Contoh: 210101001" required autofocus>
                    @error('nim')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="nim_error" class="text-danger" style="font-size: 0.8rem; margin-top: 0.25rem; display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="nama"><i class="fas fa-user"></i> Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $mahasiswa->nama) }}" placeholder="Contoh: Ahmad Fauzi" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="email"><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                    <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $mahasiswa->email) }}" placeholder="Contoh: ahmad@example.com" required>
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <div id="email_error" class="text-danger" style="font-size: 0.8rem; margin-top: 0.25rem; display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="no_hp"><i class="fas fa-phone"></i> Nomor HP <span class="text-danger">*</span></label>
                    <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $mahasiswa->no_hp) }}" placeholder="Contoh: 081234567890" required>
                    @error('no_hp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="universitas"><i class="fas fa-university"></i> Universitas <span class="text-danger">*</span></label>
                    <input type="text" id="universitas" name="universitas" class="form-control @error('universitas') is-invalid @enderror" value="{{ old('universitas', $mahasiswa->universitas) }}" placeholder="Contoh: Universitas Mulawarman" required>
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
                                $terisi = $d->terisi ?? $d->mahasiswa()->where('is_active', true)->count();
                                $sisa_kuota = $d->sisa_kuota ?? ($d->kuota - $terisi);
                                $is_current = $d->id == $mahasiswa->divisi_id;
                            @endphp
                            <option value="{{ $d->id }}" 
                                    {{ old('divisi_id', $mahasiswa->divisi_id) == $d->id ? 'selected' : '' }}
                                    {{ ($sisa_kuota <= 0 && !$is_current) ? 'disabled' : '' }}
                                    data-kuota="{{ $d->kuota }}"
                                    data-terisi="{{ $terisi }}"
                                    data-sisa="{{ $sisa_kuota }}">
                                {{ $d->nama_divisi }} - 
                                @if($is_current)
                                    (Divisi Saat Ini - Kuota: {{ $d->kuota }})
                                @elseif($sisa_kuota > 0)
                                    (Sisa Kuota: {{ $sisa_kuota }}/{{ $d->kuota }})
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
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" value="{{ old('tanggal_mulai', $mahasiswa->tanggal_mulai ? \Carbon\Carbon::parse($mahasiswa->tanggal_mulai)->format('Y-m-d') : date('Y-m-d')) }}" required>
                        @error('tanggal_mulai')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="tanggal_selesai"><i class="fas fa-calendar-minus"></i> Tanggal Selesai Magang <span class="text-danger">*</span></label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" value="{{ old('tanggal_selesai', $mahasiswa->tanggal_selesai ? \Carbon\Carbon::parse($mahasiswa->tanggal_selesai)->format('Y-m-d') : '') }}" required>
                        @error('tanggal_selesai')
                            <span class="invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="info-masa-magang">
                    <div class="info-masa-magang-header">
                        <div><i class="fas fa-calculator"></i> <strong>Estimasi Durasi Magang</strong></div>
                        <div class="info-masa-magang-durasi">
                            <strong>Durasi:</strong>
                            <span id="masa-magang-text" class="durasi-value">-</span>
                        </div>
                    </div>
                </div>

                <!-- Toggle Switch Status Keaktifan Mahasiswa -->
                @php
                    $isActiveCurrent = (bool) old('is_active', $mahasiswa->is_active);
                @endphp
                <div class="status-toggle-card {{ $isActiveCurrent ? 'card-active' : 'card-inactive' }}" id="statusCard">
                    <div class="status-toggle-left">
                        <div class="status-toggle-icon-wrap" id="statusIconWrap">
                            <i class="fas {{ $isActiveCurrent ? 'fa-user-check' : 'fa-user-slash' }}" id="statusIcon"></i>
                        </div>
                        <div class="status-toggle-text">
                            <div class="status-toggle-header">
                                <label class="status-toggle-title" for="is_active_toggle">Status Keaktifan Mahasiswa</label>
                                <span id="statusBadgePill" class="badge-status-pill {{ $isActiveCurrent ? 'active' : 'inactive' }}">
                                    <i class="fas {{ $isActiveCurrent ? 'fa-check-circle' : 'fa-times-circle' }}" id="statusBadgeIcon"></i>
                                    <span id="statusBadgeText">{{ $isActiveCurrent ? 'AKTIF' : 'NONAKTIF' }}</span>
                                </span>
                            </div>
                            <p class="status-toggle-desc" id="statusDesc">
                                @if($isActiveCurrent)
                                    Mahasiswa berstatus <strong>Aktif</strong> menjalani magang dan menggunakan kuota divisi.
                                @else
                                    Mahasiswa berstatus <strong>Nonaktif</strong> (keluar/berhenti/selesai) dan kuota divisi dibebaskan.
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="status-switch-action">
                        <label class="switch-toggle" for="is_active_toggle" title="Klik untuk mengubah status aktif/nonaktif">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" id="is_active_toggle" value="1" {{ $isActiveCurrent ? 'checked' : '' }}>
                            <span class="switch-slider"></span>
                        </label>
                    </div>
                </div>
                @error('is_active')
                    <span class="invalid-feedback" style="margin-top: -1rem; margin-bottom: 1.5rem;">{{ $message }}</span>
                @enderror

                <div class="form-actions">
                    <a href="{{ route('admin.mahasiswa.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="fas fa-save"></i> Update Data Mahasiswa</button>
                </div>
            </form>
        </div>
    </div>

    <div class="help-card">
        <h4><i class="fas fa-info-circle"></i> Petunjuk Status Keaktifan</h4>
        <ul>
            <li><i class="fas fa-check"></i> <strong>Mahasiswa Keluar/Berhenti:</strong> Jika mahasiswa tiba-tiba mengundurkan diri atau berhenti di tengah masa magang, Anda cukup mematikan tombol toggle di atas menjadi <strong>NONAKTIF</strong>.</li>
            <li><i class="fas fa-check"></i> <strong>Pelepasan Kuota:</strong> Mahasiswa yang dinonaktifkan tidak akan memakan kuota divisi lagi sehingga kuota dapat diisi oleh mahasiswa lain.</li>
            <li><i class="fas fa-check"></i> <strong>Validasi Tanggal:</strong> Tanggal selesai harus lebih akhir dari tanggal mulai.</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/admin/mahasiswa-edit.js') }}"></script>
@endpush