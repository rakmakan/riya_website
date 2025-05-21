<?php
require_once '../database/config.php';
session_start();

// Initialize message variables
$success_message = '';
$error_message = '';
$editing_case_study = null;

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Handle edit mode
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM case_studies WHERE id = ?');
        $stmt->bind_param('i', $_GET['edit_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $editing_case_study = $result->fetch_assoc();
        $stmt->close();
    } catch (Exception $e) {
        $error_message = 'Failed to load case study for editing: ' . $e->getMessage();
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    try {
        $stmt = $db->prepare('DELETE FROM case_studies WHERE id = ?');
        $stmt->bind_param('i', $_POST['delete_id']);
        
        if ($stmt->execute()) {
            $success_message = 'Case study deleted successfully!';
        } else {
            throw new Exception('Failed to delete case study: ' . $db->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle case study submissions (both add and edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    try {
        // Validate required fields
        $required_fields = ['title', 'summary', 'description', 'client', 'services', 'date_completed', 'featured_image', 'challenges', 'solutions', 'results'];
        $missing_fields = [];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }
        
        if (!empty($missing_fields)) {
            throw new Exception('Please fill in all required fields: ' . implode(', ', $missing_fields));
        }

        $title = $_POST['title'];
        $slug = strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));

        if (isset($_POST['case_study_id'])) {
            // Update existing case study
            $stmt = $db->prepare('UPDATE case_studies SET title = ?, slug = ?, summary = ?, description = ?, client = ?, services = ?, date_completed = ?, featured_image = ?, gallery = ?, challenges = ?, solutions = ?, results = ? WHERE id = ?');
            $stmt->bind_param('ssssssssssssi', 
                $_POST['title'],
                $slug,
                $_POST['summary'],
                $_POST['description'],
                $_POST['client'],
                $_POST['services'],
                $_POST['date_completed'],
                $_POST['featured_image'],
                $_POST['gallery'],
                $_POST['challenges'],
                $_POST['solutions'],
                $_POST['results'],
                $_POST['case_study_id']
            );
            $action = 'updated';
        } else {
            // Insert new case study
            $stmt = $db->prepare('INSERT INTO case_studies (title, slug, summary, description, client, services, date_completed, featured_image, gallery, challenges, solutions, results) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->bind_param('ssssssssssss', 
                $_POST['title'],
                $slug,
                $_POST['summary'],
                $_POST['description'],
                $_POST['client'],
                $_POST['services'],
                $_POST['date_completed'],
                $_POST['featured_image'],
                $_POST['gallery'],
                $_POST['challenges'],
                $_POST['solutions'],
                $_POST['results']
            );
            $action = 'added';
        }

        if ($stmt->execute()) {
            $success_message = "Case study {$action} successfully!";
            if ($action === 'updated') {
                header('Location: case-studies.php');
                exit;
            }
        } else {
            throw new Exception("Failed to {$action} case study: " . $db->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Fetch existing case studies
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Case Studies</h1>
            <div>
                <?php if ($editing_case_study): ?>
                    <a href="case-studies.php" class="btn btn-secondary me-2">Cancel Edit</a>
                <?php endif; ?>
                <a href="index.php" class="btn btn-secondary me-2">Back to Dashboard</a>
                <a href="index.php?logout" class="btn btn-danger">Logout</a>
            </div>
        </div>

        <?php if ($success_message): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($success_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if ($error_message): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($error_message); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Add/Edit Case Study Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h3><?php echo $editing_case_study ? 'Edit' : 'Add New'; ?> Case Study</h3>
                <form method="POST" class="needs-validation" novalidate>
                    <?php if ($editing_case_study): ?>
                        <input type="hidden" name="case_study_id" value="<?php echo $editing_case_study['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" required 
                                       value="<?php echo htmlspecialchars($editing_case_study['title'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Summary <span class="text-danger">*</span></label>
                                <textarea name="summary" class="form-control" rows="2" required><?php echo htmlspecialchars($editing_case_study['summary'] ?? ''); ?></textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Client <span class="text-danger">*</span></label>
                                    <input type="text" name="client" class="form-control" required 
                                           value="<?php echo htmlspecialchars($editing_case_study['client'] ?? ''); ?>">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date Completed <span class="text-danger">*</span></label>
                                    <input type="date" name="date_completed" class="form-control" required 
                                           value="<?php echo htmlspecialchars($editing_case_study['date_completed'] ?? ''); ?>">
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Featured Image URL <span class="text-danger">*</span></label>
                                <input type="text" name="featured_image" class="form-control" required 
                                       value="<?php echo htmlspecialchars($editing_case_study['featured_image'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Services (comma-separated) <span class="text-danger">*</span></label>
                                <input type="text" name="services" class="form-control" required 
                                       value="<?php echo htmlspecialchars($editing_case_study['services'] ?? ''); ?>">
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label">Gallery Images (comma-separated)</label>
                                <input type="text" name="gallery" class="form-control" 
                                       value="<?php echo htmlspecialchars($editing_case_study['gallery'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label">Full Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control summernote" rows="5" required><?php echo $editing_case_study['description'] ?? ''; ?></textarea>
                    </div>
                    
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label class="form-label">Challenges <span class="text-danger">*</span></label>
                            <textarea name="challenges" class="form-control" rows="4" required><?php echo htmlspecialchars($editing_case_study['challenges'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Solutions <span class="text-danger">*</span></label>
                            <textarea name="solutions" class="form-control" rows="4" required><?php echo htmlspecialchars($editing_case_study['solutions'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Results <span class="text-danger">*</span></label>
                            <textarea name="results" class="form-control" rows="4" required><?php echo htmlspecialchars($editing_case_study['results'] ?? ''); ?></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><?php echo $editing_case_study ? 'Update' : 'Add'; ?> Case Study</button>
                    <?php if ($editing_case_study): ?>
                        <a href="case-studies.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Existing Case Studies -->
        <h3 class="mb-3">Existing Case Studies</h3>
        <div class="row">
            <?php foreach ($case_studies as $case): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo htmlspecialchars($case['featured_image']); ?>" 
                         class="card-img-top" alt="<?php echo htmlspecialchars($case['title']); ?>"
                         style="height: 200px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($case['title']); ?></h5>
                        <p class="card-text"><?php echo htmlspecialchars($case['summary']); ?></p>
                        <div class="mt-3">
                            <a href="?edit_id=<?php echo $case['id']; ?>" class="btn btn-primary btn-sm me-1">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form method="POST" style="display: inline;" 
                                  onsubmit="return confirm('Are you sure you want to delete this case study? This action cannot be undone.');">
                                <input type="hidden" name="delete_id" value="<?php echo $case['id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                            <a href="../case-study.php?slug=<?php echo urlencode($case['slug']); ?>" 
                               class="btn btn-outline-primary btn-sm" target="_blank">
                                <i class="fas fa-external-link-alt"></i> View
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
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