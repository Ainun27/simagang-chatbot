<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
    <title>Program Magang - Diskominfosantik Kabupaten Bekasi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/public/divisi.css') }}">
    <link rel="stylesheet" href="{{ asset('css/public/chatbot.css') }}">
</head>
<body>
    <div class="bg-animation">
        <div class="bg-circle circle-1"></div>
        <div class="bg-circle circle-2"></div>
        <div class="bg-circle circle-3"></div>
        <div class="bg-circle circle-4"></div>
    </div>

    <div class="container">
        <header class="header">
            <div class="logo-container">
                <i class="fas fa-city logo-icon"></i>
                <i class="fas fa-laptop-code logo-icon"></i>
                <i class="fas fa-chart-line logo-icon"></i>
            </div>
            <h1>Program Magang Diskominfosantik</h1>
            <p>Dinas Komunikasi, Informatika, dan Statistik Kabupaten Bekasi</p>
            <p class="subtitle">Mengembangkan talenta digital untuk Smart City Bekasi</p>
        </header>

        <div class="stats-grid">
            @php
                $total_divisi = $divisi->count();
                $total_kuota = $divisi->sum('kuota');
                $total_mahasiswa_calculated = 0;
                foreach($divisi as $d) {
                    $total_mahasiswa_calculated += $d->mahasiswa->where('is_active', 1)->count();
                }
                $total_mahasiswa = $total_mahasiswa_calculated;
                $sisa_kuota = $total_kuota - $total_mahasiswa;
                
                if($sisa_kuota > 0) {
                    $sisa_color = '#28a745';
                    $sisa_color_dark = '#20c997';
                    $sisa_icon = 'fa-check-circle';
                    $sisa_status = 'Tersedia';
                } else {
                    $sisa_color = '#dc3545';
                    $sisa_color_dark = '#f72585';
                    $sisa_icon = 'fa-times-circle';
                    $sisa_status = 'Penuh';
                }
            @endphp
            
            <div class="stat-card stat-divisi">
                <span class="stat-number">{{ $total_divisi }}</span>
                <div class="stat-label">
                    <i class="fas fa-th-large"></i>
                    <span>Divisi Tersedia</span>
                </div>
                <div class="stat-subtitle">Program magang aktif</div>
            </div>
            
            <div class="stat-card stat-kuota">
                <span class="stat-number">{{ $total_kuota }}</span>
                <div class="stat-label">
                    <i class="fas fa-users"></i>
                    <span>Total Kuota</span>
                </div>
                <div class="stat-subtitle">Kapasitas seluruh divisi</div>
            </div>
            
            <div class="stat-card stat-mahasiswa">
                <span class="stat-number">{{ $total_mahasiswa }}</span>
                <div class="stat-label">
                    <i class="fas fa-user-graduate"></i>
                    <span>Mahasiswa Aktif</span>
                </div>
                <div class="stat-subtitle">Sedang menjalani magang</div>
            </div>
            
            <div class="stat-card stat-sisa" style="--sisa-color: {{ $sisa_color }}; --sisa-color-dark: {{ $sisa_color_dark }};">
                <span class="stat-number">{{ $sisa_kuota }}</span>
                <div class="stat-label">
                    <i class="fas {{ $sisa_icon }}"></i>
                    <span>{{ $sisa_status }}</span>
                </div>
                <div class="stat-subtitle">Sisa kuota tersedia</div>
            </div>
        </div>

        <div class="action-section-top">
            <div class="action-card">
                <div class="action-info">
                    <div class="action-icon">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <div class="action-text">
                        <h3>Portal Pengelola & Administrator</h3>
                        <p>Akses manajemen kuota divisi, data mahasiswa magang, laporan, dan verifikasi</p>
                    </div>
                </div>
                <div class="action-buttons-top">
                    <a href="/login" class="btn btn-secondary">
                        <i class="fas fa-lock"></i> Login Admin
                    </a>
                </div>
            </div>
        </div>

        <div class="section-title">
            <h2><i class="fas fa-th-large"></i> Divisi Magang Tersedia</h2>
        </div>
        
        <div class="divisi-grid">
            @foreach($divisi as $d)
            @php
                $icons = ['fas fa-palette', 'fas fa-chart-bar', 'fas fa-laptop-code', 'fas fa-shield-alt', 'fas fa-mobile-alt', 'fas fa-database'];
                $colors = [['#f72585','#b5179e'], ['#4cc9f0','#3a0ca3'], ['#4361ee','#3a0ca3'], ['#28a745','#1e7e34'], ['#ff9e00','#cc7e00'], ['#6f42c1','#5a32a3']];
                $icon = $icons[$loop->index % count($icons)];
                $color = $colors[$loop->index % count($colors)][0];
                $color_dark = $colors[$loop->index % count($colors)][1];
                $percentage = $d->kuota > 0 ? ($d->mahasiswa_count / $d->kuota) * 100 : 0;
                $sisa = $d->kuota - $d->mahasiswa_count;
                if($sisa == 0){ $status = 'Penuh'; $status_color = '#dc3545'; $status_bg = 'rgba(220, 53, 69, 0.1)';
                } elseif($percentage >= 80){ $status = 'Hampir Penuh'; $status_color = '#ffc107'; $status_bg = 'rgba(255, 193, 7, 0.1)';
                } else { $status = 'Tersedia'; $status_color = '#28a745'; $status_bg = 'rgba(40, 167, 69, 0.1)'; }
            @endphp
                <div class="divisi-card" style="--card-color: {{ $color }}; --card-color-dark: {{ $color_dark }}; --status-bg: {{ $status_bg }}; --status-color: {{ $status_color }};">
                    <div class="divisi-header">
                        <div class="divisi-icon-wrapper">
                            <i class="{{ $icon }} divisi-icon"></i>
                        </div>
                        <div class="divisi-info">
                            <h3 class="divisi-name">{{ $d->nama_divisi }}</h3>
                            <div class="divisi-status">{{ $status }} ({{ $d->mahasiswa_count }}/{{ $d->kuota }})</div>
                        </div>
                    </div>
                    <p class="divisi-desc">{{ $d->deskripsi }}</p>
                    <div class="kuota-progress">
                        <div class="progress-info">
                            <span>Kuota Terisi: {{ $d->mahasiswa_count }} dari {{ $d->kuota }}</span>
                            <span>{{ number_format($percentage, 1) }}%</span>
                        </div>
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: {{ $percentage }}%;"></div>
                        </div>
                    </div>
                    <div class="divisi-footer">
                        <div class="kuota-badge"><i class="fas fa-user-graduate"></i><span>Kuota: {{ $d->kuota }}</span></div>
                        <div class="duration"><i class="fas fa-clock"></i><span>3-6 Bulan</span></div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="info-container">
            <div class="main-info">
                <h3><i class="fas fa-info-circle"></i> Tentang Diskominfosantik</h3>
                <p>Dinas Komunikasi, Informatika, dan Statistik Kota Bekasi merupakan leading sector dalam transformasi digital menuju Smart City. Kami membuka kesempatan magang bagi mahasiswa untuk berkontribusi dalam proyek-proyek digital pemerintahan.</p>
                <h3 style="margin-top: 2rem;"><i class="fas fa-graduation-cap"></i> Keuntungan Magang</h3>
                <ul class="benefits-list">
                    <li>Sertifikat magang resmi dari Pemerintah Kota Bekasi</li>
                    <li>Pengalaman kerja langsung di proyek Smart City</li>
                    <li>Bimbingan dari profesional IT pemerintahan</li>
                    <li>Jaringan profesional di sektor pemerintahan</li>
                    <li>Peluang karir di instansi pemerintah</li>
                    <li>Fasilitas kerja lengkap dan modern</li>
                </ul>
            </div>
            
            <div class="sidebar">
                <h4><i class="fas fa-headset"></i> Kontak & Informasi</h4>
                <div class="contact-grid">
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                        <div class="contact-content">
                            <div class="contact-title">Email</div>
                            <div class="contact-detail">magang@diskominfosantik.bekasikota.go.id</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-phone"></i></div>
                        <div class="contact-content">
                            <div class="contact-title">Telepon</div>
                            <div class="contact-detail">(021) 8895-1234 ext. 456</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                        <div class="contact-content">
                            <div class="contact-title">Alamat</div>
                            <div class="contact-detail">Gedung Diskominfosantik, Komplek Perkantoran Pemerintah Kabupaten Bekasi, Desa Sukamahi, Kecamatan Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530.</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon"><i class="fas fa-clock"></i></div>
                        <div class="contact-content">
                            <div class="contact-title">Jam Kerja</div>
                            <div class="contact-detail">Senin-Jumat, 08:00 - 15:30 WIB</div>
                        </div>
                    </div>
                </div>
                <div class="contact-info">
                    <h4><i class="fas fa-question-circle"></i> Pertanyaan?</h4>
                    <p class="contact-note">Baca Terlebih Dahulu Ketentuan dan Informasi Pada Tombol Informasi Pendaftaran di atas. Hubungi kami untuk informasi lebih lanjut tentang program magang. Kami siap membantu Anda dari Senin hingga Jumat.</p>
                </div>
            </div>
        </div>

        <footer class="footer">
            <p>&copy; 2024 Dinas Komunikasi, Informatika, dan Statistik Kota Bekasi</p>
            <p>Diskominfosantik Bekasi, Komplek Pemkab Bekasi, Cikarang Pusat – 17530</p>
            <div class="footer-links">
                <a href="https://bekasikota.go.id" target="_blank" class="footer-link"><i class="fas fa-globe"></i>Website Resmi</a>
                <a href="https://instagram.com/diskominfosantik.bekasi" target="_blank" class="footer-link"><i class="fab fa-instagram"></i>Instagram</a>
                <a href="https://facebook.com/diskominfosantikbekasi" target="_blank" class="footer-link"><i class="fab fa-facebook"></i>Facebook</a>
                <a href="https://twitter.com/diskominfobekasi" target="_blank" class="footer-link"><i class="fab fa-twitter"></i>Twitter</a>
                <a href="https://youtube.com/@diskominfosantikbekasi" target="_blank" class="footer-link"><i class="fab fa-youtube"></i>YouTube</a>
            </div>
        </footer>
    </div>

    <script src="{{ asset('js/public/divisi.js') }}"></script>
    <!-- Floating Chatbot Widget -->
    @include('components.chatbot')
</body>
</html>