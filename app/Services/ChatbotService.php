<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Log;

/**
 * =========================================================================================
 * ChatbotService
 * =========================================================================================
 * Knowledge-Based Chatbot Informasi Magang Berbasis Web (retrieval-based) dengan alur:
 *
 *   Pertanyaan pengguna
 *     -> Text Preprocessing:
 *          1. Case Folding
 *          2. Cleansing
 *          3. Tokenisasi
 *          4. Stopword Removal
 *          5. Normalisasi Kata (aturan + kamus)
 *     -> Himpunan character bigram (set-based)
 *     -> Sørensen-Dice Similarity terhadap setiap pertanyaan di knowledge base
 *     -> Pertanyaan dengan nilai tertinggi dipakai jika nilai >= threshold
 *     -> Jika tidak memenuhi threshold, sistem memberikan respons fallback
 *
 * Penyelarasan dengan Bab I proposal:
 * - Urutan preprocessing mengikuti Batasan Masalah (stopword removal sebelum normalisasi kata).
 * - Normalisasi hanya memakai aturan dan kamus yang ditentukan secara eksplisit
 *   (kamus canonicalMap dan aturan pelepasan enklitik -nya/-lah/-kah/-pun).
 * - Tidak ada filter kata off-topic maupun deteksi intent di luar knowledge base.
 *   Sapaan, terima kasih, dan identitas bot disimpan sebagai entri knowledge base
 *   (kategori "Percakapan Umum"), sehingga seluruh keputusan respons ditentukan
 *   oleh Sørensen-Dice Similarity dan threshold.
 * - Threshold bukan nilai tetap: 0,60 hanya baseline awal dan variasinya diuji
 *   melalui EvaluasiChatbotController (threshold sweep).
 * - Nilai priority pada knowledge base hanya dipakai sebagai pemutus seri (tie-breaker)
 *   ketika skor Dice identik.
 * =========================================================================================
 */
class ChatbotService
{
    /**
     * Ambang batas kemiripan (similarity threshold) baseline.
     * Variasi nilai (0,50 - 0,80) dievaluasi melalui threshold sweep pada
     * EvaluasiChatbotController untuk menentukan nilai yang dipakai.
     */
    protected float $similarityThreshold = 0.60;

    /**
     * Pencatatan log setiap pertanyaan (dimatikan saat benchmark / threshold sweep).
     */
    protected bool $loggingEnabled = true;

    /**
     * Cache knowledge base yang sudah melewati preprocessing.
     */
    protected ?array $processedKnowledgeBase = null;

    /**
     * Daftar stopwords bahasa Indonesia (kata tugas / partikel pengisi).
     * Pengecekan dilakukan pada token hasil tokenisasi sebelum normalisasi, sehingga
     * bentuk singkatan stopword (yg, dgn, utk, dr, kpd, tsb, sbg, jd, nya) ikut didaftarkan.
     * Kata substantif pembeda topik magang tidak dimasukkan ke daftar ini.
     */
    protected array $stopwords = [
        'yang', 'di', 'ke', 'dari', 'dan', 'atau', 'untuk', 'dengan', 'tentang',
        'pada', 'dalam', 'oleh', 'sebagai', 'ini', 'itu', 'tersebut', 'jadi',
        'apakah', 'bagaimana', 'adalah', 'akan', 'agar', 'secara', 'selama', 'saat',
        'yg', 'dgn', 'utk', 'dr', 'kpd', 'tsb', 'sbg', 'jd', 'nya',
        'saya', 'kamu', 'kami', 'mereka', 'anda', 'aku', 'kita', 'dia', 'ku',
        'saja', 'aja', 'sih', 'dung', 'dong', 'deh', 'lah', 'pun', 'kok', 'kan',
        'ya', 'nih', 'oh', 'eh', 'hmm', 'aduh', 'wah', 'nah', 'lho', 'loh', 'pas', 'tuh',
        'kak', 'kakak', 'min', 'admin', 'gan', 'sis', 'bro', 'bang', 'mas', 'mba', 'mbak',
        'disana', 'disini', 'disitu', 'sana', 'sini', 'situ',
        'mau', 'ingin', 'pengen', 'tanya', 'nanya', 'bertanya',
    ];

