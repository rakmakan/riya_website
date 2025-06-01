<?php
require_once __DIR__ . '/database/config.php';

// Get content for different sections
$hero_content = get_section_content('hero');
$services = get_services();
$testimonials = get_testimonials();
$featured_cases = get_case_studies(3);
$clients = get_clients();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="assets/css/style.css" rel="stylesheet">
    
    <!-- Inline styles for What Working Together Looks Like Section -->
    <style>
        /* Hero Heading Color Animation */
        .hero-heading {
            animation: colorTransition 6s ease-in-out infinite;
            background: linear-gradient(45deg, #D8CAB8, #FFFFFF, #A1A1A1, #D8CAB8);
            background-size: 400% 400%;
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            text-fill-color: transparent;
        }

        @keyframes colorTransition {
            0% {
                background-position: 0% 50%;
            }
            33% {
                background-position: 50% 50%;
            }
            66% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Fallback for browsers that don't support background-clip: text */
        @supports not (-webkit-background-clip: text) {
            .hero-heading {
                animation: colorTransitionFallback 6s ease-in-out infinite;
                background: none;
                -webkit-text-fill-color: initial;
                text-fill-color: initial;
            }
            
            @keyframes colorTransitionFallback {
                0% { color: #D8CAB8; }
                33% { color: #FFFFFF; }
                66% { color: #A1A1A1; }
                100% { color: #D8CAB8; }
            }
        }

        /* What Working Together Looks Like Section */
        .collaboration-section {
            background-color: var(--button-bg);
            color: var(--button-text);
        }

        .collaboration-intro,
        .collaboration-scenarios {
            background-color: var(--bg-color);
            color: var(--primary-text);
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .collaboration-intro:hover,
        .collaboration-scenarios:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(51, 51, 51, 0.3);
        }

        .outcome-item {
            position: relative;
        }

        .outcome-number {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--warm-beige);
            color: var(--bg-color);
            font-weight: 700;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .outcome-content h4 {
            margin-bottom: 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-text);
        }

        .scenario-card {
            padding: 15px 0;
            position: relative;
        }

        .scenario-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--muted-gold);
            color: var(--bg-color);
            margin-bottom: 15px;
        }

        .scenario-icon i {
            font-size: 1.5rem;
        }

        .scenario-divider {
            height: 1px;
            background: linear-gradient(90deg, var(--border-color) 0%, transparent 100%);
            margin-top: 15px;
        }

        .collaboration-conclusion {
            font-style: italic;
            color: var(--button-text);
            font-weight: 500;
        }
        
        /* Extra Gap section styles for consistent alignment */
        .canvas-container {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }
        
        @media (max-width: 767px) {
            .canvas-container {
                justify-content: center;
                margin-top: 1rem;
            }
        }
    </style>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section - Black Background -->
    <section id="home" class="hero-section full-screen-section snap-section" style="background-color: var(--bg-color);">
        <div class="container">
            <div class="row align-items-center h-100">
                <div class="col-lg-6 order-lg-1 order-2">
                    <div class="hero-content">
                        <h1 class="hero-heading"><?php echo htmlspecialchars($hero_content['title'] ?? 'Get eyes on your brand and keep them there.'); ?></h1>
                        <p class="hero-description"><?php echo htmlspecialchars($hero_content['description'] ?? 'Brand strategy, Messaging & Copy that turn attention into trust.'); ?></p>
                        
                        <div class="hero-cta-group">
                            <a href="#contact" class="btn btn-primary btn-hero-primary">Start a Project</a>
                            <a href="views/case-studies.php" class="btn btn-outline-dark btn-hero-primary">View Case Studies</a>
                        </div>

                        <div class="hero-stats">
                            <?php 
                            $stats = get_homepage_stats();
                            if (empty($stats)): 
                                $default_stats = [
                                    ['value' => '7+', 'label' => 'Years Experience'],
                                    ['value' => '20+', 'label' => 'Projects Completed'],
                                    ['value' => '8+', 'label' => 'Brands']
                                ];
                                foreach ($default_stats as $stat):
                            ?>
                                <div class="hero-stat">
                                    <div class="hero-stat-number"><?php echo $stat['value']; ?></div>
                                    <div class="hero-stat-label"><?php echo $stat['label']; ?></div>
                                </div>
                            <?php 
                                endforeach;
                            else:
                                foreach ($stats as $stat):
                            ?>
                                <div class="hero-stat">
                                    <div class="hero-stat-number"><?php echo htmlspecialchars($stat['value']); ?></div>
                                    <div class="hero-stat-label"><?php echo htmlspecialchars($stat['label']); ?></div>
                                </div>
                            <?php 
                                endforeach;
                            endif;
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 order-lg-2 order-1">
                    <div class="hero-image-container">
                        <div class="orbital-background"></div>
                        <div class="orbital-container">
                            <div class="metallic-ball"></div>
                            
                            <div class="orbit orbit-1">
                                <div class="orbital-tag" data-label="Brand Strategy">
                                    <i class="fas fa-pen-fancy"></i>
                                </div>
                            </div>
                            
                            <div class="orbit orbit-2">
                                <div class="orbital-tag" data-label="AI Solutions">
                                    <i class="fas fa-robot"></i>
                                </div>
                            </div>
                            
                            <div class="orbit orbit-3">
                                <div class="orbital-tag" data-label="Market Research">
                                    <i class="fas fa-bullseye"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section - White Background -->
    <section id="services" class="services-section section-padding snap-section section-fade-in" style="background-color: var(--button-bg); color: var(--button-text);">
        <div class="container">
            <h2 class="section-title">My Services</h2>
            <div class="row g-4">
                <?php if (empty($services)): 
                    $default_services = [
                        [
                            'icon' => 'fas fa-bullseye',
                            'title' => 'Market Positioning',
                            'description' => 'Most brands sound the same. I help you say something different — and mean it. Together, we\'ll figure out who you\'re for, what makes you worth caring about, and how to claim a space no one else owns.'
                        ],
                        [
                            'icon' => 'fas fa-pen-fancy',
                            'title' => 'Brand Copy',
                            'description' => 'Words make people feel things. Or scroll past. I write the kind that make them feel, act, and remember. Websites, taglines, decks, bios — if it needs a voice, I give it yours (but sharper).'
                        ],
                        [
                            'icon' => 'fas fa-lightbulb',
                            'title' => 'Consulting',
                            'description' => 'Need a marketer without hiring one full-time? I plug into your team, review what\'s working, scrap what\'s not, and help you market smarter — not just louder.'
                        ]
                    ];
                    foreach ($default_services as $service):
                ?>
                    <div class="col-md-4">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="<?php echo $service['icon']; ?>"></i>
                            </div>
                            <h4><?php echo $service['title']; ?></h4>
                            <p><?php echo $service['description']; ?></p>
                        </div>
                    </div>
                <?php 
                    endforeach;
                else:
                    foreach ($services as $service):
                ?>
                    <div class="col-md-4">
                        <div class="service-card">
                            <div class="service-icon">
                                <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                            </div>
                            <h4><?php echo htmlspecialchars($service['title']); ?></h4>
                            <p><?php echo htmlspecialchars($service['description']); ?></p>
                        </div>
                    </div>
                <?php 
                    endforeach;
                endif;
                ?>
            </div>
        </div>
    </section>


    <!-- Case Studies Section - Black Background -->
    <section id="case-studies" class="case-studies-section section-padding snap-section section-fade-in" style="background-color: var(--bg-color);">
        <div class="container">
            <h2 class="section-title">Case Studies</h2>
            <div class="case-study-slider">
                <?php
                // Full server path to the config file to avoid path issues on SiteGround
                require_once __DIR__ . '/database/config.php';
                $featured_cases = get_case_studies(3);
                ?>
                <div id="caseStudyCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">
                        <?php foreach ($featured_cases as $index => $case): ?>
                        <button type="button" data-bs-target="#caseStudyCarousel" data-bs-slide-to="<?php echo $index; ?>" 
                                <?php echo $index === 0 ? 'class="active"' : ''; ?>></button>
                        <?php endforeach; ?>
                    </div>
                    <div class="carousel-inner">
                        <?php foreach ($featured_cases as $index => $case): ?>
                        <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                            <div class="case-study-card">
                                <div class="row align-items-center">
                                    <div class="col-lg-6">
                                        <div class="image-text-container">
                                            <img src="<?php echo htmlspecialchars($case['featured_image']); ?>" 
                                                 class="img-fluid hover-color-image" alt="<?php echo htmlspecialchars($case['title']); ?>">
                                            <div class="overlay-text">
                                                <span class="badge" style="background-color: var(--button-bg); color: var(--bg-color);"><?php echo htmlspecialchars($case['category'] ?? 'Case Study'); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <h3><?php echo htmlspecialchars($case['title']); ?></h3>
                                        <p class="lead"><?php echo htmlspecialchars($case['summary']); ?></p>
                                        <a href="views/case-study.php?slug=<?php echo urlencode($case['slug']); ?>" 
                                           class="btn btn-primary">View Case Study</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#caseStudyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#caseStudyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </button>
                </div>
                <div class="text-center mt-5">
                    <a href="views/case-studies.php" class="btn btn-outline-secondary">View All Case Studies</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Review Section - White Background -->
    <section id="reviews" class="reviews-section section-padding" style="background-color: var(--button-bg); color: var(--button-text);">
        <div class="container">
            <h2 class="section-title">Client Reviews</h2>
            <div class="reviews-container">
                <div class="review-track">
                    <?php if (empty($testimonials)): 
                        $default_testimonials = [
                            [
                                'client_name' => 'Karan Sharma',
                                'client_position' => 'Founder, Hubsell',
                                'company_logo' => 'hubsell-logo.svg',
                                'rating' => 5,
                                'review_text' => 'I highly recommend Riya to anybody needing help in marketing, corporate communications and PR. She is a self-starter with commendable storytelling, analytical and writing skills, all of which make her an excellent marketer.'
                            ],
                            [
                                'client_name' => 'Sarah Johnson',
                                'client_position' => 'Marketing Director, IDEMIA',
                                'company_logo' => 'idemia-logo.svg',
                                'rating' => 5,
                                'review_text' => 'Riya transformed our content strategy completely. Her ability to simplify complex technical concepts into compelling stories is exceptional. Our engagement rates increased by 40% under her guidance.'
                            ],
                            [
                                'client_name' => 'Michael Chen',
                                'client_position' => 'CEO, OpenSense Labs',
                                'company_logo' => 'opensense-logo.svg',
                                'rating' => 5,
                                'review_text' => 'Working with Riya was a game-changer for our startup. She not only delivered exceptional content but also helped us define our brand voice. Her strategic approach to marketing is remarkable.'
                            ],
                            [
                                'client_name' => 'Emma Rodriguez',
                                'client_position' => 'Brand Manager, Parimatch',
                                'company_logo' => 'parimatch-logo.svg',
                                'rating' => 5,
                                'review_text' => 'Riya\'s expertise in both B2B and B2C marketing is impressive. She helped us launch our new product line with compelling campaigns that drove real results. Professional and creative!'
                            ]
                        ];
                        
                        // Print testimonials twice for seamless loop
                        for ($i = 0; $i < 2; $i++):
                            foreach ($default_testimonials as $testimonial):
                    ?>
                            <div class="review-card">
                                <div class="review-profile">
                                    <div class="image-text-container">
                                        <img src="assets/images/<?php echo $testimonial['company_logo']; ?>" 
                                             alt="<?php echo htmlspecialchars($testimonial['client_position']); ?>" 
                                             class="company-logo hover-color-image">
                                    </div>
                                    <div class="rating">
                                        <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="review-text"><?php echo htmlspecialchars($testimonial['review_text']); ?></p>
                                <h4 class="client-name"><?php echo htmlspecialchars($testimonial['client_name']); ?></h4>
                                <p class="client-position"><?php echo htmlspecialchars($testimonial['client_position']); ?></p>
                            </div>
                    <?php 
                            endforeach;
                        endfor;
                    else:
                        // Print dynamic testimonials twice for seamless loop
                        for ($i = 0; $i < 2; $i++):
                            foreach ($testimonials as $testimonial):
                    ?>
                            <div class="review-card">
                                <div class="review-profile">
                                    <div class="image-text-container">
                                        <img src="<?php echo htmlspecialchars($testimonial['image_url']); ?>" 
                                             alt="<?php echo htmlspecialchars($testimonial['client_name']); ?>" 
                                             class="company-logo hover-color-image">
                                    </div>
                                    <div class="rating">
                                        <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                                            <i class="fas fa-star"></i>
                                        <?php endfor; ?>
                                    </div>
                                </div>
                                <p class="review-text"><?php echo htmlspecialchars($testimonial['review_text']); ?></p>
                                <h4 class="client-name"><?php echo htmlspecialchars($testimonial['client_name']); ?></h4>
                                <p class="client-position"><?php echo htmlspecialchars($testimonial['client_position']); ?></p>
                            </div>
                    <?php 
                            endforeach;
                        endfor;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Logos Section - Black Background -->
    <section id="clients" class="clients-section section-padding" style="background-color: var(--bg-color);">
        <div class="container-fluid">
            <div class="container">
                <h2 class="section-title">Trusted By</h2>
            </div>
            <div class="client-logos-container">
                <div class="client-logos-track">
                    <?php if (empty($clients)): 
                        $default_clients = [
                            ['company_name' => 'IDEMIA', 'logo_url' => 'idemia-logo.svg'],
                            ['company_name' => 'Pari Match', 'logo_url' => 'parimatch-logo.svg'],
                            ['company_name' => 'OpenSense Labs', 'logo_url' => 'opensense-logo.svg'],
                            ['company_name' => 'Hubsell', 'logo_url' => 'hubsell-logo.svg'],
                            ['company_name' => 'Cladiator', 'logo_url' => 'cladiator-logo.svg'],
                            ['company_name' => 'Gripphy', 'logo_url' => 'gripphy-logo.svg']
                        ];
                        
                        // Print logos twice for seamless loop
                        for ($i = 0; $i < 2; $i++):
                            foreach ($default_clients as $client):
                    ?>
                            <div class="client-logo-box">
                                <div class="image-text-container">
                                    <img src="assets/images/<?php echo $client['logo_url']; ?>" 
                                         alt="<?php echo htmlspecialchars($client['company_name']); ?>" 
                                         class="img-fluid hover-color-image">
                                </div>
                            </div>
                    <?php 
                            endforeach;
                        endfor;
                    else:
                        // Print dynamic logos twice for seamless loop
                        for ($i = 0; $i < 2; $i++):
                            foreach ($clients as $client):
                    ?>
                            <div class="client-logo-box">
                                <div class="image-text-container">
                                    <img src="<?php echo htmlspecialchars($client['logo_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($client['company_name']); ?>" 
                                         class="img-fluid hover-color-image">
                                </div>
                            </div>
                    <?php 
                            endforeach;
                        endfor;
                    endif;
                    ?>
                </div>
            </div>
        </div>
    </section>



    <!-- Contact Section - Black Background -->
    <section id="contact" class="contact-section section-padding snap-section section-fade-in" style="background-color: var(--bg-color);">
        <div class="container">
            <h2 class="section-title">Contact Me</h2>
            <form id="contactFormHome" action="services/process_contact.php" method="POST">
                <input type="hidden" name="redirect" value="true">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                    </div>
                    <div class="col-md-6 mb-4">
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                    </div>
                    <div class="col-md-12 mb-4">
                        <textarea name="message" class="form-control" rows="4" placeholder="Your Message" required></textarea>
                    </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    
    <!-- Direct Dark Mode Script (Debugging) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Direct script execution');
            const darkModeToggle = document.getElementById('darkModeToggle');
            console.log('Direct toggle element:', darkModeToggle);
            
            if (darkModeToggle) {
                darkModeToggle.addEventListener('click', function() {
                    console.log('Toggle clicked directly');
                    document.body.classList.toggle('dark-mode');
                    const isDarkMode = document.body.classList.contains('dark-mode');
                    darkModeToggle.innerHTML = isDarkMode ? '☀️' : '🌙';
                    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
                });
            }
        });
    </script>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/gap-animation.js"></script>
    <script src="assets/js/reduced-motion.js"></script>
    <!-- Load hover animation script -->
    <script src="assets/js/hover-animation.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize AOS animation
            initAOS();
            
            // Problem items animation with IntersectionObserver
            const problemItems = document.querySelectorAll('.js-animate-problem');
            
            if ('IntersectionObserver' in window) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('visible');
                            observer.unobserve(entry.target);
                        }
                    });
                }, {
                    root: null,
                    threshold: 0.2,
                    rootMargin: '0px 0px -50px 0px'
                });
                
                problemItems.forEach(item => {
                    observer.observe(item);
                });
            } else {
                // Fallback for browsers without IntersectionObserver support
                problemItems.forEach(item => {
                    item.classList.add('visible');
                });
            }
            
            // Contact form submission for homepage
            $('#contactFormHome').on('submit', function(e) {
                if (!$(this).find('input[name="redirect"]').val()) {
                    e.preventDefault();
                    
                    const button = $(this).find('button[type="submit"]');
                    const originalButtonText = button.html();
                    button.html('<i class="fas fa-spinner fa-spin"></i> Sending...').prop('disabled', true);
                    
                    $.ajax({
                        type: 'POST',
                        url: 'services/process_contact.php',
                        data: $(this).serialize(),
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                alert('Thank you for your message. I will get back to you soon!');
                                $('#contactFormHome')[0].reset();
                            } else {
                                alert(response.message || 'An error occurred. Please try again.');
                            }
                        },
                        error: function() {
                            alert('An error occurred. Please try again later.');
                        },
                        complete: function() {
                            button.html(originalButtonText).prop('disabled', false);
                        }
                    });
                }
            });
        });

        // Canvas Animation for The Gap section        // Canvas Animation for The Gap section has been moved to gap-animation.js
        // This ensures proper initialization after DOM is loaded
        
        // Intersection Observer for fade-in effects
        const fadeElements = document.querySelectorAll('.fade-in');
        if (fadeElements.length > 0 && 'IntersectionObserver' in window) {
            // Adjust threshold based on device type for better mobile performance
            const isMobileDevice = window.innerWidth < 768;
            const observerThreshold = isMobileDevice ? 0.2 : 0.1;
            const observerMargin = isMobileDevice ? '10px' : '20px';
            
            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Add visible class with a slight delay on mobile to stagger animations
                        if (isMobileDevice) {
                            const index = Array.from(fadeElements).indexOf(entry.target);
                            setTimeout(() => {
                                entry.target.classList.add('visible');
                            }, index * 150); // 150ms delay between each element
                        } else {
                            entry.target.classList.add('visible');
                        }
                        fadeObserver.unobserve(entry.target); // Stop observing once animation is triggered
                    }
                });
            }, { 
                threshold: observerThreshold,
                rootMargin: observerMargin 
            });
            
            fadeElements.forEach(element => {
                fadeObserver.observe(element);
            });
            
            // Update observer settings on window resize
            window.addEventListener('resize', () => {
                const wasIsMobile = isMobileDevice;
                const newIsMobile = window.innerWidth < 768;
                
                // Only reinitialize if device type changed
                if (wasIsMobile !== newIsMobile) {
                    fadeElements.forEach(element => {
                        if (!element.classList.contains('visible')) {
                            fadeObserver.unobserve(element);
                            fadeObserver.observe(element);
                        }
                    });
                }
            });
        }
        const fadeElements = document.querySelectorAll('.fade-in');
        
        if (fadeElements.length > 0 && 'IntersectionObserver' in window) {
            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.1 });
            
            fadeElements.forEach(element => {
                fadeObserver.observe(element);
            });
        } else {
            // Fallback for browsers without IntersectionObserver
            fadeElements.forEach(element => {
                element.classList.add('visible');
            });
        }
    </script>

    <!-- Scroll Navigation Indicator -->
    <div class="scroll-indicator">
        <div class="scroll-dot" data-target="home" data-tooltip="Home"></div>
        <div class="scroll-dot" data-target="about" data-tooltip="About Me"></div>
        <div class="scroll-dot" data-target="services" data-tooltip="My Services"></div>
        <div class="scroll-dot" data-target="case-studies" data-tooltip="Case Studies"></div>
        <div class="scroll-dot" data-target="contact" data-tooltip="Contact Me"></div>
    </div>

    <script>
        // Enhanced scroll indicator and section visibility
        document.addEventListener('DOMContentLoaded', function() {
            const scrollDots = document.querySelectorAll('.scroll-dot');
            const sections = document.querySelectorAll('.snap-section');
            const fadeElements = document.querySelectorAll('.section-fade-in');
            
            // Section visibility observer
            const sectionObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Update active scroll dot
                        const sectionId = entry.target.id;
                        scrollDots.forEach(dot => {
                            dot.classList.toggle('active', dot.dataset.target === sectionId);
                        });
                        
                        // Add fade-in animation
                        if (entry.target.classList.contains('section-fade-in')) {
                            entry.target.classList.add('visible');
                        }
                    }
                });
            }, { threshold: 0.5 });
            
            // Observe all sections
            sections.forEach(section => sectionObserver.observe(section));
            
            // Scroll dot click handlers
            scrollDots.forEach(dot => {
                dot.addEventListener('click', function() {
                    const targetId = this.dataset.target;
                    const targetSection = document.getElementById(targetId);
                    
                    if (targetSection) {
                        targetSection.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });
            
            // Enhanced fade-in animation observer
            const fadeObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, { threshold: 0.2 });
            
            fadeElements.forEach(element => {
                fadeObserver.observe(element);
            });
        });
    </script>
</body>
</html>