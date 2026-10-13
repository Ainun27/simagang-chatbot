<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Evaluasi & Uji Kinerja Chatbot AI - SIMAGANG</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Fira+Code:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- KaTeX for Scientific Math Formula Rendering -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/katex.min.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/katex@0.16.8/dist/contrib/auto-render.min.js"></script>

    <!-- Evaluasi CSS -->
    <link rel="stylesheet" href="{{ asset('css/evaluasi.css') }}">
</head>
<body>

    <!-- Header Navigation -->
    <header class="eval-navbar no-print">
        <div class="eval-nav-container">
            <div class="eval-brand">
                <div class="eval-brand-icon">
                    <i class="fas fa-robot"></i>
                </div>
                <div>
                    <h1 class="eval-brand-title">SIMAGANG &bull; AI Evaluation Lab</h1>
                    <p class="eval-brand-sub">Instrumen Pengujian Akurasi & Kinerja Chatbot NLP (Skripsi)</p>
                </div>
            </div>
            <div class="eval-nav-actions">
                <a href="{{ route('public.divisi') }}" class="btn-nav btn-outline">
                    <i class="fas fa-home"></i> Beranda Publik
                </a>
                <a href="{{ route('public.chatbot') }}" class="btn-nav btn-outline" target="_blank">
                    <i class="fas fa-comments"></i> Buka Chatbot
                </a>
                <button onclick="window.print()" class="btn-nav btn-print">
                    <i class="fas fa-print"></i> Cetak Laporan (PDF)
                </button>
            </div>
        </div>
    </header>

    <main class="eval-main-container">
        
        <!-- Hero Banner -->
        <section class="eval-hero-card">
            <div class="hero-content">
                <div class="hero-tag">
                    <i class="fas fa-microscope"></i> Laboratorium Pengujian Model NLP
                </div>
                <h2 class="hero-title">Dashboard Evaluasi Kinerja Chatbot Cerdas</h2>
                <p class="hero-desc">
                    Instrumen pengujian empiris untuk mengukur tingkat akurasi (<em>Accuracy</em>), presisi (<em>Precision</em>), perolehan kembali (<em>Recall</em>), <em>F1-Score</em>, dan kecepatan respon (<em>Latency</em>) sistem tanya jawab otomatis berbasis pencocokan kemiripan teks (<em>String Similarity & Keyword Extraction</em>).
                </p>
                <div class="hero-badges">
                    <span class="hero-pill"><i class="fas fa-database"></i> {{ $totalKb }} Dataset Knowledge Base</span>
                    <span class="hero-pill"><i class="fas fa-vial"></i> {{ $benchmarkResults['total_tests'] }} Skenario Uji Standar</span>
                    <span class="hero-pill"><i class="fas fa-bolt"></i> Rata-rata Latensi: {{ $benchmarkResults['avg_latency_ms'] }} ms</span>
                    <span class="hero-pill"><i class="fas fa-clock"></i> Terakhir Diuji: {{ $benchmarkResults['evaluated_at'] }}</span>
                </div>
            </div>
        </section>

        <!-- KPI Metrics Grid -->
        <section class="eval-metrics-grid">
            <!-- Metric 1: Accuracy -->
            <div class="eval-metric-card border-accuracy">
                <div class="metric-top">
                    <span class="metric-label">Tingkat Akurasi (Accuracy)</span>
                    <span class="metric-icon-wrap icon-accuracy"><i class="fas fa-bullseye"></i></span>
                </div>
                <div class="metric-value-row">
                    <span class="metric-main-val" id="metricAccuracy">{{ $benchmarkResults['accuracy'] }}%</span>
                    <span class="metric-grade-pill grade-excellent">Sangat Baik</span>
                </div>
                <div class="metric-formula-text">
                    Formula: (TP + TN) / Total Kasus Uji
                </div>
                <div class="metric-progress-track">
                    <div class="metric-progress-bar bar-accuracy" style="width: {{ $benchmarkResults['accuracy'] }}%;"></div>
                </div>
            </div>

            <!-- Metric 2: Precision -->
            <div class="eval-metric-card border-precision">
                <div class="metric-top">
                    <span class="metric-label">Presisi (Precision)</span>
                    <span class="metric-icon-wrap icon-precision"><i class="fas fa-crosshairs"></i></span>
                </div>
                <div class="metric-value-row">
                    <span class="metric-main-val" id="metricPrecision">{{ $benchmarkResults['precision'] }}%</span>
                    <span class="metric-grade-pill grade-good">Tinggi</span>
                </div>
                <div class="metric-formula-text">
                    Formula: TP / (TP + FP)
                </div>
                <div class="metric-progress-track">
                    <div class="metric-progress-bar bar-precision" style="width: {{ $benchmarkResults['precision'] }}%;"></div>
                </div>
            </div>

            <!-- Metric 3: Recall -->
            <div class="eval-metric-card border-recall">
                <div class="metric-top">
                    <span class="metric-label">Sensitivitas (Recall)</span>
                    <span class="metric-icon-wrap icon-recall"><i class="fas fa-filter"></i></span>
                </div>
                <div class="metric-value-row">
                    <span class="metric-main-val" id="metricRecall">{{ $benchmarkResults['recall'] }}%</span>
                    <span class="metric-grade-pill grade-good">Tinggi</span>
                </div>
                <div class="metric-formula-text">
                    Formula: TP / (TP + FN)
                </div>
                <div class="metric-progress-track">
                    <div class="metric-progress-bar bar-recall" style="width: {{ $benchmarkResults['recall'] }}%;"></div>
                </div>
            </div>

            <!-- Metric 4: F1-Score -->
            <div class="eval-metric-card border-f1">
                <div class="metric-top">
                    <span class="metric-label">F1-Score</span>
                    <span class="metric-icon-wrap icon-f1"><i class="fas fa-balance-scale"></i></span>
                </div>
                <div class="metric-value-row">
                    <span class="metric-main-val" id="metricF1">{{ $benchmarkResults['f1_score'] }}%</span>
                    <span class="metric-grade-pill grade-excellent">Seimbang</span>
                </div>
                <div class="metric-formula-text">
                    Formula: 2 &times; (P &times; R) / (P + R)
                </div>
                <div class="metric-progress-track">
                    <div class="metric-progress-bar bar-f1" style="width: {{ $benchmarkResults['f1_score'] }}%;"></div>
                </div>
            </div>
        </section>

        <!-- NLP Methodology & Pipeline Section -->
        <section class="eval-section-card">
            <div class="section-card-header">
                <div class="section-title-wrap">
                    <i class="fas fa-project-diagram"></i>
                    <div>
                        <h3 class="section-title">Alur Kerja (Flowchart) Pemrosesan Teks & Natural Language Processing</h3>
                        <p class="section-subtitle">Tahapan transformasi teks dari input pengguna hingga pencocokan jawaban pada basis pengetahuan</p>
                    </div>
                </div>
            </div>
            <div class="section-card-body">
                <div class="pipeline-grid">
                    <div class="pipeline-step">
                        <div class="step-num">1</div>
                        <div class="step-icon"><i class="fas fa-keyboard"></i></div>
                        <h4 class="step-title">Input Pertanyaan</h4>
                        <p class="step-desc">Pengguna memasukkan kalimat pertanyaan bebas melalui antarmuka chat.</p>
                    </div>
                    <div class="pipeline-arrow"><i class="fas fa-arrow-right"></i></div>
                    
                    <div class="pipeline-step">
                        <div class="step-num">2</div>
                        <div class="step-icon"><i class="fas fa-broom"></i></div>
                        <h4 class="step-title">Text Preprocessing</h4>
                        <p class="step-desc">Case Folding (huruf kecil), pembersihan tanda baca & karakter khusus non-alfanumerik.</p>
                    </div>
                    <div class="pipeline-arrow"><i class="fas fa-arrow-right"></i></div>

                    <div class="pipeline-step">
                        <div class="step-num">3</div>
                        <div class="step-icon"><i class="fas fa-filter"></i></div>
                        <h4 class="step-title">Stopwords & Sinonim</h4>
                        <p class="step-desc">Penyeragaman istilah kanonikal dan penghapusan kata umum (stopwords) yang tidak membawa bobot informasi.</p>
                    </div>
                    <div class="pipeline-arrow"><i class="fas fa-arrow-right"></i></div>

                    <div class="pipeline-step">
                        <div class="step-num">4</div>
                        <div class="step-icon"><i class="fas fa-calculator"></i></div>
                        <h4 class="step-title">Character Bigram & Dice</h4>
                        <p class="step-desc">Ekstraksi pasangan 2-karakter unik dan perhitungan Sørensen-Dice: <em>2|A &cap; B| / (|A| + |B|)</em>.</p>
                    </div>
                    <div class="pipeline-arrow"><i class="fas fa-arrow-right"></i></div>

                    <div class="pipeline-step">
                        <div class="step-num">5</div>
                        <div class="step-icon"><i class="fas fa-check-double"></i></div>
                        <h4 class="step-title">Evaluasi Threshold</h4>
                        <p class="step-desc">Jika skor kemiripan &ge; 60% &rarr; Berikan Jawaban. Jika skor &lt; 60% &rarr; Alihkan ke Fallback Cerdas.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Confusion Matrix & Formula Details -->
        <section class="eval-two-col-grid">
            <!-- Left: Confusion Matrix -->
            <div class="eval-section-card">
                <div class="section-card-header">
                    <div class="section-title-wrap">
                        <i class="fas fa-table-cells-large"></i>
                        <div>
                            <h3 class="section-title">Matriks Kebingungan (Confusion Matrix)</h3>
                            <p class="section-subtitle">Distribusi hasil klasifikasi aktual vs prediksi sistem ({{ $benchmarkResults['total_tests'] }} Sampel)</p>
                        </div>
                    </div>
                </div>
                <div class="section-card-body">
                    <div class="confusion-matrix-table-wrap">
                        <table class="confusion-table">
                            <thead>
                                <tr>
                                    <th colspan="2" rowspan="2" class="diagonal-header">
                                        <span class="diag-actual">Aktual &darr;</span>
                                        <span class="diag-pred">Prediksi &rarr;</span>
                                    </th>
                                    <th colspan="2" class="text-center group-header">Hasil Prediksi Chatbot</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Positif (Topik Magang)</th>
                                    <th class="text-center">Negatif (Di Luar Topik)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th rowspan="2" class="group-header">Kelas Aktual</th>
                                    <th class="row-header">Positif (Topik Magang)</th>
                                    <td class="cell-matrix cell-tp">
                                        <div class="matrix-code">True Positive (TP)</div>
                                        <div class="matrix-num" id="matTP">{{ $benchmarkResults['confusion_matrix']['tp'] }}</div>
                                        <small>Pertanyaan Magang terjawab TEPAT</small>
                                    </td>
                                    <td class="cell-matrix cell-fn">
                                        <div class="matrix-code">False Negative (FN)</div>
                                        <div class="matrix-num" id="matFN">{{ $benchmarkResults['confusion_matrix']['fn'] }}</div>
                                        <small>Pertanyaan Magang keliru masuk Fallback</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="row-header">Negatif (Di Luar Topik)</th>
                                    <td class="cell-matrix cell-fp">
                                        <div class="matrix-code">False Positive (FP)</div>
                                        <div class="matrix-num" id="matFP">{{ $benchmarkResults['confusion_matrix']['fp'] }}</div>
                                        <small>Pertanyaan Luar Topik salah dicocokkan</small>
                                    </td>
                                    <td class="cell-matrix cell-tn">
                                        <div class="matrix-code">True Negative (TN)</div>
                                        <div class="matrix-num" id="matTN">{{ $benchmarkResults['confusion_matrix']['tn'] }}</div>
                                        <small>Pertanyaan Luar Topik dialihkan ke Fallback</small>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Formula Cards -->
            <div class="eval-section-card">
                <div class="section-card-header">
                    <div class="section-title-wrap">
                        <i class="fas fa-square-root-variable"></i>
                        <div>
                            <h3 class="section-title">Rumus Evaluasi & Metrik Kinerja</h3>
                            <p class="section-subtitle">Rumus standar akademik untuk Bab 3 & Bab 4 Skripsi</p>
                        </div>
                    </div>
                </div>
                <div class="section-card-body">
                    <div class="formula-list">
                        <!-- Formula 1: Accuracy -->
                        <div class="formula-box">
                            <div class="formula-head">
                                <strong>1. Akurasi (Accuracy Rate)</strong>
                                <span class="formula-badge">Total Kebenaran</span>
                            </div>
                            <div class="formula-math">
                                $$\text{Accuracy} = \frac{TP + TN}{TP + TN + FP + FN} \times 100\%$$
                            </div>
                            <div class="formula-calc-sub">
                                <span class="calc-label">Substitusi Data Riil:</span>
                                <code class="calc-val">\frac{ {{ $benchmarkResults['confusion_matrix']['tp'] }} + {{ $benchmarkResults['confusion_matrix']['tn'] }} }{ {{ $benchmarkResults['total_tests'] }} } \times 100\% = <strong class="text-success">{{ $benchmarkResults['accuracy'] }}%</strong></code>
                            </div>
                            <p class="formula-desc">Mengukur rasio total prediksi yang benar (baik topik magang maupun luar topik) terhadap total keseluruhan pengujian.</p>
                        </div>

                        <!-- Formula 2: Precision -->
                        <div class="formula-box">
                            <div class="formula-head">
                                <strong>2. Presisi (Precision)</strong>
                                <span class="formula-badge">Ketepatan Positif</span>
                            </div>
                            <div class="formula-math">
                                $$\text{Precision} = \frac{TP}{TP + FP} \times 100\%$$
                            </div>
                            <div class="formula-calc-sub">
                                <span class="calc-label">Substitusi Data Riil:</span>
                                <code class="calc-val">\frac{ {{ $benchmarkResults['confusion_matrix']['tp'] }} }{ {{ $benchmarkResults['confusion_matrix']['tp'] }} + {{ $benchmarkResults['confusion_matrix']['fp'] }} } \times 100\% = <strong class="text-success">{{ $benchmarkResults['precision'] }}%</strong></code>
                            </div>
                            <p class="formula-desc">Mengukur ketepatan sistem dalam mengenali pertanyaan topik magang tanpa salah mencocokkan pertanyaan luar topik.</p>
                        </div>

                        <!-- Formula 3: Recall -->
                        <div class="formula-box">
                            <div class="formula-head">
                                <strong>3. Sensitivitas (Recall)</strong>
                                <span class="formula-badge">Daya Jangkau</span>
                            </div>
                            <div class="formula-math">
                                $$\text{Recall} = \frac{TP}{TP + FN} \times 100\%$$
                            </div>
                            <div class="formula-calc-sub">
                                <span class="calc-label">Substitusi Data Riil:</span>
                                <code class="calc-val">\frac{ {{ $benchmarkResults['confusion_matrix']['tp'] }} }{ {{ $benchmarkResults['confusion_matrix']['tp'] }} + {{ $benchmarkResults['confusion_matrix']['fn'] }} } \times 100\% = <strong class="text-success">{{ $benchmarkResults['recall'] }}%</strong></code>
                            </div>
                            <p class="formula-desc">Mengukur kemampuan sistem dalam menemukan dan menjawab seluruh pertanyaan topik magang yang diajukan.</p>
                        </div>

                        <!-- Formula 4: F1-Score -->
                        <div class="formula-box">
                            <div class="formula-head">
                                <strong>4. F1-Score</strong>
                                <span class="formula-badge">Rata-rata Harmonik</span>
                            </div>
                            <div class="formula-math">
                                $$F_1 = 2 \times \frac{\text{Precision} \times \text{Recall}}{\text{Precision} + \text{Recall}}$$
                            </div>
                            <div class="formula-calc-sub">
                                <span class="calc-label">Substitusi Data Riil:</span>
                                <code class="calc-val">2 \times \frac{ {{ $benchmarkResults['precision'] }}\% \times {{ $benchmarkResults['recall'] }}\% }{ {{ $benchmarkResults['precision'] }}\% + {{ $benchmarkResults['recall'] }}\% } = <strong class="text-success">{{ $benchmarkResults['f1_score'] }}%</strong></code>
                            </div>
                            <p class="formula-desc">Keseimbangan harmonik antara Presisi dan Recall ketika distribusi dataset pengujian bervariasi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Live Single Query Inspector (Simulator) -->
        <section class="eval-section-card no-print">
            <div class="section-card-header">
                <div class="section-title-wrap">
                    <i class="fas fa-terminal"></i>
                    <div>
                        <h3 class="section-title">Simulator Pengujian Kalimat Bebas (Single Query Inspector)</h3>
                        <p class="section-subtitle">Ketik pertanyaan apa saja untuk melihat proses kalkulasi similarity dan waktu komputasi secara transparan</p>
                    </div>
                </div>
            </div>
            <div class="section-card-body">
                <!-- Quick sample prompts -->
                <div class="sample-queries-wrap">
                    <span class="sample-queries-label"><i class="fas fa-lightbulb"></i> Contoh Cepat:</span>
                    <button type="button" class="sample-pill">Dapet uang saku ga min pas magang?</button>
                    <button type="button" class="sample-pill">Apa saja syarat daftar magang disini?</button>
                    <button type="button" class="sample-pill">Berapa lama periode pelaksanaan magang?</button>
                    <button type="button" class="sample-pill">Lokasi kantor Diskominfosantik dimana?</button>
                    <button type="button" class="sample-pill">Mau nonton film bioskop apa yang seru?</button>
                </div>

                <form id="singleTestForm" class="inspector-form">
                    <div class="inspector-input-group">
                        <input type="text" id="testQueryInput" name="query" class="inspector-input" placeholder="Ketik pertanyaan untuk diuji (contoh: Dapet uang saku ga min pas magang disini?)..." required>
                        <button type="submit" class="btn-inspect" id="btnTestQuery">
                            <i class="fas fa-play"></i> Uji Kalimat
                        </button>
                    </div>
                </form>

                <!-- Inspector Result Area -->
                <div id="inspectorResult" class="inspector-result-card" style="display: none;">
                    <div class="inspector-result-header">
                        <div class="result-status-badge" id="inspStatusBadge">
                            <i class="fas fa-check-circle"></i> <span id="inspStatusText">MATCHED</span>
                        </div>
                        <div class="result-time-badge">
                            <i class="fas fa-stopwatch"></i> Waktu Eksekusi: <strong id="inspExecutionTime">0.00 ms</strong>
                        </div>
                    </div>

                    <div class="inspector-grid">
                        <div class="insp-col">
                            <label class="insp-label"><i class="fas fa-comment-dots"></i> Respon Chatbot:</label>
                            <div class="insp-answer-box" id="inspAnswerText">-</div>
                            <div class="insp-meta-row">
                                <span>Kategori: <strong id="inspCategory">-</strong></span>
                                <span>Tingkat Keyakinan: <strong id="inspConfidence">0%</strong></span>
                            </div>

                            <div class="insp-pipeline-tags">
                                <div class="tag-row">
                                    <span class="tag-label">Token Hasil Parsing:</span>
                                    <div id="inspTokensList" class="tags-flex"></div>
                                </div>
                                <div class="tag-row">
                                    <span class="tag-label">Kata Kunci Terfilter:</span>
                                    <div id="inspKeywordsList" class="tags-flex"></div>
                                </div>
                            </div>
                        </div>

                        <div class="insp-col">
                            <label class="insp-label"><i class="fas fa-chart-simple"></i> Top 5 Skor Kemiripan Terhadap Knowledge Base:</label>
                            <div class="top-matches-list" id="inspTopMatches">
                                <!-- Populated dynamically -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Detailed Benchmark Table -->
        <section class="eval-section-card">
            <div class="section-card-header">
                <div class="section-title-wrap">
                    <i class="fas fa-list-check"></i>
                    <div>
                        <h3 class="section-title">Tabel Hasil Pengujian {{ $benchmarkResults['total_tests'] }} Skenario Dataset Akademik</h3>
                        <p class="section-subtitle">Daftar uji empiris multi-kategori (Formal, Bahasa Gaul, Typo, Singkat, dan Di Luar Topik)</p>
                    </div>
                </div>
                <div class="section-actions no-print">
                    <button class="btn-run-benchmark" id="btnRerunBenchmark">
                        <i class="fas fa-sync-alt"></i> Jalankan Ulang Pengujian
                    </button>
                </div>
            </div>

            <div class="section-card-body">
                <!-- Filter category tabs -->
                <div class="table-filter-pills no-print">
                    <button class="filter-pill active" data-filter="all">Semua Skenario ({{ $benchmarkResults['total_tests'] }})</button>
                    @foreach($benchmarkResults['by_variation'] as $varName => $varData)
                    <button class="filter-pill" data-filter="{{ $varName }}">{{ $varName }} ({{ $varData['total'] }})</button>
                    @endforeach
                </div>

                <div class="eval-table-wrap">
                    <table class="eval-table" id="benchmarkTable">
                        <thead>
                            <tr>
                                <th style="width: 50px;" class="text-center">No</th>
                                <th>Tipe Skenario</th>
                                <th>Kalimat Pertanyaan Pengujian</th>
                                <th>Kategori Target</th>
                                <th>Hasil Respon Chatbot</th>
                                <th class="text-center">Keyakinan</th>
                                <th class="text-center">Latensi</th>
                                <th class="text-center">Matriks</th>
                                <th class="text-center">Validasi</th>
                            </tr>
                        </thead>
                        <tbody id="benchmarkTableBody">
                            @foreach($benchmarkResults['details'] as $item)
                            <tr data-category="{{ $item['category_type'] }}" class="{{ $item['is_correct'] ? 'row-valid' : 'row-invalid' }}">
                                <td class="text-center font-mono">{{ $item['id'] }}</td>
                                <td>
                                    <span class="scenario-badge badge-{{ Str::slug($item['category_type']) }}">
                                        {{ $item['category_type'] }}
                                    </span>
                                </td>
                                <td>
                                    <div class="test-query-text">{{ $item['question'] }}</div>
                                    <small class="text-muted">{{ $item['description'] }}</small>
                                </td>
                                <td>
                                    <span class="expected-badge">{{ $item['expected_category'] }}</span>
                                </td>
                                <td>
                                    <div class="bot-category-badge {{ $item['bot_status'] === 'success' ? 'badge-matched' : 'badge-fallback' }}">
                                        <i class="fas {{ $item['bot_status'] === 'success' ? 'fa-check' : 'fa-reply' }}"></i>
                                        {{ $item['bot_category'] }}
                                    </div>
                                    @if($item['matched_question'] !== '-')
                                    <small class="matched-subtext"><i class="fas fa-link"></i> {{ $item['matched_question'] }}</small>
                                    @endif
                                </td>
                                <td class="text-center font-mono font-bold">
                                    {{ $item['confidence'] }}%
                                </td>
                                <td class="text-center font-mono text-muted">
                                    {{ $item['latency_ms'] }} ms
                                </td>
                                <td class="text-center">
                                    <span class="matrix-pill pill-{{ strtolower($item['classification']) }}">
                                        {{ $item['classification'] }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @if($item['is_correct'])
                                        <span class="verif-icon icon-success" title="Sesuai Target"><i class="fas fa-check-circle"></i> Sesuai</span>
                                    @else
                                        <span class="verif-icon icon-danger" title="Tidak Sesuai Target"><i class="fas fa-times-circle"></i> Meleset</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Academic Footer / Lampiran Note -->
        <footer class="eval-footer">
            <div class="eval-footer-content">
                <div>
                    <h4>Lampiran Resmi Pengujian Perangkat Lunak</h4>
                    <p>Sistem Informasi Manajemen Magang (SIMAGANG) Diskominfosantik &bull; Modul Natural Language Processing</p>
                </div>
                <div class="footer-sign">
                    <span>Dokumen Pengujian Terstandarisasi</span>
                    <strong>Laboratorium Informatika Diskominfosantik</strong>
                </div>
            </div>
        </footer>
    </main>

    <!-- KaTeX Auto-Render Initializer -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            if (typeof renderMathInElement === 'function') {
                renderMathInElement(document.body, {
                    delimiters: [
                        {left: '$$', right: '$$', display: true},
                        {left: '$', right: '$', display: false},
                        {left: '\\(', right: '\\)', display: false},
                        {left: '\\[', right: '\\]', display: true}
                    ],
                    throwOnError: false
                });
            }
        });
    </script>

    <!-- JavaScript -->
    <script src="{{ asset('js/evaluasi.js') }}"></script>
</body>
</html>
