/**
 * The Gap Section Canvas Animation
 * This file contains the particle animation for The Gap section
 */

// Ensure animation only runs once DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('Gap animation script loaded');
    initGapAnimation();
});

// Initialize the animation
function initGapAnimation() {
    const canvas = document.getElementById('scatterCanvas');
    
    if (!canvas) {
        console.warn('ScatterCanvas element not found');
        return;
    }
    
    console.log('Initializing gap animation on canvas:', canvas);
    
    try {
        const ctx = canvas.getContext('2d');
        const particles = [];
        
        // Adjust particle count based on device
        const isMobile = window.innerWidth < 768;
        const particleCount = isMobile ? 40 : 100;
        
        // Set canvas dimensions to match display size
        function resizeCanvas() {
            const displayWidth = canvas.clientWidth;
            const displayHeight = isMobile ? 300 : canvas.clientHeight;
            
            // Apply device pixel ratio for sharper rendering
            const dpr = window.devicePixelRatio || 1;
            
            // Set the canvas dimensions if they're different
            if (canvas.width !== displayWidth * dpr || canvas.height !== displayHeight * dpr) {
                canvas.width = displayWidth * dpr;
                canvas.height = displayHeight * dpr;
                
                // Scale context according to device pixel ratio
                ctx.scale(dpr, dpr);
                
                // Set dimensions for layout
                canvas.style.width = `${displayWidth}px`;
                canvas.style.height = `${displayHeight}px`;
                
                console.log(`Canvas resized to ${displayWidth}x${displayHeight} with DPR ${dpr}`);
            }
        }
        
        // Create particles
        function createParticles() {
            particles.length = 0; // Clear existing particles
            for (let i = 0; i < particleCount; i++) {
                // Adjust particle size and speed for mobile
                const particleSize = isMobile ? (Math.random() * 2 + 0.8) : (Math.random() * 3 + 1);
                const particleSpeed = isMobile ? 0.8 : 1.0;
                
                particles.push({
                    x: Math.random() * canvas.width,
                    y: Math.random() * canvas.height,
                    radius: particleSize,
                    color: `rgba(${Math.floor(Math.random() * 100)}, ${Math.floor(Math.random() * 100)}, ${Math.floor(Math.random() * 255)}, 0.7)`,
                    speedX: (Math.random() * 2 - 1) * particleSpeed,
                    speedY: (Math.random() * 2 - 1) * particleSpeed,
                    connectedParticles: []
                });
            }
            console.log(`Created ${particles.length} particles`);
        }
        
        // Draw particles and connections
        function drawParticles() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            
            // Get device pixel ratio
            const dpr = window.devicePixelRatio || 1;
            
            // If the canvas is not currently visible, reduce animation work
            const canvasRect = canvas.getBoundingClientRect();
            const isOffScreen = (
                canvasRect.bottom < 0 ||
                canvasRect.top > window.innerHeight ||
                canvasRect.right < 0 ||
                canvasRect.left > window.innerWidth
            );
            
            // Skip intensive computations if off-screen on mobile
            const skipDetail = isOffScreen && isMobile;
            
            // Adjust animation speed based on device and visibility
            const speedFactor = skipDetail ? 0.5 : (isMobile ? 0.7 : 1.0);
            
            // Update and draw each particle
            particles.forEach(particle => {
                // Update position with speed factor
                particle.x += particle.speedX * speedFactor;
                particle.y += particle.speedY * speedFactor;
                
                // Bounce off edges with a slight randomization to avoid patterns
                if (particle.x < 0 || particle.x > canvas.width / dpr) {
                    particle.speedX *= -1;
                    if (!skipDetail) particle.speedX += (Math.random() * 0.02 - 0.01);
                }
                if (particle.y < 0 || particle.y > canvas.height / dpr) {
                    particle.speedY *= -1;
                    if (!skipDetail) particle.speedY += (Math.random() * 0.02 - 0.01);
                }
                
                // Draw particle
                ctx.beginPath();
                ctx.arc(particle.x, particle.y, particle.radius, 0, Math.PI * 2);
                ctx.fillStyle = particle.color;
                ctx.fill();
                
                // Skip connection calculations if off-screen on mobile to improve performance
                if (skipDetail) return;
                
                // Find and connect nearby particles
                particle.connectedParticles = [];
                // Adjust connection distance for mobile
                const connectionDistance = isMobile ? 60 : 80;
                
                // Use a more efficient approach for finding nearby particles
                for (let i = particles.indexOf(particle) + 1; i < particles.length; i++) {
                    const otherParticle = particles[i];
                    const dx = particle.x - otherParticle.x;
                    const dy = particle.y - otherParticle.y;
                    
                    // Quick distance check (avoid square root when possible)
                    if (Math.abs(dx) < connectionDistance && Math.abs(dy) < connectionDistance) {
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        
                        // Connect if close enough
                        if (distance < connectionDistance) {
                            particle.connectedParticles.push(otherParticle);
                            
                            // Draw connection line
                            ctx.beginPath();
                            ctx.moveTo(particle.x, particle.y);
                            ctx.lineTo(otherParticle.x, otherParticle.y);
                            ctx.strokeStyle = `rgba(0, 77, 153, ${0.2 * (1 - distance / connectionDistance)})`;
                            ctx.lineWidth = isMobile ? 0.3 : 0.5;
                            ctx.stroke();
                        }
                    }
                }
            });
            
            // Request next frame with reduced framerate for mobile
            if (isMobile && !isOffScreen) {
                setTimeout(() => {
                    requestAnimationFrame(drawParticles);
                }, 16); // ~60fps on desktop, slightly lower on mobile
            } else {
                requestAnimationFrame(drawParticles);
            }
        }
        
        // Initialize canvas
        function initCanvas() {
            canvas.setAttribute('data-initialized', 'true'); // Mark as initialized
            resizeCanvas();
            createParticles();
            drawParticles();
            console.log('Canvas animation initialized successfully');
        }
        
        // Handle window resize
        window.addEventListener('resize', () => {
            // Update mobile detection
            const wasIsMobile = isMobile;
            const newIsMobile = window.innerWidth < 768;
            
            // Only recreate particles if the device type changed (mobile/desktop)
            if (wasIsMobile !== newIsMobile) {
                resizeCanvas();
                createParticles();
            } else {
                resizeCanvas();
            }
        });
        
        // Initialize
        initCanvas();
        
    } catch (error) {
        console.error('Error initializing gap animation:', error);
    }
}
