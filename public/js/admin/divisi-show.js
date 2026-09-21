document.addEventListener('DOMContentLoaded', function() {
    // Animasi progress fill
    const progressFill = document.querySelector('.progress-fill');
    if (progressFill) {
        const width = progressFill.getAttribute('data-width') || '0';
        progressFill.style.width = '0%';
        setTimeout(() => {
            progressFill.style.width = Math.min(parseFloat(width), 100) + '%';
        }, 150);
    }
});