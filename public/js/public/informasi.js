function createParticles() {
    const container = document.getElementById('bgParticles');
    if (!container) return;
    const particleCount = 15;
    for (let i = 0; i < particleCount; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        const size = Math.random() * 150 + 50;
        const posX = Math.random() * 100;
        const posY = Math.random() * 100;
        const duration = Math.random() * 30 + 20;
        const delay = Math.random() * 10;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        particle.style.left = `${posX}%`;
        particle.style.top = `${posY}%`;
        particle.style.animation = `float ${duration}s linear ${delay}s infinite`;
        container.appendChild(particle);
    }
}

function toggleFAQ(item) {
    const isActive = item.classList.contains('active');
    document.querySelectorAll('.faq-item').forEach(faq => {
        faq.classList.remove('active');
    });
    if (!isActive) {
        item.classList.add('active');
    }
}

function setupMobileMenu() {
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarMenu = document.getElementById('navbarMenu');
    if (navbarToggle && navbarMenu) {
        navbarToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navbarMenu.classList.toggle('active');
            const icon = this.querySelector('i');
            if (navbarMenu.classList.contains('active')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-times');
            } else {
                icon.classList.remove('fa-times');
                icon.classList.add('fa-bars');
            }
        });
        document.addEventListener('click', function(event) {
            if (navbarToggle && navbarMenu && !navbarToggle.contains(event.target) && !navbarMenu.contains(event.target)) {
                navbarMenu.classList.remove('active');
                const icon = navbarToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
        navbarMenu.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                navbarMenu.classList.remove('active');
                const icon = navbarToggle.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            });
        });
    }
}

function setupSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId !== '#') {
                e.preventDefault();
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            }
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    createParticles();
    setupMobileMenu();
    setupSmoothScroll();
});