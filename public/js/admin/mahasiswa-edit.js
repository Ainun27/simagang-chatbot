document.addEventListener('DOMContentLoaded', function() {
    // ELEMENTS
    const nimInput = document.getElementById('nim');
    const emailInput = document.getElementById('email');
    const btnSubmit = document.getElementById('btnSubmit');
    const divisiSelect = document.getElementById('divisi_id');
    const tanggalMulai = document.getElementById('tanggal_mulai');
    const tanggalSelesai = document.getElementById('tanggal_selesai');
    const masaMagangText = document.getElementById('masa-magang-text');
    const form = document.getElementById('mahasiswaForm');
    const currentNim = nimInput ? nimInput.value : '';
    const currentEmail = emailInput ? emailInput.value : '';

    // TOGGLE ELEMENTS
    const statusToggle = document.getElementById('is_active_toggle');
    const statusCard = document.getElementById('statusCard');
    const statusIcon = document.getElementById('statusIcon');
    const statusBadgePill = document.getElementById('statusBadgePill');
    const statusBadgeIcon = document.getElementById('statusBadgeIcon');
    const statusBadgeText = document.getElementById('statusBadgeText');
    const statusDesc = document.getElementById('statusDesc');

    let nimTimeout = null;
    let emailTimeout = null;

    // =============== STATUS TOGGLE INTERACTION ===============
    if (statusToggle) {
        statusToggle.addEventListener('change', function() {
            const isActive = this.checked;

            if (isActive) {
                if (statusCard) {
                    statusCard.classList.remove('card-inactive');
                    statusCard.classList.add('card-active');
                }
                if (statusIcon) {
                    statusIcon.className = 'fas fa-user-check';
                }
                if (statusBadgePill) {
                    statusBadgePill.className = 'badge-status-pill active';
                }
                if (statusBadgeIcon) {
                    statusBadgeIcon.className = 'fas fa-check-circle';
                }
                if (statusBadgeText) {
                    statusBadgeText.textContent = 'AKTIF';
                }
                if (statusDesc) {
                    statusDesc.innerHTML = 'Mahasiswa berstatus <strong>Aktif</strong> menjalani magang dan menggunakan kuota divisi.';
                }
            } else {
                if (statusCard) {
                    statusCard.classList.remove('card-active');
                    statusCard.classList.add('card-inactive');
                }
                if (statusIcon) {
                    statusIcon.className = 'fas fa-user-slash';
                }
                if (statusBadgePill) {
                    statusBadgePill.className = 'badge-status-pill inactive';
                }
                if (statusBadgeIcon) {
                    statusBadgeIcon.className = 'fas fa-times-circle';
                }
                if (statusBadgeText) {
                    statusBadgeText.textContent = 'NONAKTIF';
                }
                if (statusDesc) {
                    statusDesc.innerHTML = 'Mahasiswa berstatus <strong>Nonaktif</strong> (keluar/berhenti/selesai) dan kuota divisi dibebaskan.';
                }
            }
        });
    }

    // =============== CEK NIM UNIK (AJAX) - EDIT ===============
    if (nimInput) {
        nimInput.addEventListener('keyup', function() {
            const nim = this.value.trim();
            const nimError = document.getElementById('nim_error');
            
            // Skip jika NIM tidak berubah
            if (nim === currentNim) {
                if (nimError) nimError.style.display = 'none';
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }
            
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
                                nimError.style.color = '#dc2626';
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

    // =============== CEK EMAIL UNIK (AJAX) - EDIT ===============
    if (emailInput) {
        emailInput.addEventListener('keyup', function() {
            const email = this.value.trim();
            const emailError = document.getElementById('email_error');
            
            // Skip jika email tidak berubah
            if (email === currentEmail) {
                if (emailError) emailError.style.display = 'none';
                if (btnSubmit) {
                    btnSubmit.disabled = false;
                    btnSubmit.style.opacity = '1';
                    btnSubmit.style.cursor = 'pointer';
                }
                return;
            }
            
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
                    masaMagangText.textContent = 'Tanggal selesai harus setelah tanggal mulai!';
                    masaMagangText.style.color = '#ef4444';
                }
                return;
            }
            
            const selisihHari = Math.floor((selesai - mulai) / (1000 * 60 * 60 * 24));
            
            let durasiText = '';
            if (selisihHari >= 30) {
                const bulan = Math.floor(selisihHari / 30);
                const hariSisa = selisihHari % 30;
                durasiText = hariSisa > 0 ? `${bulan} bulan ${hariSisa} hari (${selisihHari} hari)` : `${bulan} bulan (${selisihHari} hari)`;
            } else {
                durasiText = `${selisihHari} hari`;
            }
            
            if (masaMagangText) {
                masaMagangText.textContent = durasiText;
                masaMagangText.style.color = '#4338ca';
            }
        } else {
            if (masaMagangText) {
                masaMagangText.textContent = '-';
                masaMagangText.style.color = '#64748b';
            }
        }
    }

    if (tanggalMulai) tanggalMulai.addEventListener('change', hitungMasaMagang);
    if (tanggalSelesai) tanggalSelesai.addEventListener('change', hitungMasaMagang);
    hitungMasaMagang();

    // =============== VALIDASI SEBELUM SUBMIT ===============
    if (form) {
        form.addEventListener('submit', function(e) {
            if (tanggalMulai && tanggalSelesai) {
                const mulai = new Date(tanggalMulai.value);
                const selesai = new Date(tanggalSelesai.value);
                
                if (selesai <= mulai) {
                    e.preventDefault();
                    alert('Tanggal selesai harus setelah tanggal mulai!');
                    if (tanggalSelesai) tanggalSelesai.focus();
                    return false;
                }
            }
            
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.style.borderColor = '#ef4444';
                    field.focus();
                } else {
                    field.style.borderColor = '#cbd5e1';
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Harap lengkapi semua field yang wajib diisi!');
                return false;
            }
            
            return true;
        });
    }
});