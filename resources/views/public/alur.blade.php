<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alur Pendaftaran Magang - Diskominfosantik</title>
    
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
                <li><a href="/syarat" class="nav-link"><i class="fas fa-clipboard-check"></i><span>Persyaratan</span></a></li>
                <li><a href="/alur" class="nav-link active"><i class="fas fa-route"></i><span>Alur Pendaftaran</span></a></li>
                <li><a href="/login" class="nav-link"><i class="fas fa-sign-in-alt"></i><span>Login Admin</span></a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <!-- Hero Header -->
        <div class="card hero-card">
            <div class="hero-content">
                <h1><i class="fas fa-route"></i> Alur Pendaftaran & Seleksi Magang</h1>
                <p>Tahapan sistematis proses pendaftaran, verifikasi kuota, masa penugasan hingga penerbitan sertifikat magang resmi</p>
                <div class="hero-buttons">
                    <a href="/syarat" class="btn btn-light"><i class="fas fa-clipboard-check"></i> Baca Syarat Lengkap</a>
                    <a href="/" class="btn btn-outline-light"><i class="fas fa-th-large"></i> Cek Kuota Divisi</a>
                </div>
            </div>
        </div>

        <!-- Alur Tahapan -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-list-ol"></i> 5 Langkah Mudah Menjadi Peserta Magang</h2>
            
            <div class="step-container">
                <div class="step-card">
                    <div class="step-badge">1</div>
                    <div class="step-info">
                        <h3>Cek Ketersediaan Kuota Divisi</h3>
                        <p>Kunjungi halaman utama untuk melihat divisi yang sedang membuka penerimaan dan kapasitas sisa kuota yang tersedia.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-badge">2</div>
                    <div class="step-info">
                        <h3>Pengajuan Surat Pengantar & Berkas</h3>
                        <p>Serahkan Surat Pengantar Magang dari Perguruan Tinggi, CV, dan proposal magang ke Kantor Pelayanan Diskominfosantik Kabupaten Bekasi atau via email resmi.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-badge">3</div>
                    <div class="step-info">
                        <h3>Verifikasi Administrasi & Penempatan</h3>
                        <p>Admin dan penanggung jawab divisi akan memverifikasi berkas dan memetakan jadwal magang serta mentor pendamping.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-badge">4</div>
                    <div class="step-info">
                        <h3>Pelaksanaan Magang & Proyek Nyata</h3>
                        <p>Peserta mengikuti penugasan proyek digital, bimbingan berkala, dan berkontribusi langsung pada inisiatif teknologi daerah.</p>
                    </div>
                </div>

                <div class="step-card">
                    <div class="step-badge step-success">5</div>
                    <div class="step-info">
                        <h3>Evaluasi Akhir & Penerbitan Sertifikat</h3>
                        <p>Di akhir periode magang, peserta menyelesaikan laporan magang dan menerima Sertifikat Resmi yang ditandatangani oleh pimpinan instansi.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lokasi Kantor -->
        <div class="card">
            <h2 class="section-title"><i class="fas fa-map-marker-alt"></i> Lokasi Kantor Pelayanan</h2>
            <div style="padding: 0.5rem 0;">
                <p><strong>Dinas Komunikasi, Informatika, Persandian dan Statistik Kabupaten Bekasi</strong></p>
                <p style="color: #64748b; margin-bottom: 1rem;"><i class="fas fa-building"></i> Kompleks Perkantoran Pemerintah Kabupaten Bekasi, Desa Sukamahi, Kec. Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530</p>
                <p style="color: #64748b; margin: 0;"><i class="fas fa-clock"></i> <strong>Jam Operasional:</strong> Senin – Jum'at: 08.00 – 15.30 WIB (Sabtu, Minggu & Hari Libur Nasional Tutup)</p>
            </div>
        </div>
    </div>

    <!-- Floating Chatbot Widget -->
    @include('components.chatbot')

    <script src="{{ asset('js/public/informasi.js') }}"></script>
</body>
</html>
