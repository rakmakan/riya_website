<?php
require_once '../database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Work Experience - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .timeline {
            position: relative;
            padding: 50px 0;
        }
        
        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            width: 2px;
            height: 100%;
            background: var(--bs-primary);
        }
        
        .work-experience-item {
            position: relative;
            margin-bottom: 60px;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.5s ease;
        }
        
        .work-experience-item.animate {
            opacity: 1;
            transform: translateY(0);
        }
        
        .company-info {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .company-info:hover {
            transform: translateY(-5px);
        }
        
        .company-logo {
            max-width: 150px;
            height: auto;
            margin-bottom: 1rem;
        }
        
        .role-description {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .responsibility-list {
            list-style: none;
            padding-left: 0;
        }
        
        .responsibility-list li {
            position: relative;
            padding-left: 25px;
            margin-bottom: 10px;
            line-height: 1.6;
        }
        
        .responsibility-list li::before {
            content: '→';
            position: absolute;
            left: 0;
            color: var(--bs-primary);
        }
        
        .duration {
            display: inline-block;
            background: var(--bs-primary);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            margin: 10px 0;
        }
        
        .industry {
            color: var(--bs-secondary);
            font-style: italic;
        }
        
        @media (max-width: 991px) {
            .timeline::before {
                left: 0;
            }
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Work Experience Section -->
    <section class="work-experience-section section-padding pt-120">
        <div class="container">
            <h2 class="section-title text-center mb-5">Professional Journey</h2>
            
            <div class="timeline">
                <!-- Current Role -->
                <div class="work-experience-item">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-4">
                            <div class="company-info">
                                <div class="image-text-container">
                                    <img src="../assets/images/clients/gripphy-logo.svg" alt="Gripphy" class="company-logo hover-color-image">
                                </div>
                                <h3 class="h4">Brand Strategy & Marketing Manager</h3>
                                <p class="company-name fw-bold mb-2">Gripphy</p>
                                <p class="duration">Jan 2025 - Present</p>
                                <p class="industry">Marketing/Creative Services</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="role-description">
                                <ul class="responsibility-list">
                                    <li>Spearheaded brand strategy initiatives tailored for remote-first operations</li>
                                    <li>Developed clear, differentiated positioning for the brand in a competitive digital landscape</li>
                                    <li>Led content alignment and campaign strategy across teams to improve message cohesion and brand visibility</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- OpenSense Labs -->
                <div class="work-experience-item">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-4">
                            <div class="company-info">
                                <div class="image-text-container">
                                    <img src="../assets/images/clients/opensense-logo.svg" alt="OpenSense Labs" class="company-logo hover-color-image">
                                </div>
                                <h3 class="h4">Marketing Lead</h3>
                                <p class="company-name fw-bold mb-2">OpenSense Labs</p>
                                <p class="duration">May 2023 - Mar 2024</p>
                                <p class="industry">SaaS/Technology</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="role-description">
                                <ul class="responsibility-list">
                                    <li>Executed go-to-market (GTM) strategies in collaboration with product and design teams</li>
                                    <li>Conducted SEO audits, improving product page visibility and driving qualified traffic by 30%</li>
                                    <li>Launched Account-Based Marketing (ABM) campaigns targeted to user segments</li>
                                    <li>Partnered with HR to streamline internal communications</li>
                                    <li>Directed the creation of 90+ content pieces across platforms</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hubsell -->
                <div class="work-experience-item">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-4">
                            <div class="company-info">
                                <div class="image-text-container">
                                    <img src="../assets/images/clients/hubsell-logo.svg" alt="Hubsell" class="company-logo hover-color-image">
                                </div>
                                <h3 class="h4">Marketing Communications Strategist</h3>
                                <p class="company-name fw-bold mb-2">Hubsell</p>
                                <p class="duration">Jun 2021 - May 2023</p>
                                <p class="industry">Sales Enablement/Technology</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="role-description">
                                <ul class="responsibility-list">
                                    <li>Led a performance-driven content strategy aligned with SEO best practices and business goals</li>
                                    <li>Increased organic traffic by 40% through data-driven refinement of content based on CRM and Google Analytics insights</li>
                                    <li>Managed full website redesign, enhancing navigation and boosting conversion by 10%</li>
                                    <li>Aligned messaging with sales and product teams to better address customer pain points and improve lead quality</li>
                                    <li>Mentored junior content creators and upheld brand voice across all communication channels</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- IDEMIA -->
                <div class="work-experience-item">
                    <div class="row g-4 align-items-center">
                        <div class="col-lg-4">
                            <div class="company-info">
                                <div class="image-text-container">
                                    <img src="../assets/images/clients/idemia-logo.svg" alt="IDEMIA" class="company-logo hover-color-image">
                                </div>
                                <h3 class="h4">Branding & Communications Executive</h3>
                                <p class="company-name fw-bold mb-2">IDEMIA</p>
                                <p class="duration">Jun 2018 - Jun 2021</p>
                                <p class="industry">Identity & Security</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="role-description">
                                <ul class="responsibility-list">
                                    <li>Maintained consistent brand messaging across digital and print platforms for over 100 SKUs</li>
                                    <li>Reduced project cycle time by creating SOPs and optimizing review workflows using Jira</li>
                                    <li>Drafted internal communication materials, improving cross-functional collaboration</li>
                                    <li>Executed employee engagement campaigns, contributing to a top pulse survey ranking</li>
                                    <li>Authored internal and external articles simplifying complex topics for broader audience understanding</li>
                                    <li>Supported C-level communications and co-led CSR initiatives to reinforce company culture</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/hover-animation.js"></script>
    <script>
        // Add animation when elements come into view
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.work-experience-item').forEach((item) => {
            observer.observe(item);
        });
    </script>
</body>
</html>