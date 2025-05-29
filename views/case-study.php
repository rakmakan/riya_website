<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/config.php';

// Get case study slug from URL
$slug = isset($_GET['slug']) ? $_GET['slug'] : '';
$case_study = get_case_study($slug);

// Redirect if case study not found
if (!$case_study) {
    header('Location: case-studies.php');
    exit;
}

// Convert gallery string to array
$gallery_images = !empty($case_study['gallery']) ? explode(',', $case_study['gallery']) : [];
$services = !empty($case_study['services']) ? explode(',', $case_study['services']) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($case_study['title']); ?> - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .case-study-detail {
            padding-top: 120px;
        }
        .case-study-header {
            position: relative;
            padding: 6rem 0 4rem;
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.3)), url('<?php echo htmlspecialchars($case_study['featured_image']); ?>');
            background-size: cover;
            background-position: center;
            color: white;
            margin-bottom: 4rem;
        }
        .case-study-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 1;
        }
        .case-study-header .container {
            position: relative;
            z-index: 2;
        }
        .case-meta {
            display: inline-block;
            background-color: var(--primary-color);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 30px;
            font-size: 0.9rem;
            margin-right: 1rem;
        }
        .meta-icon {
            margin-right: 5px;
        }
        .service-tag {
            display: inline-block;
            background-color: #f8f9fa;
            padding: 0.4rem 1rem;
            border-radius: 30px;
            margin: 0 0.5rem 0.5rem 0;
            font-size: 0.9rem;
            color: var(--primary-color);
            border: 1px solid #dee2e6;
        }
        .detail-section {
            position: relative;
            padding: 2rem;
            border-radius: 10px;
            background: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .detail-section:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .detail-section h3 {
            position: relative;
            padding-bottom: 1rem;
            margin-bottom: 1.5rem;
            color: var(--primary-color);
        }
        .detail-section h3::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 50px;
            height: 3px;
            background: var(--primary-color);
        }
        .gallery-item {
            display: block;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .gallery-item:hover {
            transform: translateY(-5px);
        }
        .gallery-item img {
            transition: transform 0.3s ease;
        }
        .gallery-item:hover img {
            transform: scale(1.05);
        }
        .project-description {
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .back-button {
            display: inline-block;
            padding: 0.75rem 2rem;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .back-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .case-info-box {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 2rem;
            margin-bottom: 2rem;
        }
        /* Dark mode overrides */
        .dark-mode .detail-section {
            background-color: var(--card-bg);
        }
        .dark-mode .case-info-box {
            background-color: rgba(255,255,255,0.05);
        }
        .dark-mode .service-tag {
            background-color: var(--card-bg);
            border-color: var(--border-color);
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Case Study Hero -->
    <section class="case-study-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4"><?php echo htmlspecialchars($case_study['title']); ?></h1>
                    <div class="meta-info mb-4">
                        <span class="case-meta"><i class="fas fa-building meta-icon"></i><?php echo htmlspecialchars($case_study['client']); ?></span>
                        <span class="case-meta"><i class="fas fa-calendar meta-icon"></i><?php echo date('F Y', strtotime($case_study['date_completed'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Study Content -->
    <section class="case-study-content">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8" data-aos="fade-up" data-aos-delay="100">
                    <div class="project-description mb-5">
                        <?php echo $case_study['description']; ?>
                    </div>
                    
                    <!-- Project Details Section -->
                    <div class="row g-4 mb-5">
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="detail-section">
                                <h3>Challenges</h3>
                                <?php echo nl2br(htmlspecialchars($case_study['challenges'])); ?>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                            <div class="detail-section">
                                <h3>Solutions</h3>
                                <?php echo nl2br(htmlspecialchars($case_study['solutions'])); ?>
                            </div>
                        </div>
                        <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                            <div class="detail-section">
                                <h3>Results</h3>
                                <?php echo nl2br(htmlspecialchars($case_study['results'])); ?>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Project Gallery -->
                    <?php if (!empty($gallery_images)): ?>
                    <div class="project-gallery mt-5" data-aos="fade-up">
                        <h2 class="section-title">Project Gallery</h2>
                        <div class="row g-4">
                            <?php foreach ($gallery_images as $index => $image): ?>
                            <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo ($index * 100); ?>">
                                <a href="<?php echo htmlspecialchars(trim($image)); ?>" 
                                data-lightbox="gallery" 
                                class="gallery-item image-text-container">
                                    <img src="<?php echo htmlspecialchars(trim($image)); ?>" 
                                        class="img-fluid rounded hover-color-image" 
                                        alt="Gallery Image">
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="case-study-sidebar">
                        <div class="case-info-box mb-4">
                            <h3 class="h4 mb-4">About this Project</h3>
                            <p><strong>Client:</strong> <?php echo htmlspecialchars($case_study['client']); ?></p>
                            <p><strong>Completed:</strong> <?php echo date('F Y', strtotime($case_study['date_completed'])); ?></p>
                            <p class="mb-0"><strong>Services:</strong></p>
                            <div class="mt-2">
                                <?php foreach ($services as $service): ?>
                                <span class="service-tag"><?php echo htmlspecialchars(trim($service)); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        
                        <div class="case-info-box text-center">
                            <h3 class="h4 mb-4">Ready to Create Something Amazing?</h3>
                            <p>Let's discuss how I can help your business achieve similar results.</p>
                            <a href="contact.php" class="btn btn-primary">Start a Conversation</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5 mb-5" data-aos="fade-up">
                <a href="case-studies.php" class="btn btn-outline-primary back-button">
                    <i class="fas fa-arrow-left me-2"></i> Back to Case Studies
                </a>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>
    
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/hover-animation.js"></script>
    
    <!-- Initialize Lightbox -->
    <script>
        $(document).ready(function() {
            // Initialize Lightbox
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true
            });
        });
    </script>
</body>
</html>