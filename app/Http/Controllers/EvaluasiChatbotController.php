<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EvaluasiChatbotController extends Controller
{
    protected ChatbotService $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Dataset Skenario Pengujian Akademik Standar untuk Skripsi (100 Skenario Uji)
     */
    protected function getTestScenarios(): array
    {
        return [
            // =========================================================================
            // 1. Skenario Kalimat Formal / Baku (20 Kasus) - Expected: Magang / Success
            // =========================================================================
            [
                'id' => 1,
                'category_type' => 'Formal / Baku',
                'question' => 'Bagaimana alur dan prosedur pendaftaran magang di Diskominfosantik?',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian pencocokan kalimat baku panjang dengan struktur tata bahasa lengkap'
            ],
            [
                'id' => 2,
                'category_type' => 'Formal / Baku',
                'question' => 'Apa saja syarat dan dokumen yang harus disiapkan untuk magang?',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian pencocokan multi-keyword (syarat, dokumen, magang)'
            ],
            [
                'id' => 3,
                'category_type' => 'Formal / Baku',
                'question' => 'Berapa lama durasi periode pelaksanaan kegiatan magang?',
                'expected_category' => 'Durasi & Periode',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan waktu dan masa magang'
            ],
            [
                'id' => 4,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah peserta magang mendapatkan sertifikat setelah selesai program?',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian pencocokan benefit dan sertifikat resmi'
            ],
            [
                'id' => 5,
                'category_type' => 'Formal / Baku',
                'question' => 'Dimana alamat dan lokasi kantor Diskominfosantik Kabupaten Bekasi?',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan informasi alamat dan lokasi kantor'
            ],
            [
                'id' => 6,
                'category_type' => 'Formal / Baku',
                'question' => 'Berapa jam kerja operasional kantor selama kegiatan magang berlangsung?',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian informasi waktu operasional harian kantor'
            ],
            [
                'id' => 7,
                'category_type' => 'Formal / Baku',
                'question' => 'Apa saja divisi dan unit penempatan yang menerima mahasiswa magang?',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan daftar pilihan divisi magang'
            ],
            [
                'id' => 8,
                'category_type' => 'Formal / Baku',
                'question' => 'Berapa sisa kuota penerimaan mahasiswa magang saat ini?',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan ketersediaan kuota pendaftaran'
            ],
            [
                'id' => 9,
                'category_type' => 'Formal / Baku',
                'question' => 'Bagaimana nomor kontak telepon dan email resmi Diskominfosantik?',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan kontak resmi kantor'
            ],
            [
                'id' => 10,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah ada ketentuan pakaian atau seragam kerja saat kegiatan magang?',
                'expected_category' => 'Aturan & Tata Tertib',
                'is_topic' => true,
                'description' => 'Pengujian tata tertib dan etika berbusana'
            ],
            [
                'id' => 11,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah mahasiswa magang diberikan uang saku atau kompensasi bulanan?',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian informasi kompensasi finansial magang'
            ],
            [
                'id' => 12,
                'category_type' => 'Formal / Baku',
                'question' => 'Bagaimana mekanisme pengurusan surat pengantar dari kampus ke kantor?',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan pengurusan surat pengantar kampus'
            ],
            [
                'id' => 13,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah program magang ini terbuka untuk mahasiswa jurusan Teknik Informatika?',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian kecocokan program studi Teknik Informatika'
            ],
            [
                'id' => 14,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah mahasiswa wajib membawa perangkat laptop pribadi selama magang?',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian kewajiban perangkat laptop peserta'
            ],
            [
                'id' => 15,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah sistem magang menerapkan absensi kehadiran harian?',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian aturan presensi dan jam kerja'
            ],
            [
                'id' => 16,
                'category_type' => 'Formal / Baku',
                'question' => 'Bagaimana proses konfirmasi penerimaan surat permohonan magang?',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian alur persetujuan surat penerimaan'
            ],
            [
                'id' => 17,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah sertifikat magang yang diterbitkan ditandatangani oleh pejabat resmi?',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian keabsahan sertifikat magang'
            ],
            [
                'id' => 18,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah ada batasan jumlah peserta magang dari satu perguruan tinggi?',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian kuota rombongan kampus'
            ],
            [
                'id' => 19,
                'category_type' => 'Formal / Baku',
                'question' => 'Apakah peserta magang diperkenankan bekerja secara daring atau WFH?',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian kebijakan kerja daring / WFH'
            ],
            [
                'id' => 20,
                'category_type' => 'Formal / Baku',
                'question' => 'Bagaimana tata cara penyusunan penilaian dan lembar laporan akhir magang?',
                'expected_category' => 'Aturan & Tata Tertib',
                'is_topic' => true,
                'description' => 'Pengujian informasi evaluasi akhir kegiatan'
            ],

            // =========================================================================
            // 2. Skenario Bahasa Gaul / Slang / Kolokial (20 Kasus) - Expected: Magang / Success
            // =========================================================================
            [
                'id' => 21,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Dapet uang saku atau gaji ga min pas pkl disini?',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian sinonim (uang saku -> gaji/honor, pkl -> magang)'
            ],
            [
                'id' => 22,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Cara daftar pkl gimana ya kak?',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian kata informal pkl dan sapaan kak'
            ],
            [
                'id' => 23,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Kantornya dimana posisinya min?',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian sinonim posisi/dimana terhadap lokasi kantor'
            ],
            [
                'id' => 24,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Dapet ijazah sertif ga kalo kelar magang?',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian singkatan sertif dan ijazah'
            ],
            [
                'id' => 25,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Berapa bln masa magang disini ya min?',
                'expected_category' => 'Durasi & Periode',
                'is_topic' => true,
                'description' => 'Pengujian singkatan bln terhadap durasi magang'
            ],
            [
                'id' => 26,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Bisa join divisi IT atau programmer ga kak?',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian kata serapan join dan istilah divisi IT'
            ],
            [
                'id' => 27,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Masuk kantor jam brp dan pulang jam brp min?',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian singkatan jam brp terhadap jam kerja'
            ],
            [
                'id' => 28,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Sisa kuota pkl masih ada ga buat kampus aku?',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian bahasa santai seputar kuota pkl'
            ],
            [
                'id' => 29,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Ada nomor wa atau telp admin yg bs dihubungin?',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian singkatan wa/telp terhadap kontak resmi'
            ],
            [
                'id' => 30,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'dpt mkn siang atau snack gratis ga kak?',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian kata dpt mkn terhadap uang saku / fasilitas'
            ],
            [
                'id' => 31,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'kudu bawa berkas apa aja kak?',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian kata santai kudu bawa berkas'
            ],
            [
                'id' => 32,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'baju bebas atau pake seragam rapi kemeja min?',
                'expected_category' => 'Aturan & Tata Tertib',
                'is_topic' => true,
                'description' => 'Pengujian dresscode pakaian kerja'
            ],
            [
                'id' => 33,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'bisa wfh ga min pas magang?',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian istilah wfh terhadap jam kerja'
            ],
            [
                'id' => 34,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'ada fee atau uang transport ga min?',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian kata fee dan uang transport'
            ],
            [
                'id' => 35,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'harus bawa laptop sendiri ga kak?',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian syarat bawa laptop pribadi'
            ],
            [
                'id' => 36,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'prodi sistem informasi bisa daftar divisi apa aja?',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian istilah prodi sistem informasi'
            ],
            [
                'id' => 37,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'gimana alur registrasi online lewat web min?',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian istilah alur registrasi online'
            ],
            [
                'id' => 38,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'Kudu nyiapin ape aje nih bre biar lolos seleksi?',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian dialek/slang ekstrem (kudu, ape aje, bre)'
            ],
            [
                'id' => 39,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'klo mau join project tech lead nya siapa yak?',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian tech slang jargon tanpa kata kunci divisi resmi'
            ],
            [
                'id' => 40,
                'category_type' => 'Bahasa Gaul / Slang',
                'question' => 'sertif nya ada ttd kepala dinas ga min?',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian istilah sertif resmi kepala dinas'
            ],

            // =========================================================================
            // 3. Skenario Typo / Kesalahan Ketik (20 Kasus) - Expected: Magang / Success
            // =========================================================================
            [
                'id' => 41,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Syrat pndaftaran mgang apa aja?',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian toleransi typo pada kata syrat, pndaftaran, mgang'
            ],
            [
                'id' => 42,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Brapa lm durasi magang nya?',
                'expected_category' => 'Durasi & Periode',
                'is_topic' => true,
                'description' => 'Pengujian typo pada kata brapa dan lm'
            ],
            [
                'id' => 43,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Almat kntor diskominfo dmana?',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian toleransi typo almat, kntor, dmana'
            ],
            [
                'id' => 44,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Apakh dpat sertipikat magang?',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian variasi fonetik sertipikat'
            ],
            [
                'id' => 45,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Cara daftr pkl onlen gmana?',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian kata typo daftr dan onlen'
            ],
            [
                'id' => 46,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Jm krja opresional kntor',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian typo jm krja dan opresional'
            ],
            [
                'id' => 47,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Kouta pnrmaan mgang msih ad?',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian typo kouta dan pnrmaan'
            ],
            [
                'id' => 48,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Emil atau tlp dskmnfo kntor',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian typo emil dan dskmnfo'
            ],
            [
                'id' => 49,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'dapt uang sakku atao gji gaa',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian typo sakku dan gji'
            ],
            [
                'id' => 50,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'pkaian dan sragam krja kemeja',
                'expected_category' => 'Aturan & Tata Tertib',
                'is_topic' => true,
                'description' => 'Pengujian typo pkaian dan sragam'
            ],
            [
                'id' => 51,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'dvisi komputr dan jaringan it',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian typo dvisi dan komputr'
            ],
            [
                'id' => 52,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'brkas srat rkomendasi kmpus',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian typo brkas dan rkomendasi'
            ],
            [
                'id' => 53,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'alr pndaftran stelah dpt srat trima',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian typo alr dan pndaftran'
            ],
            [
                'id' => 54,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'jam plang kntor hri jmat',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian typo plang dan hri'
            ],
            [
                'id' => 55,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'lksi gedung pmkab bekasi',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian typo lksi dan pmkab'
            ],
            [
                'id' => 56,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'srtfikat rsemi diskominfotik',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian typo srtfikat dan rsemi'
            ],
            [
                'id' => 57,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'kuotta untk mhswa smester akhr',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian typo kuotta dan mhswa'
            ],
            [
                'id' => 58,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'kpn wktu bka ttp regis gel 2',
                'expected_category' => 'Durasi & Periode',
                'is_topic' => true,
                'description' => 'Pengujian noise singkatan ekstrem waktu pendaftaran'
            ],
            [
                'id' => 59,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'praktek lapang krja dftar dmn ya tgl brp',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian kalimat typo terpotong-potong'
            ],
            [
                'id' => 60,
                'category_type' => 'Typo / Salah Ketik',
                'question' => 'Kalo kelar nanti dapet apa aja ya?',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian pertanyaan ambigu tanpa kata kunci topik spesifik'
            ],

            // =========================================================================
            // 4. Skenario Kata Kunci Singkat / Parsial (20 Kasus) - Expected: Magang / Success
            // =========================================================================
            [
                'id' => 61,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'syarat magang',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata kunci inti syarat magang'
            ],
            [
                'id' => 62,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'alur pendaftaran',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata alur pendaftaran'
            ],
            [
                'id' => 63,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'lokasi kantor',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata lokasi kantor'
            ],
            [
                'id' => 64,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'durasi magang',
                'expected_category' => 'Durasi & Periode',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata durasi magang'
            ],
            [
                'id' => 65,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'uang saku magang',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian input spesifik uang saku'
            ],
            [
                'id' => 66,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'sertifikat magang',
                'expected_category' => 'Fasilitas & Sertifikat',
                'is_topic' => true,
                'description' => 'Pengujian input spesifik sertifikat magang'
            ],
            [
                'id' => 67,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'jam kerja',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata jam kerja'
            ],
            [
                'id' => 68,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'divisi magang',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata divisi magang'
            ],
            [
                'id' => 69,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'kuota magang',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian input 2 kata kuota magang'
            ],
            [
                'id' => 70,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'kontak diskominfosantik',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian input kontak kantor'
            ],
            [
                'id' => 71,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'pakaian magang',
                'expected_category' => 'Aturan & Tata Tertib',
                'is_topic' => true,
                'description' => 'Pengujian input singkat pakaian magang'
            ],
            [
                'id' => 72,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'dapet makan',
                'expected_category' => 'Uang Saku & Benefit',
                'is_topic' => true,
                'description' => 'Pengujian input singkat dapet makan'
            ],
            [
                'id' => 73,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'bawa laptop',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian input singkat bawa laptop'
            ],
            [
                'id' => 74,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'divisi IT',
                'expected_category' => 'Divisi & Penempatan',
                'is_topic' => true,
                'description' => 'Pengujian input singkat divisi IT'
            ],
            [
                'id' => 75,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'email kantor',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian input singkat email kantor'
            ],
            [
                'id' => 76,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'telepon diskominfosantik',
                'expected_category' => 'Lokasi & Kontak',
                'is_topic' => true,
                'description' => 'Pengujian input singkat telepon kantor'
            ],
            [
                'id' => 77,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'waktu operasional',
                'expected_category' => 'Jam Kerja & Operasional',
                'is_topic' => true,
                'description' => 'Pengujian input singkat waktu operasional'
            ],
            [
                'id' => 78,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'berkas pendaftaran',
                'expected_category' => 'Persyaratan Magang',
                'is_topic' => true,
                'description' => 'Pengujian input singkat berkas pendaftaran'
            ],
            [
                'id' => 79,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'prosedur daftar',
                'expected_category' => 'Alur Pendaftaran',
                'is_topic' => true,
                'description' => 'Pengujian input singkat prosedur daftar'
            ],
            [
                'id' => 80,
                'category_type' => 'Kata Kunci Singkat',
                'question' => 'sisa kuota',
                'expected_category' => 'Kuota Penerimaan',
                'is_topic' => true,
                'description' => 'Pengujian input singkat sisa kuota'
            ],

            // =========================================================================
            // 5. Skenario Di Luar Topik / Negatif (20 Kasus) - Expected: Fallback Response
            // =========================================================================
            [
                'id' => 81,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Kamu punya pacar ga?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian filter off-topic terkait hal personal'
            ],
            [
                'id' => 82,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Bagaimana alur dan syarat membuat KTP atau KK di kantor Disdukcapil?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan layanan sipil KTP/KK non-magang (False Positive: overlap kata alur dan syarat)'
            ],
            [
                'id' => 83,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Siapa presiden pertama Indonesia?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan pengetahuan umum'
            ],
            [
                'id' => 84,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Mau nonton film bioskop apa yang bagus ya?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian deteksi kata kunci off-topic film/nonton'
            ],
            [
                'id' => 85,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Resep cara memasak nasi goreng enak',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan resep masakan'
            ],
            [
                'id' => 86,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Lagu pop Indonesia apa yang lagi viral sekarang?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan topik musik'
            ],
            [
                'id' => 87,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Main game Mobile Legends mabar yuk min',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan topik gaming'
            ],
            [
                'id' => 88,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Ramalan zodiak cinta Gemini hari ini apa ya?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan topik zodiak / ramalan'
            ],
            [
                'id' => 89,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Toko baju dan distro terdekat di Cikarang dimana ya?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan belanja non-magang'
            ],
            [
                'id' => 90,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'asdfghjkl zxcvbnm qwerty12345',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian input gibberish / acak tanpa arti'
            ],
            [
                'id' => 91,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Harga emas antam per gram hari ini berapa ya?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan harga emas investasi'
            ],
            [
                'id' => 92,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Cuaca hari ini di Jakarta hujan atau panas?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan ramalan cuaca'
            ],
            [
                'id' => 93,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Apa saja syarat dan dokumen izin mendirikan bangunan di pemkab?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian perizinan bangunan non-magang (False Positive: overlap syarat & dokumen)'
            ],
            [
                'id' => 94,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Rekomendasi tempat wisata alam terbaik di Bandung',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan pariwisata'
            ],
            [
                'id' => 95,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Cara memperbaiki motor mogok karena busi basah',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan otomotif / servis kendaraan'
            ],
            [
                'id' => 96,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Siapa pemenang juara dunia MotoGP musim lalu?',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan berita olahraga'
            ],
            [
                'id' => 97,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Chord kunci gitar lagu pop Indonesia terbaru',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian pertanyaan chord musik'
            ],
            [
                'id' => 98,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Jual beli mobil bekas murah berkualitas di Bekasi',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian jual beli otomotif'
            ],
            [
                'id' => 99,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => 'Cara membuat akun Instagram dan TikTok baru',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian media sosial umum'
            ],
            [
                'id' => 100,
                'category_type' => 'Out-of-Topic / Negatif',
                'question' => '1234567890 !@#$%^&*()_+=-',
                'expected_category' => 'Fallback / Di Luar Topik',
                'is_topic' => false,
                'description' => 'Pengujian simbol numerik dan karakter acak'
            ],
        ];
    }

    /**
     * Tampilkan Halaman Dashboard Evaluasi Chatbot
     */
    public function index()
    {
        $benchmarkResults = $this->executeBenchmark();
        $totalKb = KnowledgeBase::count();
        $activeKb = KnowledgeBase::where('is_active', true)->count();
        $categoriesKb = KnowledgeBase::distinct('category')->pluck('category');

        return view('evaluasi.index', compact(
            'benchmarkResults',
            'totalKb',
            'activeKb',
            'categoriesKb'
        ));
    }

    /**
     * Jalankan Uji Tolok Ukur (Benchmark) Otomatis
     */
    public function runBenchmarkAjax()
    {
        $results = $this->executeBenchmark();
        return response()->json([
            'status' => 'success',
            'data' => $results
        ]);
    }

    /**
     * Uji Satu Pertanyaan Live (Single Query Simulator)
     */
    public function testSingleQuery(Request $request)
    {
        $inputQuery = $request->input('query', $request->input('question'));

        if (empty($inputQuery)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pertanyaan / query tidak boleh kosong.'
            ], 422);
        }

        $startTime = microtime(true);
        $response = $this->chatbotService->getResponse($inputQuery);
        $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2);

        // Ekstraksi token kata kanonikal dari ChatbotService untuk visualisasi pipeline NLP
        $canonicalTokens = $this->chatbotService->extractCanonicalTokens($inputQuery);
        $clean = preg_replace('/[^\p{L}\p{N}\s]/u', ' ', strtolower($inputQuery));
        $allRawTokens = array_values(array_filter(explode(' ', $clean)));

        // Hitung Top 5 Skor Kemiripan terhadap basis pengetahuan (Knowledge Base)
        $knowledgeBase = KnowledgeBase::where('is_active', true)->get();
        $similarityScores = [];

        foreach ($knowledgeBase as $kb) {
            similar_text(strtolower($inputQuery), strtolower($kb->question), $percent);
            $similarityScores[] = [
                'id' => $kb->id,
                'question' => $kb->question,
                'category' => $kb->category,
                'similarity_percent' => round($percent, 1),
            ];
        }

        usort($similarityScores, fn($a, $b) => $b['similarity_percent'] <=> $a['similarity_percent']);
        $topMatches = array_slice($similarityScores, 0, 5);

        return response()->json([
            'status' => 'success',
            'query' => $inputQuery,
            'bot_status' => $response['status'] ?? 'fallback',
            'bot_category' => $response['category'] ?? 'Fallback / Tidak Dikenali',
            'matched_question' => $response['question_matched'] ?? '-',
            'confidence' => $response['confidence'] ?? 0,
            'latency_ms' => $executionTimeMs,
            'tokens' => $allRawTokens,
            'keywords' => $canonicalTokens,
            'top_matches' => $topMatches,
            'bot_answer' => $response['answer'] ?? $response['message'] ?? 'Maaf, saya belum memahami pertanyaan Anda.'
        ]);
    }

    /**
     * Eksekusi Pengujian 25 Skenario dan Hitung Matriks Evaluasi
     */
    protected function executeBenchmark(): array
    {
        $scenarios = $this->getTestScenarios();
        $details = [];
        $totalTime = 0;

        $tp = 0; // True Positive: Pertanyaan magang terjawab sesuai
        $tn = 0; // True Negative: Pertanyaan di luar topik berhasil dialihkan ke fallback
        $fp = 0; // False Positive: Pertanyaan di luar topik tapi salah dicocokkan
        $fn = 0; // False Negative: Pertanyaan magang valid tapi gagal dicocokkan (masuk fallback)

        foreach ($scenarios as $item) {
            $startTime = microtime(true);
            $botResponse = $this->chatbotService->getResponse($item['question']);
            $latencyMs = round((microtime(true) - $startTime) * 1000, 2);
            $totalTime += $latencyMs;

            $isBotSuccess = ($botResponse['status'] === 'success');
            $classification = '';
            $isCorrect = false;

            if ($item['is_topic']) {
                // Skenario topik magang
                if ($isBotSuccess) {
                    $tp++;
                    $classification = 'TP';
                    $isCorrect = true;
                } else {
                    $fn++;
                    $classification = 'FN';
                    $isCorrect = false;
                }
            } else {
                // Skenario di luar topik
                if (!$isBotSuccess) {
                    $tn++;
                    $classification = 'TN';
                    $isCorrect = true;
                } else {
                    $fp++;
                    $classification = 'FP';
                    $isCorrect = false;
                }
            }

            $details[] = [
                'id' => $item['id'],
                'category_type' => $item['category_type'],
                'question' => $item['question'],
                'expected_category' => $item['expected_category'],
                'bot_status' => $botResponse['status'],
                'bot_category' => $botResponse['category'] ?? 'Fallback Response',
                'matched_question' => $botResponse['question_matched'] ?? '-',
                'confidence' => $botResponse['confidence'] ?? 0,
                'latency_ms' => $latencyMs,
                'classification' => $classification,
                'is_correct' => $isCorrect,
                'description' => $item['description']
            ];
        }

        $totalTests = count($scenarios);
        $totalCorrect = $tp + $tn;

        // Formula Akurasi = (TP + TN) / Total
        $accuracy = $totalTests > 0 ? round(($totalCorrect / $totalTests) * 100, 2) : 0;

        // Formula Presisi = TP / (TP + FP)
        $precision = ($tp + $fp) > 0 ? round(($tp / ($tp + $fp)) * 100, 2) : 0;

        // Formula Recall = TP / (TP + FN)
        $recall = ($tp + $fn) > 0 ? round(($tp / ($tp + $fn)) * 100, 2) : 0;

        // Formula F1-Score = 2 * (Precision * Recall) / (Precision + Recall)
        $f1Score = ($precision + $recall) > 0 ? round((2 * ($precision * $recall) / ($precision + $recall)), 2) : 0;

        // Average Latency
        $avgLatency = $totalTests > 0 ? round($totalTime / $totalTests, 2) : 0;

        return [
            'total_tests' => $totalTests,
            'total_correct' => $totalCorrect,
            'accuracy' => $accuracy,
            'precision' => $precision,
            'recall' => $recall,
            'f1_score' => $f1Score,
            'avg_latency_ms' => $avgLatency,
            'confusion_matrix' => [
                'tp' => $tp,
                'tn' => $tn,
                'fp' => $fp,
                'fn' => $fn,
            ],
            'details' => $details,
            'evaluated_at' => Carbon::now()->format('d F Y, H:i:s')
        ];
    }
}
