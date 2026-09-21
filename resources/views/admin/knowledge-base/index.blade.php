@extends('layouts.app')

@section('title', 'Kelola Knowledge Base')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin/knowledge-base.css') }}">
@endpush

@section('content')
<div class="kb-container">

    {{-- CARD --}}
    <div class="kb-card">
        {{-- HEADER --}}
        <div class="kb-card-header">
            <h3>
                <i class="fas fa-robot"></i>
                Knowledge Base Chatbot
            </h3>
            <a href="{{ route('admin.knowledge-base.create') }}" class="btn">
                <i class="fas fa-plus-circle"></i>
                Tambah Data
            </a>
        </div>

        {{-- BODY --}}
        <div class="kb-card-body">

            {{-- ALERT SUCCESS --}}
            @if(session('success'))
            <div class="kb-alert kb-alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
            @endif

            {{-- TABLE --}}
            <div class="kb-table-wrapper">
                <table class="kb-table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kategori</th>
                            <th>Pertanyaan</th>
                            <th>Prioritas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="kb-badge kb-badge-category">
                                    {{ $item->category ?? 'Umum' }}
                                </span>
                            </td>
                            <td>{{ Str::limit($item->question, 45) }}</td>
                            <td>{{ $item->priority ?? 0 }}</td>
                            <td>
                                <span class="kb-badge {{ $item->is_active ? 'kb-badge-active' : 'kb-badge-inactive' }}">
                                    <i class="fas {{ $item->is_active ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                    {{ $item->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td>
                                <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                    <a href="{{ route('admin.knowledge-base.edit', $item) }}" 
                                       class="kb-btn kb-btn-edit kb-btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.knowledge-base.destroy', $item) }}" 
                                          method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="kb-btn kb-btn-delete kb-btn-sm" 
                                                onclick="return confirm('Yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6">
                                <div class="kb-empty">
                                    <i class="fas fa-database"></i>
                                    <h4>Belum Ada Data</h4>
                                    <p>Silakan tambahkan knowledge base pertama kamu.</p>
                                    <a href="{{ route('admin.knowledge-base.create') }}" class="kb-btn kb-btn-primary" style="margin-top: 1rem;">
                                        <i class="fas fa-plus"></i> Tambah Sekarang
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection