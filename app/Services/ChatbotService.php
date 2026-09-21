<?php

namespace App\Services;

use App\Models\KnowledgeBase;
use Illuminate\Support\Facades\Log;

class ChatbotService
{
    protected array $stopwords = [
        'apa', 'bagaimana', 'siapa', 'dimana', 'kapan', 'mengapa', 'kenapa', 'gimana',
        'yang', 'di', 'ke', 'dari', 'dan', 'atau', 'untuk', 'dengan', 'tentang',
        'pada', 'dalam', 'oleh', 'sebagai', 'ini', 'itu', 'tersebut', 'jadi',
        'saya', 'kamu', 'kami', 'mereka', 'anda', 'aku', 'kita', 'dia',
        'ada', 'bisa', 'akan', 'telah', 'sudah', 'belum', 'lagi', 'saja', 'aja',
        'apakah', 'bagi', 'tanpa', 'setelah', 'sebelum', 'sih', 'dung',
        'ga', 'gak', 'nggak', 'ya', 'nih', 'dong', 'deh', 'lah', 'pun', 'kok', 'kan',
        'oh', 'eh', 'hmm', 'aduh', 'wah', 'nah', 'lho', 'loh', 'pas', 'tuh',
        'kak', 'kakak', 'min', 'admin', 'gan', 'sis', 'bro', 'bang', 'mas', 'mba', 'mbak'
    ];

    // Canonical Normalization Dictionary (Synonyms mapped to 1 standard root term)
    protected array $canonicalMap = [
        // Topik Lokasi, Alamat & Kantor
        'lokasi' => 'alamat',
        'dimana' => 'alamat',
        'dmana' => 'alamat',
        'dmn' => 'alamat',
        'letak' => 'alamat',
        'posisi' => 'alamat',
        'posisinya' => 'alamat',
        'tempat' => 'alamat',
        'kantor' => 'alamat',
        'kantornya' => 'alamat',
        'kntor' => 'alamat',
        'almat' => 'alamat',
        'almtt' => 'alamat',
        'diskominfo' => 'alamat',
        'diskominfosantik' => 'alamat',
        'dskmnfo' => 'alamat',

        // Topik Persyaratan & Dokumen
        'syarat' => 'syarat',
        'syrat' => 'syarat',
        'srat' => 'syarat',
        'persyaratan' => 'syarat',
        'kondisi' => 'syarat',
        'ketentuan' => 'syarat',
        'dokumen' => 'syarat',
        'dkumun' => 'syarat',
        'berkas' => 'syarat',
        'kudu' => 'syarat',
        'harus' => 'syarat',
        'wajib' => 'syarat',
        'perlu' => 'syarat',
        'butuh' => 'syarat',
        'cv' => 'syarat',
        'laptop' => 'fasilitas',
        'perangkat' => 'fasilitas',
        'komputer' => 'fasilitas',
        'pc' => 'fasilitas',

        // Topik Waktu & Durasi
        'durasi' => 'durasi',
        'lama' => 'durasi',
        'brapa' => 'durasi',
        'lm' => 'durasi',
        'waktu' => 'durasi',
        'periode' => 'durasi',
        'bulan' => 'durasi',
        'bln' => 'durasi',
        'berapa_lama' => 'durasi',

        // Topik Jam Kerja & Operasional
        'jam' => 'jam_kerja',
        'kerja' => 'jam_kerja',
        'jm' => 'jam_kerja',
        'krja' => 'jam_kerja',
        'operasional' => 'jam_kerja',
        'opresional' => 'jam_kerja',
        'buka' => 'jam_kerja',
        'tutup' => 'jam_kerja',
        'pulang' => 'jam_kerja',
        'masuk' => 'jam_kerja',
        'wfh' => 'jam_kerja',
        'remote' => 'jam_kerja',
        'daring' => 'jam_kerja',

        // Topik Kuota & Ketersediaan
        'kuota' => 'kuota',
        'kouta' => 'kuota',
        'qouta' => 'kuota',
        'sisa' => 'kuota',
        'penerimaan' => 'kuota',
        'pnrmaan' => 'kuota',
        'kapasitas' => 'kuota',

        // Topik Kontak & Hubungi
        'kontak' => 'kontak',
        'telepon' => 'kontak',
        'telp' => 'kontak',
        'tlp' => 'kontak',
        'email' => 'kontak',
        'emil' => 'kontak',
        'nomor' => 'kontak',
        'nomer' => 'kontak',
        'no' => 'kontak',
        'wa' => 'kontak',
        'whatsapp' => 'kontak',
        'hubungi' => 'kontak',
        'dihubungi' => 'kontak',
        'hubungin' => 'kontak',

        // Topik Pakaian & Seragam
        'pakaian' => 'pakaian',
        'pkain' => 'pakaian',
        'seragam' => 'pakaian',
        'sragam' => 'pakaian',
        'baju' => 'pakaian',
        'kemeja' => 'pakaian',
        'busana' => 'pakaian',
        'dresscode' => 'pakaian',

        // Topik Divisi & Unit Penempatan
        'divisi' => 'divisi',
        'dvisi' => 'divisi',
        'unit' => 'divisi',
        'penempatan' => 'divisi',
        'bidang' => 'divisi',
        'jurusan' => 'divisi',
        'it' => 'divisi',
        'programmer' => 'divisi',

        // Topik Uang Saku, Makan & Finansial
        'uang' => 'uang_saku',
        'saku' => 'uang_saku',
        'jajan' => 'uang_saku',
        'gaji' => 'uang_saku',
        'honor' => 'uang_saku',
        'upah' => 'uang_saku',
        'bayaran' => 'uang_saku',
        'kompensasi' => 'uang_saku',
        'insentif' => 'uang_saku',
        'duit' => 'uang_saku',
        'cuan' => 'uang_saku',
        'fee' => 'uang_saku',
        'ongkos' => 'uang_saku',
        'transport' => 'uang_saku',
        'bensin' => 'uang_saku',
        'makan' => 'uang_saku',
        'mkn' => 'uang_saku',
        'mknan' => 'uang_saku',
        'konsumsi' => 'uang_saku',
        'konsum' => 'uang_saku',
        'snack' => 'uang_saku',
        'lunch' => 'uang_saku',

        // Topik Pendaftaran & Magang
        'internship' => 'magang',
        'pkl' => 'magang',
        'mgang' => 'magang',
        'praktik' => 'magang',
        'praktek' => 'magang',
        'pendaftaran' => 'daftar',
        'pndaftaran' => 'daftar',
        'daftar' => 'daftar',
        'daftr' => 'daftar',
        'dftr' => 'daftar',
        'register' => 'daftar',
        'registrasi' => 'daftar',
        'join' => 'daftar',
        'onlen' => 'daftar',
        'online' => 'daftar',

        // Topik Fasilitas & Sertifikat
        'sertifikat' => 'sertifikat',
        'sertif' => 'sertifikat',
        'srtfkat' => 'sertifikat',
        'sertipikat' => 'sertifikat',
        'ijazah' => 'sertifikat',
        'piagam' => 'sertifikat',
        'keuntungan' => 'fasilitas',
        'benefit' => 'fasilitas',
        
        // Topik Kantin, Makanan & Tempat Makan Sekitar
        'kantin' => 'kantin',
        'kntin' => 'kantin',
        'kanteen' => 'kantin',
        'tukang' => 'kantin',
        'pedagang' => 'kantin',
        'penjual' => 'kantin',
        'warung' => 'kantin',
        'warteg' => 'kantin',
        'resto' => 'kantin',
        'restoran' => 'kantin',
        'kuliner' => 'kantin',
        'lapar' => 'kantin',
        'laper' => 'kantin',
        'makan' => 'makan',
        'mkn' => 'makan',
        'makanan' => 'makan',
        'konsumsi' => 'makan',
        'konsum' => 'makan',
        'snack' => 'makan',
        'lunch' => 'makan',
        'deket' => 'alamat',
        'dekat' => 'alamat',
        'sekitar' => 'alamat',
        'sekitarnya' => 'alamat',
        'sana' => 'alamat',
        'sini' => 'alamat',
        
        // Kata Bantu / Verba Umum (Normalized to base)
        'dpt' => 'dapat',
        'dpet' => 'dapat',
        'dapet' => 'dapat',
        'dapetin' => 'dapat',
        'dapetkan' => 'dapat',
        'dptnya' => 'dapat',
        'nerima' => 'dapat',
        'peroleh' => 'dapat',
        'terima' => 'dapat',
        'disediakan' => 'dapat',
    ];

