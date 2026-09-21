<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informasi Program Magang - Diskominfosantik</title>
    
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
            <button class="navbar-toggle" id="navbarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="/" class="nav-link"><i class="fas fa-th-large"></i><span>Divisi Magang</span></a></li>
                <li><a href="/informasi" class="nav-link active"><i class="fas fa-info-circle"></i><span>Informasi</span></a></li>
                <li><a href="/syarat" class="nav-link"><i class="fas fa-clipboard-check"></i><span>Persyaratan</span></a></li>
                <li><a href="/alur" class="nav-link"><i class="fas fa-route"></i><span>Alur Pendaftaran</span></a></li>
                <li><a href="/login" class="nav-link"><i class="fas fa-sign-in-alt"></i><span>Login Admin</span></a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <div class="card hero-card">
            <div class="hero-content">
                <h1><i class="fas fa-graduation-cap"></i> Program Magang 2026</h1>
                <p>Kesempatan belajar dan berkontribusi di Dinas Komunikasi, Informatika, dan Statistik Kabupaten Bekasi</p>
                <div class="hero-buttons">
                    <a href="#pendaftaran" class="btn btn-light"><i class="fas fa-play-circle"></i> Mulai Daftar</a>
                    <a href="#benefit" class="btn btn-outline-light"><i class="fas fa-star"></i> Lihat Benefit</a>
                </div>
            </div>
        </div>

        <div class="card" id="benefit">
            <h2 class="section-title"><i class="fas fa-gift"></i> Benefit Magang</h2>
            <div class="benefit-grid">
                <div class="benefit-card"><div class="benefit-icon"><i class="fas fa-certificate"></i></div><h3 class="benefit-title">Sertifikat Resmi</h3><p class="benefit-desc">Dapatkan sertifikat magang resmi yang diakui untuk melengkapi portofolio profesionalmu.</p></div>
                <div class="benefit-card"><div class="benefit-icon"><i class="fas fa-network-wired"></i></div><h3 class="benefit-title">Networking</h3><p class="benefit-desc">Bangun koneksi dengan profesional di bidang teknologi informasi dan pemerintahan.</p></div>
                <div class="benefit-card"><div class="benefit-icon"><i class="fas fa-hands-helping"></i></div><h3 class="benefit-title">Mentor Berpengalaman</h3><p class="benefit-desc">Dibimbing langsung oleh praktisi IT yang berpengalaman di bidangnya.</p></div>
                <div class="benefit-card"><div class="benefit-icon"><i class="fas fa-briefcase"></i></div><h3 class="benefit-title">Pengalaman Nyata</h3><p class="benefit-desc">Kerjakan proyek nyata yang berdampak langsung pada masyarakat Kota Bekasi.</p></div>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title"><i class="fas fa-clipboard-check"></i> Syarat & Ketentuan</h2>
            <ul class="requirement-list">
                <li><i class="fas fa-user-graduate"></i> Mahasiswa aktif D3/D4/S1 dari universitas terakreditasi</li>
                <li><i class="fas fa-envelope"></i> Surat pengantar resmi dari fakultas/prodi</li>
                <li><i class="fas fa-laptop-code"></i> Menguasai skill dasar sesuai divisi yang dipilih</li>
                <li><i class="fas fa-calendar-alt"></i> Masa magang minimal 1 bulan (Senin - Jum'at; 08.00 - 15.30)</li>
                <li><i class="fas fa-handshake"></i> Komitmen penuh selama periode magang</li>
                <li><i class="fas fa-clipboard-list"></i> Mematuhi peraturan dan tata tertib instansi</li>
                <li><i class="fas fa-laptop"></i> Memiliki laptop/perangkat kerja sendiri</li>
                <li><i class="fas fa-file-pdf"></i> CV dan portofolio (jika ada)</li>
            </ul>
        </div>

        <div class="card" id="pendaftaran">
            <h2 class="section-title"><i class="fas fa-route"></i> Alur Pendaftaran</h2>
            <div class="timeline">
                <div class="timeline-item"><div class="timeline-number">1</div><h3>Cek Ketersediaan Kuota</h3><p>Pastikan sisa kuota magang pada website masih tersedia. Jika kuota masih ada, mahasiswa datang langsung ke Diskominfosantik untuk melakukan booking slot magang.</p></div>
                <div class="timeline-item"><div class="timeline-number">2</div><h3>Penyerahan Surat Rekomendasi Kampus</h3><p>Setelah mendapatkan jadwal, pada hari berikutnya mahasiswa membawa surat rekomendasi magang dari kampus ke Diskominfosantik.</p></div>
                <div class="timeline-item"><div class="timeline-number">3</div><h3>Mendapatkan Surat Terima dari Diskominfosantik</h3><p>Diskominfosantik akan memberikan surat terima magang yang selanjutnya digunakan untuk pengurusan administrasi ke Kesbangpol.</p></div>
                <div class="timeline-item"><div class="timeline-number">4</div><h3>Pengajuan ke Kesbangpol</h3><p>Mahasiswa datang ke Kesbangpol dengan membawa surat terima dari Diskominfosantik, fotokopi KTP, fotokopi KTM, serta surat pernyataan yang telah ditandatangani dan bermaterai.</p></div>
                <div class="timeline-item"><div class="timeline-number">5</div><h3>Menunggu Surat Keterangan dari Kesbangpol</h3><p>Mahasiswa menunggu proses penerbitan surat keterangan terima magang dari Kesbangpol.</p></div>
                <div class="timeline-item"><div class="timeline-number">6</div><h3>Penyerahan Surat & CV ke Diskominfosantik</h3><p>Setelah surat dari Kesbangpol diterbitkan, mahasiswa kembali ke Diskominfosantik dengan membawa surat tersebut beserta CV.</p></div>
                <div class="timeline-item"><div class="timeline-number">7</div><h3>Mulai Magang</h3><p>Mahasiswa mulai melaksanakan magang sesuai tanggal yang tercantum pada surat keterangan dari Kesbangpol.</p></div>
            </div>
        </div>

        <div class="card">
            <h2 class="section-title"><i class="fas fa-question-circle"></i> Frequently Asked Questions (FAQ)</h2>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Berapa lama durasi magang?</div><div class="faq-answer">Durasi magang fleksibel antara 1-6 bulan sesuai kebutuhan kampus dan kesepakatan dengan divisi. Minimal 1 bulan (7,5 jam kerja efektif).</div></div>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Apakah ada biaya pendaftaran?</div><div class="faq-answer">Tidak ada biaya pendaftaran sama sekali. Program magang ini gratis untuk seluruh peserta sebagai bagian dari komitmen Diskominfosantik dalam pengembangan SDM.</div></div>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Apakah mendapat sertifikat?</div><div class="faq-answer">Ya, peserta yang menyelesaikan program magang dengan baik akan mendapat sertifikat resmi dari Diskominfosantik Kota Bekasi yang dapat digunakan untuk melengkapi persyaratan akademik dan profesional.</div></div>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Bagaimana sistem absensi?</div><div class="faq-answer">Absensi dilakukan secara offline. Peserta wajib hadir sesuai jadwal yang ditentukan (Senin-Jumat, 08:00-15:30 WIB) dengan toleransi keterlambatan maksimal 15 menit.</div></div>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Apakah bisa pindah divisi?</div><div class="faq-answer">Perpindahan divisi hanya diperbolehkan dalam kondisi khusus (seperti ketidakcocokan skill atau kebutuhan proyek) dan harus melalui persetujuan admin serta kepala divisi terkait dengan alasan yang jelas.</div></div>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Kapan pendaftaran dibuka?</div><div class="faq-answer">Pendaftaran dibuka sepanjang tahun dengan sistem rolling admission, namun kuota terbatas per divisi. Kami sarankan untuk mendaftar segera ketika kuota masih tersedia untuk divisi yang Anda minati.</div></div>
            <div class="faq-item" onclick="toggleFAQ(this)"><div class="faq-question"><i class="fas fa-chevron-right"></i> Apakah mendapatkan Uang Saku?</div><div class="faq-answer">Program magang ini tidak disertai pemberian gaji, uang saku, uang makan, honorarium, maupun bentuk fasilitas atau kompensasi finansial lainnya.</div></div>
        </div>

        <div class="card contact-card">
            <h2 class="section-title"><i class="fas fa-headset"></i> Butuh Bantuan?</h2>
            <div class="contact-grid">
                <div class="contact-item"><div class="contact-icon"><i class="fas fa-envelope"></i></div><div class="contact-content"><h4 class="contact-title">Email</h4><p class="contact-text">magang@diskominfosantik.bekasikota.go.id</p></div></div>
                <div class="contact-item"><div class="contact-icon"><i class="fas fa-phone"></i></div><div class="contact-content"><h4 class="contact-title">Telepon</h4><p class="contact-text">(021) 8895-1234 ext. 456</p><p class="contact-text-small">Senin-Jumat, 08:00-15:30 WIB</p></div></div>
                <div class="contact-item"><div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div><div class="contact-content"><h4 class="contact-title">Alamat</h4><p class="contact-text">Diskominfosantik Bekasi, Komplek Pemkab Bekasi, Cikarang Pusat – 17530</p><p class="contact-text-small">Jawa Barat, 17530</p></div></div>
            </div>
        </div>

        <div class="back-button">
            <a href="/" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Kembali ke Daftar Divisi</a>
        </div>
    </div>

    <!-- Floating Chatbot Widget -->
    @include('components.chatbot')

    <script src="{{ asset('js/public/informasi.js') }}"></script>
</body>
</html>