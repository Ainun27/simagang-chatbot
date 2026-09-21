@extends('layouts.app')

@section('title', 'Tambah Divisi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/divisi-create.css') }}">
@endpush

@section('content')
<div class="container">
    <div class="dashboard-card">
        <div class="dashboard-header">
            <div class="title-wrapper">
                <div class="title-icon"><i class="fas fa-plus-circle"></i></div>
                <div class="title-text">
                    <h1 class="main-title">Tambah Divisi Baru</h1>
                    <p class="subtitle">Isi form berikut untuk menambahkan divisi magang baru</p>
                </div>
            </div>
            <a href="{{ route('admin.divisi.index') }}" class="btn-add"><i class="fas fa-arrow-left"></i><span>Kembali</span></a>
        </div>

        <div class="form-container">
            <form action="{{ route('admin.divisi.store') }}" method="POST" id="formTambahDivisi">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="nama_divisi"><i class="fas fa-building"></i> Nama Divisi <span class="text-danger">*</span></label>
                    <input type="text" id="nama_divisi" name="nama_divisi" class="form-control @error('nama_divisi') is-invalid @enderror" value="{{ old('nama_divisi') }}" placeholder="Contoh: IT & Programmer" required autofocus>
                    @error('nama_divisi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Gunakan nama yang jelas dan mudah dipahami</small>
                    <div id="nama_error" style="display: none;"></div>
                </div>

                <div class="form-group">
                    <label class="form-label" for="deskripsi"><i class="fas fa-align-left"></i> Deskripsi <span class="text-danger">*</span></label>
                    <textarea id="deskripsi" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" rows="4" placeholder="Jelaskan tugas dan tanggung jawab divisi ini..." required>{{ old('deskripsi') }}</textarea>
                    @error('deskripsi')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Minimal 20 karakter, jelaskan secara detail</small>
                </div>

                <div class="form-group">
                    <label class="form-label" for="kuota"><i class="fas fa-users"></i> Kuota Mahasiswa <span class="text-danger">*</span></label>
                    <input type="number" id="kuota" name="kuota" class="form-control @error('kuota') is-invalid @enderror" value="{{ old('kuota', 5) }}" min="1" max="50" required>
                    @error('kuota')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="text-muted"><i class="fas fa-info-circle"></i> Jumlah mahasiswa yang dapat diterima (1-50 orang)</small>
                </div>

                <div class="preview-card">
                    <h4><i class="fas fa-eye"></i> Preview Divisi</h4>
                    <div id="preview-content">
                        <div><strong>Nama:</strong> <span id="preview-nama">-</span></div>
                        <div><strong>Deskripsi:</strong> <span id="preview-deskripsi">-</span></div>
                        <div><strong>Kuota:</strong> <span id="preview-kuota">-</span></div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.divisi.index') }}" class="btn btn-secondary"><i class="fas fa-times"></i> Batal</a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit"><i class="fas fa-save"></i> Simpan Divisi</button>
                </div>
            </form>
        </div>
    </div>

    <div class="help-card">
        <h4><i class="fas fa-question-circle"></i> Panduan Pengisian</h4>
        <ul>
            <li><i class="fas fa-check"></i> <strong>Nama Divisi:</strong> Harus unik dan belum pernah digunakan</li>
            <li><i class="fas fa-check"></i> <strong>Deskripsi:</strong> Jelaskan tugas, skill yang dibutuhkan, dan output yang diharapkan</li>
            <li><i class="fas fa-check"></i> <strong>Kuota:</strong> Sesuaikan dengan jumlah mentor dan kapasitas divisi</li>
        </ul>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const namaDivisi = document.getElementById('nama_divisi');
    const namaError = document.getElementById('nama_error');
    const btnSubmit = document.getElementById('btnSubmit');
    const deskripsi = document.getElementById('deskripsi');
    const kuota = document.getElementById('kuota');
    const previewNama = document.getElementById('preview-nama');
    const previewDeskripsi = document.getElementById('preview-deskripsi');
    const previewKuota = document.getElementById('preview-kuota');

    // CEK NAMA DIVISI (AJAX)
    let timeoutId = null;
    
    if (namaDivisi) {
        namaDivisi.addEventListener('keyup', function() {
            const nama = this.value.trim();
            
            if (nama.length < 2) {
                namaError.style.display = 'none';
                btnSubmit.disabled = false;
                btnSubmit.style.opacity = '1';
                btnSubmit.style.cursor = 'pointer';
                return;
            }

            // Debounce untuk mengurangi request
            if (timeoutId) clearTimeout(timeoutId);
            
            timeoutId = setTimeout(() => {
                fetch(`{{ url('/admin/divisi/cek-nama') }}?nama=${encodeURIComponent(nama)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            namaError.style.display = 'block';
                            namaError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Nama "' + nama + '" sudah ada! Gunakan nama lain.';
                            namaError.style.background = '#fee2e2';
                            namaError.style.padding = '0.5rem';
                            namaError.style.borderRadius = '8px';
                            namaError.style.color = '#dc2626';
                            btnSubmit.disabled = true;
                            btnSubmit.style.opacity = '0.5';
                            btnSubmit.style.cursor = 'not-allowed';
                        } else {
                            namaError.style.display = 'none';
                            btnSubmit.disabled = false;
                            btnSubmit.style.opacity = '1';
                            btnSubmit.style.cursor = 'pointer';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        btnSubmit.disabled = false;
                    });
            }, 500);
        });
    }

    // LIVE PREVIEW
    function updatePreview() {
        if (previewNama) {
            previewNama.textContent = namaDivisi.value.trim() || '-';
        }
        
        if (deskripsi && previewDeskripsi) {
            let descText = deskripsi.value.trim();
            if (descText.length > 60) {
                descText = descText.substring(0, 60) + '...';
            }
            previewDeskripsi.textContent = descText || '-';
        }
        
        if (kuota && previewKuota) {
            previewKuota.textContent = kuota.value ? kuota.value + ' Mahasiswa' : '-';
        }
    }

    if (namaDivisi) namaDivisi.addEventListener('input', updatePreview);
    if (deskripsi) deskripsi.addEventListener('input', updatePreview);
    if (kuota) kuota.addEventListener('input', updatePreview);
    updatePreview();
});
</script>
@endpush