    /**
     * Kamus normalisasi kanonikal (canonical map).
     * Menyeragamkan singkatan, typo, slang, dan istilah alternatif ke bentuk baku
     * yang ditentukan secara eksplisit.
     */
    protected array $canonicalMap = [

        // ---------------------------------------------------------------------
        // 1. Singkatan & Typo Kata Tanya / Partikel / Keterangan
        // ---------------------------------------------------------------------
        'dmn' => 'dimana',
        'dmana' => 'dimana',
        'brp' => 'berapa',
        'brapa' => 'berapa',
        'lm' => 'lama',
        'kpn' => 'kapan',
        'gmn' => 'gimana',
        'bgmn' => 'gimana',
        'knp' => 'kenapa',
        'ad' => 'ada',
        'bs' => 'bisa',
        'klo' => 'kalau',
        'kalo' => 'kalau',
        'kl' => 'kalau',
        'kpd' => 'kepada',
        'krn' => 'karena',
        'utk' => 'untuk',
        'dr' => 'dari',
        'dgn' => 'dengan',
        'yg' => 'yang',
        'tsb' => 'tersebut',
        'sdh' => 'sudah',
        'udh' => 'sudah',
        'blm' => 'belum',
        'bbrp' => 'beberapa',
        'msh' => 'masih',
        'msih' => 'masih',
        'stlh' => 'setelah',
        'jml' => 'jumlah',

        // ---------------------------------------------------------------------
        // 2. Slang & Bahasa Informal Negasi / Verba / Adjektiva
        // ---------------------------------------------------------------------
        'gk' => 'tidak',
        'ga' => 'tidak',
        'gak' => 'tidak',
        'nggak' => 'tidak',
        'ngga' => 'tidak',
        'ndak' => 'tidak',
        'tdk' => 'tidak',
        'dapet' => 'dapat',
        'dapetin' => 'dapat',
        'dapetnya' => 'dapat',
        'dapatnya' => 'dapat',
        'dpt' => 'dapat',
        'kelar' => 'selesai',
        'kudu' => 'wajib',
        'harus' => 'wajib',
        'hrs' => 'wajib',
        'wajibkan' => 'wajib',

        // ---------------------------------------------------------------------
        // 3. Istilah Domain Magang & Instansi (Singkatan & Istilah Alternatif)
        // ---------------------------------------------------------------------
        'mgang' => 'magang',
        'internship' => 'magang',
        'pkl' => 'magang',
        'kp' => 'magang',
        'diskominfo' => 'diskominfosantik',
        'dskmnfo' => 'diskominfosantik',
        'kominfo' => 'diskominfosantik',
        'diskominfotik' => 'diskominfosantik',
        'pemda' => 'pemkab',

        // ---------------------------------------------------------------------
        // 4. Pendaftaran & Registrasi (Variasi Istilah & Serapan)
        // ---------------------------------------------------------------------
        'pendaftaran' => 'daftar',
        'pndaftaran' => 'daftar',
        'pndaftran' => 'daftar',
        'daftr' => 'daftar',
        'dftr' => 'daftar',
        'register' => 'daftar',
        'registrasi' => 'daftar',
        'onlen' => 'online',
        'regis' => 'daftar',

        // ---------------------------------------------------------------------
        // 5. Syarat & Dokumen (Variasi Istilah & Typo)
        // ---------------------------------------------------------------------
        'syrat' => 'syarat',
        'srat' => 'syarat',
        'persyaratan' => 'syarat',
        'syarat2' => 'syarat',
        'brkas' => 'berkas',
        'dkumun' => 'dokumen',
        'rkomendasi' => 'rekomendasi',

        // ---------------------------------------------------------------------
        // 6. Alamat & Kontak (Typo & Singkatan)
        // ---------------------------------------------------------------------
        'almat' => 'alamat',
        'almt' => 'alamat',
        'almtt' => 'alamat',
        'lksi' => 'lokasi',
        'kntor' => 'kantor',
        'telp' => 'telepon',
        'tlp' => 'telepon',
        'tlpn' => 'telepon',
        'nomer' => 'nomor',
        'nmr' => 'nomor',
        'no' => 'nomor',
        'wa' => 'whatsapp',
        'emil' => 'email',
        'hubungin' => 'hubungi',

        // ---------------------------------------------------------------------
        // 7. Waktu & Operasional
        // ---------------------------------------------------------------------
        'krja' => 'kerja',
        'jm' => 'jam',
        'bln' => 'bulan',
        'opresional' => 'operasional',
        'plang' => 'pulang',
        'hri' => 'hari',
        'hr' => 'hari',
        'jmat' => 'jumat',

        // ---------------------------------------------------------------------
        // 8. Finansial (Typo & Slang Terbatas)
        // ---------------------------------------------------------------------
        'duit' => 'uang',
        'cuan' => 'uang',
        'fee' => 'uang',
        'gji' => 'gaji',
        'sakku' => 'saku',

        // ---------------------------------------------------------------------
        // 9. Pakaian & Seragam
        // ---------------------------------------------------------------------
        'pkaian' => 'pakaian',
        'pkain' => 'pakaian',
        'baju' => 'pakaian',
        'kemeja' => 'pakaian',
        'sragam' => 'seragam',
        'dresscode' => 'pakaian',

        // ---------------------------------------------------------------------
        // 10. Kuota, Divisi & Akademik (Typo & Singkatan)
        // ---------------------------------------------------------------------
        'kouta' => 'kuota',
        'qouta' => 'kuota',
        'kuotta' => 'kuota',
        'pnrmaan' => 'penerimaan',
        'dvisi' => 'divisi',
        'komputr' => 'komputer',
        'mhswa' => 'mahasiswa',
        'mhs' => 'mahasiswa',
        'kmpus' => 'kampus',
        'univ' => 'kampus',

        // ---------------------------------------------------------------------
        // 11. Sertifikat & Fasilitas (Typo Murni)
        // ---------------------------------------------------------------------
        'sertif' => 'sertifikat',
        'srtfkat' => 'sertifikat',
        'srtfikat' => 'sertifikat',
        'sertipikat' => 'sertifikat',
        'mkn' => 'makan',
        'kntin' => 'kantin',
        'kanteen' => 'kantin',

        // ---------------------------------------------------------------------
        // 12. Percakapan Umum (diseragamkan agar cocok dengan entri knowledge base)
        // ---------------------------------------------------------------------
        'hai' => 'halo',
        'hallo' => 'halo',
        'helo' => 'halo',
        'hello' => 'halo',
        'hei' => 'halo',
        'hey' => 'halo',
        'hi' => 'halo',
        'kulonuwun' => 'punten',
        'makasih' => 'terima kasih',
        'makasi' => 'terima kasih',
        'mksih' => 'terima kasih',
        'terimakasih' => 'terima kasih',
        'thanks' => 'terima kasih',
        'thx' => 'terima kasih',
        'tks' => 'terima kasih',
        'tengkyu' => 'terima kasih',
        'pinter' => 'pintar',
        'ok' => 'oke',
        'okey' => 'oke',
        'okay' => 'oke',
        'siap' => 'oke',
        'sip' => 'oke',
        'noted' => 'oke',
        'ngerti' => 'oke',
        'dadaah' => 'dadah',
    ];

