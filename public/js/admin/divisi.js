document.addEventListener('DOMContentLoaded', function() {
    // Auto dismiss alerts
    setTimeout(() => {
        const alerts = document.querySelectorAll('.alert-dashboard');
        alerts.forEach(alert => {
            alert.style.transition = 'opacity 0.4s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 400);
        });
    }, 5000);
    
    // Close alert
    document.querySelectorAll('.close-alert').forEach(button => {
        button.addEventListener('click', function() {
            const alert = this.closest('.alert-dashboard');
            alert.style.transition = 'opacity 0.4s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 400);
        });
    });
    
    // Progress bar animation
    document.querySelectorAll('.progress-bar').forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.width = width;
        }, 300);
    });
    
    // Divisi avatar hover effect
    document.querySelectorAll('.divisi-avatar').forEach(avatar => {
        avatar.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.1)';
        });
        avatar.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
});