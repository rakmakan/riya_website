<?php
require_once 'database/config.php';

$slug = $_GET['slug'] ?? '';
$case_study = get_case_study($slug);

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
    <title><?php echo htmlspecialchars($case_study['title']); ?> - Case Study</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css">
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
                        <a class="nav-link active" href="case-studies.php">Case Studies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#skills">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#contact">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Case Study Detail -->
    <section class="case-study-detail section-padding">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-4"><?php echo htmlspecialchars($case_study['title']); ?></h1>
                    <div class="meta-info mb-4">
                        <span class="me-4"><strong>Client:</strong> <?php echo htmlspecialchars($case_study['client']); ?></span>
                        <span><strong>Completed:</strong> <?php echo date('F Y', strtotime($case_study['date_completed'])); ?></span>
                    </div>
                    <img src="<?php echo htmlspecialchars($case_study['featured_image']); ?>" 
                         alt="<?php echo htmlspecialchars($case_study['title']); ?>" 
                         class="img-fluid rounded mb-4">
                    <div class="description">
                        <?php echo nl2br(htmlspecialchars($case_study['description'])); ?>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="case-study-sidebar">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Services Provided</h3>
                                <ul class="list-unstyled">
                                    <?php foreach ($services as $service): ?>
                                    <li class="mb-2">✓ <?php echo htmlspecialchars(trim($service)); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Details -->
            <div class="project-details mb-5">
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Challenges</h3>
                                <?php echo nl2br(htmlspecialchars($case_study['challenges'])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Solutions</h3>
                                <?php echo nl2br(htmlspecialchars($case_study['solutions'])); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="h5 mb-3">Results</h3>
                                <?php echo nl2br(htmlspecialchars($case_study['results'])); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Gallery -->
            <?php if (!empty($gallery_images)): ?>
            <div class="project-gallery">
                <h2 class="h3 mb-4">Project Gallery</h2>
                <div class="row g-4">
                    <?php foreach ($gallery_images as $image): ?>
                    <div class="col-md-4">
                        <a href="<?php echo htmlspecialchars(trim($image)); ?>" 
                           data-lightbox="gallery" 
                           class="gallery-item">
                            <img src="<?php echo htmlspecialchars(trim($image)); ?>" 
                                 class="img-fluid rounded" 
                                 alt="Gallery Image">
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="text-center mt-5">
                <a href="case-studies.php" class="btn btn-outline-primary">Back to Case Studies</a>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>