    /**
     * Kata dasar yang dikenali aturan pelepasan enklitik (-nya, -lah, -kah, -pun).
     * Akhiran hanya dilepas jika kata dasarnya ada di kamus canonicalMap atau di daftar ini,
     * sehingga kata lain yang kebetulan berakhiran sama tidak terpotong.
     */
    protected array $rootWords = [
        'kantor', 'magang', 'alamat', 'lokasi', 'durasi', 'kuota', 'divisi', 'sertifikat',
        'syarat', 'berkas', 'dokumen', 'laptop', 'jurusan', 'prodi', 'kampus', 'seragam',
        'pakaian', 'fasilitas', 'mentor', 'laporan', 'uang', 'saku', 'gaji', 'biaya',
        'daftar', 'online', 'kontak', 'email', 'telepon', 'whatsapp', 'operasional',
        'jam', 'kerja', 'libur', 'absensi', 'kantin', 'surat', 'proposal', 'benefit',
    ];

    /**
     * Mengatur nilai ambang batas kemiripan (similarity threshold).
     */
    public function setSimilarityThreshold(float $threshold): void
    {
        $this->similarityThreshold = max(0.0, min(1.0, $threshold));
    }

    /**
     * Mendapatkan nilai ambang batas kemiripan saat ini.
     */
    public function getSimilarityThreshold(): float
    {
        return $this->similarityThreshold;
    }

