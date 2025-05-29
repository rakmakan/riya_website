/**
 * Handles reduced motion preference for animations
 * This helps with accessibility and battery life on mobile devices
 */
document.addEventListener('DOMContentLoaded', function() {
    // Check if the user prefers reduced motion
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    if (prefersReducedMotion) {
        // For canvas animation
        const canvas = document.getElementById('scatterCanvas');
        if (canvas) {
            // Apply reduced particle count and slower animations
            const canvasScript = document.createElement('script');
            canvasScript.innerHTML = `
                // Override particle count and animation settings for reduced motion
                if (typeof particles !== 'undefined') {
                    // Reduce particle count by 70%
                    const reducedCount = Math.floor(particleCount * 0.3);
                    particles.splice(reducedCount);
                    
                    // Slow down animation speed
                    particles.forEach(p => {
                        p.speedX *= 0.5;
                        p.speedY *= 0.5;
                    });
                }
            `;
            document.body.appendChild(canvasScript);
        }
        
        // For fade-in animations
        const fadeElements = document.querySelectorAll('.fade-in');
        fadeElements.forEach(el => {
            // Show elements immediately without animation
            el.style.transition = 'none';
            el.classList.add('visible');
        });
        
        // For AOS animations
        const aosElements = document.querySelectorAll('[data-aos]');
        aosElements.forEach(el => {
            el.removeAttribute('data-aos');
            el.removeAttribute('data-aos-delay');
            el.removeAttribute('data-aos-duration');
        });
    }
});
