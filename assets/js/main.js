// Verify main.js is loading
console.log('main.js is loaded');

// Initialize AOS with optimal settings
function initAOS() {
    AOS.init({
        duration: 800,
        easing: 'ease-out',
        once: true,
        offset: 50,
        delay: 0,
        mirror: false,
        anchorPlacement: 'top-bottom',
        disable: function() {
            return window.innerWidth < 768;
        }
    });
}

// Counter animation for statistics
function animateCounter(element, target) {
    let current = 0;
    const increment = target / 50; // Adjust speed here
    const timer = setInterval(() => {
        current += increment;
        if (current >= target) {
            clearInterval(timer);
            current = target;
        }
        element.textContent = Math.round(current);
    }, 30);
}

// Initialize counters when they come into view
const counterObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const target = parseInt(entry.target.getAttribute('data-target'));
            animateCounter(entry.target, target);
            counterObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

// Dark Mode Implementation
function initDarkMode() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    const body = document.body;
    
    // Check for saved theme preference
    const savedTheme = localStorage.getItem('theme');
    
    // Apply saved theme or system preference
    if (savedTheme === 'dark') {
        body.setAttribute('data-theme', 'dark');
        darkModeToggle.innerHTML = '☀️';
    } else {
        body.removeAttribute('data-theme');
        darkModeToggle.innerHTML = '🌙';
    }

    // Toggle theme when button is clicked
    darkModeToggle.addEventListener('click', () => {
        if (body.getAttribute('data-theme') === 'dark') {
            body.removeAttribute('data-theme');
            darkModeToggle.innerHTML = '🌙';
            localStorage.setItem('theme', 'light');
        } else {
            body.setAttribute('data-theme', 'dark');
            darkModeToggle.innerHTML = '☀️';
            localStorage.setItem('theme', 'dark');
        }
    });
}

// Main initialization when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize dark mode
    initDarkMode();
    
    const navbar = document.querySelector('.navbar');
    const navLinks = document.querySelectorAll('.nav-link');
    const heroSection = document.querySelector('.hero-section');

    // Add shadow to navbar on scroll
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            navbar.classList.add('shadow-sm');
        } else {
            navbar.classList.remove('shadow-sm');
        }
    });

    // Observe counter elements after DOM is loaded
    document.querySelectorAll('.counter').forEach(counter => {
        counterObserver.observe(counter);
    });

    // Smooth scroll for navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            // Only handle same-page anchor links
            if (href.startsWith('#')) {
                e.preventDefault();
                const targetSection = document.querySelector(href);
                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    // Initialize carousel if it exists
    const carousel = document.getElementById('caseStudyCarousel');
    if (carousel) {
        new bootstrap.Carousel(carousel, {
            interval: 5000,
            wrap: true
        });
    }

    // Initialize navbar behavior
    if (heroSection) {
        const heroObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (!entry.isIntersecting) {
                    navbar.classList.add('navbar-scrolled');
                } else {
                    navbar.classList.remove('navbar-scrolled');
                }
            });
        }, { threshold: 0.1 });
        
        heroObserver.observe(heroSection);
    }

    // Animate skill bars
    const skillBars = document.querySelectorAll('.progress-bar');
    const skillObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const width = entry.target.getAttribute('aria-valuenow') + '%';
                entry.target.style.width = width;
            }
        });
    }, { threshold: 0.2 });

    skillBars.forEach(bar => skillObserver.observe(bar));

    // Add animation classes to elements
    const animatedElements = document.querySelectorAll('.service-card, .case-study-card, .review-card');
    animatedElements.forEach((element, index) => {
        element.setAttribute('data-aos', 'fade-up');
        element.setAttribute('data-aos-delay', (index * 100).toString());
        element.style.opacity = '0';
    });

    // Initialize AOS after everything is set up
    window.addEventListener('load', () => {
        // Short delay to ensure all elements are properly laid out
        setTimeout(initAOS, 100);
        
        // Make elements visible after AOS is initialized
        animatedElements.forEach(element => {
            element.style.opacity = '';
        });
    });

    // Add hover effect to service icons
    const serviceIcons = document.querySelectorAll('.service-icon');
    serviceIcons.forEach(icon => {
        icon.addEventListener('mouseover', function() {
            this.style.transform = 'rotate(0deg) scale(1.1)';
        });
        icon.addEventListener('mouseout', function() {
            this.style.transform = 'rotate(-5deg) scale(1)';
        });
    });
});

// Orbit Animation Control
document.addEventListener('DOMContentLoaded', () => {
    const orbitalContainer = document.querySelector('.orbital-container');
    if (!orbitalContainer) return;

    // Pause animations on hover
    orbitalContainer.addEventListener('mouseenter', () => {
        document.querySelectorAll('.orbit').forEach(orbit => {
            orbit.style.animationPlayState = 'paused';
        });
    });

    orbitalContainer.addEventListener('mouseleave', () => {
        document.querySelectorAll('.orbit').forEach(orbit => {
            orbit.style.animationPlayState = 'running';
        });
    });

    // Calculate and set orbital tag positions
    const orbitTags = document.querySelectorAll('.orbital-tag');
    orbitTags.forEach((tag, index) => {
        const angle = (360 / orbitTags.length) * index;
        const orbit = tag.closest('.orbit');
        const radius = orbit.offsetWidth / 2;
        
        // Position tags along their orbits
        const x = Math.cos((angle * Math.PI) / 180) * radius;
        const y = Math.sin((angle * Math.PI) / 180) * radius;
        tag.style.transform = `translate(${x}px, ${y}px)`;
    });

    // Mobile responsive checks
    const checkMobile = () => {
        if (window.innerWidth <= 768) {
            document.querySelectorAll('.orbit').forEach(orbit => {
                orbit.style.animation = 'none';
            });
            
            // Stack orbital tags vertically
            orbitTags.forEach((tag, index) => {
                tag.style.transform = 'none';
                tag.style.opacity = '0';
                setTimeout(() => {
                    tag.style.opacity = '1';
                }, index * 200);
            });
        } else {
            document.querySelectorAll('.orbit').forEach(orbit => {
                orbit.style.animation = '';
            });
        }
    };

    // Check on load and resize
    checkMobile();
    window.addEventListener('resize', checkMobile);
});

// Smooth scroll for navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth'
            });
        }
    });
});