    /**
     * Mengaktifkan / menonaktifkan pencatatan log (dipakai saat benchmark massal).
     */
    public function setLoggingEnabled(bool $enabled): void
    {
        $this->loggingEnabled = $enabled;
    }

    public function isLoggingEnabled(): bool
    {
        return $this->loggingEnabled;
    }

    /**
     * Mengosongkan cache knowledge base (panggil setelah isi knowledge base berubah).
     */
    public function flushKnowledgeBaseCache(): void
    {
        $this->processedKnowledgeBase = null;
    }

    /**
     * Menerima pertanyaan pengguna, memprosesnya melalui pipeline preprocessing dan
     * Sørensen-Dice Similarity, lalu mengembalikan respons terstruktur.
     */
    public function getResponse(string $userInput): array
    {
        $trimmedInput = trim($userInput);

        if ($trimmedInput === '') {
            return $this->buildFallback(0.0);
        }

        // 1. Text preprocessing (case folding, cleansing, tokenisasi, stopword removal, normalisasi)
        $processedInput = $this->preprocess($trimmedInput);

        if ($processedInput === '') {
            return $this->buildFallback(0.0);
        }

        // 2. Pencocokan dengan knowledge base menggunakan Sørensen-Dice Similarity
        $ranking = $this->rankKnowledgeBase($processedInput, 1);
        $bestMatch = $ranking[0]['item'] ?? null;
        $bestScore = $ranking[0]['score'] ?? 0.0;
        $confidence = round($bestScore * 100, 2);

        // 3. Keputusan berdasarkan threshold
        $isMatch = ($bestMatch !== null && $bestScore > 0.0 && $bestScore >= $this->similarityThreshold);

        if ($this->loggingEnabled) {
            Log::info('Chatbot Similarity Evaluation', [
                'original_input' => $trimmedInput,
                'processed_input' => $processedInput,
                'matched_question' => $bestMatch?->question,
                'dice_score' => round($bestScore, 4),
                'confidence' => $confidence,
                'threshold' => $this->similarityThreshold,
                'status' => $isMatch ? 'success' : 'fallback',
            ]);
        }

        if ($isMatch) {
            return [
                'status' => 'success',
                'answer' => $bestMatch->answer,
                'category' => $bestMatch->category,
                'confidence' => $confidence,
                'question_matched' => $bestMatch->question,
                'score' => $bestScore,
            ];
        }

        return $this->buildFallback($confidence, $bestScore);
    }

    /**
     * Menjalankan tahapan text preprocessing dan mengembalikan hasil akhir berupa string.
     */
    public function preprocess(string $text): string
    {
        return $this->preprocessWithSteps($text)['result'];
    }

