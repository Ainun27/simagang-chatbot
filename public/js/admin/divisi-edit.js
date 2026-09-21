document.addEventListener('DOMContentLoaded', function() {
    // ELEMENTS
    const namaDivisi = document.getElementById('nama_divisi');
    const btnSubmit = document.getElementById('btnSubmit');
    const currentNama = namaDivisi ? namaDivisi.value : '';
    let namaTimeout = null;

    // =============== CEK NAMA DIVISI UNIK (AJAX) - EDIT ===============
    if (namaDivisi) {
        namaDivisi.addEventListener('keyup', function() {
            const nama = this.value.trim();
            const namaError = document.getElementById('nama_error');
            
            // Skip jika nama tidak berubah (sama dengan nama lama)
            if (nama === currentNama) {
                if (namaError) namaError.style.display = 'none';
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }
            
            if (nama.length < 2) {
                if (namaError) namaError.style.display = 'none';
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }

            if (namaTimeout) clearTimeout(namaTimeout);
            
            namaTimeout = setTimeout(() => {
                fetch(`/admin/divisi/cek-nama?nama=${encodeURIComponent(nama)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            if (namaError) {
                                namaError.style.display = 'block';
                                namaError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Nama "' + nama + '" sudah ada! Gunakan nama lain.';
                            }
                            if (btnSubmit) {
                                btnSubmit.disabled = true;
                                btnSubmit.style.opacity = '0.5';
                                btnSubmit.style.cursor = 'not-allowed';
                            }
                        } else {
                            if (namaError) namaError.style.display = 'none';
                            if (btnSubmit) {
                                btnSubmit.disabled = false;
                                btnSubmit.style.opacity = '1';
                                btnSubmit.style.cursor = 'pointer';
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        if (btnSubmit) btnSubmit.disabled = false;
                    });
            }, 500);
        });
    }

    // =============== VALIDASI KUOTA ===============
    const kuotaInput = document.getElementById('kuota');
    const minKuota = kuotaInput ? parseInt(kuotaInput.getAttribute('min')) : 0;
    
    if (kuotaInput && minKuota > 0) {
        kuotaInput.addEventListener('change', function() {
            const value = parseInt(this.value);
            if (value < minKuota) {
                alert('Kuota tidak boleh kurang dari ' + minKuota + ' karena sudah ada mahasiswa terdaftar!');
                this.value = minKuota;
            }
        });
    }
});