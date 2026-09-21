<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Syarat & Ketentuan Magang - Diskominfosantik</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/public/informasi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/chatbot.css') }}">
</head>
<body>
    <div class="bg-particles" id="bgParticles"></div>

    <nav class="navbar">
        <div class="navbar-container">
            <a href="/" class="navbar-brand">
                <i class="fas fa-city"></i>
                <span>Diskominfosantik</span>
            </a>
            <button class="navbar-toggle" id="navbarToggle" aria-label="Toggle Navigation">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="/" class="nav-link"><i class="fas fa-th-large"></i><span>Divisi Magang</span></a></li>
                <li><a href="/informasi" class="nav-link"><i class="fas fa-info-circle"></i><span>Informasi</span></a></li>
                <li><a href="/syarat" class="nav-link active"><i class="fas fa-clipboard-check"></i><span>Persyaratan</span></a></li>
                <li><a href="/alur" class="nav-link"><i class="fas fa-route"></i><span>Alur Pendaftaran</span></a></li>
                <li><a href="/login" class="nav-link"><i class="fas fa-sign-in-alt"></i><span>Login Admin</span></a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Header -->
        <div class="card hero-card">
            <div class="hero-content">
                <h1><i class="fas fa-clipboard-check"></i> Persyaratan Program Magang</h1>
                <p>Panduan lengkap kriteria akademik, berkas administrasi, dan komitmen peserta magang di Diskominfosantik Kabupaten Bekasi</p>
                <div class="hero-buttons">
                    <a href="/alur" class="btn btn-light"><i class="fas fa-route"></i> Lihat Alur Pendaftaran</a>
                    <a href="/" class="btn btn-outline-light"><i class="fas fa-th-large"></i> Cek Kuota Divisi</a>
                </div>
            </div>
        </div>

        <!-- Syarat Umum -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-user-check"></i> Syarat Umum Peserta</h2>
            <ul class="requirement-list">
                <li><i class="fas fa-user-graduate"></i> Mahasiswa aktif jenjang D3 / D4 / S1 dari perguruan tinggi terakreditasi</li>
                <li><i class="fas fa-id-card"></i> Memiliki Kartu Tanda Mahasiswa (KTM) yang masih berlaku</li>
                <li><i class="fas fa-laptop-code"></i> Memiliki dasar keahlian teknis sesuai divisi peminatan yang dipilih</li>
                <li><i class="fas fa-calendar-alt"></i> Bersedia melaksanakan masa magang minimal 1 bulan hingga 6 bulan</li>
                <li><i class="fas fa-business-time"></i> Mematuhi jam kerja kedinasan (Senin – Jum'at, pukul 08.00 – 15.30 WIB)</li>
                <li><i class="fas fa-laptop"></i> Membawa laptop dan perlengkapan kerja mandiri selama periode magang</li>
                <li><i class="fas fa-shield-alt"></i> Berkelakuan baik, menjaga integritas, dan mematuhi etika birokrasi pemerintahan</li>
            </ul>
        </div>

        <!-- Berkas Administrasi -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-folder-open"></i> Dokumen & Berkas yang Wajib Disiapkan</h2>
            <div class="benefit-grid">
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-envelope-open-text"></i></div>
                    <h3 class="benefit-title">Surat Pengantar Kampus</h3>
                    <p class="benefit-desc">Surat permohonan magang resmi yang diterbitkan oleh Dekanat / Program Studi / BAAK perguruan tinggi.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-id-badge"></i></div>
                    <h3 class="benefit-title">Curriculum Vitae (CV)</h3>
                    <p class="benefit-desc">CV terbaru yang memuat riwayat pendidikan, keahlian teknis, dan portofolio proyek.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-file-alt"></i></div>
                    <h3 class="benefit-title">Proposal / Rencana Magang</h3>
                    <p class="benefit-desc">Gambaran fokus bidang, topik riset, atau proyek yang ingin dikerjakan di Diskominfosantik.</p>
                </div>
                <div class="benefit-card">
                    <div class="benefit-icon"><i class="fas fa-file-pdf"></i></div>
                    <h3 class="benefit-title">Transkrip Nilai Terakhir</h3>
                    <p class="benefit-desc">Salinan transkrip nilai akademik sementara yang menunjukkan kompetensi bidang studi.</p>
                </div>
            </div>
        </div>

        <!-- Informasi Bantuan / FAQ Chatbot -->
        <div class="card" style="text-align: center; padding: 2.5rem 1.5rem;">
            <h2 class="section-title" style="justify-content: center;"><i class="fas fa-question-circle"></i> Butuh Informasi Tambahan?</h2>
            <p style="color: var(--text-light, #64748b); max-width: 600px; margin: 0 auto 1.5rem auto;">
                Gunakan Asisten Virtual Diskominfosantik di pojok kanan bawah atau buka chatbot mandiri untuk bertanya seputar program magang.
            </p>
            <a href="/chatbot" class="btn btn-primary" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white; padding: 0.75rem 1.5rem; border-radius: 12px; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; font-weight: 600;">
                <i class="fas fa-robot"></i> Buka Chatbot Magang
            </a>
        </div>
    </div>

    <!-- Floating Chatbot Widget -->
    @include('components.chatbot')

    <script src="{{ asset('js/public/informasi.js') }}"></script>
</body>
</html>
