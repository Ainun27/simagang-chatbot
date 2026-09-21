/**
 * Evaluasi Chatbot AI Dashboard - Interactivity & Real-time Benchmark Engine
 * SIMAGANG - Sistem Informasi Manajemen Magang Diskominfosantik
 */

document.addEventListener('DOMContentLoaded', function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    // -------------------------------------------------------------
    // 1. Quick Sample Prompt Fillers
    // -------------------------------------------------------------
    const samplePills = document.querySelectorAll('.sample-pill');
    const testQueryInput = document.getElementById('testQueryInput');
    const singleTestForm = document.getElementById('singleTestForm');
    const btnTestQuery = document.getElementById('btnTestQuery');
    const inspectorResult = document.getElementById('inspectorResult');

    samplePills.forEach(pill => {
        pill.addEventListener('click', function () {
            if (testQueryInput) {
                testQueryInput.value = this.innerText.replace(/"/g, '').trim();
                testQueryInput.focus();
                // Trigger live test directly on click
                if (singleTestForm) {
                    singleTestForm.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
                }
            }
        });
    });

    // -------------------------------------------------------------
    // 2. Single Query Realtime Inspector (AJAX Test)
    // -------------------------------------------------------------
    if (singleTestForm) {
        singleTestForm.addEventListener('submit', async function (e) {
            e.preventDefault();
            const query = (testQueryInput ? testQueryInput.value : '').trim();
            if (!query) return;

            const originalBtnHtml = btnTestQuery ? btnTestQuery.innerHTML : 'Uji Kalimat';
            if (btnTestQuery) {
                btnTestQuery.disabled = true;
                btnTestQuery.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menguji...';
            }

            try {
                const response = await fetch('/evaluasi-chatbot/test-single', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ question: query })
                });

                const data = await response.json();

                if (data.status === 'success') {
                    renderSingleResult(data);
                } else {
                    alert('Gagal menguji kalimat: ' + (data.message || 'Terjadi kesalahan sistem'));
                }
            } catch (err) {
                console.error('Test Single Query Error:', err);
                alert('Terjadi kesalahan jaringan saat menguji kalimat pertanyaan.');
            } finally {
                if (btnTestQuery) {
                    btnTestQuery.disabled = false;
                    btnTestQuery.innerHTML = originalBtnHtml;
                }
            }
        });
    }

    function renderSingleResult(res) {
        if (!inspectorResult) return;
        inspectorResult.style.display = 'block';

        const isMatched = res.bot_status === 'success';
        const confidence = parseFloat(res.confidence || 0);

        // Status Badge
        const statusBadge = document.getElementById('inspStatusBadge');
        const statusText = document.getElementById('inspStatusText');
        if (statusBadge && statusText) {
            if (isMatched) {
                statusBadge.className = 'result-status-badge status-badge-matched';
                statusBadge.innerHTML = `<i class="fas fa-check-circle"></i> <span id="inspStatusText">MATCHED (${confidence}%)</span>`;
            } else {
                statusBadge.className = 'result-status-badge status-badge-fallback';
                statusBadge.innerHTML = `<i class="fas fa-exclamation-triangle"></i> <span id="inspStatusText">FALLBACK RESPONSE</span>`;
            }
        }

        // Execution time
        const execTimeEl = document.getElementById('inspExecutionTime');
        if (execTimeEl) execTimeEl.innerText = res.latency_ms + ' ms';

        // Answer & Metadata
        const answerEl = document.getElementById('inspAnswerText');
        if (answerEl) answerEl.innerHTML = nl2br(escapeHtml(res.bot_answer));

        const categoryEl = document.getElementById('inspCategory');
        if (categoryEl) categoryEl.innerText = res.bot_category;

        const confEl = document.getElementById('inspConfidence');
        if (confEl) confEl.innerText = confidence + '%';

        // Token list
        const tokensList = document.getElementById('inspTokensList');
        if (tokensList) {
            if (res.tokens && res.tokens.length > 0) {
                tokensList.innerHTML = res.tokens.map(t => `<span class="tag-chip">${escapeHtml(t)}</span>`).join('');
            } else {
                tokensList.innerHTML = '<span class="text-muted font-italic text-sm">Tidak ada token</span>';
            }
        }

        // Keywords list
        const keywordsList = document.getElementById('inspKeywordsList');
        if (keywordsList) {
            if (res.keywords && res.keywords.length > 0) {
                keywordsList.innerHTML = res.keywords.map(k => `<span class="tag-chip tag-keyword">${escapeHtml(k)}</span>`).join('');
            } else {
                keywordsList.innerHTML = '<span class="text-muted font-italic text-sm">Tidak ada kata kunci khusus</span>';
            }
        }

        // Top matches
        const topMatchesEl = document.getElementById('inspTopMatches');
        if (topMatchesEl) {
            if (res.top_matches && res.top_matches.length > 0) {
                let html = '';
                res.top_matches.forEach(item => {
                    const pct = parseFloat(item.similarity_percent || 0);
                    let scoreClass = 'score-low';
                    if (pct >= 55) scoreClass = 'score-high';
                    else if (pct >= 30) scoreClass = 'score-medium';

                    html += `
                        <div class="match-item">
                            <div>
                                <div class="match-question">${escapeHtml(item.question)}</div>
                                <small class="text-muted">${escapeHtml(item.category)}</small>
                            </div>
                            <span class="match-score ${scoreClass}">${pct}%</span>
                        </div>
                    `;
                });
                topMatchesEl.innerHTML = html;
            } else {
                topMatchesEl.innerHTML = '<span class="text-muted font-italic">Tidak ada data kemiripan.</span>';
            }
        }

        // Smooth scroll to result
        inspectorResult.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    // -------------------------------------------------------------
    // 3. Batch Benchmark Re-Run (AJAX Benchmark)
    // -------------------------------------------------------------
    const btnRerunBenchmark = document.getElementById('btnRerunBenchmark');
    if (btnRerunBenchmark) {
        btnRerunBenchmark.addEventListener('click', async function () {
            const originalBtnHtml = btnRerunBenchmark.innerHTML;
            btnRerunBenchmark.disabled = true;
            btnRerunBenchmark.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Menghitung Benchmark...';

            try {
                const response = await fetch('/evaluasi-chatbot/run-benchmark', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (data.status === 'success') {
                    updateDashboardMetrics(data.data);
                    renderBenchmarkTable(data.data.details);
                } else {
                    alert('Gagal menjalankan benchmark otomatis.');
                }
            } catch (err) {
                console.error('Benchmark Error:', err);
                alert('Terjadi kesalahan koneksi saat menjalankan benchmark.');
            } finally {
                btnRerunBenchmark.disabled = false;
                btnRerunBenchmark.innerHTML = originalBtnHtml;
            }
        });
    }

    function updateDashboardMetrics(metrics) {
        // KPI values
        updateText('metricAccuracy', metrics.accuracy + '%');
        updateText('metricPrecision', metrics.precision + '%');
        updateText('metricRecall', metrics.recall + '%');
        updateText('metricF1', metrics.f1_score + '%');

        // Progress bars
        updateWidth('.bar-accuracy', metrics.accuracy + '%');
        updateWidth('.bar-precision', metrics.precision + '%');
        updateWidth('.bar-recall', metrics.recall + '%');
        updateWidth('.bar-f1', metrics.f1_score + '%');

        // Confusion Matrix
        updateText('matTP', metrics.confusion_matrix.tp);
        updateText('matFN', metrics.confusion_matrix.fn);
        updateText('matFP', metrics.confusion_matrix.fp);
        updateText('matTN', metrics.confusion_matrix.tn);
    }

    function renderBenchmarkTable(details) {
        const tbody = document.getElementById('benchmarkTableBody');
        if (!tbody) return;

        let html = '';
        details.forEach(item => {
            const rowClass = item.is_correct ? 'row-valid' : 'row-invalid';
            const catSlug = slugify(item.category_type);
            const statusClass = item.bot_status === 'success' ? 'badge-matched' : 'badge-fallback';
            const statusIcon = item.bot_status === 'success' ? 'fa-check' : 'fa-reply';
            const classPill = 'pill-' + item.classification.toLowerCase();

            html += `
                <tr data-category="${escapeHtml(item.category_type)}" class="${rowClass}">
                    <td class="text-center font-mono">${item.id}</td>
                    <td>
                        <span class="scenario-badge badge-${catSlug}">${escapeHtml(item.category_type)}</span>
                    </td>
                    <td>
                        <div class="test-query-text">${escapeHtml(item.question)}</div>
                        <small class="text-muted">${escapeHtml(item.description)}</small>
                    </td>
                    <td>
                        <span class="expected-badge">${escapeHtml(item.expected_category)}</span>
                    </td>
                    <td>
                        <div class="bot-category-badge ${statusClass}">
                            <i class="fas ${statusIcon}"></i>
                            ${escapeHtml(item.bot_category)}
                        </div>
                        ${item.matched_question !== '-' ? `<small class="matched-subtext"><i class="fas fa-link"></i> ${escapeHtml(item.matched_question)}</small>` : ''}
                    </td>
                    <td class="text-center font-mono font-bold">${item.confidence}%</td>
                    <td class="text-center font-mono text-muted">${item.latency_ms} ms</td>
                    <td class="text-center">
                        <span class="matrix-pill ${classPill}">${item.classification}</span>
                    </td>
                    <td class="text-center">
                        ${item.is_correct
                            ? `<span class="verif-icon icon-success" title="Sesuai Target"><i class="fas fa-check-circle"></i> Sesuai</span>`
                            : `<span class="verif-icon icon-danger" title="Tidak Sesuai Target"><i class="fas fa-times-circle"></i> Meleset</span>`
                        }
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
        applyActiveFilter();
    }

    // -------------------------------------------------------------
    // 4. Scenario Category Filtering
    // -------------------------------------------------------------
    const filterButtons = document.querySelectorAll('.filter-pill');
    let currentFilter = 'all';

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            currentFilter = this.getAttribute('data-filter');
            applyActiveFilter();
        });
    });

    function applyActiveFilter() {
        const rows = document.querySelectorAll('#benchmarkTableBody tr');
        rows.forEach(row => {
            const rowCat = row.getAttribute('data-category');
            if (currentFilter === 'all' || rowCat === currentFilter) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // -------------------------------------------------------------
    // Utility Helpers
    // -------------------------------------------------------------
    function updateText(id, text) {
        const el = document.getElementById(id);
        if (el) el.innerText = text;
    }

    function updateWidth(selector, width) {
        const el = document.querySelector(selector);
        if (el) el.style.width = width;
    }

    function escapeHtml(str) {
        if (!str) return '';
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(str));
        return div.innerHTML;
    }

    function nl2br(str) {
        return str.replace(/\n/g, '<br>');
    }

    function slugify(text) {
        return text.toString().toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    }
});
