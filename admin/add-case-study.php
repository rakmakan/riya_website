<?php
require_once '../database/config.php';

// Simple security - this is a basic approach, consider implementing better authentication
$secret_key = "riya"; // Change this to a secure random string
$valid_access = false;

// Check if the key is provided and matches
if (isset($_GET['key']) && $_GET['key'] === $secret_key) {
    $valid_access = true;
}

// Handle form submission
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $valid_access) {
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

        if ($stmt->execute()) {
            $message = '<div class="alert alert-success">Case study added successfully!</div>';
        } else {
            $message = '<div class="alert alert-danger">Error adding case study.</div>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Case Study</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 2rem;
            padding-bottom: 2rem;
            background-color: #f8f9fa;
        }
        .form-container {
            background: white;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e9ecef;
        }
        .preview-container {
            margin-top: 3rem;
            padding: 1.5rem;
            background: #f8f9fa;
            border-radius: 5px;
            border: 1px dashed #ced4da;
        }
        .preview-title {
            color: #495057;
            font-size: 1.25rem;
            margin-bottom: 1rem;
        }
        .image-upload-area {
            border: 2px dashed #ced4da;
            padding: 2rem;
            text-align: center;
            margin-bottom: 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .image-upload-area:hover {
            background-color: #f1f3f5;
        }
        .hint-text {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if (!$valid_access): ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="form-container">
                        <div class="header">
                            <h2 class="text-center">Access Required</h2>
                        </div>
                        <p class="text-center">This page requires a valid access key.</p>
                        <p class="text-center text-muted">
                            <small>Add the key parameter to your URL: ?key=your_secret_key_here</small>
                        </p>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="form-container">
                        <div class="header d-flex justify-content-between align-items-center">
                            <h2>Add New Case Study</h2>
                            <a href="../case-studies.php" class="btn btn-outline-secondary" target="_blank">View All Case Studies</a>
                        </div>
                        
                        <?php echo $message; ?>
                        
                        <form method="POST" class="needs-validation" novalidate>
                            <div class="row mb-4">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" required>
                                        <div class="form-text">The main title of your case study</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Summary <span class="text-danger">*</span></label>
                                        <textarea name="summary" class="form-control" rows="2" required></textarea>
                                        <div class="form-text">A brief summary (1-2 sentences) for preview cards</div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Client <span class="text-danger">*</span></label>
                                            <input type="text" name="client" class="form-control" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label">Date Completed <span class="text-danger">*</span></label>
                                            <input type="date" name="date_completed" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label">Featured Image URL <span class="text-danger">*</span></label>
                                        <input type="text" name="featured_image" class="form-control" required>
                                        <div class="form-text">URL to the main image for this case study</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Services (comma-separated) <span class="text-danger">*</span></label>
                                        <input type="text" name="services" class="form-control" required>
                                        <div class="form-text">e.g., "Brand Strategy, Content Writing, SEO"</div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Gallery Images (comma-separated)</label>
                                        <input type="text" name="gallery" class="form-control">
                                        <div class="form-text">Additional image URLs, separated by commas</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Full Description <span class="text-danger">*</span></label>
                                <textarea name="description" class="form-control summernote" rows="5" required></textarea>
                                <div class="form-text">Detailed description of the project and your work</div>
                            </div>
                            
                            <div class="row mb-4">
                                <div class="col-md-4">
                                    <label class="form-label">Challenges <span class="text-danger">*</span></label>
                                    <textarea name="challenges" class="form-control" rows="4" required></textarea>
                                    <div class="form-text">Problems that needed to be solved</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Solutions <span class="text-danger">*</span></label>
                                    <textarea name="solutions" class="form-control" rows="4" required></textarea>
                                    <div class="form-text">How you approached and solved the challenges</div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Results <span class="text-danger">*</span></label>
                                    <textarea name="results" class="form-control" rows="4" required></textarea>
                                    <div class="form-text">Outcomes, metrics, and achievements</div>
                                </div>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Save Case Study</button>
                            </div>
                        </form>
                        
                        <div class="preview-container mt-4">
                            <div class="preview-title">After saving, your case study will be:</div>
                            <ul>
                                <li>Listed on the <a href="../case-studies.php" target="_blank">Case Studies page</a></li>
                                <li>Available as an individual page with its unique URL</li>
                                <li>Potentially featured on the homepage carousel (if it's one of the 3 most recent)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote rich text editor
            $('.summernote').summernote({
                height: 250,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview']]
                ],
                placeholder: 'Write the complete case study description here...'
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