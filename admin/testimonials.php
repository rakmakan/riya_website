<?php
require_once '../database/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Handle testimonial submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['client_name'])) {
        $stmt = $db->prepare('INSERT INTO testimonials (client_name, client_position, review_text, rating, image_url) VALUES (:name, :position, :review, :rating, :image)');
        $stmt->bindValue(':name', $_POST['client_name'], SQLITE3_TEXT);
        $stmt->bindValue(':position', $_POST['client_position'], SQLITE3_TEXT);
        $stmt->bindValue(':review', $_POST['review_text'], SQLITE3_TEXT);
        $stmt->bindValue(':rating', $_POST['rating'], SQLITE3_INTEGER);
        $stmt->bindValue(':image', $_POST['image_url'], SQLITE3_TEXT);
        $stmt->execute();
    }
}

$testimonials = get_testimonials();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Testimonials</h1>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <!-- Add New Testimonial -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Add New Testimonial</h3>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Name</label>
                            <input type="text" name="client_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position/Company</label>
                            <input type="text" name="client_position" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Text</label>
                        <textarea name="review_text" class="form-control" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rating (1-5)</label>
                            <input type="number" name="rating" class="form-control" min="1" max="5" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile Image URL</label>
                            <input type="text" name="image_url" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Testimonial</button>
                </form>
            </div>
        </div>

        <!-- Existing Testimonials -->
        <h3 class="mb-3">Existing Testimonials</h3>
        <div class="row">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <img src="<?php echo htmlspecialchars($testimonial['image_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($testimonial['client_name']); ?>" 
                                 class="rounded-circle me-3" style="width: 50px; height: 50px; object-fit: cover;">
                            <div>
                                <h5 class="card-title mb-0"><?php echo htmlspecialchars($testimonial['client_name']); ?></h5>
                                <small class="text-muted"><?php echo htmlspecialchars($testimonial['client_position']); ?></small>
                            </div>
                        </div>
                        <p class="card-text"><?php echo htmlspecialchars($testimonial['review_text']); ?></p>
                        <div class="text-warning">
                            <?php for ($i = 0; $i < $testimonial['rating']; $i++): ?>
                            ⭐
                            <?php endfor; ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>