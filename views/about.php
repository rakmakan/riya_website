<?php
require_once '../database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Airy Alps</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/header-styles.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <link href="../assets/css/animations.css" rel="stylesheet">
    <style>
        /* About Page Specific Styles */
        :root {
            --bg-color: #121212;           /* Soft Black - Primary Background */
            --bg-alt: #1E1E1E;            /* Charcoal Grey - Card/Section BG */
            --text-color: #FFFFFF;         /* Pure White - Primary Text */
            --accent-color: #D8CAB8;       /* Changed from blue to warm beige for better contrast */
            --accent-light: rgba(216, 202, 184, 0.1);
            --secondary-accent: #D8CAB8;   /* Warm Beige - Subtle elegance */
            --section-spacing: 64px;
            --text-padding: 60px;
            --heading-spacing: 24px;
            --paragraph-spacing: 20px;
            --divider-color: #333333;     /* Graphite Grey - Dividers */
            --transition-standard: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        @media (max-width: 768px) {
            :root {
                --section-spacing: 40px;
                --text-padding: 20px;
                --heading-spacing: 20px;
                --paragraph-spacing: 16px;
            }
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            font-size: 18px;
            line-height: 1.6;
            overflow-x: hidden;
            padding-top: 0; /* Override default padding for fixed header */
        }
        
        /* Main layout containers */
        .about-main {
            position: relative;
            overflow-x: hidden;
        }
        
        .about-container {
            max-width: 1440px;
            margin: 0 auto;
            padding: 0 20px;
            position: relative;
        }
        
        /* Vertical accent line */
        .about-main::before {
            content: '';
            position: fixed;
            top: 0;
            left: 40px;
            height: 100vh;
            width: 2px;
            background-color: var(--divider-color);
            z-index: 0;
            opacity: 0.6;
        }
        
        .about-content-wrapper {
            display: flex;
            flex-direction: row;
            align-items: center;
            min-height: 80vh;
            position: relative;
        }
        
        .about-text-column {
            flex: 0 0 660px;
            max-width: 660px;
            padding-left: var(--text-padding);
            position: relative;
            z-index: 2;
        }
        
        .about-visual-column {
            flex: 1;
            position: relative;
            height: 100%;
            min-height: 400px;
            z-index: 1;
        }
        
        /* Hero section styles */
        .about-hero {
            padding: 40px 0 64px;
            position: relative;
            background-color: var(--bg-color);
        }
        
        /* Section styles */
        .about-section {
            padding: var(--section-spacing) 0;
            position: relative;
            border-top: 1px solid var(--divider-color);
            transform: translateY(20px);
            opacity: 0;
            transition: transform 0.8s ease-out, opacity 0.8s ease-out;
        }
        
        .about-section.in-view {
            transform: translateY(0);
            opacity: 1;
        }
        
        .about-section:nth-of-type(odd) {
            background-color: var(--bg-color);
        }
        
        .about-section:nth-of-type(even) {
            background-color: var(--bg-alt);
        }
        
        /* Floating keywords */
        .floating-keyword {
            position: absolute;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--secondary-accent);
            opacity: 0.3;
            pointer-events: none;
            transition: transform 0.3s ease;
        }
        
        /* Typography */
        .about-heading {
            font-family: 'Playfair Display', serif;
            font-size: 3.5rem;
            line-height: 1.2;
            margin-bottom: var(--heading-spacing);
            font-weight: 600;
            position: relative;
        }
        
        .about-heading::after {
            content: '';
            display: block;
            width: 80px;
            height: 2px;
            background-color: var(--secondary-accent);
            margin-top: 10px;
            opacity: 0.6;
        }
        
        .about-subhead {
            font-family: 'Inter', sans-serif;
            font-size: 1.5rem;
            margin-bottom: var(--heading-spacing);
            color: var(--text-color);
            opacity: 0.8;
            font-weight: 400;
        }
        
        .about-paragraph p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: var(--paragraph-spacing);
            max-width: 100%;
        }
        
        /* Visual elements */
        .about-visual-element {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            pointer-events: none;
        }
        
        .animated-svg,
        .section-svg {
            width: 100%;
            height: 100%;
            max-width: 500px;
            max-height: 500px;
            pointer-events: auto;
        }
        
        /* Keyword animations */
        .keyword-container {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            right: 0;
            overflow: hidden;
        }
        
        /* CTA Button */
        .cta-wrapper {
            margin-top: 2rem;
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.8s ease, transform 0.8s ease;
        }
        
        .cta-wrapper.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        .cta-button {
            display: inline-flex;
            align-items: center;
            background-color: var(--accent-color);
            border: 2px solid var(--accent-color);
            color: var(--bg-color);
            font-family: 'Inter', sans-serif;
            padding: 15px 30px;
            font-size: 1rem;
            font-weight: 500;
            text-decoration: none;
            position: relative;
            overflow: hidden;
            transition: var(--transition-standard);
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(216, 202, 184, 0.2);
        }
        
        .cta-text {
            position: relative;
            z-index: 2;
            transition: var(--transition-standard);
        }
        
        .cta-arrow {
            margin-left: 15px;
            transition: var(--transition-standard);
            position: relative;
            z-index: 2;
        }
        
        .cta-button::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0%;
            background-color: var(--text-color);
            transition: var(--transition-standard);
            z-index: 1;
        }
        
        .cta-button:hover,
        .cta-button.hover {
            color: var(--bg-color);
            background-color: var(--text-color);
            border-color: var(--text-color);
            transform: translateY(-3px);
        }
        
        .cta-button:hover::after,
        .cta-button.hover::after {
            height: 100%;
        }
        
        .cta-button:hover .cta-arrow,
        .cta-button.hover .cta-arrow {
            transform: translateX(5px);
        }
        
        /* SVG Animation */
        @keyframes float {
            0% {
                transform: translate(0, 0);
            }
            50% {
                transform: translate(10px, -10px);
            }
            100% {
                transform: translate(0, 0);
            }
        }
        
        .grid-dot {
            transition: opacity 0.3s ease, r 0.3s ease;
        }
        
        .grid-dot:hover {
            opacity: 0.8 !important;
            r: 5px;
        }
        
        .text-visual {
            transition: opacity 0.5s ease;
        }
        
        .text-visual:hover {
            opacity: 0.8 !important;
        }
        
        .wave {
            animation: wave 8s ease-in-out infinite;
            animation-delay: calc(var(--i) * 0.5s);
        }
        
        @keyframes wave {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-15px);
            }
        }
        
        /* Animation for staggered paragraph appearance */
        .about-paragraph p {
            opacity: 0;
            transform: translateY(15px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        
        .about-paragraph p.visible {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Subtle hover animation for floating shapes */
        .floating-shape:hover {
            opacity: 0.9 !important;
            filter: saturate(1.5);
        }
        
        /* Responsive styles */
        @media (max-width: 1200px) {
            .about-heading {
                font-size: 3rem;
            }
            
            .about-text-column {
                flex: 0 0 580px;
                max-width: 580px;
            }
        }
        
        @media (max-width: 992px) {
            .about-main::before {
                left: 20px;
            }
            
            .about-content-wrapper {
                flex-direction: column;
                min-height: auto;
                padding: 40px 0;
            }
            
            .about-text-column {
                flex: 0 0 100%;
                max-width: 100%;
                padding-left: 0;
                padding-right: 0;
                order: 1;
            }
            
            .about-visual-column {
                flex: 0 0 100%;
                max-width: 100%;
                height: 250px;
                margin-top: 30px;
                order: 2;
                position: relative;
            }
            
            .about-visual-element {
                position: relative;
                height: 100%;
            }
            
            .about-hero,
            .about-section {
                padding: var(--section-spacing) 0;
            }
            
            .about-heading {
                font-size: 2.5rem;
            }
            
            .about-subhead {
                font-size: 1.25rem;
                margin-bottom: var(--heading-spacing);
            }
            
            .keyword-container {
                display: none;
            }
        }
        
        @media (max-width: 768px) {
            .about-hero {
                padding-top: 24px;
            }
            
            .about-heading {
                font-size: 2.25rem;
            }
            
            .about-paragraph p {
                font-size: 16px;
            }
            
            .about-visual-column {
                height: 250px;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <main class="about-main">
        <!-- Hero Section -->
        <section class="about-hero">
            <div class="about-container">
                <div class="about-content-wrapper">
                    <div class="about-text-column" data-aos="fade-right">
                        <h1 class="about-heading">I treat your brand like my&nbsp;own.</h1>
                        <p class="about-subhead">That means I care where every word lands.</p>
                        
                        <div class="about-paragraph">
                            <p data-aos="fade-up" data-aos-delay="100">Airy Alps isn't an agency.<br>
                            It's a one-person studio where I work with brands that want to sound like themselves — not like everyone else.</p>
                            <p data-aos="fade-up" data-aos-delay="150">No fluff. No filler.<br>
                            Just clarity, voice, and strategy. Built from questions, not assumptions.</p>
                            <p data-aos="fade-up" data-aos-delay="200">I've helped early-stage founders and global teams find the right words.<br>
                            But the size doesn't matter — the intent does.</p>
                            <p data-aos="fade-up" data-aos-delay="250">If it matters to you, it matters to me.</p>
                        </div>
                    </div>
                    <div class="about-visual-column">
                        <div class="about-visual-element hero-visual" data-aos="fade-in" data-aos-duration="1000">
                            <!-- Animated SVG will be inserted here via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Airy Alps Section -->
        <section class="about-section">
            <div class="about-container">
                <div class="about-content-wrapper">
                    <div class="about-text-column" data-aos="fade-right">
                        <h2 class="about-heading"><span class="pen-animation">About Airy Alps</span></h2>
                        
                        <div class="about-paragraph">
                            <p data-aos="fade-up" data-aos-delay="100">This isn't about catchy headlines or clever positioning.<br>
                            It's about creating language that fits — and holds.</p>
                            <p data-aos="fade-up" data-aos-delay="150">I work with thoughtful, conscious brands — often founder-led, often deeply personal — to help them find their footing and express what they stand for.</p>
                            <p data-aos="fade-up" data-aos-delay="200">We don't guess at messaging. We find it, refine it, and let it breathe.</p>
                            <p data-aos="fade-up" data-aos-delay="250">Because real connection doesn't come from volume.<br>
                            It comes from <span class="pen-animation">resonance</span>.</p>
                        </div>
                    </div>
                    <div class="about-visual-column">
                        <div class="about-visual-element section-visual" data-aos="fade-in" data-aos-duration="1000">
                            <!-- Visual element will be inserted here via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Why "Airy Alps" Section -->
        <section class="about-section light-section">
            <div class="about-container">
                <div class="about-content-wrapper">
                    <div class="about-text-column" data-aos="fade-right">
                        <h2 class="about-heading">Why "Airy Alps"</h2>
                        
                        <div class="about-paragraph">
                            <p data-aos="fade-up" data-aos-delay="100">The name is a quiet nod to who I am.<br>
                            'Airy' is 'Riya' in alphabetical order.<br>
                            'Alps' comes from 'Uppal.'</p>
                            <p data-aos="fade-up" data-aos-delay="150">But it also sounds like what I try to do —<br>
                            Clear the noise. Rise above the buzz.<br>
                            Find the words that feel crisp, elevated, and unmistakably yours.</p>
                        </div>
                    </div>
                    <div class="about-visual-column">
                        <div class="about-visual-element name-visual" data-aos="fade-in" data-aos-duration="1000">
                            <!-- Visual element will be inserted here via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Who I Am Section -->
        <section class="about-section">
            <div class="about-container">
                <div class="about-content-wrapper">
                    <div class="about-text-column" data-aos="fade-right">
                        <h2 class="about-heading"><span class="pen-animation">Who I Am</span></h2>
                        
                        <div class="about-paragraph">
                            <p data-aos="fade-up" data-aos-delay="100">I'm Riya Uppal — a strategist, writer, and someone who takes words seriously.</p>
                            <p data-aos="fade-up" data-aos-delay="150">Over the past 7+ years, I've shaped messaging for early-stage startups, creative agencies, global brands, and MNCs.<br>
                            I've worked fast, I've worked deep, and I've always worked closely.</p>
                            <p data-aos="fade-up" data-aos-delay="200">What ties it all together is a belief that the right words can do more than explain — they can <span class="pen-animation">anchor a brand, open up new space, and feel like truth</span>.</p>
                            <p data-aos="fade-up" data-aos-delay="250">Outside of work, I'm usually reading about human behavior, experimenting with AI prompts, or lost in a novel that makes me forget what time it is.</p>
                        </div>
                    </div>
                    <div class="about-visual-column">
                        <div class="about-visual-element who-visual" data-aos="fade-in" data-aos-duration="1000">
                            <!-- Visual element will be inserted here via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Let's Clear the Air Section -->
        <section class="about-section light-section">
            <div class="about-container">
                <div class="about-content-wrapper">
                    <div class="about-text-column" data-aos="fade-right">
                        <h2 class="about-heading"><span class="pen-animation">Let's Clear the Air</span></h2>
                        
                        <div class="about-paragraph">
                            <p data-aos="fade-up" data-aos-delay="100">If your brand has something honest to say,<br>
                            I'd love to help you say it in a way that <span class="pen-animation">feels like you — and sounds like something people remember</span>.</p>
                            <div class="cta-wrapper">
                                <a href="contact.php" class="cta-button pen-animation">
                                    <span class="cta-text">Let's Work Together</span>
                                    <span class="cta-arrow"><i class="fas fa-arrow-right"></i></span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="about-visual-column">
                        <div class="about-visual-element air-visual" data-aos="fade-in" data-aos-duration="1000">
                            <!-- Visual element will be inserted here via JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../includes/footer.php'; ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.10.4/gsap.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS animation library
            AOS.init({
                duration: 600,
                easing: 'ease-out',
                once: false,
                offset: 30,
                delay: 50
            });

            // Create and animate SVG elements for each section
            createHeroVisual();
            createSectionVisuals();
            
            // Add floating keywords to sections
            addFloatingKeywords();
            
            // Observe sections for scroll-based animations
            initSectionObserver();
            
            // Add hover event listeners to CTA button
            const ctaButton = document.querySelector('.cta-button');
            if (ctaButton) {
                ctaButton.addEventListener('mouseenter', function() {
                    this.classList.add('hover');
                });
                ctaButton.addEventListener('mouseleave', function() {
                    this.classList.remove('hover');
                });
            }
            
            // Animate CTA button on scroll
            const ctaWrapper = document.querySelector('.cta-wrapper');
            if (ctaWrapper) {
                const ctaObserver = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            ctaObserver.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.7 });
                
                ctaObserver.observe(ctaWrapper);
            }
        });

        // Create animated SVG for hero section
        function createHeroVisual() {
            const heroVisual = document.querySelector('.hero-visual');
            if (heroVisual) {
                // Create floating shapes with subtle animation
                const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("viewBox", "0 0 400 400");
                svg.setAttribute("width", "100%");
                svg.setAttribute("height", "100%");
                svg.classList.add('animated-svg');
                
                // Add shapes to SVG
                svg.innerHTML = `
                    <defs>
                        <linearGradient id="gradient1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="rgba(29, 53, 87, 0.6)" />
                            <stop offset="100%" stop-color="rgba(29, 53, 87, 0.2)" />
                        </linearGradient>
                        <linearGradient id="gradient2" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="rgba(224, 122, 95, 0.6)" />
                            <stop offset="100%" stop-color="rgba(224, 122, 95, 0.2)" />
                        </linearGradient>
                    </defs>
                    <circle class="floating-shape shape-1" cx="100" cy="150" r="50" fill="url(#gradient1)" opacity="0.7" />
                    <circle class="floating-shape shape-2" cx="280" cy="120" r="30" fill="url(#gradient2)" opacity="0.5" />
                    <circle class="floating-shape shape-3" cx="220" cy="280" r="40" fill="url(#gradient1)" opacity="0.3" />
                    <path class="floating-shape shape-4" d="M150,80 C200,120 250,60 300,100" stroke="rgba(29, 53, 87, 0.4)" stroke-width="3" fill="none" />
                    <path class="floating-shape shape-5" d="M80,200 C130,250 180,220 230,270" stroke="rgba(224, 122, 95, 0.4)" stroke-width="2" fill="none" />
                `;
                
                heroVisual.appendChild(svg);
                
                // Add animation to shapes
                animateShapes();
            }
        }
        
        // Create visuals for other sections
        function createSectionVisuals() {
            // Abstract patterns for each section
            const sectionVisualEls = document.querySelectorAll('.section-visual, .name-visual, .who-visual, .air-visual');
            
            sectionVisualEls.forEach((el, index) => {
                const svg = document.createElementNS("http://www.w3.org/2000/svg", "svg");
                svg.setAttribute("viewBox", "0 0 400 400");
                svg.setAttribute("width", "100%");
                svg.setAttribute("height", "100%");
                svg.classList.add('section-svg');
                
                // Different pattern for each section
                let pattern = '';
                switch(index) {
                    case 0: // About section visual - dot grid
                        pattern = createDotGridPattern();
                        break;
                    case 1: // Why Airy Alps - text transformation visual
                        pattern = createTextVisual();
                        break;
                    case 2: // Who I Am - organic shapes
                        pattern = createOrganicShapes();
                        break;
                    case 3: // Let's Clear the Air - airy waves
                        pattern = createWavePattern();
                        break;
                    default:
                        pattern = createDotGridPattern();
                }
                
                svg.innerHTML = pattern;
                el.appendChild(svg);
                
                // Make SVG elements interactive
                svg.querySelectorAll('.grid-dot, .text-visual, .organic-shape, .wave').forEach(element => {
                    // Store original properties for hover effects
                    const originalOpacity = element.getAttribute('opacity') || '0.3';
                    element.setAttribute('data-original-opacity', originalOpacity);
                    
                    // Make SVG elements respond to mouse events
                    element.style.pointerEvents = 'auto';
                    
                    element.addEventListener('mouseenter', () => {
                        element.setAttribute('opacity', '0.8');
                        if (element.hasAttribute('r')) {
                            element.setAttribute('r', parseFloat(element.getAttribute('r')) * 1.5);
                        }
                    });
                    
                    element.addEventListener('mouseleave', () => {
                        element.setAttribute('opacity', originalOpacity);
                        if (element.hasAttribute('r')) {
                            element.setAttribute('r', parseFloat(element.getAttribute('r')) / 1.5);
                        }
                    });
                });
            });
        }
        
        // Create a dot grid pattern
        function createDotGridPattern() {
            let dots = '';
            const rows = 10;
            const cols = 10;
            const spacing = 35;
            
            for (let i = 0; i < rows; i++) {
                for (let j = 0; j < cols; j++) {
                    const x = 40 + j * spacing;
                    const y = 40 + i * spacing;
                    const opacity = Math.random() * 0.5 + 0.1;
                    const radius = Math.random() * 3 + 2;
                    
                    dots += `<circle class="grid-dot" cx="${x}" cy="${y}" r="${radius}" fill="var(--accent-color)" opacity="${opacity}" />`;
                }
            }
            
            return dots;
        }
        
        // Create text transformation visual
        function createTextVisual() {
            return `
                <defs>
                    <linearGradient id="text-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="rgba(29, 53, 87, 0.8)" />
                        <stop offset="100%" stop-color="rgba(29, 53, 87, 0.3)" />
                    </linearGradient>
                </defs>
                <text x="50" y="150" class="text-visual riya" font-family="Playfair Display" font-size="60" fill="url(#text-gradient)" opacity="0.6">Riya</text>
                <text x="50" y="220" class="text-visual airy" font-family="Playfair Display" font-size="60" fill="url(#text-gradient)" opacity="0.3">Airy</text>
                <text x="150" y="290" class="text-visual uppal" font-family="Playfair Display" font-size="60" fill="url(#text-gradient)" opacity="0.6">Uppal</text>
                <text x="150" y="360" class="text-visual alps" font-family="Playfair Display" font-size="60" fill="url(#text-gradient)" opacity="0.3">Alps</text>
            `;
        }
        
        // Create organic shapes
        function createOrganicShapes() {
            return `
                <defs>
                    <linearGradient id="shape-gradient" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" stop-color="rgba(29, 53, 87, 0.6)" />
                        <stop offset="100%" stop-color="rgba(29, 53, 87, 0.2)" />
                    </linearGradient>
                </defs>
                <path class="organic-shape shape-1" d="M100,100 C150,50 200,150 250,100 S350,150 300,200 S200,300 150,250 S50,200 100,100" fill="url(#shape-gradient)" opacity="0.4" />
                <path class="organic-shape shape-2" d="M150,150 C180,100 220,200 250,150 S280,180 250,200 S220,220 190,200 S120,200 150,150" fill="var(--secondary-accent)" opacity="0.2" />
            `;
        }
        
        // Create wave pattern
        function createWavePattern() {
            let waves = '';
            const numWaves = 5;
            
            for (let i = 0; i < numWaves; i++) {
                const yPos = 100 + i * 40;
                const opacity = 0.4 - (i * 0.05);
                waves += `<path class="wave wave-${i}" d="M0,${yPos} C50,${yPos-20} 100,${yPos+20} 150,${yPos} S250,${yPos-20} 300,${yPos} S400,${yPos+20} 450,${yPos}" stroke="var(--accent-color)" stroke-width="2" fill="none" opacity="${opacity}" style="animation-delay: ${i * 0.5}s;" />`;
            }
            
            return waves;
        }
        
        // Animate floating shapes
        function animateShapes() {
            const shapes = document.querySelectorAll('.floating-shape');
            shapes.forEach((shape, index) => {
                // Random animation parameters for each shape
                const duration = 5 + Math.random() * 10; // Between 5-15 seconds
                const delay = Math.random() * 5; // Random delay up to 5 seconds
                
                // Apply animation
                shape.style.animation = `float ${duration}s ease-in-out infinite ${delay}s`;
            });
        }
        
        // Add floating keywords to each section
        function addFloatingKeywords() {
            const keywords = [
                ['clarity', 'voice', 'impact', 'strategy'],
                ['authentic', 'resonance', 'messaging', 'purpose'],
                ['identity', 'essence', 'brand', 'story'],
                ['craft', 'precision', 'connection', 'meaning']
            ];
            
            // Use GSAP for smoother animations
            if (typeof gsap !== 'undefined') {
            
            const sections = document.querySelectorAll('.about-visual-column');
            
            sections.forEach((section, index) => {
                if (index < keywords.length) {
                    const keywordContainer = document.createElement('div');
                    keywordContainer.classList.add('keyword-container');
                    
                    keywords[index].forEach((word, i) => {
                        const keyword = document.createElement('div');
                        keyword.classList.add('floating-keyword');
                        keyword.textContent = word;
                        
                        // Random positioning
                        const topPos = 20 + Math.random() * 60; // 20-80%
                        const rightPos = Math.random() * 70; // 0-70%
                        
                        keyword.style.top = `${topPos}%`;
                        keyword.style.right = `${rightPos}%`;
                        keyword.style.opacity = '0';
                        keyword.style.transform = 'translateY(20px)';
                        
                        keyword.style.transition = `
                            opacity 0.8s ease ${i * 0.2}s, 
                            transform 0.8s ease ${i * 0.2}s
                        `;
                        
                        keywordContainer.appendChild(keyword);
                        
                        // Set animation for gentle floating
                        setTimeout(() => {
                            keyword.style.opacity = '0.15';
                            keyword.style.transform = 'translateY(0)';
                        }, 300);
                        
                        // Create subtle random movement
                        setInterval(() => {
                            const moveX = Math.random() * 10 - 5; // -5px to 5px
                            const moveY = Math.random() * 10 - 5;
                            keyword.style.transform = `translate(${moveX}px, ${moveY}px)`;
                        }, 3000 + i * 500);
                    });
                    
                    section.appendChild(keywordContainer);
                    
                    // Animate keywords with GSAP for smoother motion
                    if (typeof gsap !== 'undefined') {
                        const keywordElements = keywordContainer.querySelectorAll('.floating-keyword');
                        
                        keywordElements.forEach((elem) => {
                            gsap.to(elem, {
                                opacity: 0.15,
                                y: 0,
                                duration: 0.8,
                                delay: Math.random() * 0.5
                            });
                            
                            // Random subtle floating animation
                            gsap.to(elem, {
                                x: "random(-10, 10)",
                                y: "random(-10, 10)",
                                duration: "random(3, 6)",
                                repeat: -1,
                                yoyo: true,
                                ease: "sine.inOut"
                            });
                        });
                    }
                }
            });
            } else {
                // Fallback if GSAP is not loaded
                const sections = document.querySelectorAll('.about-visual-column');
                
                sections.forEach((section, index) => {
                    if (index < keywords.length) {
                        const keywordContainer = document.createElement('div');
                        keywordContainer.classList.add('keyword-container');
                        
                        keywords[index].forEach((word, i) => {
                            const keyword = document.createElement('div');
                            keyword.classList.add('floating-keyword');
                            keyword.textContent = word;
                            
                            // Random positioning
                            const topPos = 20 + Math.random() * 60;
                            const rightPos = Math.random() * 70;
                            
                            keyword.style.top = `${topPos}%`;
                            keyword.style.right = `${rightPos}%`;
                            keyword.style.opacity = '0';
                            keyword.style.transform = 'translateY(20px)';
                            
                            keyword.style.transition = `
                                opacity 0.8s ease ${i * 0.2}s, 
                                transform 0.8s ease ${i * 0.2}s
                            `;
                            
                            keywordContainer.appendChild(keyword);
                            
                            // Set animation for gentle floating
                            setTimeout(() => {
                                keyword.style.opacity = '0.15';
                                keyword.style.transform = 'translateY(0)';
                            }, 300);
                            
                            // Create subtle random movement
                            setInterval(() => {
                                const moveX = Math.random() * 10 - 5;
                                const moveY = Math.random() * 10 - 5;
                                keyword.style.transform = `translate(${moveX}px, ${moveY}px)`;
                            }, 3000 + i * 500);
                        });
                        
                        section.appendChild(keywordContainer);
                    }
                });
            }
        }
        
        // Initialize intersection observer for sections
        function initSectionObserver() {
            const sections = document.querySelectorAll('.about-section');
            
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('in-view');
                        
                        // Add staggered paragraph animations
                        const paragraphs = entry.target.querySelectorAll('.about-paragraph p');
                        
                        // Use GSAP for smoother animations if available
                        if (typeof gsap !== 'undefined') {
                            gsap.fromTo(paragraphs, 
                                { opacity: 0, y: 20 },
                                { 
                                    opacity: 1, 
                                    y: 0, 
                                    duration: 0.6,
                                    stagger: 0.1,
                                    ease: "power2.out"
                                }
                            );
                        } else {
                            // Fallback to CSS transitions
                            paragraphs.forEach((p, i) => {
                                p.style.opacity = '0';
                                p.style.transform = 'translateY(20px)';
                                p.style.transition = `opacity 0.6s ease ${i * 0.1}s, transform 0.6s ease ${i * 0.1}s`;
                                
                                setTimeout(() => {
                                    p.style.opacity = '1';
                                    p.style.transform = 'translateY(0)';
                                }, 100);
                            });
                        }
                        
                        sectionObserver.unobserve(entry.target);
                    }
                });
            }, {
                threshold: 0.15
            });
            
            sections.forEach(section => {
                sectionObserver.observe(section);
            });
        }
    </script>
    
    <!-- Animation enhancements -->
    <script src="../assets/js/animations.js"></script>
    <script src="../assets/js/animation-compatibility.js"></script>
    <script src="../assets/js/hover-animation.js"></script>
</html>