    // Substantive Keywords that carry heavy domain meaning
    protected array $substantiveKeywords = [
        'alamat', 'syarat', 'durasi', 'uang_saku', 'magang', 'daftar',
        'sertifikat', 'fasilitas', 'divisi', 'kuota', 'jam_kerja',
        'kontak', 'pakaian', 'kantin', 'makan'
    ];

    protected array $offTopicKeywords = [
        'kamu cantik', 'kamu ganteng', 'aku suka', 'punya pacar',
        'liburan', 'film', 'musik', 'game', 'mabar',
        'nonton', 'tidur', 'jalan', 'main', 'belanja', 'nama kamu',
        'resep', 'masak', 'bioskop', 'pacaran', 'jodoh', 'zodiak',
        'presiden', 'politik', 'cuaca', 'distro', 'mall', 'pasar'
    ];

    public function getResponse(string $userInput): array
    {
        $lowerInput = strtolower(trim($userInput));

        // 1. Cek Percakapan Umum / Basa-Basi (Sapaan, Terima Kasih, Identitas Bot, Pamitan)
        $conversationalResponse = $this->checkConversationalIntent($userInput);
        if ($conversationalResponse !== null) {
            return $conversationalResponse;
        }

        // 2. Cek Kata Kunci Di Luar Topik (Off-Topic Filter)
        foreach ($this->offTopicKeywords as $keyword) {
            if (str_contains($lowerInput, $keyword)) {
                return [
                    'status' => 'fallback',
                    'answer' => $this->getFallbackResponse(),
                    'category' => null,
                    'confidence' => 0,
                    'question_matched' => null
                ];
            }
        }

        $cleanTokens = $this->extractCanonicalTokens($userInput);
        Log::info('Chatbot Input:', ['original' => $userInput, 'tokens' => $cleanTokens]);
        
        // 3. Pencocokan Cerdas Terhadap Basis Pengetahuan (Knowledge Base)
        $bestMatch = $this->findBestMatch($cleanTokens, $userInput);

        if ($bestMatch) {
            Log::info('Chatbot Match:', [
                'question' => $bestMatch->question,
                'score' => $bestMatch->score ?? 0,
                'category' => $bestMatch->category
            ]);
            
            return [
                'status' => 'success',
                'answer' => $bestMatch->answer,
                'category' => $bestMatch->category,
                'confidence' => $bestMatch->confidence ?? 80,
                'question_matched' => $bestMatch->question
            ];
        }

        Log::info('Chatbot: No match found, using fallback');
        
        return [
            'status' => 'fallback',
            'answer' => $this->getFallbackResponse(),
            'category' => null,
            'confidence' => 0,
            'question_matched' => null
        ];
    }

