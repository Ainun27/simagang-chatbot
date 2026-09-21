document.addEventListener('DOMContentLoaded', function() {
    // ELEMENTS
    const nimInput = document.getElementById('nim');
    const emailInput = document.getElementById('email');
    const btnSubmit = document.getElementById('btnSubmit');
    const divisiSelect = document.getElementById('divisi_id');
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const masaMagangText = document.getElementById('masa-magang-text');
    const statusOtomatis = document.getElementById('status-otomatis');

    let nimTimeout = null;
    let emailTimeout = null;

    // =============== CEK NIM UNIK (AJAX) ===============
    if (nimInput) {
        nimInput.addEventListener('keyup', function() {
            const nim = this.value.trim();
            const nimError = document.getElementById('nim_error');
            
            if (nim.length < 3) {
                if (nimError) nimError.style.display = 'none';
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }

            if (nimTimeout) clearTimeout(nimTimeout);
            
            nimTimeout = setTimeout(() => {
                fetch(`/admin/mahasiswa/cek-nim?nim=${encodeURIComponent(nim)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            if (nimError) {
                                nimError.style.display = 'block';
                                nimError.innerHTML = '<i class="fas fa-exclamation-circle"></i> NIM "' + nim + '" sudah ada! Gunakan NIM lain.';
                                nimError.style.background = '#fee2e2';
                                nimError.style.padding = '0.5rem';
                                nimError.style.borderRadius = '8px';
                            }
                            if (btnSubmit) {
                                btnSubmit.disabled = true;
                                btnSubmit.style.opacity = '0.5';
                                btnSubmit.style.cursor = 'not-allowed';
                            }
                        } else {
                            if (nimError) nimError.style.display = 'none';
                            if (btnSubmit) {
                                btnSubmit.disabled = false;
                                btnSubmit.style.opacity = '1';
                                btnSubmit.style.cursor = 'pointer';
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 500);
        });
    }

    // =============== CEK EMAIL UNIK (AJAX) ===============
    if (emailInput) {
        emailInput.addEventListener('keyup', function() {
            const email = this.value.trim();
            const emailError = document.getElementById('email_error');
            
            if (email.length < 5) {
                if (emailError) emailError.style.display = 'none';
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }

            if (emailTimeout) clearTimeout(emailTimeout);
            
            emailTimeout = setTimeout(() => {
                fetch(`/admin/mahasiswa/cek-email?email=${encodeURIComponent(email)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists) {
                            if (emailError) {
                                emailError.style.display = 'block';
                                emailError.innerHTML = '<i class="fas fa-exclamation-circle"></i> Email "' + email + '" sudah ada! Gunakan email lain.';
                                emailError.style.background = '#fee2e2';
                                emailError.style.padding = '0.5rem';
                                emailError.style.borderRadius = '8px';
                            }
                            if (btnSubmit) {
                                btnSubmit.disabled = true;
                                btnSubmit.style.opacity = '0.5';
                                btnSubmit.style.cursor = 'not-allowed';
                            }
                        } else {
                            if (emailError) emailError.style.display = 'none';
                            if (btnSubmit) {
                                btnSubmit.disabled = false;
                                btnSubmit.style.opacity = '1';
                                btnSubmit.style.cursor = 'pointer';
                            }
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }, 500);
        });
    }

    // =============== SHOW DIVISI INFO ===============
    if (divisiSelect) {
        divisiSelect.addEventListener('change', function() {
            const option = this.options[this.selectedIndex];
            const infoDiv = document.getElementById('divisi-info');
            
            if (this.value) {
                const kuotaNum = parseInt(kuota) || 0;
                const terisiNum = parseInt(terisi) || 0;
                const sisaNum = parseInt(sisa) || 0;
                const persentase = kuotaNum > 0 ? (terisiNum / kuotaNum) * 100 : 0;
                
                let isPenuh = sisaNum <= 0;
                let isHampirPenuh = !isPenuh && terisiNum > 0 && (persentase >= 75 || (sisaNum <= 2 && persentase >= 50));
                
                let statusColor = isPenuh ? 'text-danger' : (isHampirPenuh ? 'text-warning' : 'text-success');
                let statusBadgeClass = isPenuh ? 'badge-danger' : (isHampirPenuh ? 'badge-warning' : 'badge-success');
                let statusText = isPenuh ? 'Penuh' : (isHampirPenuh ? 'Hampir Penuh' : 'Tersedia');
                let sisaIcon = isPenuh ? 'fa-ban' : (isHampirPenuh ? 'fa-exclamation-triangle' : 'fa-chair');
                let namaDivisi = option.text.split(' - ')[0].trim();
                
                infoDiv.innerHTML = `
                    <div class="divisi-info-card">
                        <div class="divisi-info-header">
                            <div class="divisi-info-title">
                                <i class="fas fa-building"></i>
                                <span>${namaDivisi}</span>
                            </div>
                            <span class="divisi-info-tag"><i class="fas fa-info-circle"></i> Info Kuota Divisi</span>
                        </div>
                        <div class="divisi-info-stats">
                            <div class="divisi-stat-box box-total">
                                <span class="stat-box-label"><i class="fas fa-users"></i> Total Kuota</span>
                                <div class="stat-box-value">${kuota} <small class="unit-text">Mahasiswa</small></div>
                            </div>
                            <div class="divisi-stat-box box-terisi">
                                <span class="stat-box-label"><i class="fas fa-user-check"></i> Terisi (Aktif)</span>
                                <div class="stat-box-value text-terisi">${terisi} <small class="unit-text">Mahasiswa</small></div>
                            </div>
                            <div class="divisi-stat-box ${sisa > 0 ? 'box-sisa-avail' : 'box-sisa-full'}">
                                <span class="stat-box-label"><i class="fas ${sisaIcon}"></i> Sisa Kuota</span>
                                <div class="stat-box-value ${statusColor}">
                                    ${sisa}
                                    <span class="stat-pill ${statusBadgeClass}">${statusText}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                infoDiv.style.display = 'block';
            } else {
                infoDiv.style.display = 'none';
            }
        });
        // Trigger change if has value
        if (divisiSelect.value) {
            divisiSelect.dispatchEvent(new Event('change'));
        }
    }

    // =============== HITUNG MASA MAGANG ===============
    function hitungMasaMagang() {
        if (!tanggalMulai || !tanggalSelesai) return;
        
        const tglMulai = tanggalMulai.value;
        const tglSelesai = tanggalSelesai.value;
        
        if (tglMulai && tglSelesai) {
            const mulai = new Date(tglMulai);
            const selesai = new Date(tglSelesai);
            
            if (selesai <= mulai) {
                if (masaMagangText) {
                    masaMagangText.textContent = 'Tanggal tidak valid!';
                    masaMagangText.style.color = '#ef4444';
                }
                if (statusOtomatis) {
                    statusOtomatis.innerHTML = '<i class="fas fa-times-circle"></i> Error';
                    statusOtomatis.className = 'badge-status inactive';
                }
                return;
            }
            
            // Hitung selisih hari
            const selisihHari = Math.floor((selesai - mulai) / (1000 * 60 * 60 * 24));
            
            // Format durasi
            let durasiText = '';
            if (selisihHari >= 30) {
                const bulan = Math.floor(selisihHari / 30);
                const hariSisa = selisihHari % 30;
                durasiText = hariSisa > 0 ? `${bulan} bulan ${hariSisa} hari` : `${bulan} bulan`;
            } else {
                durasiText = `${selisihHari} hari`;
            }
            
            if (masaMagangText) {
                masaMagangText.textContent = durasiText;
                masaMagangText.style.color = '#10b981';
            }
            
            // Update status
            const sekarang = new Date();
            if (selesai < sekarang) {
                if (statusOtomatis) {
                    statusOtomatis.innerHTML = '<i class="fas fa-times-circle"></i> Nonaktif (Otomatis)';
                    statusOtomatis.className = 'badge-status inactive';
                }
            } else if (selesai.toDateString() === sekarang.toDateString()) {
                if (statusOtomatis) {
                    statusOtomatis.innerHTML = '<i class="fas fa-clock"></i> Hari Terakhir';
                    statusOtomatis.className = 'badge-status warning';
                }
            } else {
                const sisaHari = Math.floor((selesai - sekarang) / (1000 * 60 * 60 * 24));
                if (sisaHari <= 7) {
                    if (statusOtomatis) {
                        statusOtomatis.innerHTML = `<i class="fas fa-clock"></i> Sisa ${sisaHari} hari`;
                        statusOtomatis.className = 'badge-status warning';
                    }
                } else {
                    if (statusOtomatis) {
                        statusOtomatis.innerHTML = '<i class="fas fa-check-circle"></i> Aktif';
                        statusOtomatis.className = 'badge-status active';
                    }
                }
            }
        } else {
            if (masaMagangText) {
                masaMagangText.textContent = '-';
                masaMagangText.style.color = '#6b7280';
            }
            if (statusOtomatis) {
                statusOtomatis.innerHTML = '<i class="fas fa-info-circle"></i> Belum diatur';
                statusOtomatis.className = 'badge-status warning';
                statusOtomatis.style.backgroundColor = '#fef3c7';
            }
        }
    }

    if (tanggalMulai) tanggalMulai.addEventListener('change', hitungMasaMagang);
    if (tanggalSelesai) tanggalSelesai.addEventListener('change', hitungMasaMagang);
    
    // Initial call
    hitungMasaMagang();

    // =============== VALIDASI SEBELUM SUBMIT ===============
    const form = document.getElementById('mahasiswaForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            if (tanggalMulai && tanggalSelesai) {
                const mulai = new Date(tanggalMulai.value);
                const selesai = new Date(tanggalSelesai.value);
                
                if (selesai <= mulai) {
                    e.preventDefault();
                    alert('Tanggal selesai harus setelah tanggal mulai!');
                    if (tanggalSelesai) tanggalSelesai.focus();
                }
            }
        });
    }
});