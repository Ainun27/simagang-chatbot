<?php

namespace Database\Seeders;

use App\Models\KnowledgeBase;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KnowledgeBaseSeeder extends Seeder
{
    /**
     * Knowledge Base resmi SIMAGANG Diskominfosantik Kabupaten Bekasi.
     *
     * Penyelarasan dengan Bab I proposal:
     * 1. Seluruh jawaban chatbot bersumber dari knowledge base ini (retrieval-based),
     *    termasuk sapaan, terima kasih, dan identitas bot (kategori "Percakapan Umum"),
     *    sehingga keputusan respons sepenuhnya ditentukan oleh Sørensen-Dice Similarity
     *    dan threshold, bukan oleh aturan di luar knowledge base.
     * 2. Informasi divisi, kuota, dan sisa kuota ditampilkan melalui dashboard mahasiswa.
     *    Entri kategori "Kuota Penerimaan" dan "FAQ" hanya mengarahkan pengguna ke dashboard.
     * 3. Kategori "Alur Pengajuan" hanya menjelaskan prosedur pengajuan magang (surat pengantar
     *    ke instansi). Pendaftaran magang secara daring berada di luar ruang lingkup penelitian.
     * 4. Kategori durasi dipisah menjadi "Durasi Magang" dan "Jam Kerja" agar evaluasi
     *    berbasis kategori tidak mencampur dua topik yang berbeda.
     */
    public function run(): void
    {
        DB::table('knowledge_base')->truncate();

        $sapaan = 'Halo! 👋 Selamat datang di Layanan Informasi <strong>SIMAGANG Diskominfosantik Kab. Bekasi</strong>.<br><br>Saya siap membantu Anda memberikan informasi resmi seputar:<br>• 📋 <strong>Persyaratan Pengajuan & Berkas</strong><br>• 🔄 <strong>Alur & Prosedur Pengajuan Magang</strong><br>• ⏱️ <strong>Durasi Magang & Jam Kerja Operasional</strong><br>• 💼 <strong>Divisi yang Tersedia & Kuota (lihat dashboard)</strong><br>• 🍱 <strong>Fasilitas, Kantin & Pakaian</strong><br><br>Silakan ketik pertanyaan Anda secara langsung ya! 😊';

        $terimaKasih = 'Sama-sama! 😊 Senang bisa membantu Anda.<br><br>Jika masih ada hal lain yang ingin ditanyakan seputar program magang di Diskominfosantik Kabupaten Bekasi, silakan ketik langsung ya. Semoga sukses selalu! 🚀';

        $identitasBot = 'Saya adalah <strong>Asisten Virtual SIMAGANG</strong> 🤖 milik Dinas Komunikasi, Informatika, Persandian, dan Statistik (Diskominfosantik) Kabupaten Bekasi.<br><br>Tugas saya adalah memberikan informasi seputar program magang secara otomatis berdasarkan basis pengetahuan (Knowledge Base) dan algoritma Sørensen-Dice Similarity.';

        $apresiasi = 'Terima kasih banyak atas apresiasinya! 😊 Saya terus berusaha memberikan informasi yang cepat dan akurat seputar program magang Diskominfosantik. Ada hal lain yang ingin kamu ketahui?';

        $konfirmasi = 'Siap! 👍 Jika nanti butuh informasi lebih lanjut seputar program magang Diskominfosantik, jangan ragu untuk bertanya kembali ya. Semangat dan sukses selalu! 😊✨';

        $pamitan = 'Sampai jumpa! 👋 Semoga harimu menyenangkan dan proses kegiatan magangmu di Diskominfosantik berjalan lancar!';

        $knowledgeBases = [

            // ================================================================
            // 1. INFORMASI INSTANSI / PERUSAHAAN
            // ================================================================
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'alamat kantor diskominfosantik',
                'answer' => 'Kantor Diskominfosantik Kabupaten Bekasi berlokasi di Gedung Diskominfosantik, Komplek Perkantoran Pemerintah Kabupaten Bekasi, Blok B, Desa Sukamahi, Kecamatan Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530.',
                'priority' => 10,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'dimana lokasi kantor diskominfosantik bekasi',
                'answer' => 'Kantor Diskominfosantik Kabupaten Bekasi berlokasi di Gedung Diskominfosantik, Komplek Perkantoran Pemerintah Kabupaten Bekasi, Blok B, Desa Sukamahi, Kecamatan Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530.',
                'priority' => 9,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'kontak telepon wa admin diskominfosantik',
                'answer' => 'Helpdesk Layanan Magang Diskominfosantik dapat dihubungi melalui Telepon: (021) 89970000, WhatsApp Layanan Informasi: 0812-3456-7890, atau Email resmi: diskominfo@bekasikab.go.id pada hari dan jam kerja operasional.',
                'priority' => 10,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'profil dan tugas diskominfosantik bekasi',
                'answer' => 'Diskominfosantik Kabupaten Bekasi bertugas mengelola urusan pemerintahan daerah di bidang komunikasi, informatika, persandian, dan statistik serta transformasi digital Smart City di Kabupaten Bekasi.',
                'priority' => 8,
            ],

            // ================================================================
            // 2. SYARAT
            // ================================================================
            [
                'category' => 'Syarat',
                'question' => 'syarat magang',
                'answer' => "Persyaratan magang di Diskominfosantik:\n1) Mahasiswa atau siswa aktif,\n2) Surat pengantar resmi dari kampus/sekolah,\n3) Membawa perangkat laptop pribadi,\n4) Berkomitmen mengikuti tata tertib instansi.",
                'priority' => 10,
            ],
            [
                'category' => 'Syarat',
                'question' => 'syarat magang diskominfosantik apa saja',
                'answer' => "Persyaratan magang di Diskominfosantik:\n1) Mahasiswa atau siswa aktif,\n2) Surat pengantar resmi dari kampus/sekolah,\n3) Membawa perangkat laptop pribadi,\n4) Berkomitmen mengikuti tata tertib instansi.",
                'priority' => 10,
            ],
            [
                'category' => 'Syarat',
                'question' => 'dokumen persyaratan berkas magang apa',
                'answer' => "Berkas dokumen persyaratan magang:\n1) Surat pengantar resmi dari kampus/sekolah,\n2) Proposal pengajuan magang (bila ada),\n3) Salinan kartu identitas mahasiswa/siswa (KTM/KTS),\n4) Curriculum Vitae (CV) singkat.",
                'priority' => 9,
            ],
            [
                'category' => 'Syarat',
                'question' => 'wajib bawa laptop sendiri atau komputer magang',
                'answer' => 'Ya, peserta magang diwajibkan membawa perangkat laptop pribadi untuk menunjang pengerjaan tugas dan proyek dinas selama pelaksanaan magang.',
                'priority' => 8,
            ],
            [
                'category' => 'Syarat',
                'question' => 'apakah boleh magang tanpa pengalaman kerja',
                'answer' => 'Boleh. Program magang terbuka bagi mahasiswa dan siswa yang belum memiliki pengalaman kerja sebelumnya asalkan memiliki komitmen untuk belajar.',
                'priority' => 7,
            ],

            // ================================================================
            // 3. ALUR PENGAJUAN (prosedur pengajuan magang, bukan pendaftaran daring)
            // ================================================================
            [
                'category' => 'Alur Pengajuan',
                'question' => 'alur pendaftaran magang',
                'answer' => "Alur pengajuan magang:\n1) Cek ketersediaan kuota divisi pada dashboard SIMAGANG,\n2) Ajukan surat pengantar resmi dari kampus/sekolah ke kantor Diskominfosantik,\n3) Proses verifikasi berkas dan persetujuan penempatan,\n4) Pendataan peserta magang pada sistem SIMAGANG.",
                'priority' => 10,
            ],
            [
                'category' => 'Alur Pengajuan',
                'question' => 'alur dan prosedur pendaftaran magang',
                'answer' => "Alur pengajuan magang:\n1) Cek ketersediaan kuota divisi pada dashboard SIMAGANG,\n2) Ajukan surat pengantar resmi dari kampus/sekolah ke kantor Diskominfosantik,\n3) Proses verifikasi berkas dan persetujuan penempatan,\n4) Pendataan peserta magang pada sistem SIMAGANG.",
                'priority' => 10,
            ],
            [
                'category' => 'Alur Pengajuan',
                'question' => 'bagaimana cara daftar mengajukan magang',
                'answer' => "Tata cara pengajuan magang:\n1) Siapkan surat permohonan/pengantar resmi dari institusi pendidikan,\n2) Serahkan berkas surat ke kantor Diskominfosantik Kabupaten Bekasi,\n3) Tunggu konfirmasi persetujuan dari dinas terkait kuota dan penempatan divisi.",
                'priority' => 9,
            ],
            [
                'category' => 'Alur Pengajuan',
                'question' => 'konfirmasi surat persetujuan acc magang',
                'answer' => 'Konfirmasi persetujuan magang akan diinformasikan oleh pihak instansi atau melalui kontak admin resmi setelah surat pengantar diverifikasi.',
                'priority' => 8,
            ],
            [
                'category' => 'Alur Pengajuan',
                'question' => 'alur registrasi pendaftaran online lewat web',
                'answer' => 'SIMAGANG merupakan platform informasi kuota dan layanan magang di Diskominfosantik. Pengajuan permohonan magang diawali dengan menyerahkan surat pengantar resmi dari kampus/sekolah ke dinas.',
                'priority' => 7,
            ],

            // ================================================================
            // 4. DURASI MAGANG
            // ================================================================
            [
                'category' => 'Durasi Magang',
                'question' => 'durasi magang',
                'answer' => 'Durasi kegiatan magang di Diskominfosantik Kabupaten Bekasi umumnya berkisar antara 1 hingga 3 bulan (atau disesuaikan dengan kurikulum kampus/sekolah). Peserta yang melaksanakan magang selama 3 bulan atau lebih akan mendapatkan sertifikat magang resmi.',
                'priority' => 10,
            ],
            [
                'category' => 'Durasi Magang',
                'question' => 'berapa lama durasi magang diskominfosantik bekasi',
                'answer' => 'Durasi kegiatan magang di Diskominfosantik Kabupaten Bekasi umumnya berkisar antara 1 hingga 3 bulan (atau disesuaikan dengan kurikulum kampus/sekolah). Peserta yang melaksanakan magang selama 3 bulan atau lebih akan mendapatkan sertifikat magang resmi.',
                'priority' => 10,
            ],

            // ================================================================
            // 5. JAM KERJA
            // ================================================================
            [
                'category' => 'Jam Kerja',
                'question' => 'berapa jam kerja operasional kantor',
                'answer' => 'Jam kerja operasional di Diskominfosantik Kabupaten Bekasi adalah hari Senin hingga Jumat pukul 07.30 - 16.00 WIB.',
                'priority' => 9,
            ],
            [
                'category' => 'Jam Kerja',
                'question' => 'hari kerja dan libur sabtu minggu masuk ga',
                'answer' => 'Hari kerja magang adalah hari Senin sampai dengan Jumat. Hari Sabtu, Minggu, serta hari libur nasional kantor libur.',
                'priority' => 8,
            ],

            // ================================================================
            // 6. BIAYA
            // ================================================================
            [
                'category' => 'Biaya',
                'question' => 'apakah magang dapat uang saku atau gaji',
                'answer' => 'Program magang di Diskominfosantik Kabupaten Bekasi bersifat non-berbayar (unpaid internship), sehingga instansi tidak memberikan uang saku maupun gaji bulanan kepada peserta.',
                'priority' => 10,
            ],
            [
                'category' => 'Biaya',
                'question' => 'ada uang makan atau uang transport tidak',
                'answer' => 'Instansi tidak menyediakan uang makan harian maupun uang transportasi. Biaya transportasi dan konsumsi harian menjadi tanggung jawab mandiri masing-masing peserta magang.',
                'priority' => 9,
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapat uang makan konsumsi snack harian',
                'answer' => 'Peserta magang tidak mendapatkan tunjangan uang makan maupun konsumsi harian dari instansi.',
                'priority' => 8,
            ],
            [
                'category' => 'Biaya',
                'question' => 'biaya pendaftaran magang gratis bayar tidak',
                'answer' => 'Pendaftaran dan pelaksanaan magang di Diskominfosantik Kabupaten Bekasi sepenuhnya GRATIS (tidak dipungut biaya apapun).',
                'priority' => 9,
            ],

            // ================================================================
            // 7. SERTIFIKAT
            // ================================================================
            [
                'category' => 'Sertifikat',
                'question' => 'sertifikat magang',
                'answer' => 'Ya, peserta yang melaksanakan kegiatan magang selama 3 bulan atau lebih akan mendapatkan sertifikat resmi magang setelah menyelesaikan seluruh periode magang.',
                'priority' => 10,
            ],
            [
                'category' => 'Sertifikat',
                'question' => 'apakah dapat sertifikat resmi selesai magang',
                'answer' => 'Ya, peserta yang melaksanakan kegiatan magang selama 3 bulan atau lebih akan mendapatkan sertifikat resmi magang setelah menyelesaikan seluruh periode magang.',
                'priority' => 10,
            ],
            [
                'category' => 'Sertifikat',
                'question' => 'syarat mendapatkan sertifikat magang 3 bulan',
                'answer' => "Ketentuan penerbitan sertifikat magang:\n1) Melaksanakan magang selama 3 bulan atau lebih,\n2) Menyelesaikan seluruh periode magang dengan baik,\n3) Menyerahkan draf laporan akhir magang.",
                'priority' => 9,
            ],
            [
                'category' => 'Sertifikat',
                'question' => 'kapan sertifikat magang diberikan',
                'answer' => 'Sertifikat magang diberikan kepada peserta yang telah melaksanakan magang selama 3 bulan atau lebih setelah menyelesaikan seluruh periode magang.',
                'priority' => 8,
            ],

            // ================================================================
            // 8. BENEFIT
            // ================================================================
            [
                'category' => 'Benefit',
                'question' => 'benefit magang',
                'answer' => "Manfaat magang di Diskominfosantik:\n1) Pengalaman kerja riil di instansi pemerintah daerah,\n2) Bimbingan langsung dari mentor profesional,\n3) Memperluas relasi dan jaringan kerja,\n4) Memperoleh sertifikat resmi magang (bagi peserta magang 3 bulan atau lebih).",
                'priority' => 10,
            ],
            [
                'category' => 'Benefit',
                'question' => 'keuntungan dan benefit pengalaman magang',
                'answer' => "Manfaat magang di Diskominfosantik:\n1) Pengalaman kerja riil di instansi pemerintah daerah,\n2) Bimbingan langsung dari mentor profesional,\n3) Memperluas relasi dan jaringan kerja,\n4) Memperoleh sertifikat resmi magang (bagi peserta magang 3 bulan atau lebih).",
                'priority' => 10,
            ],
            [
                'category' => 'Benefit',
                'question' => 'apakah peserta magang dapat mentor pembimbing',
                'answer' => 'Ya, setiap peserta magang akan mendapatkan bimbingan dan arahan langsung dari mentor atau staf ahli pada bidang unit kerja masing-masing.',
                'priority' => 8,
            ],

            // ================================================================
            // 9. FASILITAS
            // ================================================================
            [
                'category' => 'Fasilitas',
                'question' => 'fasilitas ruang kerja dan wifi kantor magang',
                'answer' => 'Fasilitas yang disediakan kantor bagi peserta magang meliputi ruang kerja ber-AC, akses internet Wi-Fi kantor, meja kerja bersama, colokan listrik, serta bimbingan mentor.',
                'priority' => 9,
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'ada kantin tidak warung makan kantor',
                'answer' => 'Di dalam gedung kantor tidak tersedia kantin khusus, namun di sekitar komplek perkantoran Pemkab Bekasi terdapat banyak pedagang makanan, warung makan, dan kantin pujasera yang dapat dikunjungi peserta saat jam istirahat.',
                'priority' => 10,
            ],
            [
                'category' => 'Fasilitas',
                'question' => 'makan siang beli dimana warung makan sekitar',
                'answer' => 'Peserta magang dapat membeli makan siang di warung makan atau pedagang di sekitar area perkantoran Pemkab Bekasi saat jam istirahat (12.00 - 13.00 WIB), atau membawa bekal makanan sendiri dari rumah.',
                'priority' => 9,
            ],

            // ================================================================
            // 10. ABSENSI
            // ================================================================
            [
                'category' => 'Absensi',
                'question' => 'ketentuan absensi dan jam kehadiran magang',
                'answer' => 'Kehadiran selama magang mengikuti jadwal dan ketentuan yang ditetapkan oleh instansi. Peserta wajib hadir langsung di kantor pada hari dan jam kerja yang berlaku (Senin - Jumat, 07.30 - 16.00 WIB).',
                'priority' => 10,
            ],
            [
                'category' => 'Absensi',
                'question' => 'izin sakit berhalangan hadir magang bagaimana',
                'answer' => 'Jika berhalangan hadir atau sakit, peserta wajib mengabari mentor divisi serta menyerahkan surat keterangan dokter atau surat izin resmi dari pihak kampus/sekolah.',
                'priority' => 9,
            ],

            // ================================================================
            // 11. KUOTA PENERIMAAN (informasi utama tersedia di dashboard)
            // ================================================================
            [
                'category' => 'Kuota Penerimaan',
                'question' => 'sisa kuota penerimaan magang masih ada',
                'answer' => 'Informasi kuota penerimaan dan sisa kuota magang pada tiap divisi dapat dilihat langsung pada tampilan dashboard SIMAGANG atau dikonfirmasi kepada admin helpdesk instansi.',
                'priority' => 10,
            ],
            [
                'category' => 'Kuota Penerimaan',
                'question' => 'bagaimana jika kuota divisi magang sudah penuh',
                'answer' => 'Jika kuota pada divisi tujuan sudah penuh, calon peserta dapat memilih opsi divisi lain yang masih tersedia pada dashboard SIMAGANG atau mengajukan permohonan untuk periode bulan berikutnya.',
                'priority' => 8,
            ],

            // ================================================================
            // 12. ATURAN & TATA TERTIB
            // ================================================================
            [
                'category' => 'Aturan & Tata Tertib',
                'question' => 'ketentuan pakaian seragam rapi kemeja magang',
                'answer' => "Ketentuan pakaian magang:\n1) Mengenakan kemeja rapi berkerah atau seragam almamater/sekolah,\n2) Celana atau rok bahan kain gelap non-jeans,\n3) Memakai sepatu tertutup formal.",
                'priority' => 10,
            ],
            [
                'category' => 'Aturan & Tata Tertib',
                'question' => 'bisa wfh atau harus offline wfo magang',
                'answer' => 'Kegiatan magang dilaksanakan secara tatap muka langsung (Offline / WFO di kantor Diskominfosantik), kecuali terdapat penugasan dinas lapangan atau arahan khusus dari mentor divisi.',
                'priority' => 9,
            ],
            [
                'category' => 'Aturan & Tata Tertib',
                'question' => 'apakah peserta wajib membuat laporan akhir magang',
                'answer' => 'Peserta wajib menyusun laporan akhir magang dan menyerahkan draf laporan kepada mentor divisi sebagai salah satu syarat penerbitan sertifikat dan lembar penilaian kinerja.',
                'priority' => 8,
            ],

            // ================================================================
            // 13. FAQ (daftar divisi dan jurusan; detail kuota ada di dashboard)
            // ================================================================
            [
                'category' => 'FAQ',
                'question' => 'divisi yang tersedia',
                'answer' => "Pilihan divisi dan ketersediaan kuota dapat dilihat langsung pada tampilan dashboard SIMAGANG. Divisi yang tersedia meliputi:\n1) Bidang TIK / Informatika,\n2) Bidang Informasi & Komunikasi Publik (IKP / Humas),\n3) Bidang Persandian & Keamanan Informasi,\n4) Bidang Statistik Daerah.",
                'priority' => 10,
            ],
            [
                'category' => 'FAQ',
                'question' => 'divisi magang apa saja yang tersedia',
                'answer' => "Pilihan divisi dan ketersediaan kuota dapat dilihat langsung pada tampilan dashboard SIMAGANG. Divisi yang tersedia meliputi:\n1) Bidang TIK / Informatika,\n2) Bidang Informasi & Komunikasi Publik (IKP / Humas),\n3) Bidang Persandian & Keamanan Informasi,\n4) Bidang Statistik Daerah.",
                'priority' => 10,
            ],
            [
                'category' => 'FAQ',
                'question' => 'jurusan apa saja prodi yang bisa daftar magang',
                'answer' => "Program magang terbuka untuk berbagai jurusan seperti:\n1) Teknik Informatika, Sistem Informasi, Ilmu Komputer,\n2) Ilmu Komunikasi, Desain Komunikasi Visual (DKV),\n3) Administrasi Perkantoran, Manajemen Informatika,\n4) Statistika dan jurusan serumpun lainnya.",
                'priority' => 9,
            ],

            // ================================================================
            // 14. PERTANYAAN TAMBAHAN DARI VARIASI FAQ LAMA
            // Hanya menambahkan intent yang belum ter-cover dengan baik.
            // Jawaban tetap mengikuti Knowledge Base versi 2.
            // ================================================================
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'alamat kantor',
                'answer' => 'Kantor Diskominfosantik Kabupaten Bekasi berlokasi di Gedung Diskominfosantik, Komplek Perkantoran Pemerintah Kabupaten Bekasi, Blok B, Desa Sukamahi, Kecamatan Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530.',
                'priority' => 10,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'alamat diskominfosantik',
                'answer' => 'Kantor Diskominfosantik Kabupaten Bekasi berlokasi di Gedung Diskominfosantik, Komplek Perkantoran Pemerintah Kabupaten Bekasi, Blok B, Desa Sukamahi, Kecamatan Cikarang Pusat, Kabupaten Bekasi, Jawa Barat 17530.',
                'priority' => 10,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'email diskominfosantik',
                'answer' => 'Helpdesk Layanan Magang Diskominfosantik dapat dihubungi melalui Telepon: (021) 89970000, WhatsApp Layanan Informasi: 0812-3456-7890, atau Email resmi: diskominfo@bekasikab.go.id pada hari dan jam kerja operasional.',
                'priority' => 10,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'nomor telepon diskominfosantik',
                'answer' => 'Helpdesk Layanan Magang Diskominfosantik dapat dihubungi melalui Telepon: (021) 89970000, WhatsApp Layanan Informasi: 0812-3456-7890, atau Email resmi: diskominfo@bekasikab.go.id pada hari dan jam kerja operasional.',
                'priority' => 10,
            ],
            [
                'category' => 'Informasi Perusahaan',
                'question' => 'kontak yang bisa dihubungi',
                'answer' => 'Helpdesk Layanan Magang Diskominfosantik dapat dihubungi melalui Telepon: (021) 89970000, WhatsApp Layanan Informasi: 0812-3456-7890, atau Email resmi: diskominfo@bekasikab.go.id pada hari dan jam kerja operasional.',
                'priority' => 10,
            ],

            [
                'category' => 'Syarat',
                'question' => 'persyaratan magang',
                'answer' => "Persyaratan magang di Diskominfosantik:\n1) Mahasiswa atau siswa aktif,\n2) Surat pengantar resmi dari kampus/sekolah,\n3) Membawa perangkat laptop pribadi,\n4) Berkomitmen mengikuti tata tertib instansi.",
                'priority' => 10,
            ],
            [
                'category' => 'Syarat',
                'question' => 'dokumen yang dibutuhkan',
                'answer' => "Berkas dokumen persyaratan magang:\n1) Surat pengantar resmi dari kampus/sekolah,\n2) Proposal pengajuan magang (bila ada),\n3) Salinan kartu identitas mahasiswa/siswa (KTM/KTS),\n4) Curriculum Vitae (CV) singkat.",
                'priority' => 9,
            ],
            [
                'category' => 'Syarat',
                'question' => 'butuh cv',
                'answer' => 'CV termasuk dalam berkas dokumen persyaratan magang yang perlu disiapkan sebagai CV singkat.',
                'priority' => 9,
            ],
            [
                'category' => 'Syarat',
                'question' => 'harus mahasiswa aktif',
                'answer' => 'Ya. Peserta magang harus berstatus sebagai mahasiswa atau siswa aktif.',
                'priority' => 9,
            ],
            [
                'category' => 'Syarat',
                'question' => 'harus punya laptop',
                'answer' => 'Ya, peserta magang diwajibkan membawa perangkat laptop pribadi untuk menunjang pengerjaan tugas dan proyek dinas selama pelaksanaan magang.',
                'priority' => 9,
            ],

            [
                'category' => 'Alur Pengajuan',
                'question' => 'alur',
                'answer' => "Alur pengajuan magang:\n1) Cek ketersediaan kuota divisi pada dashboard SIMAGANG,\n2) Ajukan surat pengantar resmi dari kampus/sekolah ke kantor Diskominfosantik,\n3) Proses verifikasi berkas dan persetujuan penempatan,\n4) Pendataan peserta magang pada sistem SIMAGANG.",
                'priority' => 10,
            ],
            [
                'category' => 'Alur Pengajuan',
                'question' => 'cara daftar magang',
                'answer' => "Tata cara pengajuan magang:\n1) Siapkan surat permohonan/pengantar resmi dari institusi pendidikan,\n2) Serahkan berkas surat ke kantor Diskominfosantik Kabupaten Bekasi,\n3) Tunggu konfirmasi persetujuan dari dinas terkait kuota dan penempatan divisi.",
                'priority' => 10,
            ],

            [
                'category' => 'Jam Kerja',
                'question' => 'jam operasional',
                'answer' => 'Jam kerja operasional di Diskominfosantik Kabupaten Bekasi adalah hari Senin hingga Jumat pukul 07.30 - 16.00 WIB.',
                'priority' => 10,
            ],
            [
                'category' => 'Jam Kerja',
                'question' => 'jam kerja',
                'answer' => 'Jam kerja operasional di Diskominfosantik Kabupaten Bekasi adalah hari Senin hingga Jumat pukul 07.30 - 16.00 WIB.',
                'priority' => 10,
            ],
            [
                'category' => 'Jam Kerja',
                'question' => 'buka jam berapa',
                'answer' => 'Jam kerja operasional di Diskominfosantik Kabupaten Bekasi adalah hari Senin hingga Jumat pukul 07.30 - 16.00 WIB.',
                'priority' => 9,
            ],

            [
                'category' => 'Biaya',
                'question' => 'uang saku',
                'answer' => 'Program magang di Diskominfosantik Kabupaten Bekasi bersifat non-berbayar (unpaid internship), sehingga instansi tidak memberikan uang saku maupun gaji bulanan kepada peserta.',
                'priority' => 10,
            ],
            [
                'category' => 'Biaya',
                'question' => 'gaji',
                'answer' => 'Program magang di Diskominfosantik Kabupaten Bekasi bersifat non-berbayar (unpaid internship), sehingga instansi tidak memberikan uang saku maupun gaji bulanan kepada peserta.',
                'priority' => 10,
            ],
            [
                'category' => 'Biaya',
                'question' => 'dapet makan',
                'answer' => 'Peserta magang tidak mendapatkan tunjangan uang makan maupun konsumsi harian dari instansi.',
                'priority' => 9,
            ],
            [
                'category' => 'Biaya',
                'question' => 'uang makan',
                'answer' => 'Peserta magang tidak mendapatkan tunjangan uang makan maupun konsumsi harian dari instansi.',
                'priority' => 9,
            ],
            [
                'category' => 'Biaya',
                'question' => 'gratis magang',
                'answer' => 'Pendaftaran dan pelaksanaan magang di Diskominfosantik Kabupaten Bekasi sepenuhnya GRATIS (tidak dipungut biaya apapun).',
                'priority' => 9,
            ],
            [
                'category' => 'Biaya',
                'question' => 'bayar magang',
                'answer' => 'Pendaftaran dan pelaksanaan magang di Diskominfosantik Kabupaten Bekasi sepenuhnya GRATIS (tidak dipungut biaya apapun).',
                'priority' => 9,
            ],

            [
                'category' => 'Sertifikat',
                'question' => 'dapet sertifikat',
                'answer' => 'Ya, peserta yang melaksanakan kegiatan magang selama 3 bulan atau lebih akan mendapatkan sertifikat resmi magang setelah menyelesaikan seluruh periode magang.',
                'priority' => 10,
            ],

            [
                'category' => 'Fasilitas',
                'question' => 'kantin',
                'answer' => 'Di dalam gedung kantor tidak tersedia kantin khusus, namun di sekitar komplek perkantoran Pemkab Bekasi terdapat banyak pedagang makanan, warung makan, dan kantin pujasera yang dapat dikunjungi peserta saat jam istirahat.',
                'priority' => 10,
            ],

            [
                'category' => 'Absensi',
                'question' => 'absensi',
                'answer' => 'Kehadiran selama magang mengikuti jadwal dan ketentuan yang ditetapkan oleh instansi. Peserta wajib hadir langsung di kantor pada hari dan jam kerja yang berlaku (Senin - Jumat, 07.30 - 16.00 WIB).',
                'priority' => 10,
            ],
            [
                'category' => 'Absensi',
                'question' => 'telat',
                'answer' => 'Peserta wajib hadir sesuai jadwal kerja yang berlaku, yaitu Senin - Jumat pukul 07.30 - 16.00 WIB. Jika berhalangan hadir atau mengalami keterlambatan, peserta sebaiknya mengabari mentor divisi.',
                'priority' => 9,
            ],

            [
                'category' => 'FAQ',
                'question' => 'libur',
                'answer' => 'Hari Sabtu, Minggu, serta hari libur nasional kantor libur.',
                'priority' => 10,
            ],
            [
                'category' => 'FAQ',
                'question' => 'tanggal merah',
                'answer' => 'Hari libur nasional atau tanggal merah merupakan hari libur kantor. Kegiatan magang mengikuti ketentuan hari kerja instansi.',
                'priority' => 10,
            ],
            [
                'category' => 'FAQ',
                'question' => 'apakah bisa pindah divisi',
                'answer' => 'Jika kuota pada divisi tujuan sudah penuh, calon peserta dapat memilih opsi divisi lain yang masih tersedia pada dashboard SIMAGANG atau mengajukan permohonan untuk periode bulan berikutnya.',
                'priority' => 8,
            ],

            // ================================================================
            // 15. PERCAKAPAN UMUM (dijawab melalui mekanisme Dice yang sama)
            // ================================================================
            ['category' => 'Percakapan Umum', 'question' => 'halo', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'selamat pagi', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'selamat siang', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'selamat sore', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'selamat malam', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'assalamualaikum', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'permisi', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'punten', 'answer' => $sapaan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'terima kasih', 'answer' => $terimaKasih, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'kamu siapa', 'answer' => $identitasBot, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'bot ini bisa apa', 'answer' => $identitasBot, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'keren', 'answer' => $apresiasi, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'pintar', 'answer' => $apresiasi, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'mantap', 'answer' => $apresiasi, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'oke', 'answer' => $konfirmasi, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'dadah', 'answer' => $pamitan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'bye', 'answer' => $pamitan, 'priority' => 10],
            ['category' => 'Percakapan Umum', 'question' => 'sampai jumpa', 'answer' => $pamitan, 'priority' => 10],
        ];

        foreach ($knowledgeBases as $item) {
            KnowledgeBase::create([
                'category' => $item['category'],
                'question' => $item['question'],
                'answer' => $item['answer'],
                'is_active' => true,
                'priority' => $item['priority'],
            ]);
        }
    }
}