@extends('layouts.app')

@section('title', 'Tambah Knowledge Base')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/knowledge-base.css') }}">
@endpush

@section('content')
<div class="kb-container">

    <div class="kb-card">
        {{-- HEADER --}}
        <div class="kb-card-header">
            <h3>
                <i class="fas fa-plus-circle"></i>
                Tambah Knowledge Base
            </h3>
            <a href="{{ route('admin.knowledge-base.index') }}" class="btn">
                <i class="fas fa-arrow-left"></i>
                Kembali
            </a>
        </div>

        {{-- BODY --}}
        <div class="kb-card-body">

            <form action="{{ route('admin.knowledge-base.store') }}" method="POST">
                @csrf

                {{-- KATEGORI & PRIORITAS --}}
                <div class="kb-form-row">
                    <div class="kb-form-group">
                        <label for="category" class="kb-form-label">Kategori</label>
                        <select class="kb-form-control kb-form-select @error('category') is-invalid @enderror" 
                                id="category" name="category">
                            <option value="">Pilih Kategori</option>
                            <option value="Informasi Perusahaan" {{ old('category') == 'Informasi Perusahaan' ? 'selected' : '' }}>Informasi Perusahaan</option>
                            <option value="Syarat" {{ old('category') == 'Syarat' ? 'selected' : '' }}>Syarat</option>
                            <option value="Alur Pendaftaran" {{ old('category') == 'Alur Pendaftaran' ? 'selected' : '' }}>Alur Pendaftaran</option>
                            <option value="Durasi & Waktu" {{ old('category') == 'Durasi & Waktu' ? 'selected' : '' }}>Durasi & Waktu</option>
                            <option value="Biaya" {{ old('category') == 'Biaya' ? 'selected' : '' }}>Biaya</option>
                            <option value="Sertifikat" {{ old('category') == 'Sertifikat' ? 'selected' : '' }}>Sertifikat</option>
                            <option value="Benefit" {{ old('category') == 'Benefit' ? 'selected' : '' }}>Benefit</option>
                            <option value="Fasilitas" {{ old('category') == 'Fasilitas' ? 'selected' : '' }}>Fasilitas</option>
                            <option value="Absensi" {{ old('category') == 'Absensi' ? 'selected' : '' }}>Absensi</option>
                            <option value="FAQ" {{ old('category') == 'FAQ' ? 'selected' : '' }}>FAQ</option>
                            <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('category')
                            <span class="kb-form-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="kb-form-group">
                        <label for="priority" class="kb-form-label">Prioritas</label>
                        <input type="number" class="kb-form-control @error('priority') is-invalid @enderror" 
                               id="priority" name="priority" value="{{ old('priority', 0) }}" min="0">
                        <span class="kb-form-text">Semakin tinggi angka, semakin diprioritaskan</span>
                        @error('priority')
                            <span class="kb-form-error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                {{-- PERTANYAAN --}}
                <div class="kb-form-group">
                    <label for="question" class="kb-form-label">
                        Pertanyaan <span class="required">*</span>
                    </label>
                    <input type="text" class="kb-form-control @error('question') is-invalid @enderror" 
                           id="question" name="question" value="{{ old('question') }}" 
                           placeholder="Contoh: dapet uang saku" required>
                    <span class="kb-form-text">Masukkan pertanyaan seperti yang biasa ditanyakan pengguna</span>
                    @error('question')
                        <span class="kb-form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- JAWABAN --}}
                <div class="kb-form-group">
                    <label for="answer" class="kb-form-label">
                        Jawaban <span class="required">*</span>
                    </label>
                    <textarea class="kb-form-control kb-form-textarea @error('answer') is-invalid @enderror" 
                              id="answer" name="answer" rows="6" 
                              placeholder="Tulis jawaban lengkap untuk pertanyaan di atas" required>{{ old('answer') }}</textarea>
                    <span class="kb-form-text">Jawaban akan ditampilkan secara langsung ke pengguna</span>
                    @error('answer')
                        <span class="kb-form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- STATUS --}}
                <div class="kb-form-group">
                    <label for="is_active" class="kb-form-label">Status</label>
                    <select class="kb-form-control kb-form-select @error('is_active') is-invalid @enderror" 
                            id="is_active" name="is_active">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>✅ Aktif</option>
                        <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>⛔ Nonaktif</option>
                    </select>
                    <span class="kb-form-text">Data nonaktif tidak akan digunakan oleh chatbot</span>
                    @error('is_active')
                        <span class="kb-form-error">{{ $message }}</span>
                    @enderror
                </div>

                {{-- TOMBOL --}}
                <div class="kb-actions">
                    <button type="submit" class="kb-btn kb-btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('admin.knowledge-base.index') }}" class="kb-btn kb-btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection