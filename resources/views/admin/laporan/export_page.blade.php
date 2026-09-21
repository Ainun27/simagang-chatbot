@extends('layouts.app')

@section('title', 'Pusat Cetak & Download Laporan')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/export-page.css') }}">
@endpush

@section('content')
<div class="export-page-wrapper">
    <div class="export-container">
        <!-- Back Button Navigation -->
        <div class="top-nav-bar">
            <a href="{{ route('admin.laporan.index') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i><span>Kembali ke Laporan Mahasiswa</span>
            </a>
        </div>

        <div class="export-card">
            <!-- Header -->
            <div class="export-header">
                <div class="header-icon-box">
                    <i class="fas fa-file-export"></i>
                </div>
                <div class="header-text-content">
                    <h2 class="export-title">Pusat Cetak & Unduh Laporan</h2>
                    <p class="export-description">
                        Kustomisasi parameter filter untuk mengunduh arsip data mahasiswa magang dalam format dokumen resmi (PDF) atau lembar kerja (Excel).
                    </p>
                </div>
                <div class="header-meta-badge">
                    <span class="meta-label">Total Arsip</span>
                    <strong class="meta-count">{{ $total_data }} Mahasiswa</strong>
                </div>
            </div>

            <!-- Form Body -->
            <div class="export-body">
                <form id="formExport" method="GET" action="{{ route('admin.laporan.export.pdf') }}">
                    <div class="form-section-title">
                        <i class="fas fa-sliders-h"></i> Parameter Penyaringan Data
                    </div>

                    <div class="filter-controls-grid">
                        <!-- Filter Divisi -->
                        <div class="export-form-group">
                            <label class="export-label">
                                <i class="fas fa-building"></i> Divisi Magang
                            </label>
                            <div class="select-wrapper">
                                <select name="divisi_id" class="export-select">
                                    <option value="">Semua Divisi (Seluruh Unit)</option>
                                    @foreach($divisi as $d)
                                        <option value="{{ $d->id }}">{{ $d->nama_divisi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filter Status -->
                        <div class="export-form-group">
                            <label class="export-label">
                                <i class="fas fa-toggle-on"></i> Status Kepesertaan
                            </label>
                            <div class="select-wrapper">
                                <select name="status" class="export-select">
                                    <option value="">Semua Status (Aktif & Selesai)</option>
                                    <option value="1">Hanya Mahasiswa Aktif</option>
                                    <option value="0">Hanya Mahasiswa Selesai / Nonaktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Filter Bulan -->
                        <div class="export-form-group">
                            <label class="export-label">
                                <i class="fas fa-calendar-alt"></i> Periode Bulan
                            </label>
                            <div class="select-wrapper">
                                <select name="bulan" class="export-select">
                                    <option value="">Semua Bulan (Sepanjang Tahun)</option>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}">{{ \Carbon\Carbon::create(null, $m, 1)->translatedFormat('F') }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Filter Tahun -->
                        <div class="export-form-group">
                            <label class="export-label">
                                <i class="fas fa-calendar-check"></i> Periode Tahun
                            </label>
                            <div class="select-wrapper">
                                <select name="tahun" class="export-select">
                                    <option value="">Semua Tahun Arsip</option>
                                    @foreach($tahun_list as $t)
                                        <option value="{{ $t }}" {{ $t == date('Y') ? 'selected' : '' }}>{{ $t }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Pilihan Format Unduhan -->
                    <div class="form-section-title format-section-title">
                        <i class="fas fa-download"></i> Pilih Format Dokumen Unduhan
                    </div>

                    <div class="export-action-grid">
                        <!-- Download PDF Card Button -->
                        <button type="button" onclick="submitExport('pdf')" class="export-choice-card card-pdf">
                            <div class="choice-icon">
                                <i class="fas fa-file-pdf"></i>
                            </div>
                            <div class="choice-info">
                                <h4>Unduh Dokumen PDF Resmi</h4>
                                <p>Format siap cetak (Kop Resmi Diskominfosantik A4 Landscape)</p>
                            </div>
                            <div class="choice-badge">
                                <i class="fas fa-arrow-down"></i> Unduh PDF
                            </div>
                        </button>

                        <!-- Download Excel Card Button -->
                        <button type="button" onclick="submitExport('excel')" class="export-choice-card card-excel">
                            <div class="choice-icon">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div class="choice-info">
                                <h4>Unduh Spreadsheet Excel (.xlsx)</h4>
                                <p>Format data tabular lengkap untuk rekapitulasi & olah data</p>
                            </div>
                            <div class="choice-badge">
                                <i class="fas fa-arrow-down"></i> Unduh Excel
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function submitExport(type) {
        const form = document.getElementById('formExport');
        if (type === 'pdf') {
            form.action = "{{ route('admin.laporan.export.pdf') }}";
        } else if (type === 'excel') {
            form.action = "{{ route('admin.laporan.export.excel') }}";
        }
        form.submit();
    }
</script>
@endpush