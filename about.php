<?php
require_once 'database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="about-section">
        <div class="container">
            <section class="hero-section text-center">
                <div class="hero-content">
                    <h1 class="display-1 fw-bold mb-4">Your Content's Not Broken.<br><span class="text-muted">Just… Forgettable</span></h1>
                    <p class="lead text-gradient mb-5">"Clarity is rebellion in a world full of noise"</p>
                </div>
            </section>

            <section class="content-blocks">
                <div class="block-container">
                    <div class="block fade-in" data-aos="fade-up">
                        <p class="lead-text">In a world of 8-second attention spans, everything starts to feel like noise.</p>
                        <p class="supporting-text">They scroll. Blink. Scroll again.</p>
                    </div>

                    <div class="block emphasis fade-in" data-aos="fade-up">
                        <p class="lead-text">Your content doesn't get ignored because it's bad.</p>
                        <p class="supporting-text">It gets ignored because it blends in.</p>
                    </div>

                    <div class="block fade-in" data-aos="fade-up">
                        <p class="lead-text">Safe. Polished. Buzzworded to death.</p>
                        <p class="supporting-text">It says everything and means nothing.</p>
                    </div>

                    <div class="block highlight fade-in" data-aos="fade-up">
                        <p class="lead-text">But people don't pause for perfect.</p>
                        <p class="supporting-text">They stop for real.</p>
                    </div>

                    <div class="block fade-in" data-aos="fade-up">
                        <p class="lead-text">For something that makes them feel something.</p>
                        <p class="supporting-text">That snaps them out of scroll mode and makes them listen.</p>
                    </div>

                    <div class="block statement fade-in" data-aos="fade-up">
                        <p class="focus-text">That's what I help you do.</p>
                    </div>

                    <div class="block expertise fade-in" data-aos="fade-up">
                        <p class="lead-text">With a background in storytelling, brand strategy, and marketing —</p>
                        <p class="supporting-text">I help brands cut the fluff, find their edge, and say the thing that actually lands.</p>
                        <p class="supporting-text">With strategy that digs deep. Copy that cuts through. And AI that brings it all together.</p>
                    </div>

                    <div class="block conclusion fade-in" data-aos="fade-up">
                        <p class="impact-text">So you don't just blend in.</p>
                        <p class="impact-text">You stick.</p>
                        <p class="impact-text">You sell.</p>
                    </div>
                </div>
            </section>

            <!-- Professional Experience Section -->
            <section class="experience-section my-5">
                <h2 class="section-title">Professional Journey</h2>
                <div class="experience-timeline">
                    <div class="timeline-item current">
                        <h3>Marketing Lead at OpenSense Labs</h3>
                        <p class="timeline-date">May 2023 - March 2024</p>
                        <div class="achievements">
                            <ul>
                                <li>Led GTM strategies with measurable impact on product visibility</li>
                                <li>Improved product page traffic by 30% through strategic SEO optimization</li>
                                <li>Spearheaded ABM campaigns for enhanced brand reach</li>
                            </ul>
                        </div>
                    </div>

                    <div class="timeline-item">
                        <h3>Marketing Communications Strategist at hubsell</h3>
                        <p class="timeline-date">June 2021 - May 2023</p>
                        <div class="achievements">
                            <ul>
                                <li>Achieved 40% organic traffic growth through data-driven content strategy</li>
                                <li>Enhanced website conversion rates by 10% through strategic redesign</li>
                                <li>Led cross-functional alignment of marketing messaging</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Client Showcase Section -->
            <section class="trusted-by my-5">
                <h2 class="section-title">Trusted By Industry Leaders</h2>
                <div class="client-grid">
                    <?php
                    $clients = array(
                        array("OpenSense Labs", "SaaS/Technology"),
                        array("Gripphy", "Marketing/Creative Services"),
                        array("hubshell", "Sales Enablement/Technology"),
                        array("IDEMIA", "Identity & Security")
                    );
                    
                    foreach ($clients as $client): ?>
                        <div class="client-item">
                            <div class="client-logo">
                                <img src="images/clients/<?php echo strtolower(str_replace(' ', '-', $client[0])); ?>.svg" 
                                     alt="<?php echo $client[0]; ?> logo" 
                                     class="img-fluid">
                            </div>
                            <p class="client-industry"><?php echo $client[1]; ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <!-- Call-to-Action Section -->
            <section class="cta-section text-center my-5">
                <div class="cta-content">
                    <h2>Ready to Make Your Content Unforgettable?</h2>
                    <p>Let's work together to cut through the noise and create content that truly resonates.</p>
                    <a href="contact.php" class="btn btn-primary btn-lg">Start a Conversation</a>
                </div>
            </section>
        </div>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>