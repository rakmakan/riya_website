<?php
require_once '../database/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $slug = strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    $summary = $_POST['summary'] ?? '';
    $description = $_POST['description'] ?? '';
    $client = $_POST['client'] ?? '';
    $services = $_POST['services'] ?? '';
    $date_completed = $_POST['date_completed'] ?? '';
    $featured_image = $_POST['featured_image'] ?? '';
    $gallery = $_POST['gallery'] ?? '';
    $challenges = $_POST['challenges'] ?? '';
    $solutions = $_POST['solutions'] ?? '';
    $results = $_POST['results'] ?? '';

    if (!empty($title)) {
        $stmt = $db->prepare('INSERT INTO case_studies (
            title, slug, summary, description, client, services, 
            date_completed, featured_image, gallery, challenges, 
            solutions, results
        ) VALUES (
            :title, :slug, :summary, :description, :client, :services,
            :date_completed, :featured_image, :gallery, :challenges,
            :solutions, :results
        )');

        $stmt->bindValue(':title', $title, SQLITE3_TEXT);
        $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
        $stmt->bindValue(':summary', $summary, SQLITE3_TEXT);
        $stmt->bindValue(':description', $description, SQLITE3_TEXT);
        $stmt->bindValue(':client', $client, SQLITE3_TEXT);
        $stmt->bindValue(':services', $services, SQLITE3_TEXT);
        $stmt->bindValue(':date_completed', $date_completed, SQLITE3_TEXT);
        $stmt->bindValue(':featured_image', $featured_image, SQLITE3_TEXT);
        $stmt->bindValue(':gallery', $gallery, SQLITE3_TEXT);
        $stmt->bindValue(':challenges', $challenges, SQLITE3_TEXT);
        $stmt->bindValue(':solutions', $solutions, SQLITE3_TEXT);
        $stmt->bindValue(':results', $results, SQLITE3_TEXT);

        $stmt->execute();
    }
}

$case_studies = get_case_studies();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Case Studies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Case Studies</h1>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <!-- Add New Case Study -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Add New Case Study</h3>
                <form method="POST" class="needs-validation" novalidate>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client</label>
                            <input type="text" name="client" class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Summary</label>
                        <textarea name="summary" class="form-control" rows="2" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control summernote" rows="5" required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Services (comma-separated)</label>
                            <input type="text" name="services" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Date Completed</label>
                            <input type="date" name="date_completed" class="form-control" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Featured Image URL</label>
                            <input type="text" name="featured_image" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Gallery Images URLs (comma-separated)</label>
                            <input type="text" name="gallery" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Challenges</label>
                            <textarea name="challenges" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Solutions</label>
                            <textarea name="solutions" class="form-control" rows="4" required></textarea>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Results</label>
                            <textarea name="results" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary">Add Case Study</button>
                </form>
            </div>
        </div>

        <!-- Existing Case Studies -->
        <h3 class="mb-3">Existing Case Studies</h3>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Date Completed</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($case_studies as $case): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($case['title']); ?></td>
                        <td><?php echo htmlspecialchars($case['client']); ?></td>
                        <td><?php echo date('F j, Y', strtotime($case['date_completed'])); ?></td>
                        <td>
                            <a href="../case-study.php?slug=<?php echo urlencode($case['slug']); ?>" 
                               class="btn btn-sm btn-outline-primary" target="_blank">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote rich text editor
            $('.summernote').summernote({
                height: 200,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link']]
                ]
            });

            // Form validation
            const forms = document.querySelectorAll('.needs-validation');
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        });
    </script>
</body>
</html>