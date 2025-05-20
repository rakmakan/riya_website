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
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section id="home" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-lg-1 order-2">
                    <div class="hero-content">
                        <h1 class="hero-heading">Building Brands Through Strategic Storytelling</h1>
                        <p class="hero-description">Helping brands cut through the noise with compelling narratives, data-driven strategies, and AI-powered solutions.</p>
                        
                        <div class="hero-cta-group">
                            <a href="#contact" class="btn btn-primary btn-hero-primary">Start a Project</a>
                            <a href="views/case-studies.php" class="btn btn-outline-dark btn-hero-primary">View Case Studies</a>
                        </div>

                        <div class="hero-stats">
                            <div class="hero-stat">
                                <div class="hero-stat-number">7+</div>
                                <div class="hero-stat-label">Years Experience</div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-number">90+</div>
                                <div class="hero-stat-label">Projects Completed</div>
                            </div>
                            <div class="hero-stat">
                                <div class="hero-stat-number">95%</div>
                                <div class="hero-stat-label">Client Satisfaction</div>
                            </div>
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

    <!-- About Section -->
    <section id="about" class="about-section section-padding bg-light">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            <div class="row">
                <div class="col-lg-6">
                    <img src="assets/images/about-image.png" alt="About Image" class="img-fluid rounded shadow">
                </div>
                <div class="col-lg-6">
                    <h3 class="mb-4">Building Brands Through Strategic Storytelling</h3>
                    <p class="lead mb-4">I didn't stumble into marketing. I built it. Layer by layer, over seven years of learning how people think, what makes them feel, and why they act.</p>
                    <p class="mb-4">With a foundation in English Literature and specialized training in Marketing & Brand Direction, I bring both the art and science of communication to every project.</p>
                    <div class="d-flex align-items-center mb-4">
                        <div class="experience-highlight me-4">
                            <h4 class="mb-0">7+</h4>
                            <p class="mb-0">Years Experience</p>
                        </div>
                        <div class="experience-highlight">
                            <h4 class="mb-0">90+</h4>
                            <p class="mb-0">Projects Completed</p>
                        </div>
                    </div>
                    <a href="views/about.php" class="btn btn-primary">Learn More About Me</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services-section section-padding">
        <div class="container">
            <h2 class="section-title">My Services</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-bullseye"></i>
                        </div>
                        <h4>Market Positioning</h4>
                        <p>Most brands sound the same. I help you say something different — and mean it. Together, we'll figure out who you're for, what makes you worth caring about, and how to claim a space no one else owns.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-pen-fancy"></i>
                        </div>
                        <h4>Brand Copy</h4>
                        <p>Words make people feel things. Or scroll past. I write the kind that make them feel, act, and remember. Websites, taglines, decks, bios — if it needs a voice, I give it yours (but sharper).</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h4>Consulting</h4>
                        <p>Need a marketer without hiring one full-time? I plug into your team, review what's working, scrap what's not, and help you market smarter — not just louder.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How I Work Section -->
    <section id="how-i-work" class="how-i-work-section section-padding">
        <div class="container">
            <h2 class="section-title">How I Work</h2>
            <div class="row g-4">
                <!-- Step 1: LISTEN -->
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">1</div>
                        <div class="step-icon-circle">
                            <i class="fas fa-comments"></i>
                        </div>
                        <h3 class="step-title">LISTEN</h3>
                        <p class="step-description">We start with interviews, surveys, and a little (friendly) stalking to understand what your audience really thinks and wants.</p>
                        <ul class="step-tags">
                            <li>Voice-of-customer research</li>
                            <li>Stakeholder interviews</li>
                            <li>Message audit (AI-supported)</li>
                        </ul>
                        <div class="step-connector"></div>
                    </div>
                </div>

                <!-- Step 2: FRAME -->
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">2</div>
                        <div class="step-icon-circle">
                            <i class="fas fa-puzzle-piece"></i>
                        </div>
                        <h3 class="step-title">FRAME</h3>
                        <p class="step-description">We shape your message, tone, and position with a clear POV. Strategy before copy.</p>
                        <ul class="step-tags">
                            <li>Positioning + personality</li>
                            <li>Messaging framework</li>
                            <li>Voice & tone system</li>
                        </ul>
                        <div class="step-connector"></div>
                    </div>
                </div>

                <!-- Step 3: WRITE -->
                <div class="col-md-4">
                    <div class="process-step">
                        <div class="step-number">3</div>
                        <div class="step-icon-circle">
                            <i class="fas fa-pen-nib"></i>
                        </div>
                        <h3 class="step-title">WRITE</h3>
                        <p class="step-description">Words that sound human — and sell. AI helps move faster, not sound robotic.</p>
                        <ul class="step-tags">
                            <li>Website copy</li>
                            <li>Email flows</li>
                            <li>Sales decks & social messaging</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies Section -->
    <section id="case-studies" class="case-studies-section section-padding bg-light">
        <div class="container">
            <h2 class="section-title">Case Studies</h2>
            <div class="case-study-slider">
                <?php
                require_once 'database/config.php';
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
                                        <img src="<?php echo htmlspecialchars($case['featured_image']); ?>" 
                                             class="img-fluid" alt="<?php echo htmlspecialchars($case['title']); ?>">
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
                    <a href="views/case-studies.php" class="btn btn-outline-primary">View All Case Studies</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Review Section -->
    <section id="reviews" class="reviews-section section-padding">
        <div class="container">
            <h2 class="section-title">Client Reviews</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="review-card">
                        <div class="review-profile">
                            <img src="assets/images/hubsell-logo.svg" alt="Hubsell" class="company-logo">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="review-text">I highly recommend Riya to anybody needing help in marketing, corporate communications and PR. She is a self-starter with commendable storytelling, analytical and writing skills, all of which make her an excellent marketer. Her knowledge helped us create highly targeted content and scale our outreach.</p>
                        <h4 class="client-name">Karan Sharma</h4>
                        <p class="client-position">Founder, Hubsell</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="review-card">
                        <div class="review-profile">
                            <img src="assets/images/opensense-logo.svg" alt="Opensense Labs" class="company-logo">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="review-text">It was a pleasant experience working with Riya. She exhibited exceptional talent for copywriting, demonstrating a keen ability to craft compelling narratives that resonate with our target audience. A quick learner and someone who could always think on her feet, she added great value to our team.</p>
                        <h4 class="client-name">Danish Usmani</h4>
                        <p class="client-position">CEO, Opensense Labs</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="review-card">
                        <div class="review-profile">
                            <img src="assets/images/parimatch-logo.svg" alt="Parimatch" class="company-logo">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="review-text">It's a pleasure to work with Riya! All comms were done perfectly, she's well-structured and ready to implement changes if needed. All the text were selling and catchy. Will definitely go on cooperating with Riya and highly recommend her as TOP professional.</p>
                        <h4 class="client-name">Olha Tkachenko</h4>
                        <p class="client-position">Product Manager, Parimatch</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3">
                    <div class="review-card">
                        <div class="review-profile">
                            <img src="assets/images/idemia-logo.svg" alt="IDEMIA" class="company-logo">
                            <div class="rating">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                        <p class="review-text">Riya is brilliant at creating internal as well as external communications. She successfully executed various campaigns for us internally for employees as well as externally for clients and potential customers. She has a good understanding of technology and does a great job in defining the target audience.</p>
                        <h4 class="client-name">Manisha Dubey</h4>
                        <p class="client-position">VP Marketing & Communications, IDEMIA</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Client Logos Section -->
    <section id="clients" class="clients-section section-padding bg-light">
        <div class="container">
            <h2 class="section-title">Trusted By</h2>
            <div class="client-logos">
                <div class="row align-items-center justify-content-center g-4">
                    <div class="col-6 col-md-3">
                        <div class="client-logo-box">
                            <img src="assets/images/idemia-logo.svg" alt="IDEMIA" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="client-logo-box">
                            <img src="assets/images/parimatch-logo.svg" alt="Pari Match" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="client-logo-box">
                            <img src="assets/images/opensense-logo.svg" alt="OpenSense Labs" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="client-logo-box">
                            <img src="assets/images/hubsell-logo.svg" alt="Hubshell" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="client-logo-box">
                            <img src="assets/images/cladiator-logo.svg" alt="Cladiator" class="img-fluid">
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="client-logo-box">
                            <img src="assets/images/gripphy-logo.svg" alt="Gripphy" class="img-fluid">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="skills-section section-padding">
        <div class="container">
            <h2 class="section-title">Skills & Expertise</h2>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="skill-category">
                        <h3 class="mb-4">Marketing & Communications</h3>
                        <div class="skill-bar mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Brand Strategy & Positioning</span>
                                <span>95%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 95%" aria-valuenow="95" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill-bar mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Content Strategy</span>
                                <span>90%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill-bar mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Digital Marketing</span>
                                <span>88%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="skill-category">
                        <h3 class="mb-4">Digital Tools & Analytics</h3>
                        <div class="skill-bar mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>SEO & Google Analytics</span>
                                <span>92%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 92%" aria-valuenow="92" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill-bar mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Email Marketing</span>
                                <span>90%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div class="skill-bar mb-4">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Social Media Marketing</span>
                                <span>85%</span>
                            </div>
                            <div class="progress">
                                <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="views/skills.php" class="btn btn-outline-primary">View Full Skills & Experience</a>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact-section section-padding">
        <div class="container">
            <h2 class="section-title">Contact Me</h2>
            <form action="services/process_contact.php" method="POST">
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
</body>
</html>