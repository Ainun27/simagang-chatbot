function setExportAction(type) {
    const form = document.getElementById('formExport');
    if (!form) return;
    
    if (type === 'excel') {
        form.action = "/admin/laporan/export-excel";
    } else {
        form.action = "/admin/laporan/export-pdf";
    }
    
    form.submit();
}

// Auto close alert jika ada (opsional)
document.addEventListener('DOMContentLoaded', function() {
    // Event listener untuk tombol export dengan enter key
    const form = document.getElementById('formExport');
    if (form) {
        form.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                const excelBtn = document.querySelector('.btn-excel');
                if (excelBtn) {
                    setExportAction('excel');
                }
            }
        });
    }
});