<?php
require_once '../database/config.php';

// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

// Initialize message variables
$success_message = '';
$error_message = '';
$editing_testimonial = null;

if (!isset($_SESSION['admin'])) {
    header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/index.php');
    exit;
}

// Handle edit mode
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM testimonials WHERE id = ?');
        $stmt->bind_param('i', $_GET['edit_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $editing_testimonial = $result->fetch_assoc();
        $stmt->close();
    } catch (Exception $e) {
        $error_message = 'Failed to load testimonial for editing: ' . $e->getMessage();
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    try {
        $stmt = $db->prepare('DELETE FROM testimonials WHERE id = ?');
        $stmt->bind_param('i', $_POST['delete_id']);
        
        if ($stmt->execute()) {
            $success_message = 'Testimonial deleted successfully!';
        } else {
            throw new Exception('Failed to delete testimonial: ' . $db->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle testimonial submissions (both add and edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['client_name'])) {
    try {
        // Validate required fields
        $required_fields = ['client_name', 'client_position', 'review_text', 'rating'];
        $missing_fields = [];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }
        
        if (!empty($missing_fields)) {
            throw new Exception('Please fill in all required fields: ' . implode(', ', $missing_fields));
        }
        
        // Validate rating
        if (!is_numeric($_POST['rating']) || $_POST['rating'] < 1 || $_POST['rating'] > 5) {
            throw new Exception('Rating must be a number between 1 and 5');
        }

        // Prepare image URL (use a default if none provided)
        $image_url = !empty($_POST['image_url']) ? $_POST['image_url'] : 'assets/images/default-profile.png';

        if (isset($_POST['testimonial_id'])) {
            // Update existing testimonial
            $stmt = $db->prepare('UPDATE testimonials SET client_name = ?, client_position = ?, review_text = ?, rating = ?, image_url = ? WHERE id = ?');
            $stmt->bind_param('sssisi', 
                $_POST['client_name'],
                $_POST['client_position'],
                $_POST['review_text'],
                $_POST['rating'],
                $image_url,
                $_POST['testimonial_id']
            );
            $action = 'updated';
        } else {
            // Insert new testimonial
            $stmt = $db->prepare('INSERT INTO testimonials (client_name, client_position, review_text, rating, image_url) VALUES (?, ?, ?, ?, ?)');
            $stmt->bind_param('sssis', 
                $_POST['client_name'],
                $_POST['client_position'],
                $_POST['review_text'],
                $_POST['rating'],
                $image_url
            );
            $action = 'added';
        }

        // Execute the statement
        $result = $stmt->execute();

        if ($result) {
            $success_message = "Testimonial {$action} successfully!";
            // Clear editing state after successful update
            if ($action === 'updated') {
                header('Location: testimonials.php');
                exit;
            }
        } else {
            throw new Exception("Failed to {$action} testimonial: " . $db->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Fetch existing testimonials
try {
    $testimonials = get_testimonials();
} catch (Exception $e) {
    $error_message = 'Failed to load testimonials: ' . $e->getMessage();
    $testimonials = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Testimonials</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Testimonials</h1>
            <div>
                <?php if ($editing_testimonial): ?>
                    <a href="testimonials.php" class="btn btn-secondary me-2">Cancel Edit</a>
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

        <!-- Add/Edit Testimonial Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h3><?php echo $editing_testimonial ? 'Edit' : 'Add New'; ?> Testimonial</h3>
                <form method="POST" novalidate>
                    <?php if ($editing_testimonial): ?>
                        <input type="hidden" name="testimonial_id" value="<?php echo $editing_testimonial['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Client Name *</label>
                            <input type="text" name="client_name" class="form-control" required 
                                   value="<?php echo htmlspecialchars($editing_testimonial['client_name'] ?? $_POST['client_name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Position/Company *</label>
                            <input type="text" name="client_position" class="form-control" required
                                   value="<?php echo htmlspecialchars($editing_testimonial['client_position'] ?? $_POST['client_position'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Review Text *</label>
                        <textarea name="review_text" class="form-control" rows="3" required><?php echo htmlspecialchars($editing_testimonial['review_text'] ?? $_POST['review_text'] ?? ''); ?></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rating (1-5) *</label>
                            <input type="number" name="rating" class="form-control" min="1" max="5" required
                                   value="<?php echo htmlspecialchars($editing_testimonial['rating'] ?? $_POST['rating'] ?? '5'); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Profile Image URL</label>
                            <input type="text" name="image_url" class="form-control"
                                   value="<?php echo htmlspecialchars($editing_testimonial['image_url'] ?? $_POST['image_url'] ?? ''); ?>"
                                   placeholder="Leave empty for default image">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $editing_testimonial ? 'Update' : 'Add'; ?> Testimonial</button>
                    <?php if ($editing_testimonial): ?>
                        <a href="testimonials.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Existing Testimonials -->
        <h3 class="mb-3">Existing Testimonials</h3>
        <?php if (empty($testimonials)): ?>
            <div class="alert alert-info">No testimonials found. Add your first testimonial above!</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($testimonials as $testimonial): ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="<?php echo htmlspecialchars($testimonial['image_url']); ?>" 
                                         alt="<?php echo htmlspecialchars($testimonial['client_name']); ?>" 
                                         class="rounded-circle me-3" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         onerror="this.src='../assets/images/default-profile.png';">
                                    <div>
                                        <h5 class="card-title mb-0"><?php echo htmlspecialchars($testimonial['client_name']); ?></h5>
                                        <small class="text-muted"><?php echo htmlspecialchars($testimonial['client_position']); ?></small>
                                    </div>
                                </div>
                                <div>
                                    <a href="?edit_id=<?php echo $testimonial['id']; ?>" class="btn btn-primary btn-sm me-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this testimonial? This action cannot be undone.');">
                                        <input type="hidden" name="delete_id" value="<?php echo $testimonial['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
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
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>