    /**
     * Menjalankan tahapan text preprocessing dan mengembalikan hasil setiap tahap
     * (dipakai untuk visualisasi pipeline pada halaman evaluasi).
     *
     * 1. Case Folding   : mengubah seluruh huruf menjadi huruf kecil.
     * 2. Cleansing      : menghapus tanda baca dan karakter selain huruf, angka, dan spasi.
     * 3. Tokenisasi     : memecah kalimat menjadi token kata.
     * 4. Stopword Removal : membuang kata tugas / partikel pengisi.
     * 5. Normalisasi    : menyeragamkan singkatan, slang, typo, dan istilah alternatif
     *                     menggunakan kamus dan aturan yang telah ditentukan.
     */
    public function preprocessWithSteps(string $text): array
    {
        // Tahap 1: Case Folding
        $caseFolded = mb_strtolower(trim($text), 'UTF-8');

        // Tahap 2: Cleansing
        $cleansed = preg_replace('/[^a-z0-9\s]/u', ' ', $caseFolded);
        $cleansed = trim(preg_replace('/\s+/', ' ', $cleansed));

        if ($cleansed === '') {
            return [
                'case_folding' => $caseFolded,
                'cleansing' => '',
                'tokens' => [],
                'after_stopword' => [],
                'normalized' => [],
                'result' => '',
            ];
        }

        // Tahap 3: Tokenisasi
        $tokens = explode(' ', $cleansed);

        // Tahap 4: Stopword Removal
        $afterStopword = [];
        foreach ($tokens as $token) {
            if ($token !== '' && !in_array($token, $this->stopwords, true)) {
                $afterStopword[] = $token;
            }
        }

        // Tahap 5: Normalisasi Kata (kamus + aturan)
        $normalized = [];
        foreach ($afterStopword as $token) {
            $normalized[] = $this->normalizeToken($token);
        }

        return [
            'case_folding' => $caseFolded,
            'cleansing' => $cleansed,
            'tokens' => $tokens,
            'after_stopword' => $afterStopword,
            'normalized' => $normalized,
            'result' => implode(' ', $normalized),
        ];
    }

    /**
     * Normalisasi satu token:
     * 1. Pencarian langsung pada kamus canonicalMap.
     * 2. Aturan pelepasan enklitik (-nya, -lah, -kah, -pun) bila kata dasarnya dikenali.
     */
    protected function normalizeToken(string $token): string
    {
        if (isset($this->canonicalMap[$token])) {
            return $this->canonicalMap[$token];
        }

        if (mb_strlen($token, 'UTF-8') > 4) {
            foreach (['nya', 'lah', 'kah', 'pun'] as $suffix) {
                $suffixLength = mb_strlen($suffix, 'UTF-8');

                if (mb_substr($token, -$suffixLength, $suffixLength, 'UTF-8') === $suffix) {
                    $root = mb_substr($token, 0, mb_strlen($token, 'UTF-8') - $suffixLength, 'UTF-8');

                    if (isset($this->canonicalMap[$root])) {
                        return $this->canonicalMap[$root];
                    }

                    if (in_array($root, $this->rootWords, true)) {
                        return $root;
                    }
                }
            }
        }

        return $token;
    }

    /**
     * Ekstraksi token hasil normalisasi (helper untuk inspektor evaluasi).
     */
    public function extractCanonicalTokens(string $text): array
    {
        return $this->preprocessWithSteps($text)['normalized'];
    }

    /**
     * Membentuk himpunan character bigram (2 karakter berturutan) dari string.
     * Menggunakan himpunan unik (set) berbasis karakter.
     */
    public function generateBigrams(string $text): array
    {
        $text = preg_replace('/\s+/', ' ', trim($text));
        $length = mb_strlen($text, 'UTF-8');

        if ($length < 2) {
            return $length === 1 ? [$text] : [];
        }

        $bigrams = [];
        for ($i = 0; $i < $length - 1; $i++) {
            $bigrams[] = mb_substr($text, $i, 2, 'UTF-8');
        }

        return array_values(array_unique($bigrams));
    }

    /**
     * Menghitung koefisien Sørensen-Dice Similarity berbasis character bigram.
     *
     * DS(A, B) = (2 * |A ∩ B|) / (|A| + |B|)
     */
    public function sorensenDice(string $textA, string $textB): float
    {
        $textA = trim($textA);
        $textB = trim($textB);

        if ($textA === '' || $textB === '') {
            return 0.0;
        }

        if ($textA === $textB) {
            return 1.0;
        }

        return $this->diceFromBigrams(
            $this->generateBigrams($textA),
            $this->generateBigrams($textB)
        );
    }

