document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.getElementById('menuToggle');
    const navbarMenu = document.getElementById('navbarMenu');
    const html = document.documentElement;
    
    if (menuToggle && navbarMenu) {
        menuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            navbarMenu.classList.toggle('active');
            menuToggle.innerHTML = navbarMenu.classList.contains('active') 
                ? '<i class="fas fa-times"></i>' 
                : '<i class="fas fa-bars"></i>';
        });
        
        document.addEventListener('click', function(e) {
            if (!navbarMenu.contains(e.target) && !menuToggle.contains(e.target)) {
                navbarMenu.classList.remove('active');
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                navbarMenu.classList.remove('active');
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
        
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                navbarMenu.classList.remove('active');
                menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
            }
        });
        
        if (window.innerWidth <= 768) {
            const navLinks = navbarMenu.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', function() {
                    navbarMenu.classList.remove('active');
                    menuToggle.innerHTML = '<i class="fas fa-bars"></i>';
                });
            });
        }
    }
    
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        const linkPath = link.getAttribute('href');
        if (linkPath === currentPath || 
            (linkPath !== '/' && currentPath.startsWith(linkPath))) {
            link.classList.add('active');
        } else {
            link.classList.remove('active');
        }
    });
    
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.attributeName === 'class') {
                if (navbarMenu && navbarMenu.classList.contains('active')) {
                    html.style.overflow = 'hidden';
                } else {
                    html.style.overflow = '';
                }
            }
        });
    });
    
    if (navbarMenu) {
        observer.observe(navbarMenu, { attributes: true });
    }
});