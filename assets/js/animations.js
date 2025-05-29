/**
 * Airy Alps Animation Enhancements
 * This script handles animation interactions and accessibility features for the About page
 * 
 * Key Features:
 * - Detects and respects user preferences for reduced motion
 * - Adds interactive hover effects to animated elements
 * - Triggers animations based on scroll position
 * - Ensures animations are accessible with proper ARIA attributes
 * - Creates synchronized effects between different animation types
 * 
 * Animation Types:
 * 1. Heartbeat Animation - Used for key headings to show care
 * 2. Pen Animation - Used for important text to show intentionality
 * 3. SVG Animations - Decorative elements that enhance visual appeal
 */

document.addEventListener('DOMContentLoaded', () => {
    // Check for reduced motion preference
    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    
    // Heartbeat animation control for accessibility
    const heartbeatElements = document.querySelectorAll('.heartbeat-animation');
    
    // Disable animations if user prefers reduced motion
    if (prefersReducedMotion) {
        heartbeatElements.forEach(element => {
            element.style.animation = 'none';
        });
        
        // Also disable pen animations
        document.querySelectorAll('.pen-animation').forEach(el => {
            el.style.animation = 'none';
        });
        
        // Disable floating shape animations
        document.querySelectorAll('.floating-shape').forEach(shape => {
            shape.style.animation = 'none';
        });
    } else {
        // Add interactive features for the heartbeat element
        heartbeatElements.forEach(element => {
            // Pause animation on hover for a more intentional interaction
            element.addEventListener('mouseenter', () => {
                // Save current animation state
                element.dataset.originalAnimation = element.style.animation;
                // Gently grow and add glow on hover
                element.style.animation = 'none';
                element.style.transform = 'scale(1.05)';
                element.style.textShadow = '0 0 10px rgba(224, 122, 95, 0.3)';
                element.style.transition = 'transform 0.5s ease, text-shadow 0.5s ease';
                
                // Create ripple effect by interacting with nearby SVG elements
                const nearbyShapes = document.querySelectorAll('.floating-shape');
                nearbyShapes.forEach(shape => {
                    // Temporarily increase animation duration to create a ripple effect
                    shape.style.animationDuration = '2s';
                    shape.style.animationTimingFunction = 'ease-out';
                    
                    // Reset after interaction
                    setTimeout(() => {
                        shape.style.animationDuration = '';
                        shape.style.animationTimingFunction = '';
                    }, 2000);
                });
            });
            
            // Resume animation on mouse leave
            element.addEventListener('mouseleave', () => {
                // Reset to original animation
                element.style.animation = element.dataset.originalAnimation || '';
                element.style.transform = '';
                element.style.textShadow = '';
                // Keep transition for smooth effect
                setTimeout(() => {
                    element.style.transition = '';
                }, 500);
            });
        });
        
        // Add subtle interactions for pen-animation elements
        document.querySelectorAll('span.pen-animation').forEach(el => {
            el.addEventListener('mouseenter', () => {
                // Find nearby text to slightly animate
                const paragraph = el.closest('p');
                if (paragraph) {
                    paragraph.style.color = 'var(--accent-color)';
                    paragraph.style.transition = 'color 0.5s ease';
                }
            });
            
            el.addEventListener('mouseleave', () => {
                const paragraph = el.closest('p');
                if (paragraph) {
                    paragraph.style.color = '';
                    // Keep transition for smooth effect
                    setTimeout(() => {
                        paragraph.style.transition = '';
                    }, 500);
                }
            });
        });
    }
    
    // Make decorative elements more accessible
    const decorativeElements = document.querySelectorAll('.about-visual-element');
    decorativeElements.forEach(el => {
        // Ensure decorative elements are properly marked for screen readers
        el.setAttribute('aria-hidden', 'true');
    });
    
    // Synchronize animations with scroll position
    const animationSections = document.querySelectorAll('.about-section');
    
    const handleAnimationScroll = () => {
        animationSections.forEach(section => {
            const rect = section.getBoundingClientRect();
            const isVisible = (rect.top <= window.innerHeight * 0.75) && (rect.bottom >= 0);
            
            if (isVisible) {
                // Find SVG shapes within this section and adjust their animation
                const shapes = section.querySelectorAll('.floating-shape');
                shapes.forEach(shape => {
                    shape.style.animationPlayState = 'running';
                });
                
                // Find pen-animations within this section
                const penElements = section.querySelectorAll('.pen-animation');
                penElements.forEach((el, index) => {
                    // Add slight delay between elements
                    setTimeout(() => {
                        el.classList.add('visible');
                    }, index * 200);
                });
            }
        });
    };
    
    // Initial check and add scroll listener
    handleAnimationScroll();
    window.addEventListener('scroll', handleAnimationScroll);
});
