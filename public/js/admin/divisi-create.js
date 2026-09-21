document.addEventListener('DOMContentLoaded', function() {
    // Elements
    const namaDivisi = document.getElementById('nama_divisi');
    const namaError = document.getElementById('nama_error');
    const btnSubmit = document.getElementById('btnSubmit');
    const deskripsi = document.getElementById('deskripsi');
    const kuota = document.getElementById('kuota');
    const previewNama = document.getElementById('preview-nama');
    const previewDeskripsi = document.getElementById('preview-deskripsi');
    const previewKuota = document.getElementById('preview-kuota');

    // CEK NAMA DIVISI (AJAX)
    let timeoutId = null;
    
    if (namaDivisi) {
        namaDivisi.addEventListener('keyup', function() {
            const nama = this.value.trim();
            
            if (nama.length < 2) {
                if (namaError) {
                    namaError.style.display = 'none';
                }
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }

            // Debounce untuk mengurangi request
            if (timeoutId) clearTimeout(timeoutId);
            
            timeoutId = setTimeout(() => {
                fetch(`/admin/divisi/cek-nama?nama=${encodeURIComponent(nama)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            if (namaError) {
                                namaError.style.display = 'block';
                                namaError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Nama "' + nama + '" sudah ada! Gunakan nama lain.';
                                namaError.style.background = '#fee2e2';
                                namaError.style.padding = '0.5rem';
                                namaError.style.borderRadius = '8px';
                                namaError.style.color = '#dc2626';
                            }
                            if (btnSubmit) {
                                btnSubmit.disabled = true;
                                btnSubmit.style.opacity = '0.5';
                                btnSubmit.style.cursor = 'not-allowed';
                            }
                        } else {
                            if (namaError) {
                                namaError.style.display = 'none';
                            }
                            if (btnSubmit) {
                                btnSubmit.disabled = false;
                                btnSubmit.style.opacity = '1';
                                btnSubmit.style.cursor = 'pointer';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (btnSubmit) {
                            btnSubmit.disabled = false;
                        }
                    });
            }, 500);
        });
    }

    // LIVE PREVIEW
    function updatePreview() {
        if (previewNama && namaDivisi) {
            previewNama.textContent = namaDivisi.value.trim() || '-';
        }
        
        if (deskripsi && previewDeskripsi) {
            let descText = deskripsi.value.trim();
            if (descText.length > 60) {
                descText = descText.substring(0, 60) + '...';
            }
            previewDeskripsi.textContent = descText || '-';
        }
        
        if (kuota && previewKuota) {
            previewKuota.textContent = kuota.value ? kuota.value + ' Mahasiswa' : '-';
        }
    }

    if (namaDivisi) namaDivisi.addEventListener('input', updatePreview);
    if (deskripsi) deskripsi.addEventListener('input', updatePreview);
    if (kuota) kuota.addEventListener('input', updatePreview);
    updatePreview();
});