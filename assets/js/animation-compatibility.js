/**
 * Animation Compatibility Check
 * This script helps verify that animations work properly across different browsers
 * and provides fallback behaviors if needed.
 */

document.addEventListener('DOMContentLoaded', () => {
    // Check for animation support
    const animationSupported = 'animation' in document.documentElement.style;
    const webkitAnimationSupported = 'webkitAnimation' in document.documentElement.style;
    const mozAnimationSupported = 'mozAnimation' in document.documentElement.style;
    
    // Log browser animation support
    console.log('Animation support check:');
    console.log('- Standard animations:', animationSupported);
    console.log('- Webkit animations:', webkitAnimationSupported);
    console.log('- Mozilla animations:', mozAnimationSupported);
    
    // Add a class to the body indicating animation support level
    const body = document.body;
    if (animationSupported) {
        body.classList.add('animations-supported');
    } else if (webkitAnimationSupported || mozAnimationSupported) {
        body.classList.add('animations-partial');
        
        // Add prefixed animation classes for older browsers
        addPrefixedAnimations();
    } else {
        body.classList.add('animations-not-supported');
        
        // Apply fallback styles for browsers without animation support
        applyFallbackStyles();
    }
    
    // Check GPU acceleration support
    const gpuAccelerated = testGPUAcceleration();
    if (!gpuAccelerated) {
        body.classList.add('no-gpu-acceleration');
        
        // Simplify animations if GPU acceleration isn't available
        simplifyAnimations();
    }
    
    // Log animations in view for debugging
    logVisibleAnimations();
});

/**
 * Tests for GPU acceleration support
 * @returns {boolean} Whether GPU acceleration appears to be supported
 */
function testGPUAcceleration() {
    const test = document.createElement('div');
    test.style.cssText = 
        'position:absolute;transform:translateZ(0);-webkit-transform:translateZ(0);';
    document.body.appendChild(test);
    const hasGPU = 
        (getComputedStyle(test).getPropertyValue('transform') !== 'none') ||
        (getComputedStyle(test).getPropertyValue('-webkit-transform') !== 'none');
    document.body.removeChild(test);
    console.log('GPU Acceleration:', hasGPU ? 'supported' : 'not supported');
    return hasGPU;
}

/**
 * Adds prefixed animation classes for older browsers
 */
function addPrefixedAnimations() {
    // Add prefixed versions of keyframes if needed
    const styleSheet = document.createElement('style');
    styleSheet.type = 'text/css';
    
    // Add prefixed keyframes for heartbeat animation
    const heartbeatKeyframes = `
        @-webkit-keyframes heartbeat {
            0% { -webkit-transform: scale(1); }
            25% { -webkit-transform: scale(1.05); }
            50% { -webkit-transform: scale(1); }
            75% { -webkit-transform: scale(1.03); }
            100% { -webkit-transform: scale(1); }
        }
        
        @-moz-keyframes heartbeat {
            0% { -moz-transform: scale(1); }
            25% { -moz-transform: scale(1.05); }
            50% { -moz-transform: scale(1); }
            75% { -moz-transform: scale(1.03); }
            100% { -moz-transform: scale(1); }
        }
    `;
    
    // Add prefixed keyframes for pen drawing animation
    const penKeyframes = `
        @-webkit-keyframes ink-flow {
            0% { width: 0; opacity: 0; }
            20% { opacity: 1; }
            100% { width: 100%; opacity: 1; }
        }
        
        @-moz-keyframes ink-flow {
            0% { width: 0; opacity: 0; }
            20% { opacity: 1; }
            100% { width: 100%; opacity: 1; }
        }
    `;
    
    styleSheet.textContent = heartbeatKeyframes + penKeyframes;
    document.head.appendChild(styleSheet);
    
    console.log('Added prefixed animations for compatibility');
}

/**
 * Applies fallback styles for browsers that don't support animations
 */
function applyFallbackStyles() {
    console.log('Applying fallback styles for browsers without animation support');
    
    // Apply static highlights to elements that would be animated
    document.querySelectorAll('.heartbeat-animation').forEach(el => {
        el.style.textShadow = '0 0 8px rgba(224, 122, 95, 0.2)';
    });
    
    document.querySelectorAll('.pen-animation').forEach(el => {
        // Show underline immediately without animation
        const underline = document.createElement('div');
        underline.style.cssText = `
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, 
                var(--muted-gold) 0%, 
                var(--secondary-color) 50%, 
                var(--muted-gold) 100%);
        `;
        el.style.position = 'relative';
        el.appendChild(underline);
    });
}

/**
 * Simplifies animations for devices with limited GPU capabilities
 */
function simplifyAnimations() {
    console.log('Simplifying animations for devices with limited GPU capabilities');
    
    // Reduce animation complexity
    document.querySelectorAll('.heartbeat-animation').forEach(el => {
        el.style.animationDuration = '6s'; // Slow down the animation
    });
    
    // Disable floating shape animations which can be more resource-intensive
    document.querySelectorAll('.floating-shape').forEach(shape => {
        shape.style.animation = 'none';
        shape.style.transform = 'none';
    });
}

/**
 * Log visible animations for debugging purposes
 */
function logVisibleAnimations() {
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const elementType = entry.target.classList.contains('heartbeat-animation') ? 'Heartbeat' :
                                  entry.target.classList.contains('pen-animation') ? 'Pen' : 'Other';
                console.log(`${elementType} animation visible: `, entry.target);
            }
        });
    }, { threshold: 0.5 });
    
    // Observe heartbeat animations
    document.querySelectorAll('.heartbeat-animation').forEach(el => {
        observer.observe(el);
    });
    
    // Observe pen animations
    document.querySelectorAll('.pen-animation').forEach(el => {
        observer.observe(el);
    });
}
