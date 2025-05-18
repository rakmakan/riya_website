<?php
require_once 'database/config.php';
$case_studies = get_case_studies();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Case Studies - Portfolio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <!-- Case Studies List -->
    <section class="case-studies-list section-padding">
        <div class="container">
            <h1 class="section-title">Case Studies</h1>
            <div class="row g-4">
                <?php foreach ($case_studies as $case): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="case-study-card h-100">
                        <img src="<?php echo htmlspecialchars($case['featured_image']); ?>" 
                             class="card-img-top" alt="<?php echo htmlspecialchars($case['title']); ?>">
                        <div class="card-body">
                            <h3 class="card-title h4"><?php echo htmlspecialchars($case['title']); ?></h3>
                            <p class="card-text"><?php echo htmlspecialchars($case['summary']); ?></p>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">Client: <?php echo htmlspecialchars($case['client']); ?></small>
                                <a href="case-study.php?slug=<?php echo urlencode($case['slug']); ?>" 
                                   class="btn btn-outline-primary">View Case Study</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
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