<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/database/config.php';
$case_studies = get_case_studies();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Studies - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Case Studies Header -->
    <section class="case-studies-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Case Studies</h1>
                    <p class="lead">Explore how I've helped businesses transform their messaging and achieve growth through strategic communications.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Case Studies List -->
    <section class="case-studies-list section-padding">
        <div class="container">
            <div class="section-intro">
                <p>Each case study provides an in-depth look at the challenges, solutions, and results of projects I've worked on. You'll find detailed information about my approach and the impact of my work.</p>
            </div>
            
            <div class="row g-4">
                <?php foreach ($case_studies as $case): 
                    $services = !empty($case['services']) ? explode(',', $case['services']) : [];
                ?>
                <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="case-study-card">
                        <!-- Top Section (Visual) -->
                        <div class="image-container image-text-container">
                            <img src="<?php echo htmlspecialchars($case['featured_image']); ?>" 
                                 alt="<?php echo htmlspecialchars($case['title']); ?>"
                                 class="hover-color-image">
                            <div class="card-overlay">
                                <span class="badge bg-primary">Case Study</span>
                            </div>
                        </div>
                        
                        <!-- Middle Section (Content) -->
                        <div class="card-body">
                            <h3 class="card-title fw-semibold"><?php echo htmlspecialchars($case['title']); ?></h3>
                            
                            <div class="service-tags">
                                <?php foreach (array_slice($services, 0, 3) as $service): ?>
                                <span class="service-tag"><i class="fas fa-tag"></i><?php echo htmlspecialchars(trim($service)); ?></span>
                                <?php endforeach; ?>
                                <?php if (count($services) > 3): ?>
                                <span class="service-tag"><i class="fas fa-ellipsis-h"></i>+<?php echo count($services) - 3; ?> more</span>
                                <?php endif; ?>
                            </div>
                            
                            <p class="card-text"><?php echo htmlspecialchars($case['summary']); ?></p>
                        </div>
                        
                        <!-- Footer Section -->
                        <div class="card-footer">
                            <div class="meta-info">
                                <div class="client-info">
                                    <i class="fas fa-building"></i>
                                    <span><?php echo htmlspecialchars($case['client']); ?></span>
                                </div>
                                <div class="date-completed">
                                    <i class="far fa-calendar-alt"></i>
                                    <span><?php echo date('F Y', strtotime($case['date_completed'])); ?></span>
                                </div>
                            </div>
                            
                            <a href="case-study.php?slug=<?php echo urlencode($case['slug']); ?>" 
                               class="btn btn-secondary view-case-btn">View Details <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/hover-animation.js"></script>
</body>
</html>