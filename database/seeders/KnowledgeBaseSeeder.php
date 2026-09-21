<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnowledgeBaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('knowledge_base')->truncate();

        $data = [
            // =========================================================
            // 1. INFORMASI PERUSAHAAN (12 data)
            // =========================================================
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'alamat kantor',
                'answer' => 'Diskominfosantik Bekasi berlokasi di Komplek Pemkab Bekasi, Cikarang Pusat – 17530, Jawa Barat.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'alamat diskominfosantik',
                'answer' => 'Diskominfosantik Bekasi berlokasi di Komplek Pemkab Bekasi, Cikarang Pusat – 17530, Jawa Barat.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'dimana alamatnya',
                'answer' => 'Diskominfosantik Bekasi berlokasi di Komplek Pemkab Bekasi, Cikarang Pusat – 17530, Jawa Barat.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'alamatnya dimana sih',
                'answer' => 'Diskominfosantik Bekasi berlokasi di Komplek Pemkab Bekasi, Cikarang Pusat – 17530, Jawa Barat.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'lokasi diskominfosantik',
                'answer' => 'Diskominfosantik Bekasi berlokasi di Komplek Pemkab Bekasi, Cikarang Pusat – 17530, Jawa Barat.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'email diskominfosantik',
                'answer' => 'Email resmi: magang@diskominfosantik.bekasikota.go.id',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'nomor telepon diskominfosantik',
                'answer' => 'Telepon: (021) 8895-1234 ext. 456, aktif Senin-Jumat pukul 08.00-15.30 WIB.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'kontak diskominfosantik',
                'answer' => 'Email: magang@diskominfosantik.bekasikota.go.id, Telepon: (021) 8895-1234 ext. 456.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'jam operasional',
                'answer' => 'Senin-Jumat, pukul 08.00 - 15.30 WIB.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'jam kerja',
                'answer' => 'Senin-Jumat, pukul 08.00 - 15.30 WIB.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'buka jam berapa',
                'answer' => 'Senin-Jumat, pukul 08.00 - 15.30 WIB.',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'buka jam berapa sih',
                'answer' => 'Senin-Jumat, pukul 08.00 - 15.30 WIB.',
                'priority' => 1
            ],

            // =========================================================
            // PERTANYAAN "ADA NOMER YANG BISA DIHUBUNGI?"
            // =========================================================
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'ada nomer yang bisa dihubungi',
                'answer' => 'Tentu! Anda bisa menghubungi admin kami di nomor (021) 8895-1234 ext. 456. Aktif Senin-Jumat, pukul 08.00-15.30 WIB. Atau email ke magang@diskominfosantik.bekasikota.go.id 😊',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'nomer yang bisa dihubungi',
                'answer' => 'Tentu! Admin bisa dihubungi di (021) 8895-1234 ext. 456 atau email magang@diskominfosantik.bekasikota.go.id',
                'priority' => 1
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'kontak yang bisa dihubungi',
                'answer' => 'Anda bisa hubungi admin di (021) 8895-1234 ext. 456 atau email magang@diskominfosantik.bekasikota.go.id. Aktif Senin-Jumat, 08.00-15.30 WIB.',
                'priority' => 1
            ],

            // =========================================================
            // 2. SYARAT & KETENTUAN (11 data)
            // =========================================================
            [
                'category' => 'Syarat',
                'question' => 'syarat magang',
                'answer' => 'Syarat magang Diskominfosantik: 1) Mahasiswa aktif D3/D4/S1 dari universitas terakreditasi, 2) Surat pengantar resmi dari fakultas/prodi, 3) Menguasai skill dasar sesuai divisi, 4) Masa magang minimal 1 bulan (Senin-Jumat, 08.00-15.30), 5) Komitmen penuh selama magang, 6) Mematuhi peraturan dan tata tertib instansi, 7) Memiliki laptop/perangkat kerja sendiri, 8) CV dan portofolio (jika ada).',
                'priority' => 3
            ],
            [
                'category' => 'Syarat',
                'question' => 'persyaratan magang',
                'answer' => '1) Mahasiswa aktif D3/D4/S1, 2) Surat pengantar resmi dari fakultas, 3) Skill dasar sesuai divisi, 4) Masa magang minimal 1 bulan, 5) Komitmen penuh, 6) Patuhi peraturan, 7) Punya laptop, 8) CV & portofolio.',
                'priority' => 3
            ],
            [
                'category' => 'Syarat',
                'question' => 'apa saja syarat magang',
                'answer' => '1) Mahasiswa aktif D3/D4/S1, 2) Surat pengantar resmi dari fakultas, 3) Skill dasar sesuai divisi, 4) Masa magang minimal 1 bulan, 5) Komitmen penuh, 6) Patuhi peraturan, 7) Punya laptop, 8) CV & portofolio.',
                'priority' => 3
            ],
            [
                'category' => 'Syarat',
                'question' => 'syaratnya apa aja',
                'answer' => '1) Mahasiswa aktif D3/D4/S1, 2) Surat pengantar resmi dari fakultas, 3) Skill dasar sesuai divisi, 4) Masa magang minimal 1 bulan, 5) Komitmen penuh, 6) Patuhi peraturan, 7) Punya laptop, 8) CV & portofolio.',
                'priority' => 3
            ],

            [
                'category' => 'Syarat',
                'question' => 'syaratnya apa sih',
                'answer' => '1) Mahasiswa aktif D3/D4/S1, 2) Surat pengantar resmi dari fakultas, 3) Skill dasar sesuai divisi, 4) Masa magang minimal 1 bulan, 5) Komitmen penuh, 6) Patuhi peraturan, 7) Punya laptop, 8) CV & portofolio.',
                'priority' => 3
            ],
            [
                'category' => 'Syarat',
                'question' => 'dokumen yang dibutuhkan',
                'answer' => 'Dokumen yang dibutuhkan: Surat pengantar resmi dari fakultas/prodi, KTP, KTM, surat pernyataan bermaterai, CV, dan portofolio (jika ada).',
                'priority' => 2
            ],
            [
                'category' => 'Syarat',
                'question' => 'berkas yang dibutuhkan',
                'answer' => 'Berkas: Surat pengantar fakultas, KTP, KTM, surat pernyataan bermaterai, CV, dan portofolio.',
                'priority' => 2
            ],
            [
                'category' => 'Syarat',
                'question' => 'butuh surat pengantar',
                'answer' => 'Ya, surat pengantar resmi dari fakultas/prodi diperlukan sebagai salah satu syarat pendaftaran magang.',
                'priority' => 2
            ],
            [
                'category' => 'Syarat',
                'question' => 'butuh cv',
                'answer' => 'Ya, CV dan portofolio (jika ada) diperlukan saat penyerahan berkas ke Diskominfosantik.',
                'priority' => 2
            ],
            [
                'category' => 'Syarat',
                'question' => 'harus mahasiswa aktif',
                'answer' => 'Ya, peserta harus mahasiswa aktif D3/D4/S1 dari universitas terakreditasi.',
                'priority' => 2
            ],
            [
                'category' => 'Syarat',
                'question' => 'harus punya laptop',
                'answer' => 'Ya, peserta wajib memiliki laptop/perangkat kerja sendiri selama masa magang.',
                'priority' => 2
            ],

            // =========================================================
            // 3. ALUR PENDAFTARAN (8 data)
            // =========================================================
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'alur pendaftaran',
                'answer' => 'Alur pendaftaran magang: 1) Cek kuota & booking slot di website/kantor, 2) Bawa surat rekomendasi kampus ke Diskominfosantik, 3) Dapat surat terima dari Diskominfosantik, 4) Ke Kesbangpol (bawa surat terima, KTP, KTM, surat pernyataan), 5) Tunggu surat keterangan dari Kesbangpol, 6) Kembali ke Diskominfosantik bawa surat & CV, 7) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'mau tanya alurnya',
                'answer' => 'Alur pendaftaran magang: 1) Cek kuota & booking slot di website/kantor, 2) Bawa surat rekomendasi kampus ke Diskominfosantik, 3) Dapat surat terima dari Diskominfosantik, 4) Ke Kesbangpol (bawa surat terima, KTP, KTM, surat pernyataan), 5) Tunggu surat keterangan dari Kesbangpol, 6) Kembali ke Diskominfosantik bawa surat & CV, 7) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'alur',
                'answer' => 'Alur pendaftaran magang: 1) Cek kuota & booking slot di website/kantor, 2) Bawa surat rekomendasi kampus ke Diskominfosantik, 3) Dapat surat terima dari Diskominfosantik, 4) Ke Kesbangpol (bawa surat terima, KTP, KTM, surat pernyataan), 5) Tunggu surat keterangan dari Kesbangpol, 6) Kembali ke Diskominfosantik bawa surat & CV, 7) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'alur magang',
                'answer' => '1) Cek kuota & booking, 2) Bawa surat rekomendasi, 3) Dapat surat terima, 4) Ke Kesbangpol, 5) Tunggu surat, 6) Kembali ke Diskominfosantik, 7) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'cara daftar magang',
                'answer' => '1) Cek kuota di website/kantor, 2) Booking slot magang, 3) Bawa surat rekomendasi kampus, 4) Urus surat ke Kesbangpol, 5) Serahkan CV ke Diskominfosantik, 6) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'proses pendaftaran',
                'answer' => 'Proses pendaftaran: Booking slot di kantor → penyerahan surat rekomendasi → pengurusan ke Kesbangpol → mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'langkah langkah daftar magang',
                'answer' => '1) Cek kuota & booking slot, 2) Bawa surat rekomendasi kampus, 3) Dapat surat terima, 4) Ke Kesbangpol, 5) Tunggu surat, 6) Kembali ke Diskominfosantik, 7) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'ke kesbangpol',
                'answer' => 'Ya, setelah mendapat surat terima dari Diskominfosantik, mahasiswa mengajukan ke Kesbangpol dengan membawa surat terima, fotokopi KTP, KTM, dan surat pernyataan bermaterai.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'surat rekomendasi kampus',
                'answer' => 'Surat rekomendasi magang dari kampus/fakultas/prodi wajib dibawa ke Diskominfosantik setelah booking slot.',
                'priority' => 2
            ],
            [
                'category' => 'Alur Pendaftaran',
                'question' => 'booking slot magang',
                'answer' => 'Mahasiswa datang langsung ke Diskominfosantik untuk melakukan booking slot magang setelah cek kuota.',
                'priority' => 2
            ],

            // =========================================================
            // 4. DURASI & WAKTU (4 data)
            // =========================================================
            [
                'category' => 'Durasi & Waktu',
                'question' => 'durasi magang',
                'answer' => 'Durasi magang fleksibel antara 1-6 bulan sesuai kebutuhan kampus dan kesepakatan dengan divisi. Minimal 1 bulan.',
                'priority' => 2
            ],
            [
                'category' => 'Durasi & Waktu',
                'question' => 'berapa lama magang',
                'answer' => 'Minimal 1 bulan, maksimal 6 bulan. Fleksibel sesuai kebutuhan kampus.',
                'priority' => 2
            ],
            [
                'category' => 'Durasi & Waktu',
                'question' => 'lama magang',
                'answer' => 'Magang berlangsung minimal 1 bulan dan maksimal 6 bulan.',
                'priority' => 2
            ],
            [
                'category' => 'Durasi & Waktu',
                'question' => 'magang berapa bulan',
                'answer' => 'Fleksibel 1-6 bulan sesuai kebutuhan kampus dan divisi.',
                'priority' => 2
            ],

            // =========================================================
            // 5. BIAYA / KOMPENSASI (23 data)
            // =========================================================
            [
                'category' => 'Biaya',
                'question' => 'uang saku',
                'answer' => 'Program magang ini tidak memberikan uang saku, gaji, uang makan, honorarium, atau kompensasi finansial lainnya.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet uang saku',
                'answer' => 'Tidak. Program magang ini tidak memberikan uang saku, gaji, uang makan, honorarium, atau kompensasi finansial lainnya.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet uang saku ga',
                'answer' => 'Tidak ada uang saku, gaji, uang makan, atau kompensasi finansial lainnya.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet uang saku nggak',
                'answer' => 'Tidak. Program magang ini murni tanpa kompensasi finansial.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'ada uang saku ga',
                'answer' => 'Tidak ada uang saku atau kompensasi finansial lainnya.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'gaji',
                'answer' => 'Program magang ini tidak memberikan gaji atau kompensasi finansial.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet gaji',
                'answer' => 'Tidak. Magang di Diskominfosantik tidak memberikan gaji.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet gaji ga',
                'answer' => 'Tidak ada gaji. Program ini murni magang tanpa kompensasi finansial.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet gaji nggak',
                'answer' => 'Tidak ada gaji. Magang ini adalah program pengembangan SDM tanpa bayaran.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet makan',
                'answer' => 'Program magang ini tidak menyediakan uang makan atau fasilitas makan gratis dari kantor. Namun di sekitar komplek Pemkab Bekasi banyak terdapat warung makan/kantin, atau peserta dapat membawa bekal dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet uang makan',
                'answer' => 'Tidak ada uang makan atau kompensasi finansial. Namun peserta magang dapat membeli makanan sendiri di warung sekitar komplek Pemkab Bekasi atau membawa bekal makanan dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet makan ga',
                'answer' => 'Tidak ada uang makan atau fasilitas makan gratis dari kantor. Untuk makan siang, peserta magang dapat membeli makanan di warung/kantin sekitar kawasan Pemkab Bekasi, pesan online, atau membawa bekal dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet makan nggak',
                'answer' => 'Tidak ada fasilitas makan gratis dari kantor. Peserta magang biasanya membeli makan siang di warung/kantin sekitar komplek Pemkab Bekasi, pesan makanan via online, atau membawa bekal sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'disana dapet makan',
                'answer' => 'Tidak ada fasilitas makan gratis dari instansi. Peserta magang dipersilakan membeli makan di warung/kantin sekitar area Pemkab atau membawa bekal sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'uang makan',
                'answer' => 'Program magang ini tidak memberikan uang makan atau uang saku. Peserta dapat membeli makanan secara mandiri di warung/kantin sekitar Pemkab Bekasi atau membawa bekal dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'biaya pendaftaran',
                'answer' => 'Program magang Diskominfosantik GRATIS! Tidak ada biaya pendaftaran sama sekali.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'ada biaya pendaftaran',
                'answer' => 'Tidak ada biaya pendaftaran. Program magang ini GRATIS!',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'gratis magang',
                'answer' => 'Ya, program magang ini GRATIS! Tidak ada biaya pendaftaran.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'bayar magang',
                'answer' => 'Tidak ada biaya pendaftaran. Program magang ini GRATIS!',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'magang gratis ga',
                'answer' => 'Ya, program magang ini GRATIS! Tidak ada biaya pendaftaran sama sekali.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'kenapa ga ada gaji',
                'answer' => 'Program magang ini merupakan program pengembangan SDM dari Diskominfosantik yang fokus pada pemberian pengalaman, sertifikat, dan networking. Tidak ada kompensasi finansial karena ini adalah program magang non-profit.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'kenapa ga dapet uang saku',
                'answer' => 'Program magang ini adalah program pengembangan SDM yang fokus pada pengalaman, sertifikat, dan networking. Tidak ada kompensasi finansial karena ini adalah program magang non-profit dari pemerintah.',
                'priority' => 2
            ],
            [
                'category' => 'Biaya',
                'question' => 'kok ga ada gaji',
                'answer' => 'Program ini adalah program magang non-profit dari Diskominfosantik yang fokus pada pengembangan skill dan pengalaman peserta, bukan pada kompensasi finansial.',
                'priority' => 2
            ],

            // =========================================================
            // 6. SERTIFIKAT (4 data)
            // =========================================================
            [
                'category' => 'Sertifikat',
                'question' => 'sertifikat magang',
                'answer' => 'Ya! Peserta yang menyelesaikan program magang dengan baik akan mendapat sertifikat resmi dari Diskominfosantik Bekasi.',
                'priority' => 2
            ],
            [
                'category' => 'Sertifikat',
                'question' => 'dapet sertifikat',
                'answer' => 'Ya! Peserta yang menyelesaikan magang akan mendapat sertifikat resmi.',
                'priority' => 2
            ],
            [
                'category' => 'Sertifikat',
                'question' => 'dapet sertifikat ga',
                'answer' => 'Ya, sertifikat resmi diberikan setelah menyelesaikan program magang dengan baik.',
                'priority' => 2
            ],
            [
                'category' => 'Sertifikat',
                'question' => 'ada sertifikat',
                'answer' => 'Ya, sertifikat resmi diberikan setelah menyelesaikan program magang dengan baik.',
                'priority' => 2
            ],

            // =========================================================
            // 7. BENEFIT (3 data)
            // =========================================================
            [
                'category' => 'Benefit',
                'question' => 'benefit magang',
                'answer' => 'Dapatkan: 1) Sertifikat resmi, 2) Networking dengan profesional IT dan pemerintahan, 3) Mentor berpengalaman, 4) Pengalaman proyek nyata yang berdampak langsung pada masyarakat!',
                'priority' => 2
            ],
            [
                'category' => 'Benefit',
                'question' => 'keuntungan magang',
                'answer' => 'Keuntungan magang: Sertifikat resmi, pengalaman kerja langsung di proyek Smart City, bimbingan profesional, jaringan di sektor pemerintahan, peluang karir, fasilitas kerja lengkap.',
                'priority' => 2
            ],
            [
                'category' => 'Benefit',
                'question' => 'dapat apa dari magang',
                'answer' => 'Sertifikat resmi, networking dengan profesional, mentor berpengalaman, pengalaman proyek nyata!',
                'priority' => 2
            ],

            // =========================================================
            // 8. FASILITAS (Kantin, Laptop, dll.)
            // =========================================================
            [
                'category' => 'Fasilitas',
                'question' => 'laptop',
                'answer' => 'Peserta wajib memiliki laptop/perangkat kerja sendiri selama masa magang.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'bawa laptop',
                'answer' => 'Ya, peserta wajib membawa laptop/perangkat kerja sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'fasilitas magang',
                'answer' => 'Fasilitas: bimbingan mentor, sertifikat, pengalaman proyek nyata, dan networking. Peserta wajib membawa laptop sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'kantin',
                'answer' => 'Di kantor Diskominfosantik tidak tersedia kantin khusus. Namun, peserta magang dipersilakan untuk keluar membeli makan siang di warung/kantin sekitar kawasan Pemkab Bekasi, memesan makanan via ojek online, atau membawa bekal makanan sendiri dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada kantin',
                'answer' => 'Di Diskominfosantik tidak ada kantin internal. Peserta magang biasanya keluar mencari makan siang di sekitar area perkantoran Pemkab Bekasi, pesan online, atau membawa bekal sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada kantin ga',
                'answer' => 'Tidak ada kantin khusus di dalam kantor. Peserta magang bisa keluar mencari makan siang di warung sekitar komplek Pemkab Bekasi, pesan makanan online, atau membawa bekal dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada kantin nggak',
                'answer' => 'Tidak ada kantin khusus di dalam kantor. Peserta magang bisa keluar mencari makan siang di warung sekitar komplek Pemkab Bekasi, pesan makanan online, atau membawa bekal dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'tempat makan siang',
                'answer' => 'Untuk makan siang, peserta magang dapat keluar di sekitar area perkantoran Pemkab Bekasi (banyak warung makan/kantin sekitar), memesan makanan secara online, atau membawa bekal sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'makan siang beli dimana',
                'answer' => 'Makan siang bisa dibeli di warung/kantin di sekitar komplek perkantoran Pemkab Bekasi, pesan lewat aplikasi online, atau membawa bekal sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'bisa keluar cari makan ga',
                'answer' => 'Ya, pada saat jam istirahat makan siang peserta magang dipersilakan keluar kantor untuk membeli makanan di sekitar komplek Pemkab atau makan bekal sendiri.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'boleh bawa bekal makan',
                'answer' => 'Tentu boleh! Peserta magang sangat diperbolehkan membawa bekal makanan dan minuman sendiri dari rumah.',
                'priority' => 2
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada tukang makan deket sana',
                'answer' => 'Ya, di sekitar kawasan komplek perkantoran Pemkab Bekasi terdapat banyak warung makan, kantin pemkab, dan pedagang makanan. Peserta magang dapat keluar saat jam istirahat untuk membeli makanan, memesan via ojek online, atau membawa bekal dari rumah.',
                'priority' => 3
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'tukang makan deket sana',
                'answer' => 'Ya, di sekitar komplek Pemkab Bekasi banyak terdapat warung makan dan pedagang makanan. Peserta magang bisa keluar mencari makan saat jam istirahat atau pesan via online.',
                'priority' => 3
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada tukang makan',
                'answer' => 'Di sekitar area perkantoran Pemkab Bekasi banyak tersedia warung makan dan penjual makanan. Peserta magang bisa membeli makan siang di sekitar kantor saat jam istirahat.',
                'priority' => 3
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada warung makan dekat kantor',
                'answer' => 'Ya, di sekitar komplek Pemkab Bekasi terdapat banyak warung makan, kantin, dan tempat makan. Peserta magang bisa membeli makan siang saat jam istirahat.',
                'priority' => 3
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'tempat makan dekat kantor',
                'answer' => 'Di sekitar kawasan perkantoran Pemkab Bekasi banyak terdapat warung makan dan kantin. Peserta magang dipersilakan keluar membeli makanan saat jam istirahat.',
                'priority' => 3
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada yang jualan makanan dekat sana',
                'answer' => 'Ya, banyak penjual makanan dan warung makan di sekitar komplek perkantoran Pemkab Bekasi yang bisa dikunjungi saat jam istirahat siang.',
                'priority' => 3
            ],

            // =========================================================
            // 9. ABSENSI (3 data)
            // =========================================================
            [
                'category' => 'Absensi',
                'question' => 'absensi',
                'answer' => 'Absensi dilakukan secara offline. Wajib hadir sesuai jadwal (Senin-Jumat, 08:00-15:30 WIB) dengan toleransi keterlambatan maksimal 15 menit.',
                'priority' => 2
            ],
            [
                'category' => 'Absensi',
                'question' => 'bagaimana absensi',
                'answer' => 'Absensi dilakukan secara offline. Wajib hadir sesuai jadwal dengan toleransi keterlambatan maksimal 15 menit.',
                'priority' => 2
            ],
            [
                'category' => 'Absensi',
                'question' => 'telat',
                'answer' => 'Toleransi keterlambatan maksimal 15 menit. Setelah itu dianggap terlambat.',
                'priority' => 2
            ],

            // =========================================================
            // 10. LIBUR & TANGGAL MERAH (9 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'libur',
                'answer' => 'Kami libur pada hari Sabtu dan Minggu, serta mengikuti hari libur nasional/tanggal merah yang ditetapkan pemerintah.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'apakah ada hari libur',
                'answer' => 'Kami libur pada hari Sabtu dan Minggu, serta mengikuti hari libur nasional/tanggal merah yang ditetapkan pemerintah.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'hari libur',
                'answer' => 'Hari libur kami adalah Sabtu dan Minggu, serta tanggal merah / hari libur nasional.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'tanggal merah',
                'answer' => 'Kami mengikuti hari libur nasional / tanggal merah yang ditetapkan pemerintah. Tidak ada aktivitas magang di hari libur nasional.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'libur nasional',
                'answer' => 'Kami mengikuti hari libur nasional / tanggal merah yang ditetapkan pemerintah. Magang diliburkan pada hari libur nasional.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'hari minggu kerja ga',
                'answer' => 'Tidak. Kami libur pada hari Minggu. Aktivitas magang hanya Senin-Jumat, pukul 08.00-15.30 WIB.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'sabtu minggu kerja ga',
                'answer' => 'Tidak. Kami libur pada hari Sabtu dan Minggu. Aktivitas magang hanya Senin-Jumat, pukul 08.00-15.30 WIB.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'hari sabtu kerja',
                'answer' => 'Tidak. Hari Sabtu dan Minggu adalah hari libur. Magang hanya dilaksanakan Senin-Jumat.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kalau tanggal merah gimana',
                'answer' => 'Kami mengikuti hari libur nasional / tanggal merah yang ditetapkan pemerintah. Tidak ada aktivitas magang di hari libur nasional.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'tanggal merah masuk ga',
                'answer' => 'Tidak. Kami libur pada tanggal merah / hari libur nasional sesuai ketetapan pemerintah.',
                'priority' => 2
            ],

            // =========================================================
            // 11. FAQ DARI HALAMAN INFORMASI (7 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'Berapa lama durasi magang?',
                'answer' => 'Durasi magang fleksibel antara 1-6 bulan sesuai kebutuhan kampus dan kesepakatan dengan divisi. Minimal 1 bulan (7,5 jam kerja efektif).',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'Apakah ada biaya pendaftaran?',
                'answer' => 'Tidak ada biaya pendaftaran sama sekali. Program magang ini gratis untuk seluruh peserta sebagai bagian dari komitmen Diskominfosantik dalam pengembangan SDM.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'Apakah mendapat sertifikat?',
                'answer' => 'Ya, peserta yang menyelesaikan program magang dengan baik akan mendapat sertifikat resmi dari Diskominfosantik Bekasi yang dapat digunakan untuk melengkapi persyaratan akademik dan profesional.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'Bagaimana sistem absensi?',
                'answer' => 'Absensi dilakukan secara offline. Peserta wajib hadir sesuai jadwal yang ditentukan (Senin-Jumat, 08:00-15:30 WIB) dengan toleransi keterlambatan maksimal 15 menit.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'Apakah bisa pindah divisi?',
                'answer' => 'Perpindahan divisi hanya diperbolehkan dalam kondisi khusus (seperti ketidakcocokan skill atau kebutuhan proyek) dan harus melalui persetujuan admin serta kepala divisi terkait dengan alasan yang jelas.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'Kapan pendaftaran dibuka?',
                'answer' => 'Pendaftaran dibuka sepanjang tahun dengan sistem rolling admission, namun kuota terbatas per divisi. Kami sarankan untuk mendaftar segera ketika kuota masih tersedia untuk divisi yang Anda minati.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'Apakah mendapatkan Uang Saku?',
                'answer' => 'Program magang ini tidak disertai pemberian gaji, uang saku, uang makan, honorarium, maupun bentuk fasilitas atau kompensasi finansial lainnya.',
                'priority' => 2
            ],

            // =========================================================
            // 12. VARIASI CASUAL (15 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'kenapa gratis',
                'answer' => 'Program magang ini gratis sebagai bentuk komitmen Diskominfosantik dalam pengembangan SDM dan memberikan kesempatan kepada mahasiswa untuk belajar tanpa beban biaya.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kenapa ga bayar',
                'answer' => 'Program magang ini adalah program non-profit dari pemerintah yang bertujuan mengembangkan talenta digital.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kenapa harus magang disini',
                'answer' => 'Karena Diskominfosantik adalah leading sector transformasi digital Smart City Bekasi. Kamu akan mendapat pengalaman kerja nyata di proyek pemerintah, bimbingan mentor profesional, dan sertifikat resmi!',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kenapa harus bawa laptop',
                'answer' => 'Karena peserta magang akan mengerjakan proyek digital menggunakan perangkat sendiri. Ini juga melatih kemandirian dan tanggung jawab peserta.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kok gratis',
                'answer' => 'Program magang ini gratis sebagai bentuk komitmen Diskominfosantik dalam pengembangan SDM dan memberikan kesempatan kepada mahasiswa untuk belajar tanpa beban biaya.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kok ga ada gaji',
                'answer' => 'Program ini adalah program magang non-profit dari Diskominfosantik yang fokus pada pengembangan skill dan pengalaman peserta, bukan pada kompensasi finansial.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kok harus pindah ke kesbangpol',
                'answer' => 'Karena Kesbangpol adalah instansi yang mengeluarkan surat keterangan resmi untuk magang di lingkup pemerintah daerah. Ini adalah prosedur administrasi yang wajib.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'syaratnya apa sih',
                'answer' => 'Syarat magang: 1) Mahasiswa aktif D3/D4/S1, 2) Surat pengantar resmi dari fakultas, 3) Skill dasar sesuai divisi, 4) Masa magang minimal 1 bulan, 5) Komitmen penuh, 6) Patuhi peraturan, 7) Punya laptop, 8) CV & portofolio.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'alamatnya dimana sih',
                'answer' => 'Diskominfosantik Bekasi berlokasi di Komplek Pemkab Bekasi, Cikarang Pusat – 17530, Jawa Barat.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'caranya gimana sih daftar',
                'answer' => '1) Cek kuota di website/kantor, 2) Booking slot magang, 3) Bawa surat rekomendasi kampus, 4) Urus surat ke Kesbangpol, 5) Serahkan CV ke Diskominfosantik, 6) Mulai magang.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapet sertifikat dong',
                'answer' => 'Ya! Peserta yang menyelesaikan magang akan mendapat sertifikat resmi dari Diskominfosantik Bekasi.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'gratis kan dong',
                'answer' => 'Ya, program magang ini GRATIS! Tidak ada biaya pendaftaran sama sekali.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ga ada biaya kan',
                'answer' => 'Ya, program magang ini GRATIS! Tidak ada biaya pendaftaran sama sekali.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'nggak bayar kan',
                'answer' => 'Ya, program magang ini GRATIS! Tidak ada biaya pendaftaran sama sekali.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'nggak dapet uang saku kan',
                'answer' => 'Ya benar, program magang ini tidak memberikan uang saku atau kompensasi finansial lainnya.',
                'priority' => 2
            ],

            // =========================================================
            // 13. PERTANYAAN DI LUAR KRITERIA (6 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'boleh tanya apa aja',
                'answer' => 'Maaf, saya hanya bisa menjawab pertanyaan seputar program magang Diskominfosantik. Untuk pertanyaan lain, silakan hubungi admin kami di (021) 8895-1234 ext. 456 atau datang langsung ke kantor Diskominfosantik Bekasi. Terima kasih! 😊',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'info lain',
                'answer' => 'Maaf, saya hanya bisa menjawab seputar program magang. Untuk informasi di luar magang, silakan hubungi admin di (021) 8895-1234 ext. 456 atau datang langsung ke Diskominfosantik Bekasi. 😊',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'bisa tanya apa',
                'answer' => 'Saya bisa menjawab pertanyaan seputar: 1) Syarat magang, 2) Alur pendaftaran, 3) Durasi magang, 4) Sertifikat, 5) Benefit, 6) Jam kerja, 7) Alamat kantor, 8) Kontak Diskominfosantik. Untuk pertanyaan lain, silakan hubungi admin ya! 😊',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'di luar magang',
                'answer' => 'Maaf, saya hanya bisa membantu pertanyaan seputar program magang Diskominfosantik. Untuk pertanyaan lain, silakan hubungi admin kami di (021) 8895-1234 ext. 456. Terima kasih! 🙏',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'bukan magang',
                'answer' => 'Maaf, saya hanya bisa menjawab pertanyaan seputar program magang. Untuk informasi lainnya, silakan datang langsung ke Diskominfosantik Bekasi atau hubungi (021) 8895-1234 ext. 456. 😊',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'pertanyaan lain',
                'answer' => 'Maaf, saya belum bisa menjawab pertanyaan di luar topik magang. Silakan hubungi admin kami di (021) 8895-1234 ext. 456 atau email ke magang@diskominfosantik.bekasikota.go.id. Terima kasih! 🙏',
                'priority' => 3
            ],

            // =========================================================
            // 14. PERTANYAAN "NANYA APA" & "NOMER ADMIN" (6 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'emang saya nanya apa',
                'answer' => 'Hmm, sepertinya Anda belum menanyakan apa-apa. 😊 Saya siap membantu pertanyaan seputar program magang Diskominfosantik, seperti: 1) Syarat magang, 2) Alur pendaftaran, 3) Durasi magang, 4) Sertifikat, 5) Benefit, 6) Jam kerja, 7) Alamat kantor, 8) Kontak Diskominfosantik. Silakan tanyakan!',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'saya nanya apa',
                'answer' => 'Sepertinya Anda belum bertanya apa-apa. 😊 Saya siap membantu! Coba tanyakan tentang: syarat magang, alur pendaftaran, durasi, sertifikat, benefit, jam kerja, alamat, atau kontak Diskominfosantik.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'nomer adminnya ada',
                'answer' => 'Tentu! Anda bisa menghubungi admin kami di nomor (021) 8895-1234 ext. 456. Aktif Senin-Jumat, pukul 08.00-15.30 WIB. Atau email ke magang@diskominfosantik.bekasikota.go.id 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ada kontak yang bisa dihubungi',
                'answer' => 'Tentu! Anda bisa menghubungi admin kami di nomor (021) 8895-1234 ext. 456. Aktif Senin-Jumat, pukul 08.00-15.30 WIB. Atau email ke magang@diskominfosantik.bekasikota.go.id 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ada kontak',
                'answer' => 'Tentu! Anda bisa menghubungi admin kami di nomor (021) 8895-1234 ext. 456. Aktif Senin-Jumat, pukul 08.00-15.30 WIB. Atau email ke magang@diskominfosantik.bekasikota.go.id 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'nomer admin',
                'answer' => 'Nomor admin: (021) 8895-1234 ext. 456. Aktif Senin-Jumat, pukul 08.00-15.30 WIB. Atau email: magang@diskominfosantik.bekasikota.go.id',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'nomor telepon admin',
                'answer' => 'Admin bisa dihubungi di (021) 8895-1234 ext. 456. Jam kerja Senin-Jumat, 08.00-15.30 WIB.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'hubungi admin',
                'answer' => 'Anda bisa menghubungi admin kami di (021) 8895-1234 ext. 456 atau email ke magang@diskominfosantik.bekasikota.go.id. Atau datang langsung ke Diskominfosantik Bekasi, Komplek Pemkab Bekasi, Cikarang Pusat – 17530. 😊',
                'priority' => 2
            ],

            // =========================================================
            // 15. PERTANYAAN "AKU MAU TANYA SEPUTAR MAGANG" (5 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'aku mau tanya seputar magang',
                'answer' => 'Tentu! Saya siap membantu pertanyaan seputar program magang Diskominfosantik. 😊 Silakan tanyakan tentang: 1) Syarat magang, 2) Alur pendaftaran, 3) Durasi magang, 4) Sertifikat, 5) Benefit/keuntungan, 6) Jam kerja, 7) Alamat kantor, 8) Kontak admin. Ada yang bisa saya bantu?',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'mau tanya magang',
                'answer' => 'Tentu! Saya siap membantu. 😊 Silakan tanyakan tentang syarat magang, alur pendaftaran, durasi, sertifikat, benefit, jam kerja, alamat, atau kontak admin Diskominfosantik.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'tanya magang',
                'answer' => 'Tentu! Saya siap membantu pertanyaan seputar magang Diskominfosantik. Silakan tanyakan! 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'mau nanya magang',
                'answer' => 'Tentu! Saya siap membantu. 😊 Coba tanyakan tentang: syarat magang, alur pendaftaran, durasi, sertifikat, benefit, jam kerja, alamat, atau kontak admin.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ada yang mau ditanyakan tentang magang',
                'answer' => 'Tentu! Saya siap membantu pertanyaan seputar program magang Diskominfosantik. Silakan tanyakan! 😊',
                'priority' => 2
            ],

            // =========================================================
            // 16. PERTANYAAN DASAR (Kamu siapa, magang apa) (12 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'kamu siapa',
                'answer' => 'Halo! Saya adalah asisten virtual Diskominfosantik Kabupaten Bekasi. 🤖 Saya dibuat untuk membantu menjawab pertanyaan seputar program magang di Diskominfosantik. Silakan tanyakan apa saja tentang magang! 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'siapa kamu',
                'answer' => 'Saya asisten virtual Diskominfosantik Kabupaten Bekasi! 👋 Saya siap membantu informasi seputar program magang. Tanyakan tentang syarat, alur, durasi, sertifikat, atau hal lain tentang magang ya! 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kamu itu siapa',
                'answer' => 'Saya adalah chatbot asisten Diskominfosantik Kabupaten Bekasi. 🤖 Tugas saya membantu calon peserta magang mendapatkan informasi yang akurat dan cepat. Ada yang bisa saya bantu? 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'perkenalan',
                'answer' => 'Halo! Saya asisten virtual Diskominfosantik Kabupaten Bekasi. 🤖 Saya siap membantu pertanyaan seputar program magang. Tanyakan tentang syarat, alur pendaftaran, durasi, sertifikat, benefit, jam kerja, alamat, atau kontak admin! 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'program magang itu apa',
                'answer' => 'Program magang Diskominfosantik adalah program pengembangan SDM di bidang teknologi informasi dan komunikasi yang bertujuan memberikan pengalaman kerja nyata kepada mahasiswa di lingkungan pemerintahan. Program ini terbuka untuk mahasiswa aktif D3/D4/S1 dan berlangsung 1-6 bulan dengan bimbingan mentor profesional! 🎓',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'apa itu program magang',
                'answer' => 'Program magang Diskominfosantik adalah kesempatan bagi mahasiswa untuk belajar dan berkontribusi langsung di Dinas Komunikasi, Informatika, dan Statistik Kabupaten Bekasi. Peserta akan mendapatkan pengalaman kerja nyata, bimbingan mentor, sertifikat, dan networking! 🎓',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'magang itu apa',
                'answer' => 'Magang adalah program pembelajaran dan pengembangan skill melalui pengalaman kerja langsung di instansi atau perusahaan. Di Diskominfosantik, magang memberikan kesempatan mahasiswa untuk terjun ke proyek-proyek digital pemerintahan dan Smart City! 💻',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'apa itu magang',
                'answer' => 'Magang adalah kegiatan pembelajaran berbasis kerja yang bertujuan mengembangkan kompetensi mahasiswa di dunia profesional. Di Diskominfosantik, magang memberikan pengalaman berharga di bidang teknologi informasi dan komunikasi pemerintahan. 🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'diskominfosantik itu apa',
                'answer' => 'Diskominfosantik adalah Dinas Komunikasi, Informatika, dan Statistik Kabupaten Bekasi. Kami adalah leading sector dalam transformasi digital menuju Smart City Bekasi. Di sini, mahasiswa magang bisa belajar langsung tentang pengelolaan sistem informasi pemerintahan, jaringan, data, dan layanan digital publik. 🏙️',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'apa itu diskominfosantik',
                'answer' => 'Diskominfosantik adalah singkatan dari Dinas Komunikasi, Informatika, dan Statistik Kabupaten Bekasi. Kami bertanggung jawab mengelola komunikasi publik, sistem informasi, dan data statistik untuk mendukung pembangunan Kabupaten Bekasi. 📊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'tentang magang',
                'answer' => 'Program magang Diskominfosantik adalah program pengembangan SDM di bidang teknologi informasi dan komunikasi. Peserta akan belajar langsung tentang: 1) Sistem Informasi Pemerintahan, 2) Jaringan & Infrastruktur, 3) Data Analytics, 4) Digital Marketing, 5) Pengembangan Aplikasi. Tanyakan lebih lanjut! 😊',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'info magang',
                'answer' => 'Info magang Diskominfosantik: 📌 Syarat: mahasiswa aktif D3/D4/S1 📌 Durasi: 1-6 bulan 📌 Benefit: sertifikat, networking, mentor, pengalaman proyek 📌 Gratis: tidak ada biaya pendaftaran 📌 Alamat: Komplek Pemkab Bekasi, Cikarang Pusat – 17530. Ada yang mau ditanyakan? 😊',
                'priority' => 2
            ],

            // =========================================================
            // 17. PERTANYAAN TENTANG PENGALAMAN (6 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'apakah boleh jika tidak memiliki pengalaman',
                'answer' => 'Tentu saja boleh! Program magang Diskominfosantik terbuka untuk semua mahasiswa, termasuk yang belum memiliki pengalaman kerja. 😊 Yang terpenting adalah kemauan untuk belajar, komitmen, dan menguasai skill dasar sesuai divisi yang dipilih. Selama magang, kamu akan dibimbing oleh mentor profesional, jadi pengalaman akan didapatkan selama program berlangsung! 🎓',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'apakah bisa magang tanpa pengalaman',
                'answer' => 'Tentu saja boleh! Program magang Diskominfosantik terbuka untuk semua mahasiswa, termasuk yang belum memiliki pengalaman kerja. 😊 Yang terpenting adalah kemauan untuk belajar, komitmen, dan menguasai skill dasar sesuai divisi yang dipilih. Selama magang, kamu akan dibimbing oleh mentor profesional, jadi pengalaman akan didapatkan selama program berlangsung! 🎓',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'tidak punya pengalaman',
                'answer' => 'Tidak masalah! Program magang ini justru dirancang untuk mahasiswa yang ingin mendapatkan pengalaman pertama di dunia kerja. 😊 Yang penting adalah semangat belajar dan willingness to learn. Mentor kami akan membimbing kamu selama magang!',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'butuh pengalaman ga',
                'answer' => 'Tidak wajib! Program magang Diskominfosantik terbuka untuk semua mahasiswa, baik yang sudah punya pengalaman maupun belum. 🎯 Yang terpenting adalah kemauan belajar, komitmen, dan skill dasar yang sesuai dengan divisi pilihan.',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'boleh ga pengalaman',
                'answer' => 'Boleh banget! Program magang ini tidak mensyaratkan pengalaman kerja sebelumnya. 😊 Yang dibutuhkan adalah mahasiswa aktif, surat pengantar, skill dasar, dan komitmen selama magang. Pengalaman akan didapatkan selama program berlangsung!',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'pengalaman kerja',
                'answer' => 'Pengalaman kerja bukan syarat utama untuk mengikuti program magang Diskominfosantik. 🎓 Kami menerima mahasiswa aktif D3/D4/S1 dari berbagai latar belakang. Yang penting adalah kemauan untuk belajar dan berkembang. Selama magang, kamu akan dibimbing oleh mentor profesional dan mendapatkan pengalaman berharga!',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'kalau pengalamannya',
                'answer' => 'Pengalaman kerja bukan syarat utama untuk mengikuti program magang Diskominfosantik. 🎓 Kami menerima mahasiswa aktif D3/D4/S1 dari berbagai latar belakang. Yang penting adalah kemauan untuk belajar dan berkembang. Selama magang, kamu akan dibimbing oleh mentor profesional dan mendapatkan pengalaman berharga!',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'syarat pengalaman',
                'answer' => 'Tidak ada syarat pengalaman kerja untuk mengikuti program magang Diskominfosantik. 😊 Program ini terbuka untuk mahasiswa aktif yang ingin mendapatkan pengalaman pertama di dunia profesional. Yang diperlukan adalah komitmen, kemauan belajar, dan skill dasar sesuai divisi.',
                'priority' => 2
            ],

            // =========================================================
            // 18. PERTANYAAN EKSPRESIF (10 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'ish kenapa',
                'answer' => 'Hmm, sepertinya Anda bingung atau kesal ya? 😊 Maaf jika ada yang kurang jelas. Saya siap membantu pertanyaan seputar program magang Diskominfosantik. Coba tanyakan dengan lebih spesifik, atau hubungi admin kami di (021) 8895-1234 ext. 456 ya!',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'aduh',
                'answer' => 'Maaf ya 😊 Ada yang bisa saya bantu? Saya siap membantu pertanyaan seputar program magang Diskominfosantik. Tanyakan apa saja tentang syarat, alur, durasi, atau sertifikat magang.',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'ya Allah',
                'answer' => 'Maaf ya 🙏 Saya hanya bisa membantu pertanyaan seputar program magang Diskominfosantik. Jika ada yang kurang jelas, silakan hubungi admin di (021) 8895-1234 ext. 456 atau datang langsung ke kantor Diskominfosantik Bekasi.',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'kok gitu',
                'answer' => 'Maaf jika ada yang kurang jelas. 😊 Saya siap membantu! Coba tanyakan tentang syarat magang, alur pendaftaran, durasi, sertifikat, atau benefit. Atau hubungi admin kami di (021) 8895-1234 ext. 456.',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'gimana sih',
                'answer' => 'Coba tanyakan lebih spesifik ya! 😊 Saya siap membantu pertanyaan seputar program magang Diskominfosantik. Misalnya: "syarat magang apa saja?", "bagaimana alur pendaftaran?", atau "berapa lama durasi magang?".',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'lah kok',
                'answer' => 'Hmm, sepertinya Anda bingung. 😊 Saya siap membantu! Silakan tanyakan tentang program magang Diskominfosantik. Atau hubungi admin di (021) 8895-1234 ext. 456 untuk bantuan lebih lanjut.',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'eh',
                'answer' => 'Ya? Ada yang bisa saya bantu? 😊 Saya siap menjawab pertanyaan seputar program magang Diskominfosantik. Silakan tanyakan tentang syarat, alur, durasi, atau sertifikat magang.',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'hmm',
                'answer' => 'Hmm, ada yang ingin ditanyakan? 😊 Saya siap membantu pertanyaan seputar program magang Diskominfosantik. Tanyakan tentang syarat, alur pendaftaran, durasi, atau sertifikat magang ya!',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'oh',
                'answer' => 'Oh, ada yang mau ditanyakan? 😊 Saya siap membantu seputar program magang Diskominfosantik. Silakan tanyakan tentang syarat, alur, durasi, atau lainnya!',
                'priority' => 3
            ],

            // =========================================================
            // 19. UCAPAN TERIMA KASIH & SALAM (20 data)
            // =========================================================
            [
                'category' => 'Sapaan',
                'question' => 'makasih',
                'answer' => 'Sama-sama! 😊 Senang bisa membantu. Kalau ada pertanyaan lain seputar program magang Diskominfosantik, jangan ragu untuk bertanya ya! Semangat! 💪',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'terima kasih',
                'answer' => 'Sama-sama! 😊 Terima kasih juga sudah bertanya. Semoga informasi yang saya berikan bermanfaat. Kalau ada yang perlu ditanyakan lagi, saya siap membantu! 🙏',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'thanks',
                'answer' => 'You\'re welcome! 😊 Glad I could help. Feel free to ask if you have more questions about the internship program! 🙌',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'makasih banyak',
                'answer' => 'Sama-sama! 😊 Terima kasih kembali. Semoga lancar magangnya! Kalau ada pertanyaan, saya selalu siap membantu. 🙏',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'oke makasih',
                'answer' => 'Sama-sama! 😊 Senang bisa membantu. Semoga sukses dengan program magangnya! 🎉',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'dadah',
                'answer' => 'Dadah! 👋 Semoga sukses dan lancar magangnya! Kalau ada pertanyaan, jangan ragu untuk kembali lagi ya. 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'bye',
                'answer' => 'Bye! 👋 Semoga sukses dengan program magangnya! Jangan lupa cek informasi di website ya. 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'sampai jumpa',
                'answer' => 'Sampai jumpa! 👋 Semoga sukses dan lancar magangnya! Kalau ada yang perlu ditanyakan lagi, saya siap membantu kapan saja. 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'halo',
                'answer' => 'Halo! 👋 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan tentang syarat, alur, durasi, atau sertifikat magang ya! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'hai',
                'answer' => 'Hai! 👋 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'hello',
                'answer' => 'Hello! 👋 How can I help you with the internship program at Diskominfosantik? Feel free to ask! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'hey',
                'answer' => 'Hey! 👋 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'pagi',
                'answer' => 'Selamat pagi! 🌅 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'selamat pagi',
                'answer' => 'Selamat pagi! 🌅 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'selamat siang',
                'answer' => 'Selamat siang! 🌞 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'selamat sore',
                'answer' => 'Selamat sore! 🌅 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'selamat malam',
                'answer' => 'Selamat malam! 🌙 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 😊',
                'priority' => 1
            ],
            [
                'category' => 'Sapaan',
                'question' => 'assalamualaikum',
                'answer' => 'Waalaikumsalam! 😊 Ada yang bisa saya bantu seputar program magang Diskominfosantik? Silakan tanyakan apa saja! 🙏',
                'priority' => 1
            ],

            // =========================================================
            // 20. PERTANYAAN PROGRAM MAGANG / DIVISI (11 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'ada program magang apa aja',
                'answer' => 'Untuk melihat daftar program magang yang tersedia, silakan lihat di halaman utama / dashboard umum ya! 😊 Di sana kamu bisa melihat semua divisi magang yang sedang dibuka, kuota, dan deskripsinya. Klik tombol "Kembali ke Daftar Divisi" atau kunjungi halaman utama website. 📋',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'program magang apa saja',
                'answer' => 'Untuk informasi lengkap tentang program magang yang tersedia, silakan cek di halaman dashboard umum / halaman utama ya! 😊 Di sana ada daftar semua divisi magang beserta kuota dan deskripsinya. Jangan lupa cek secara berkala karena kuota terbatas! 🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'magang apa aja',
                'answer' => 'Silakan lihat di halaman utama / dashboard umum untuk melihat daftar program magang yang tersedia! 😊 Semua divisi magang ditampilkan lengkap dengan deskripsi dan kuota masing-masing. 📋',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ada magang apa',
                'answer' => 'Untuk melihat program magang yang sedang dibuka, silakan kunjungi halaman utama website / dashboard umum ya! 😊 Di sana kamu bisa melihat semua divisi magang yang tersedia. Jangan lupa cek kuota sebelum mendaftar! 🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'divisi magang apa saja',
                'answer' => 'Silakan lihat daftar divisi magang di halaman utama / dashboard umum! 😊 Semua divisi magang Diskominfosantik ditampilkan lengkap di sana, termasuk kuota dan status ketersediaannya. 📋',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'divisi apa aja',
                'answer' => 'Untuk melihat divisi magang yang tersedia, silakan cek di halaman utama website / dashboard umum ya! 😊 Semua divisi dengan kuota dan deskripsinya bisa kamu lihat di sana. 🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'daftar divisi magang',
                'answer' => 'Daftar divisi magang bisa dilihat di halaman utama / dashboard umum! 😊 Di sana ada semua informasi tentang divisi yang tersedia, kuota, dan deskripsi lengkapnya. Klik "Kembali ke Daftar Divisi" atau buka halaman utama website. 📋',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'divisi magang',
                'answer' => 'Untuk melihat divisi magang yang tersedia, silakan buka halaman utama website / dashboard umum! 😊 Semua divisi magang Diskominfosantik ditampilkan di sana lengkap dengan kuota dan statusnya. 🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ada divisi apa saja',
                'answer' => 'Silakan cek di halaman utama / dashboard umum untuk melihat daftar divisi magang yang tersedia! 😊 Semua divisi ditampilkan lengkap dengan deskripsi dan kuota masing-masing. Jangan lupa cek kuota terbaru! 📋',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'ada divisi magang apa',
                'answer' => 'Untuk melihat divisi magang yang sedang dibuka, silakan kunjungi halaman utama website / dashboard umum! 😊 Di sana kamu bisa melihat semua divisi magang yang tersedia beserta kuotanya. 🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'lihat divisi magang',
                'answer' => 'Silakan buka halaman utama / dashboard umum untuk melihat daftar divisi magang yang tersedia! 😊 Semua informasi divisi, kuota, dan statusnya bisa kamu lihat di sana. 📋',
                'priority' => 2
            ],

            // =========================================================
            // 21. PERTANYAAN "DAPETNYA APA DONG?" (10 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'dapetnya apa dong',
                'answer' => 'Kamu akan mendapatkan: 1) Sertifikat resmi dari Diskominfosantik Bekasi, 2) Pengalaman kerja nyata di proyek Smart City, 3) Bimbingan dari mentor profesional, 4) Networking dengan pegawai dan profesional IT, 5) Peluang karir di instansi pemerintah. 📜🎓✨',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapet apa dong',
                'answer' => 'Kamu akan dapat sertifikat resmi, pengalaman kerja di proyek Smart City, bimbingan mentor, dan networking! 😊🎓',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapetnya apa',
                'answer' => 'Dapet sertifikat resmi, pengalaman kerja nyata, bimbingan mentor profesional, dan relasi di pemerintahan! 📜💪',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapat apa dari magang',
                'answer' => 'Dapat: 1) Sertifikat resmi, 2) Pengalaman kerja, 3) Bimbingan mentor, 4) Networking, 5) Peluang karir. Pokoknya banyak banget manfaatnya! 😊🎉',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'apa yang didapat dari magang',
                'answer' => 'Yang didapat: Sertifikat resmi, pengalaman proyek Smart City, bimbingan mentor profesional, jaringan di pemerintahan, dan peluang karir! 📜🎯',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'manfaat magang',
                'answer' => 'Manfaat magang: 1) Sertifikat resmi, 2) Pengalaman kerja, 3) Bimbingan mentor, 4) Networking, 5) Peluang karir. Sangat berharga untuk masa depanmu! 😊💪',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'keuntungan magang',
                'answer' => 'Keuntungan magang: Sertifikat resmi, pengalaman kerja langsung di proyek Smart City, bimbingan profesional, jaringan di sektor pemerintahan, peluang karir, dan fasilitas kerja lengkap. 🎓✨',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapet uang ga',
                'answer' => 'Maaf, program magang ini tidak memberikan uang saku atau gaji. Tapi kamu akan mendapatkan sertifikat resmi, pengalaman kerja, bimbingan mentor, dan networking yang sangat berharga untuk masa depan karirmu! 😊📜',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapet uang nggak',
                'answer' => 'Tidak ada uang saku atau gaji. Tapi kamu akan dapat sertifikat resmi, pengalaman kerja, bimbingan mentor, dan networking yang berharga! 😊🎓',
                'priority' => 2
            ],
            [
                'category' => 'FAQ',
                'question' => 'dapet duit ga',
                'answer' => 'Tidak dapet uang ya. Tapi dapet sertifikat resmi, pengalaman kerja, bimbingan mentor, dan networking! 😊📜',
                'priority' => 2
            ],

            // =========================================================
            // 22. PERTANYAAN "OH JADI GA PUNYA NAMA?" (5 data)
            // =========================================================
            [
                'category' => 'FAQ',
                'question' => 'oh jadi ga punya nama',
                'answer' => 'Maaf, saya tidak bisa menjawab pertanyaan tersebut. 😊 Saya hanya bisa membantu seputar program magang Diskominfosantik. Silakan tanyakan tentang syarat, alur, durasi, sertifikat, atau hubungi admin di (021) 8895-1234 ext. 456.',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'ga punya nama',
                'answer' => 'Maaf, saya tidak bisa menjawab pertanyaan tersebut. Saya hanya bisa membantu seputar program magang Diskominfosantik. 😊',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'punya nama ga',
                'answer' => 'Maaf, pertanyaan Anda di luar topik magang. Saya hanya bisa membantu seputar program magang Diskominfosantik. Silakan hubungi admin di (021) 8895-1234 ext. 456. 🙏',
                'priority' => 3
            ],
            [
                'category' => 'FAQ',
                'question' => 'nama kamu siapa',
                'answer' => 'Saya asisten virtual Diskominfosantik! 🤖 Saya dibuat untuk membantu pertanyaan seputar program magang. Silakan tanyakan tentang syarat, alur, durasi, atau sertifikat magang ya! 😊',
                'priority' => 2
            ],
            // =========================================================
            // 23. ATURAN PAKAIAN & SERAGAM MAGANG
            // =========================================================
            [
                'category' => 'Aturan & Tata Tertib',
                'question' => 'ketentuan pakaian atau seragam magang',
                'answer' => 'Peserta magang diwajibkan mengenakan pakaian formal dan rapi (kemeja berkerah, celana/rok bahan warna gelap, dan sepatu tertutup). Kaos oblong dan celana jeans tidak diperkenankan selama berada di kantor.',
                'priority' => 2
            ],
            [
                'category' => 'Aturan & Tata Tertib',
                'question' => 'pakaian dinas harian kemeja rapi seragam magang',
                'answer' => 'Pakaian magang wajib kemeja rapi berkerah, celana/rok bahan formal, dan sepatu tertutup. Pakaian bebas/kaos tidak diperkenankan.',
                'priority' => 2
            ],
            // =========================================================
            // 24. SISA KUOTA PENERIMAAN MAGANG
            // =========================================================
            [
                'category' => 'Kuota Penerimaan',
                'question' => 'sisa kuota penerimaan magang',
                'answer' => 'Informasi sisa kuota penerimaan magang untuk setiap divisi dapat Anda pantau secara langsung pada halaman Daftar Divisi di website SIMAGANG.',
                'priority' => 2
            ],
        ];

        DB::table('knowledge_base')->insert($data);
    }
}