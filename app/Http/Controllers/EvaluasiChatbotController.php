<?php

namespace App\Http\Controllers;

use App\Models\KnowledgeBase;
use App\Services\ChatbotService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EvaluasiChatbotController extends Controller
{
    protected ChatbotService $chatbotService;

    /**
     * Variasi threshold yang diuji (threshold sweep).
     * Nilai yang dipakai ditentukan dari hasil pengujian ini, sesuai rumusan penelitian.
     */
    protected array $thresholdCandidates = [0.30, 0.35, 0.40, 0.45, 0.50, 0.55, 0.60, 0.65, 0.70, 0.75, 0.80];

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    /**
     * Dataset skenario pengujian (120 skenario) yang mewakili variasi pertanyaan pada Bab I:
     * formal, kata kunci singkat, istilah sehari-hari, singkatan, kesalahan pengetikan,
     * ditambah skenario negatif (di luar topik) untuk menghitung TN dan FP.
     *
     * Format baris: [id, variasi, pertanyaan, kategori KB yang diharapkan, is_topic, deskripsi].
     * Kategori yang diharapkan memakai nama kategori pada knowledge base secara langsung.
     */
    protected function getTestScenarios(): array
    {
        $rows = [

            // ===== 1. Formal / Baku (20) =====
            [1, 'Formal / Baku', 'Bagaimana alur dan prosedur pendaftaran magang di Diskominfosantik?', 'Alur Pengajuan', true, 'Pengujian pencocokan kalimat baku panjang dengan struktur tata bahasa lengkap'],
            [2, 'Formal / Baku', 'Apa saja syarat dan dokumen yang harus disiapkan untuk magang?', 'Syarat', true, 'Pengujian pencocokan multi-keyword (syarat, dokumen, magang)'],
            [3, 'Formal / Baku', 'Berapa lama durasi periode pelaksanaan kegiatan magang?', 'Durasi Magang', true, 'Pengujian pertanyaan waktu dan masa magang'],
            [4, 'Formal / Baku', 'Apakah peserta magang mendapatkan sertifikat setelah selesai program?', 'Sertifikat', true, 'Pengujian pencocokan sertifikat resmi'],
            [5, 'Formal / Baku', 'Dimana alamat dan lokasi kantor Diskominfosantik Kabupaten Bekasi?', 'Informasi Perusahaan', true, 'Pengujian pertanyaan informasi alamat dan lokasi kantor'],
            [6, 'Formal / Baku', 'Berapa jam kerja operasional kantor selama kegiatan magang berlangsung?', 'Jam Kerja', true, 'Pengujian informasi waktu operasional harian kantor'],
            [7, 'Formal / Baku', 'Apa saja divisi dan unit penempatan yang menerima mahasiswa magang?', 'FAQ', true, 'Pengujian pertanyaan daftar pilihan divisi magang'],
            [8, 'Formal / Baku', 'Berapa sisa kuota penerimaan mahasiswa magang saat ini?', 'Kuota Penerimaan', true, 'Pengujian pertanyaan ketersediaan kuota'],
            [9, 'Formal / Baku', 'Bagaimana nomor kontak telepon dan email resmi Diskominfosantik?', 'Informasi Perusahaan', true, 'Pengujian pertanyaan kontak resmi kantor'],
            [10, 'Formal / Baku', 'Apakah ada ketentuan pakaian atau seragam kerja saat kegiatan magang?', 'Aturan & Tata Tertib', true, 'Pengujian tata tertib dan etika berbusana'],
            [11, 'Formal / Baku', 'Apakah mahasiswa magang diberikan uang saku atau kompensasi bulanan?', 'Biaya', true, 'Pengujian informasi kompensasi finansial magang'],
            [12, 'Formal / Baku', 'Bagaimana mekanisme pengurusan surat pengantar dari kampus ke kantor?', 'Alur Pengajuan', true, 'Pengujian pertanyaan pengurusan surat pengantar kampus'],
            [13, 'Formal / Baku', 'Apakah program magang ini terbuka untuk mahasiswa jurusan Teknik Informatika?', 'FAQ', true, 'Pengujian kecocokan program studi Teknik Informatika'],
            [14, 'Formal / Baku', 'Apakah mahasiswa wajib membawa perangkat laptop pribadi selama magang?', 'Syarat', true, 'Pengujian kewajiban perangkat laptop peserta'],
            [15, 'Formal / Baku', 'Apakah sistem magang menerapkan absensi kehadiran harian?', 'Absensi', true, 'Pengujian aturan presensi kehadiran'],
            [16, 'Formal / Baku', 'Bagaimana proses konfirmasi penerimaan surat permohonan magang?', 'Alur Pengajuan', true, 'Pengujian alur persetujuan surat penerimaan'],
            [17, 'Formal / Baku', 'Apakah sertifikat magang yang diterbitkan ditandatangani oleh pejabat resmi?', 'Sertifikat', true, 'Pengujian keabsahan sertifikat magang (detail tanda tangan belum ada di KB)'],
            [18, 'Formal / Baku', 'Apakah ada batasan jumlah peserta magang dari satu perguruan tinggi?', 'Kuota Penerimaan', true, 'Pengujian kuota rombongan kampus (detail batas per kampus belum ada di KB)'],
            [19, 'Formal / Baku', 'Apakah peserta magang diperkenankan bekerja secara daring atau WFH?', 'Aturan & Tata Tertib', true, 'Pengujian kebijakan kerja daring / WFH'],
            [20, 'Formal / Baku', 'Bagaimana tata cara penyusunan penilaian dan lembar laporan akhir magang?', 'Aturan & Tata Tertib', true, 'Pengujian informasi evaluasi akhir kegiatan'],

            // ===== 2. Istilah Sehari-hari (20) =====
            [21, 'Bahasa Gaul / Slang', 'Dapet uang saku atau gaji ga min pas pkl disini?', 'Biaya', true, 'Pengujian bahasa sehari-hari (dapet, ga, min) dan istilah pkl'],
            [22, 'Bahasa Gaul / Slang', 'Cara daftar pkl gimana ya kak?', 'Alur Pengajuan', true, 'Pengujian kata informal pkl dan sapaan kak'],
            [23, 'Bahasa Gaul / Slang', 'Kantornya dimana posisinya min?', 'Informasi Perusahaan', true, 'Pengujian sinonim posisi/dimana terhadap lokasi kantor'],
            [24, 'Bahasa Gaul / Slang', 'Dapet ijazah sertif ga kalo kelar magang?', 'Sertifikat', true, 'Pengujian istilah sertif dan ijazah (ijazah tidak ada di KB)'],
            [25, 'Bahasa Gaul / Slang', 'Berapa bln masa magang disini ya min?', 'Durasi Magang', true, 'Pengujian bahasa santai terhadap durasi magang'],
            [26, 'Bahasa Gaul / Slang', 'Bisa join divisi IT atau programmer ga kak?', 'FAQ', true, 'Pengujian kata serapan join dan istilah divisi IT'],
            [27, 'Bahasa Gaul / Slang', 'Masuk kantor jam brp dan pulang jam brp min?', 'Jam Kerja', true, 'Pengujian bahasa santai terhadap jam kerja'],
            [28, 'Bahasa Gaul / Slang', 'Sisa kuota pkl masih ada ga buat kampus aku?', 'Kuota Penerimaan', true, 'Pengujian bahasa santai seputar kuota pkl'],
            [29, 'Bahasa Gaul / Slang', 'Ada nomor wa atau telp admin yg bs dihubungin?', 'Informasi Perusahaan', true, 'Pengujian istilah santai terhadap kontak resmi'],
            [30, 'Bahasa Gaul / Slang', 'dpt mkn siang atau snack gratis ga kak?', 'Biaya', true, 'Pengujian bahasa santai terhadap uang makan'],
            [31, 'Bahasa Gaul / Slang', 'kudu bawa berkas apa aja kak?', 'Syarat', true, 'Pengujian kata santai kudu bawa berkas'],
            [32, 'Bahasa Gaul / Slang', 'baju bebas atau pake seragam rapi kemeja min?', 'Aturan & Tata Tertib', true, 'Pengujian dresscode pakaian kerja'],
            [33, 'Bahasa Gaul / Slang', 'bisa wfh ga min pas magang?', 'Aturan & Tata Tertib', true, 'Pengujian istilah wfh'],
            [34, 'Bahasa Gaul / Slang', 'ada fee atau uang transport ga min?', 'Biaya', true, 'Pengujian kata fee dan uang transport'],
            [35, 'Bahasa Gaul / Slang', 'harus bawa laptop sendiri ga kak?', 'Syarat', true, 'Pengujian syarat bawa laptop pribadi'],
            [36, 'Bahasa Gaul / Slang', 'prodi sistem informasi bisa daftar divisi apa aja?', 'FAQ', true, 'Pengujian istilah prodi sistem informasi'],
            [37, 'Bahasa Gaul / Slang', 'gimana alur registrasi online lewat web min?', 'Alur Pengajuan', true, 'Pengujian istilah alur registrasi online'],
            [38, 'Bahasa Gaul / Slang', 'Kudu nyiapin ape aje nih bre biar lolos seleksi?', 'Syarat', true, 'Pengujian dialek/slang ekstrem (kudu, ape aje, bre)'],
            [39, 'Bahasa Gaul / Slang', 'klo mau join project tech lead nya siapa yak?', 'FAQ', true, 'Pengujian jargon teknologi tanpa kata kunci divisi resmi'],
            [40, 'Bahasa Gaul / Slang', 'sertif nya ada ttd kepala dinas ga min?', 'Sertifikat', true, 'Pengujian istilah sertif resmi kepala dinas (detail tanda tangan belum ada di KB)'],

            // ===== 3. Kesalahan Pengetikan / Typo (20) =====
            [41, 'Typo / Salah Ketik', 'Syrat pndaftaran mgang apa aja?', 'Syarat', true, 'Pengujian toleransi typo pada kata syrat, pndaftaran, mgang'],
            [42, 'Typo / Salah Ketik', 'Brapa lm durasi magang nya?', 'Durasi Magang', true, 'Pengujian typo pada kata brapa dan lm'],
            [43, 'Typo / Salah Ketik', 'Almat kntor diskominfo dmana?', 'Informasi Perusahaan', true, 'Pengujian toleransi typo almat, kntor, dmana'],
            [44, 'Typo / Salah Ketik', 'Apakh dpat sertipikat magang?', 'Sertifikat', true, 'Pengujian variasi fonetik sertipikat'],
            [45, 'Typo / Salah Ketik', 'Cara daftr pkl onlen gmana?', 'Alur Pengajuan', true, 'Pengujian kata typo daftr dan onlen'],
            [46, 'Typo / Salah Ketik', 'Jm krja opresional kntor', 'Jam Kerja', true, 'Pengujian typo jm krja dan opresional'],
            [47, 'Typo / Salah Ketik', 'Kouta pnrmaan mgang msih ad?', 'Kuota Penerimaan', true, 'Pengujian typo kouta dan pnrmaan'],
            [48, 'Typo / Salah Ketik', 'Emil atau tlp dskmnfo kntor', 'Informasi Perusahaan', true, 'Pengujian typo emil dan dskmnfo'],
            [49, 'Typo / Salah Ketik', 'dapt uang sakku atao gji gaa', 'Biaya', true, 'Pengujian typo sakku dan gji'],
            [50, 'Typo / Salah Ketik', 'pkaian dan sragam krja kemeja', 'Aturan & Tata Tertib', true, 'Pengujian typo pkaian dan sragam'],
            [51, 'Typo / Salah Ketik', 'dvisi komputr dan jaringan it', 'FAQ', true, 'Pengujian typo dvisi dan komputr'],
            [52, 'Typo / Salah Ketik', 'brkas srat rkomendasi kmpus', 'Syarat', true, 'Pengujian typo brkas dan rkomendasi'],
            [53, 'Typo / Salah Ketik', 'alr pndaftran stelah dpt srat trima', 'Alur Pengajuan', true, 'Pengujian typo alr dan pndaftran'],
            [54, 'Typo / Salah Ketik', 'jam plang kntor hri jmat', 'Jam Kerja', true, 'Pengujian typo plang dan hri'],
            [55, 'Typo / Salah Ketik', 'lksi gedung pmkab bekasi', 'Informasi Perusahaan', true, 'Pengujian typo lksi dan pmkab'],
            [56, 'Typo / Salah Ketik', 'srtfikat rsemi diskominfotik', 'Sertifikat', true, 'Pengujian typo srtfikat dan rsemi'],
            [57, 'Typo / Salah Ketik', 'kuotta untk mhswa smester akhr', 'Kuota Penerimaan', true, 'Pengujian typo kuotta dan mhswa'],
            [58, 'Typo / Salah Ketik', 'kpn wktu bka ttp regis gel 2', 'Durasi Magang', true, 'Pengujian noise singkatan ekstrem waktu pendaftaran (tidak ada di KB)'],
            [59, 'Typo / Salah Ketik', 'praktek lapang krja dftar dmn ya tgl brp', 'Alur Pengajuan', true, 'Pengujian kalimat typo terpotong-potong'],
            [60, 'Typo / Salah Ketik', 'Kalo kelar nanti dapet apa aja ya?', 'Benefit', true, 'Pengujian pertanyaan ambigu tanpa kata kunci topik spesifik'],

            // ===== 4. Kata Kunci Singkat (20) =====
            [61, 'Kata Kunci Singkat', 'syarat magang', 'Syarat', true, 'Pengujian input 2 kata kunci inti syarat magang'],
            [62, 'Kata Kunci Singkat', 'alur pendaftaran', 'Alur Pengajuan', true, 'Pengujian input 2 kata alur pendaftaran'],
            [63, 'Kata Kunci Singkat', 'lokasi kantor', 'Informasi Perusahaan', true, 'Pengujian input 2 kata lokasi kantor'],
            [64, 'Kata Kunci Singkat', 'durasi magang', 'Durasi Magang', true, 'Pengujian input 2 kata durasi magang'],
            [65, 'Kata Kunci Singkat', 'uang saku magang', 'Biaya', true, 'Pengujian input spesifik uang saku'],
            [66, 'Kata Kunci Singkat', 'sertifikat magang', 'Sertifikat', true, 'Pengujian input spesifik sertifikat magang'],
            [67, 'Kata Kunci Singkat', 'jam kerja', 'Jam Kerja', true, 'Pengujian input 2 kata jam kerja'],
            [68, 'Kata Kunci Singkat', 'divisi magang', 'FAQ', true, 'Pengujian input 2 kata divisi magang'],
            [69, 'Kata Kunci Singkat', 'kuota magang', 'Kuota Penerimaan', true, 'Pengujian input 2 kata kuota magang'],
            [70, 'Kata Kunci Singkat', 'kontak diskominfosantik', 'Informasi Perusahaan', true, 'Pengujian input kontak kantor'],
            [71, 'Kata Kunci Singkat', 'pakaian magang', 'Aturan & Tata Tertib', true, 'Pengujian input singkat pakaian magang'],
            [72, 'Kata Kunci Singkat', 'dapet makan', 'Biaya', true, 'Pengujian input singkat dapet makan'],
            [73, 'Kata Kunci Singkat', 'bawa laptop', 'Syarat', true, 'Pengujian input singkat bawa laptop'],
            [74, 'Kata Kunci Singkat', 'divisi IT', 'FAQ', true, 'Pengujian input singkat divisi IT'],
            [75, 'Kata Kunci Singkat', 'email kantor', 'Informasi Perusahaan', true, 'Pengujian input singkat email kantor'],
            [76, 'Kata Kunci Singkat', 'telepon diskominfosantik', 'Informasi Perusahaan', true, 'Pengujian input singkat telepon kantor'],
            [77, 'Kata Kunci Singkat', 'waktu operasional', 'Jam Kerja', true, 'Pengujian input singkat waktu operasional'],
            [78, 'Kata Kunci Singkat', 'berkas pendaftaran', 'Syarat', true, 'Pengujian input singkat berkas pendaftaran'],
            [79, 'Kata Kunci Singkat', 'prosedur daftar', 'Alur Pengajuan', true, 'Pengujian input singkat prosedur daftar'],
            [80, 'Kata Kunci Singkat', 'sisa kuota', 'Kuota Penerimaan', true, 'Pengujian input singkat sisa kuota'],

            // ===== 5. Singkatan (20) =====
            [81, 'Singkatan', 'Syarat magang di diskominfo apa aja yg hrs dibawa?', 'Syarat', true, 'Pengujian singkatan yg dan hrs pada pertanyaan syarat'],
            [82, 'Singkatan', 'Brp bln durasi pkl di kominfo?', 'Durasi Magang', true, 'Pengujian singkatan brp, bln, pkl, dan kominfo'],
            [83, 'Singkatan', 'Jm krja kantor dari jam brp sampai jam brp?', 'Jam Kerja', true, 'Pengujian singkatan jm, krja, dan brp pada jam kerja'],
            [84, 'Singkatan', 'Bs wfh ga utk mhs pkl?', 'Aturan & Tata Tertib', true, 'Pengujian singkatan bs, utk, mhs, dan pkl pada kebijakan WFH'],
            [85, 'Singkatan', 'Dpt sertif ga stlh kelar pkl 3 bln?', 'Sertifikat', true, 'Pengujian singkatan dpt, sertif, stlh, dan bln'],
            [86, 'Singkatan', 'Ada uang saku atau gji utk pkl ga?', 'Biaya', true, 'Pengujian singkatan gji, utk, dan pkl pada uang saku'],
            [87, 'Singkatan', 'Nmr tlp dan wa admin diskominfo brp ya?', 'Informasi Perusahaan', true, 'Pengujian singkatan nmr, tlp, wa, dan brp pada kontak'],
            [88, 'Singkatan', 'Almt email diskominfo', 'Informasi Perusahaan', true, 'Pengujian singkatan almt pada informasi instansi'],
            [89, 'Singkatan', 'Kuota pkl msh ad ga utk mhs univ?', 'Kuota Penerimaan', true, 'Pengujian singkatan msh, ad, mhs, dan univ pada kuota'],
            [90, 'Singkatan', 'Divisi apa aja yg tersedia utk pkl?', 'FAQ', true, 'Pengujian singkatan yg, utk, dan pkl pada daftar divisi'],
            [91, 'Singkatan', 'Hrs bawa laptop pribadi ga?', 'Syarat', true, 'Pengujian singkatan hrs pada syarat laptop'],
            [92, 'Singkatan', 'Dresscode pkl hrs kemeja rapi ga?', 'Aturan & Tata Tertib', true, 'Pengujian istilah dresscode, pkl, dan hrs pada pakaian'],
            [93, 'Singkatan', 'Alur daftar pkl di diskominfo gmn?', 'Alur Pengajuan', true, 'Pengujian singkatan gmn dan pkl pada alur pengajuan'],
            [94, 'Singkatan', 'Dpt uang mkn atau transport ga?', 'Biaya', true, 'Pengujian singkatan dpt dan mkn pada uang makan'],
            [95, 'Singkatan', 'Jam kerja hr jmat sampai jam brp?', 'Jam Kerja', true, 'Pengujian singkatan hr, jmat, dan brp pada jam kerja'],
            [96, 'Singkatan', 'Lksi kntor diskominfo dmn?', 'Informasi Perusahaan', true, 'Pengujian singkatan lksi, kntor, dan dmn pada lokasi'],
            [97, 'Singkatan', 'Dokumen persyaratan pkl apa aja yg hrs disiapkan?', 'Syarat', true, 'Pengujian singkatan pkl, yg, dan hrs pada dokumen syarat'],
            [98, 'Singkatan', 'Sertif dpt kalo pkl brp bln?', 'Sertifikat', true, 'Pengujian singkatan sertif, dpt, brp, dan bln pada syarat sertifikat'],
            [99, 'Singkatan', 'Kpn konfirmasi acc surat pkl dr dinas?', 'Alur Pengajuan', true, 'Pengujian singkatan kpn, pkl, dan dr pada konfirmasi surat'],
            [100, 'Singkatan', 'Izin sakit hrs kirim surat dokter ga?', 'Absensi', true, 'Pengujian singkatan hrs pada ketentuan izin sakit'],

            // ===== 6. Negatif / Di Luar Topik (20) - Expected: Fallback =====
            [101, 'Di Luar Konteks', 'Kamu punya pacar ga?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan personal di luar topik'],
            [102, 'Di Luar Konteks', 'Bagaimana alur dan syarat membuat KTP atau KK di kantor Disdukcapil?', 'Fallback / Di Luar Topik', false, 'Pengujian layanan sipil non-magang (berpotensi False Positive: overlap kata alur dan syarat)'],
            [103, 'Di Luar Konteks', 'Siapa presiden pertama Indonesia?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan pengetahuan umum'],
            [104, 'Di Luar Konteks', 'Mau nonton film bioskop apa yang bagus ya?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan hiburan film'],
            [105, 'Di Luar Konteks', 'Resep cara memasak nasi goreng enak', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan resep masakan'],
            [106, 'Di Luar Konteks', 'Lagu pop Indonesia apa yang lagi viral sekarang?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan topik musik'],
            [107, 'Di Luar Konteks', 'Main game Mobile Legends mabar yuk min', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan topik gaming'],
            [108, 'Di Luar Konteks', 'Ramalan zodiak cinta Gemini hari ini apa ya?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan topik zodiak'],
            [109, 'Di Luar Konteks', 'Toko baju dan distro terdekat di Cikarang dimana ya?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan belanja non-magang'],
            [110, 'Di Luar Konteks', 'asdfghjkl zxcvbnm qwerty12345', 'Fallback / Di Luar Topik', false, 'Pengujian input acak tanpa arti'],
            [111, 'Di Luar Konteks', 'Harga emas antam per gram hari ini berapa ya?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan harga emas'],
            [112, 'Di Luar Konteks', 'Cuaca hari ini di Jakarta hujan atau panas?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan cuaca'],
            [113, 'Di Luar Konteks', 'Apa saja syarat dan dokumen izin mendirikan bangunan di pemkab?', 'Fallback / Di Luar Topik', false, 'Pengujian perizinan non-magang (berpotensi False Positive: overlap syarat dan dokumen)'],
            [114, 'Di Luar Konteks', 'Rekomendasi tempat wisata alam terbaik di Bandung', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan pariwisata'],
            [115, 'Di Luar Konteks', 'Cara memperbaiki motor mogok karena busi basah', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan otomotif'],
            [116, 'Di Luar Konteks', 'Siapa pemenang juara dunia MotoGP musim lalu?', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan olahraga'],
            [117, 'Di Luar Konteks', 'Chord kunci gitar lagu pop Indonesia terbaru', 'Fallback / Di Luar Topik', false, 'Pengujian pertanyaan chord musik'],
            [118, 'Di Luar Konteks', 'Jual beli mobil bekas murah berkualitas di Bekasi', 'Fallback / Di Luar Topik', false, 'Pengujian jual beli otomotif'],
            [119, 'Di Luar Konteks', 'Cara membuat akun Instagram dan TikTok baru', 'Fallback / Di Luar Topik', false, 'Pengujian media sosial umum'],
            [120, 'Di Luar Konteks', '1234567890 !@#$%^&*()_+=-', 'Fallback / Di Luar Topik', false, 'Pengujian simbol numerik dan karakter acak'],
        ];

        return array_map(fn(array $r) => [
            'id' => $r[0],
            'category_type' => $r[1],
            'question' => $r[2],
            'expected_category' => $r[3],
            'is_topic' => $r[4],
            'description' => $r[5],
        ], $rows);
    }

    /**
     * Tampilkan halaman dashboard evaluasi chatbot.
     */
    public function index()
    {
        $benchmarkResults = $this->executeBenchmark();
        $thresholdResults = $this->executeThresholdSweep();
        $totalKb = KnowledgeBase::count();
        $activeKb = KnowledgeBase::where('is_active', true)->count();
        $categoriesKb = KnowledgeBase::distinct()->pluck('category');

        return view('evaluasi.index', compact(
            'benchmarkResults',
            'thresholdResults',
            'totalKb',
            'activeKb',
            'categoriesKb'
        ));
    }

    /**
     * Jalankan uji tolok ukur (benchmark) pada threshold yang sedang aktif.
     */
    public function runBenchmarkAjax()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->executeBenchmark(),
        ]);
    }

    /**
     * Jalankan threshold sweep (variasi nilai threshold) untuk menentukan threshold.
     */
    public function runThresholdSweepAjax()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->executeThresholdSweep(),
        ]);
    }

    /**
     * Uji satu pertanyaan live (single query simulator).
     */
    public function testSingleQuery(Request $request)
    {
        $inputQuery = $request->input('query', $request->input('question'));

        if (empty($inputQuery)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pertanyaan / query tidak boleh kosong.',
            ], 422);
        }

        $startTime = microtime(true);
        $response = $this->chatbotService->getResponse($inputQuery);
        $executionTimeMs = round((microtime(true) - $startTime) * 1000, 2);

        // Hasil setiap tahap preprocessing untuk visualisasi pipeline
        $steps = $this->chatbotService->preprocessWithSteps($inputQuery);

        // Top 5 skor kemiripan memakai mesin yang sama dengan chatbot (Sørensen-Dice, character bigram)
        $topMatches = array_map(fn(array $row) => [
            'id' => $row['item']->id,
            'question' => $row['item']->question,
            'category' => $row['item']->category,
            'similarity_percent' => round($row['score'] * 100, 2),
        ], $this->chatbotService->rankKnowledgeBase($steps['result'], 5));

        return response()->json([
            'status' => 'success',
            'query' => $inputQuery,
            'bot_status' => $response['status'] ?? 'fallback',
            'bot_category' => $response['category'] ?? 'Fallback / Tidak Dikenali',
            'matched_question' => $response['question_matched'] ?? '-',
            'confidence' => $response['confidence'] ?? 0,
            'threshold' => $this->chatbotService->getSimilarityThreshold(),
            'latency_ms' => $executionTimeMs,
            'tokens' => $steps['tokens'],
            'keywords' => $steps['normalized'],
            'processed_input' => $steps['result'],
            'preprocessing' => $steps,
            'top_matches' => $topMatches,
            'bot_answer' => $response['answer'] ?? 'Maaf, saya belum memahami pertanyaan Anda.',
        ]);
    }

    /**
     * Eksekusi seluruh skenario pengujian dan hitung matriks evaluasi.
     *
     * Definisi confusion matrix (konsisten untuk seluruh pengujian):
     * - TP: pertanyaan topik magang, chatbot menjawab, dan kategori jawaban sesuai.
     * - FN: pertanyaan topik magang, tetapi chatbot memberikan fallback.
     * - FP: chatbot memberikan jawaban yang tidak seharusnya, yaitu jawaban pada pertanyaan
     *       di luar topik, atau jawaban dengan kategori yang salah pada pertanyaan topik magang.
     * - TN: pertanyaan di luar topik dan chatbot memberikan fallback.
     *
     * @param bool $withDetails sertakan detail per skenario (dimatikan saat threshold sweep)
     */
    protected function executeBenchmark(bool $withDetails = true): array
    {
        $scenarios = $this->getTestScenarios();
        $details = [];
        $byVariation = [];
        $totalTime = 0;

        $tp = 0;
        $tn = 0;
        $fp = 0;
        $fn = 0;

        $loggingWasEnabled = $this->chatbotService->isLoggingEnabled();
        $this->chatbotService->setLoggingEnabled(false);

        foreach ($scenarios as $item) {
            $startTime = microtime(true);
            $botResponse = $this->chatbotService->getResponse($item['question']);
            $latencyMs = round((microtime(true) - $startTime) * 1000, 2);
            $totalTime += $latencyMs;

            $isBotSuccess = ($botResponse['status'] === 'success');
            $botCategory = $botResponse['category'] ?? null;

            $categoryCorrect = $item['is_topic']
                ? ($isBotSuccess && $botCategory === $item['expected_category'])
                : !$isBotSuccess;

            if ($item['is_topic']) {
                if ($isBotSuccess && $categoryCorrect) {
                    $tp++;
                    $classification = 'TP';
                } elseif ($isBotSuccess) {
                    $fp++;
                    $classification = 'FP';
                } else {
                    $fn++;
                    $classification = 'FN';
                }
            } else {
                if (!$isBotSuccess) {
                    $tn++;
                    $classification = 'TN';
                } else {
                    $fp++;
                    $classification = 'FP';
                }
            }

            $isCorrect = in_array($classification, ['TP', 'TN'], true);

            $type = $item['category_type'];
            $byVariation[$type] ??= ['total' => 0, 'correct' => 0, 'tp' => 0, 'tn' => 0, 'fp' => 0, 'fn' => 0];
            $byVariation[$type]['total']++;
            $byVariation[$type]['correct'] += $isCorrect ? 1 : 0;
            $byVariation[$type][strtolower($classification)]++;

            if ($withDetails) {
                $details[] = [
                    'id' => $item['id'],
                    'category_type' => $type,
                    'question' => $item['question'],
                    'expected_category' => $item['expected_category'],
                    'bot_status' => $botResponse['status'],
                    'bot_category' => $botCategory ?? 'Fallback Response',
                    'matched_question' => $botResponse['question_matched'] ?? '-',
                    'confidence' => $botResponse['confidence'] ?? 0,
                    'latency_ms' => $latencyMs,
                    'classification' => $classification,
                    'category_correct' => $categoryCorrect,
                    'is_correct' => $isCorrect,
                    'description' => $item['description'],
                ];
            }
        }

        $this->chatbotService->setLoggingEnabled($loggingWasEnabled);

        foreach ($byVariation as $type => $row) {
            $byVariation[$type]['accuracy'] = $row['total'] > 0
                ? round(($row['correct'] / $row['total']) * 100, 2)
                : 0;
        }

        $totalTests = count($scenarios);
        $metrics = $this->calculateMetrics($tp, $tn, $fp, $fn);

        return [
            'threshold' => $this->chatbotService->getSimilarityThreshold(),
            'total_tests' => $totalTests,
            'total_correct' => $tp + $tn,
            'accuracy' => $metrics['accuracy'],
            'precision' => $metrics['precision'],
            'recall' => $metrics['recall'],
            'f1_score' => $metrics['f1_score'],
            'avg_latency_ms' => $totalTests > 0 ? round($totalTime / $totalTests, 2) : 0,
            'confusion_matrix' => [
                'tp' => $tp,
                'tn' => $tn,
                'fp' => $fp,
                'fn' => $fn,
            ],
            'by_variation' => $byVariation,
            'details' => $details,
            'evaluated_at' => Carbon::now()->format('d F Y, H:i:s'),
        ];
    }

    /**
     * Threshold sweep: menjalankan seluruh skenario pada setiap kandidat threshold
     * dan menentukan threshold terbaik berdasarkan F1-score (seri: accuracy, lalu threshold lebih tinggi).
     */
    protected function executeThresholdSweep(): array
    {
        $originalThreshold = $this->chatbotService->getSimilarityThreshold();
        $rows = [];

        try {
            foreach ($this->thresholdCandidates as $threshold) {
                $this->chatbotService->setSimilarityThreshold($threshold);
                $result = $this->executeBenchmark(false);

                $rows[] = [
                    'threshold' => $threshold,
                    'accuracy' => $result['accuracy'],
                    'precision' => $result['precision'],
                    'recall' => $result['recall'],
                    'f1_score' => $result['f1_score'],
                    'confusion_matrix' => $result['confusion_matrix'],
                ];
            }
        } finally {
            $this->chatbotService->setSimilarityThreshold($originalThreshold);
        }

        $best = null;
        foreach ($rows as $row) {
            if (
                $best === null
                || $row['f1_score'] > $best['f1_score']
                || ($row['f1_score'] === $best['f1_score'] && $row['accuracy'] > $best['accuracy'])
                || ($row['f1_score'] === $best['f1_score'] && $row['accuracy'] === $best['accuracy'] && $row['threshold'] > $best['threshold'])
            ) {
                $best = $row;
            }
        }

        return [
            'results' => $rows,
            'best_threshold' => $best['threshold'] ?? null,
            'best_f1_score' => $best['f1_score'] ?? null,
        ];
    }

    /**
     * Menghitung accuracy, precision, recall, dan F1-score (dalam persen).
     */
    protected function calculateMetrics(int $tp, int $tn, int $fp, int $fn): array
    {
        $total = $tp + $tn + $fp + $fn;

        $accuracy = $total > 0 ? round((($tp + $tn) / $total) * 100, 2) : 0;
        $precision = ($tp + $fp) > 0 ? round(($tp / ($tp + $fp)) * 100, 2) : 0;
        $recall = ($tp + $fn) > 0 ? round(($tp / ($tp + $fn)) * 100, 2) : 0;
        $f1Score = ($precision + $recall) > 0
            ? round((2 * ($precision * $recall) / ($precision + $recall)), 2)
            : 0;

        return [
            'accuracy' => $accuracy,
            'precision' => $precision,
            'recall' => $recall,
            'f1_score' => $f1Score,
        ];
    }
}