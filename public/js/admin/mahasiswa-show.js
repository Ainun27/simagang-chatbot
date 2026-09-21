document.addEventListener('DOMContentLoaded', function() {
    // Animasi untuk stat-card saat di-hover (opsional)
    const statCards = document.querySelectorAll('.stat-card');
    statCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.transition = 'all 0.3s ease';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Animasi untuk info-card-detail
    const infoCards = document.querySelectorAll('.info-card-detail');
    infoCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
            this.style.transition = 'all 0.3s ease';
        });
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
    
    // Tooltip untuk encrypted badge (opsional)
    const encryptedBadges = document.querySelectorAll('.encrypted-badge');
    encryptedBadges.forEach(badge => {
        badge.addEventListener('mouseenter', function() {
            this.style.backgroundColor = '#c7d2fe';
            this.style.transition = 'all 0.3s ease';
        });
        badge.addEventListener('mouseleave', function() {
            this.style.backgroundColor = '#e0e7ff';
        });
    });
});