    /**
     * Deteksi Conversational Intent (Sapaan, Ucapan Terima Kasih, Pengakuan/OK, Identitas Bot, Pamitan, Pujian)
     */
    protected function checkConversationalIntent(string $userInput): ?array
    {
        $clean = strtolower(trim(preg_replace('/[^a-zA-Z0-9\s]/', ' ', $userInput)));
        $clean = preg_replace('/\s+/', ' ', $clean);

        if (empty($clean)) {
            return null;
        }

        // Ekstraksi token untuk memastikan tidak ada pertanyaan substantif yang terpotong
        $tokens = $this->extractCanonicalTokens($userInput);
        $hasSubstantive = false;
        foreach ($tokens as $t) {
            if (in_array($t, $this->substantiveKeywords)) {
                $hasSubstantive = true;
                break;
            }
        }

        // Jika mengandung pertanyaan substantif magang (misal: "makasih min tapi syaratnya apa"),
        // lewati conversational intent dan teruskan ke Knowledge Base!
        if ($hasSubstantive) {
            return null;
        }

        // 1. Ucapan Terima Kasih (Gratitude: "oke terima kasih yak", "makasih min", "thanks ya", "trm ksh", dll.)
        if (preg_match('/\b(terima\s*kasih|terimakasih|trm\s*ksh|makasih|makasi|mksih|thanks|thank\s*you|thx|tengkyu|ty|matur\s*nuwun|syukron|hatur\s*nuhun|nuhun)\b/i', $clean)) {
            return [
                'status' => 'success',
                'answer' => "Sama-sama! 😊 Senang bisa membantu Anda.<br><br>Jika masih ada hal lain yang ingin ditanyakan seputar program magang di Diskominfosantik Kabupaten Bekasi, silakan ketik langsung ya. Semoga sukses selalu! 🚀",
                'category' => 'Ucapan Terima Kasih',
                'confidence' => 98,
                'question_matched' => 'Ungkapan Terima Kasih'
            ];
        }

        // 2. Identitas Bot & Kemampuan (Bot Persona / Capabilities: "kamu siapa", "kamu bot siapa", "bot apa ini", "bisa apa")
        if ((preg_match('/\b(siapa|bisa\s*apa|bantu\s*apa|tentang\s*bot|tugasmu)\b/i', $clean) && preg_match('/\b(kamu|bot|asisten|anda|sistem|lu)\b/i', $clean)) ||
            preg_match('/\b(siapa\s*kamu|kamu\s*siapa|nama\s*kamu|bot\s*apa)\b/i', $clean)) {
            return [
                'status' => 'success',
                'answer' => "Saya adalah <strong>Asisten Virtual SIMAGANG</strong> 🤖 milik Dinas Komunikasi, Informatika, dan Statistik (Diskominfosantik) Kabupaten Bekasi.<br><br>Tugas saya adalah menjawab pertanyaan seputar program kerja praktik/magang mahasiswa dan siswa SMK secara otomatis 24/7 menggunakan kecerdasan buatan pemrosesan bahasa alami (NLP).",
                'category' => 'Profil & Identitas Bot',
                'confidence' => 95,
                'question_matched' => 'Identitas Asisten Virtual'
            ];
        }

        // 3. Pujian & Apresiasi ("keren", "pinter banget", "hebat", "bagus", "mantap bot")
        if (preg_match('/\b(keren|hebat|pinter|pintar|smart|top)\b/i', $clean)) {
            return [
                'status' => 'success',
                'answer' => "Terima kasih banyak atas apresiasinya! 😊 Saya terus berusaha memberikan informasi yang cepat dan akurat seputar program magang Diskominfosantik. Ada hal lain yang ingin kamu ketahui?",
                'category' => 'Apresiasi & Pujian',
                'confidence' => 95,
                'question_matched' => 'Apresiasi Pengguna'
            ];
        }

        // 4. Ingin Bertanya / Pembuka Pertanyaan ("aku mau tnya", "mau nanya dong", "boleh tanya ga", "izin bertanya", "nanya dong", "tanya min")
        if (preg_match('/\b(tnya|tanya|nanya|bertanya|tny|tanya2|nanya2)\b/i', $clean) ||
            preg_match('/\b(mau|pengen|ingin|boleh|bisa|mo|izin|ijin|kalo|kalau)\s*(tnya|tanya|nanya|bertanya|tny)\b/i', $clean)) {
            return [
                'status' => 'success',
                'answer' => "Boleh banget! 😊 Silakan tanyakan apa saja yang ingin kamu ketahui seputar program magang di <strong>Diskominfosantik Kabupaten Bekasi</strong>, seperti:<br><br>• 📋 <strong>Persyaratan Berkas & Kriteria</strong><br>• 🔄 <strong>Alur & Prosedur Pendaftaran</strong><br>• ⏱️ <strong>Durasi Magang & Jam Kerja</strong><br>• 💼 <strong>Pilihan Divisi & Sisa Kuota</strong><br>• 🍱 <strong>Fasilitas, Kantin & Pakaian</strong><br><br>Ketik langsung pertanyaanmu ya, saya siap membantu! 💬",
                'category' => 'Bantuan Tanya Jawab',
                'confidence' => 98,
                'question_matched' => 'Permohonan Bertanya'
            ];
        }

        // 5. Persetujuan & Respon Positif ("oke", "siap min mantap", "baik", "sip", "noted", "paham", "mantul")
        if (preg_match('/\b(oke|ok|okey|okay|siap|baik|sip|noted|paham|ngerti|mantap|mantul)\b/i', $clean)) {
            return [
                'status' => 'success',
                'answer' => "Siap! 👍 Jika nanti butuh informasi lebih lanjut seputar program magang Diskominfosantik, jangan ragu untuk bertanya kembali ya. Semangat dan sukses selalu! 😊✨",
                'category' => 'Persetujuan & Respon',
                'confidence' => 98,
                'question_matched' => 'Konfirmasi Percakapan'
            ];
        }

        // 5. Sapaan / Greetings (halo, hai, assalamualaikum, selamat pagi, etc.)
        $greetings = [
            'halo', 'halo min', 'halo kak', 'halo admin', 'halo bot',
            'hai', 'hai min', 'hai kak', 'hai admin', 'hai bot',
            'hello', 'helo', 'hei', 'hey', 'hi',
            'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam',
            'pagi', 'siang', 'sore', 'malam',
            'assalamualaikum', 'assalamu alaikum', 'assalamu alaikuum', 'kulonuwun', 'permisi', 'punten',
            'tes', 'test', 'ping', 'p'
        ];

        $isGreetingPattern = in_array($clean, $greetings) || 
            preg_match('/^(halo|hai|hello|hei|hey|assalamu\s*alaikum|selamat\s*(pagi|siang|sore|malam)|permisi|punten)\b/i', $clean);

        if ($isGreetingPattern) {
            return [
                'status' => 'success',
                'answer' => "Halo! 👋 Selamat datang di Layanan Informasi <strong>SIMAGANG Diskominfosantik Kab. Bekasi</strong>.<br><br>Saya siap membantu Anda memberikan informasi resmi seputar:<br>• 📋 <strong>Persyaratan Pendaftaran & Berkas</strong><br>• 🔄 <strong>Alur & Prosedur Registrasi</strong><br>• ⏱️ <strong>Durasi & Waktu Pelaksanaan</strong><br>• 💼 <strong>Divisi yang Tersedia & Kuota</strong><br>• 🍱 <strong>Fasilitas, Kantin & Pakaian</strong><br><br>Silakan tanyakan langsung apa yang ingin Anda ketahui atau klik tombol opsi pertanyaan cepat di bawah ya! 😊",
                'category' => 'Sapaan & Bantuan',
                'confidence' => 98,
                'question_matched' => 'Sapaan / Salam Pembuka'
            ];
        }

        // 6. Pamitan / Closing (dadah, bye, sampai jumpa)
        $byePhrases = [
            'dadah', 'dadaah', 'bye', 'goodbye', 'sampai jumpa', 'selamat tinggal', 'pamit', 'bye bye'
        ];
        if (in_array($clean, $byePhrases) || preg_match('/\b(dadah|dadaah|bye\s*bye|sampai\s*jumpa|selamat\s*tinggal|pamit)\b/i', $clean)) {
            return [
                'status' => 'success',
                'answer' => "Sampai jumpa! 👋 Semoga harimu menyenangkan dan proses kegiatan magangmu di Diskominfosantik berjalan lancar!",
                'category' => 'Penutup / Pamitan',
                'confidence' => 95,
                'question_matched' => 'Salam Penutup'
            ];
        }

        return null;
    }

