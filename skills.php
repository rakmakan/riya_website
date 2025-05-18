<?php
require_once 'database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Skills & Expertise - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Portfolio</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#work">Work</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="case-studies.php">Case Studies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="skills.php">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Why I'm Your Go-To Section -->
    <section class="section-padding pt-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <h2 class="section-title">Why I'm Your Go-To for Marketing Comms</h2>
                    <div class="content-block">
                        <p class="lead mb-4">I didn't stumble into marketing. I built it.<br>
                        Layer by layer, over seven years of learning how people think, what makes them feel, and why they act.</p>

                        <p class="mb-4">It started with a Bachelor's and Master's in English.<br>
                        That's where I learned to unpack behavior, analyze culture, and understand the power of language—not just to inform, but to influence.</p>

                        <p class="mb-4">Then came a degree in Marketing & Brand Direction.<br>
                        That's where strategy met storytelling—where I learned to shape perception, build positioning, and turn brand values into messages people remember.</p>

                        <p class="mb-4">I added the tools: certifications in digital marketing, SEO, Google Ads, email marketing, and analytics. Because knowing how to think is one thing. Knowing how to execute—that's what brings it to life.</p>

                        <p class="mb-4">I don't rush the work. I obsess over tone, flow, timing, and the smallest of choices—because the magic's always in the details.</p>

                        <p class="mb-4">Writing isn't just work. It's craft.<br>
                        And I bring that mindset into every brand I work with.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section class="section-padding bg-light">
        <div class="container">
            <h2 class="section-title">Education</h2>
            <div class="row g-4">
                <div class="col-lg-4">
                    <div class="education-card h-100">
                        <h3 class="h4 mb-3">Executive Diploma in Marketing & Direction</h3>
                        <p class="location mb-3">Delhi, India</p>
                        <h4 class="h5 mb-3">Key Learnings:</h4>
                        <ul class="list-unstyled">
                            <li>✓ Principles of management and marketing</li>
                            <li>✓ Branding vs. marketing</li>
                            <li>✓ Brand positioning and evaluation</li>
                            <li>✓ Brand equity and architecture</li>
                            <li>✓ Communication strategies</li>
                            <li>✓ Verbal, visual, and sensory identity systems</li>
                            <li>✓ Consumer behavior and ZMET analysis</li>
                            <li>✓ Online branding and brand audits</li>
                            <li>✓ Strategic brand management</li>
                            <li>✓ Creative direction and brand-mark design</li>
                            <li>✓ Case study–based learning</li>
                        </ul>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="education-card h-100">
                        <h3 class="h4 mb-3">M.A. (Hons.) in English Literature</h3>
                        <p class="location mb-3">Delhi, India</p>
                        <h4 class="h5 mb-3">Focus:</h4>
                        <ul class="list-unstyled">
                            <li>✓ Critical thinking</li>
                            <li>✓ Storytelling</li>
                            <li>✓ Narrative analysis</li>
                        </ul>
                        <p class="mt-3">Foundations that power my brand communication approach today</p>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="education-card h-100">
                        <h3 class="h4 mb-3">Digital Marketing Nanodegree</h3>
                        <p class="location mb-3">Online, Canada</p>
                        <h4 class="h5 mb-3">Key Learnings:</h4>
                        <ul class="list-unstyled">
                            <li>✓ Content strategy and storytelling frameworks</li>
                            <li>✓ Landing page planning and tracking</li>
                            <li>✓ Social media marketing and advertising</li>
                            <li>✓ Campaign planning across platforms</li>
                            <li>✓ SEO: keyword research and audits</li>
                            <li>✓ Google Ads and SEM</li>
                            <li>✓ Display and video advertising</li>
                            <li>✓ Email marketing and A/B testing</li>
                            <li>✓ Marketing analytics</li>
                            <li>✓ Conversion tracking</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Certifications Section -->
    <section class="section-padding">
        <div class="container">
            <h2 class="section-title">Licenses & Certifications</h2>
            <div class="row g-4">
                <div class="col-md-6 col-lg-3">
                    <div class="certification-card text-center">
                        <img src="images/hubspot-logo.svg" alt="Hubspot Academy" class="mb-3">
                        <h4>Email Marketing Certification</h4>
                        <p class="mb-0">Hubspot Academy</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="certification-card text-center">
                        <img src="images/metdda-logo.png" alt="Meta" class="mb-3">
                        <h4>Marketing Analytics</h4>
                        <p class="mb-0">Meta</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="certification-card text-center">
                        <img src="images/udacity-logo.jpg" alt="Udacity" class="mb-3">
                        <h4>Digital Marketing Nanodegree</h4>
                        <p class="mb-0">Udacity</p>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-3">
                    <div class="certification-card text-center">
                        <img src="images/wes-logo.webp" alt="WES" class="mb-3">
                        <h4>WES Certification</h4>
                        <p class="mb-0">Credly by Pearson</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-light py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2023 Portfolio. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>