/**
 * Image Hover Animation Script
 * 
 * This script enhances the hover animation effect for images
 * by smoothly transitioning from grayscale to color on hover.
 */

document.addEventListener('DOMContentLoaded', function() {
    // Find all elements with the hover-color-image class
    const hoverImages = document.querySelectorAll('.hover-color-image');
    
    // Find all containers with text that should change on hover
    const imageTextContainers = document.querySelectorAll('.image-text-container');
    
    // Add event listeners for hover images
    hoverImages.forEach(function(image) {
        // Add subtle entrance animation
        setTimeout(() => {
            image.style.opacity = '1';
        }, 100);
        
        // For accessibility, add focus events only for client logos
        if (image.classList.contains('client-logo') || image.closest('.clients-section')) {
            image.addEventListener('focus', function() {
                this.style.filter = 'grayscale(0%)';
            });
            
            image.addEventListener('blur', function() {
                this.style.filter = 'grayscale(100%)';
            });
        }
    });
    
    // Add event listeners for image-text containers
    imageTextContainers.forEach(function(container) {
        // Add subtle entrance animation
        setTimeout(() => {
            container.style.opacity = '1';
        }, 100);
        
        // Optional: Add subtle hover effect without scale
        container.addEventListener('mouseenter', function() {
            // Scale effect removed for better UX
            
            // Find any overlay text and animate it
            const overlayText = this.querySelector('.overlay-text');
            if (overlayText) {
                overlayText.style.opacity = '1';
                overlayText.style.transform = 'translateY(-5px)';
            }
        });
        
        container.addEventListener('mouseleave', function() {
            // Scale effect removed for better UX
            
            // Reset overlay text animation
            const overlayText = this.querySelector('.overlay-text');
            if (overlayText) {
                overlayText.style.opacity = '0.8';
                overlayText.style.transform = 'translateY(0)';
            }
        });
    });
    
    // Detect reduced motion preference and disable animations if needed
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        // Remove transitions for users who prefer reduced motion
        const style = document.createElement('style');
        style.textContent = `
            .hover-color-image, .image-text-container, .overlay-text {
                transition: none !important;
            }
        `;
        document.head.appendChild(style);
    }
});
