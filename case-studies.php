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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

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

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>