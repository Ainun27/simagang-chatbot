document.addEventListener('DOMContentLoaded', function() {
    // Counter animation untuk statistik
    const statNumbers = document.querySelectorAll('.stat-number');
    statNumbers.forEach(stat => {
        const finalValue = parseInt(stat.textContent);
        if (!isNaN(finalValue) && finalValue > 0) {
            let current = 0;
            const increment = finalValue / 100;
            const stepTime = 1500 / 100;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= finalValue) {
                    stat.textContent = finalValue.toLocaleString();
                    clearInterval(timer);
                } else {
                    stat.textContent = Math.floor(current).toLocaleString();
                }
            }, stepTime);
        }
    });
    
    // Progress bar animation
    const progressBars = document.querySelectorAll('.progress-fill');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });
    
    // Hover effect untuk cards
    const cards = document.querySelectorAll('.divisi-card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', () => { card.style.zIndex = '10'; });
        card.addEventListener('mouseleave', () => { card.style.zIndex = '1'; });
    });
});