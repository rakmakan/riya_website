<?php
require_once '../database/config.php';

// Handle logout
if (isset($_GET['logout'])) {
    session_start();
    session_destroy();
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

// Ensure session directory is writable
$session_dir = session_save_path();
if (!is_writable($session_dir)) {
    error_log("Session directory is not writable: " . $session_dir);
}

// Set session cookie parameters
session_set_cookie_params([
    'lifetime' => 3600,
    'path' => '/',
    'secure' => true,
    'httponly' => true
]);

session_start();

// Simple authentication (in production, use proper authentication)
$admin_password = 'admin123'; // Change this in production

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['password'])) {
    if ($_POST['password'] === $admin_password) {
        $_SESSION['admin'] = true;
        $_SESSION['login_time'] = time();
        // Redirect to the same page to avoid form resubmission
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $error_message = 'Invalid password';
    }
}

if (!isset($_SESSION['admin'])) {
    // Show login form
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body class="bg-light">
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title text-center mb-4">Admin Login</h3>
                            <?php if (isset($error_message)): ?>
                            <div class="alert alert-danger"><?php echo htmlspecialchars($error_message); ?></div>
                            <?php endif; ?>
                            <form method="POST">
                                <div class="mb-3">
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// Handle content updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['section'])) {
        $stmt = $db->prepare('INSERT OR REPLACE INTO content (section, title, description, image_url) VALUES (:section, :title, :description, :image_url)');
        $stmt->bindValue(':section', $_POST['section'], SQLITE3_TEXT);
        $stmt->bindValue(':title', $_POST['title'], SQLITE3_TEXT);
        $stmt->bindValue(':description', $_POST['description'], SQLITE3_TEXT);
        $stmt->bindValue(':image_url', $_POST['image_url'], SQLITE3_TEXT);
        $stmt->execute();
    }
}

// Get current content
$hero_content = get_section_content('hero');
$about_content = get_section_content('about');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Website Content Management</h1>
            <a href="?logout" class="btn btn-danger">Logout</a>
        </div>
        
        <!-- Hero Section Content -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Hero Section</h3>
                <form method="POST">
                    <input type="hidden" name="section" value="hero">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($hero_content['title'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($hero_content['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image URL</label>
                        <input type="text" name="image_url" class="form-control" value="<?php echo htmlspecialchars($hero_content['image_url'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Hero Section</button>
                </form>
            </div>
        </div>

        <!-- About Section Content -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>About Section</h3>
                <form method="POST">
                    <input type="hidden" name="section" value="about">
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($about_content['title'] ?? ''); ?>">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"><?php echo htmlspecialchars($about_content['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Image URL</label>
                        <input type="text" name="image_url" class="form-control" value="<?php echo htmlspecialchars($about_content['image_url'] ?? ''); ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update About Section</button>
                </form>
            </div>
        </div>

        <a href="testimonials.php" class="btn btn-secondary me-2">Manage Testimonials</a>
        <a href="services.php" class="btn btn-secondary me-2">Manage Services</a>
        <a href="clients.php" class="btn btn-secondary me-2">Manage Clients</a>
        <a href="case-studies.php" class="btn btn-secondary">Manage Case Studies</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>