    /**
     * Menghitung Dice dari dua himpunan bigram yang sudah terbentuk.
     */
    protected function diceFromBigrams(array $bigramsA, array $bigramsB): float
    {
        $countA = count($bigramsA);
        $countB = count($bigramsB);

        if ($countA === 0 || $countB === 0) {
            return 0.0;
        }

        $countIntersection = count(array_intersect($bigramsA, $bigramsB));

        return (2.0 * $countIntersection) / ($countA + $countB);
    }

    /**
     * Mengurutkan seluruh pertanyaan di knowledge base berdasarkan skor Sørensen-Dice
     * terhadap input yang sudah diproses. Nilai priority hanya dipakai sebagai pemutus seri.
     *
     * @return array<int, array{item: KnowledgeBase, score: float}>
     */
    public function rankKnowledgeBase(string $processedInput, ?int $limit = null): array
    {
        if ($processedInput === '') {
            return [];
        }

        $inputBigrams = $this->generateBigrams($processedInput);
        $ranking = [];

        foreach ($this->getProcessedKnowledgeBase() as $entry) {
            $score = ($processedInput === $entry['processed'])
                ? 1.0
                : $this->diceFromBigrams($inputBigrams, $entry['bigrams']);

            $ranking[] = [
                'item' => $entry['item'],
                'score' => $score,
            ];
        }

        usort($ranking, function (array $a, array $b) {
            if ($a['score'] === $b['score']) {
                return $b['item']->priority <=> $a['item']->priority;
            }

            return $b['score'] <=> $a['score'];
        });

        return $limit !== null ? array_slice($ranking, 0, $limit) : $ranking;
    }

    /**
     * Memuat knowledge base aktif beserta hasil preprocessing dan bigram-nya (di-cache).
     */
    protected function getProcessedKnowledgeBase(): array
    {
        if ($this->processedKnowledgeBase === null) {
            $this->processedKnowledgeBase = [];

            foreach (KnowledgeBase::where('is_active', true)->get() as $item) {
                $processed = $this->preprocess($item->question);

                if ($processed === '') {
                    continue;
                }

                $this->processedKnowledgeBase[] = [
                    'item' => $item,
                    'processed' => $processed,
                    'bigrams' => $this->generateBigrams($processed),
                ];
            }
        }

        return $this->processedKnowledgeBase;
    }

    /**
     * Membentuk respons fallback terstruktur.
     */
    protected function buildFallback(float $confidence, float $score = 0.0): array
    {
        return [
            'status' => 'fallback',
            'answer' => $this->getFallbackResponse(),
            'category' => null,
            'confidence' => $confidence,
            'question_matched' => null,
            'score' => $score,
        ];
    }

    /**
     * Template respons fallback saat skor similarity tidak mencapai threshold.
     */
    public function getFallbackResponse(): string
    {
        return 'Maaf, saya tidak memahami maksud pertanyaan Anda seputar program magang di Diskominfosantik Kabupaten Bekasi. 🤔<br><br>' .
               'Silakan ajukan pertanyaan menggunakan kata kunci yang lebih spesifik, seperti:<br>' .
               '• <em>"Apa saja syarat berkas magang?"</em><br>' .
               '• <em>"Bagaimana alur prosedur pengajuan magang?"</em><br>' .
               '• <em>"Berapa lama durasi magang?"</em><br>' .
               '• <em>"Berapa jam kerja operasional kantor?"</em><br>' .
               '• <em>"Apakah magang mendapatkan uang saku atau gaji?"</em><br>' .
               '• <em>"Dimana alamat dan lokasi kantor Diskominfosantik?"</em><br>' .
               '• <em>"Berapa sisa kuota penerimaan magang?"</em>';
    }
}