    /**
     * Tokenisasi & Normalisasi Kanonikal (Lemmatization Sederhana)
     */
    public function extractCanonicalTokens(string $text): array
    {
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        $words = array_filter(explode(' ', $text));
        $canonicalTokens = [];

        foreach ($words as $rawWord) {
            // Cek stopword terlebih dahulu
            if (in_array($rawWord, $this->stopwords)) {
                continue;
            }

            $word = $rawWord;
            // Normalisasi enclitic suffix Indonesia (-nya, -lah, -kah) jika memiliki bentuk dasar
            if (strlen($word) > 5 && (str_ends_with($word, 'nya') || str_ends_with($word, 'lah') || str_ends_with($word, 'kah'))) {
                $stripped = substr($word, 0, -3);
                if (isset($this->canonicalMap[$stripped]) || in_array($stripped, $this->substantiveKeywords)) {
                    $word = $stripped;
                }
            }

            // Normalisasi ke bentuk kata kanonikal jika ada di kamus
            if (isset($this->canonicalMap[$word])) {
                $canonicalTokens[] = $this->canonicalMap[$word];
            } else {
                $canonicalTokens[] = $word;
            }
        }

        return array_values(array_unique($canonicalTokens));
    }

    private function findBestMatch(array $inputTokens, string $originalInput): ?object
    {
        $knowledgeBase = KnowledgeBase::where('is_active', true)->get();

        if ($knowledgeBase->isEmpty() || empty($inputTokens)) {
            return null;
        }

        $bestMatch = null;
        $bestScore = 0;
        $inputTokensString = implode(' ', $inputTokens);

        foreach ($knowledgeBase as $item) {
            $kbTokens = $this->extractCanonicalTokens($item->question);
            if (empty($kbTokens)) {
                continue;
            }

            $kbTokensString = implode(' ', $kbTokens);

            // 1. Base String Similarity pada Canonical Representation
            similar_text($inputTokensString, $kbTokensString, $simPercent);
            $score = $simPercent * 0.5; // Max 50 pts

            // 2. Irisan Kata Kunci (Keyword Intersect)
            $commonTokens = array_intersect($inputTokens, $kbTokens);
            
            // Hitung bobot substantive vs generic helper verbs
            $substantiveMatchCount = 0;
            $genericMatchCount = 0;

            foreach ($commonTokens as $tok) {
                if (in_array($tok, $this->substantiveKeywords)) {
                    $substantiveMatchCount++;
                } else {
                    $genericMatchCount++;
                }
            }

            // Substantive keyword bernilai tinggi (+30 poin per kata kunci topik)
            $score += ($substantiveMatchCount * 30);
            
            // Helper verb (seperti 'dapat') bernilai kecil (+5 poin)
            $score += ($genericMatchCount * 5);

            // 3. Penalti proporsional jika input punya kata kunci substantif yang berbeda
            $inputSubstantive = array_intersect($inputTokens, $this->substantiveKeywords);
            $kbSubstantive = array_intersect($kbTokens, $this->substantiveKeywords);
            
            $unmatchedInputSubstantive = array_diff($inputSubstantive, $kbSubstantive);
            if (!empty($unmatchedInputSubstantive)) {
                if ($substantiveMatchCount === 0) {
                    $score -= (count($unmatchedInputSubstantive) * 20);
                } else {
                    $score -= (count($unmatchedInputSubstantive) * 5);
                }
            }

            // 4. Bonus jika semua kata kunci KB tercover oleh input
            if (!empty($kbSubstantive) && count(array_diff($kbSubstantive, $inputTokens)) === 0) {
                $score += 25;
            }

            // 5. Penalti khusus: Jika hanya helper verb 'dapat' yang cocok tanpa kata kunci topik lain
            if ($substantiveMatchCount === 0 && $genericMatchCount > 0) {
                $score = min($score, 35); // Batasi di bawah threshold
            }

            // Tambahkan bobot prioritas admin
            $score += ($item->priority ?? 0) * 3;

            if ($score > $bestScore) {
                $bestScore = $score;
                $bestMatch = $item;
                $bestMatch->score = $score;
                $bestMatch->confidence = min(max(round($score), 0), 100);
            }
        }

        // Thresholding: Hanya terima match jika skor >= 55% dan setidaknya ada relevansi substantif
        if ($bestScore < 55) {
            return null;
        }

        return $bestMatch;
    }

    private function getFallbackResponse(): string
    {
        return 'Maaf, saya tidak memahami maksud pertanyaan Anda. 🙏 Informasi yang Anda tanyakan belum tersedia di basis pengetahuan kami. Untuk informasi lebih lanjut, silakan hubungi admin kami di (021) 8895-1234 ext. 456 atau email ke magang@diskominfosantik.bekasikota.go.id.';
    }
}