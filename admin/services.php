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
$editing_service = null;

if (!isset($_SESSION['admin'])) {
    header('Location: ' . dirname($_SERVER['PHP_SELF']) . '/index.php');
    exit;
}

// Handle edit mode
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM services WHERE id = ?');
        $stmt->bind_param('i', $_GET['edit_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $editing_service = $result->fetch_assoc();
        $stmt->close();
    } catch (Exception $e) {
        $error_message = 'Failed to load service for editing: ' . $e->getMessage();
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    try {
        $stmt = $db->prepare('DELETE FROM services WHERE id = ?');
        $stmt->bind_param('i', $_POST['delete_id']);
        
        if ($stmt->execute()) {
            $success_message = 'Service deleted successfully!';
        } else {
            throw new Exception('Failed to delete service: ' . $db->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle service submissions (both add and edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'])) {
    try {
        // Validate required fields
        $required_fields = ['title', 'description', 'icon'];
        $missing_fields = [];
        
        foreach ($required_fields as $field) {
            if (empty($_POST[$field])) {
                $missing_fields[] = $field;
            }
        }
        
        if (!empty($missing_fields)) {
            throw new Exception('Please fill in all required fields: ' . implode(', ', $missing_fields));
        }

        if (isset($_POST['service_id'])) {
            // Update existing service
            $stmt = $db->prepare('UPDATE services SET title = ?, description = ?, icon = ? WHERE id = ?');
            $stmt->bind_param('sssi', 
                $_POST['title'],
                $_POST['description'],
                $_POST['icon'],
                $_POST['service_id']
            );
            $action = 'updated';
        } else {
            // Insert new service
            $stmt = $db->prepare('INSERT INTO services (title, description, icon) VALUES (?, ?, ?)');
            $stmt->bind_param('sss', 
                $_POST['title'],
                $_POST['description'],
                $_POST['icon']
            );
            $action = 'added';
        }

        // Execute the statement
        $result = $stmt->execute();

        if ($result) {
            $success_message = "Service {$action} successfully!";
            // Clear editing state after successful update
            if ($action === 'updated') {
                header('Location: services.php');
                exit;
            }
        } else {
            throw new Exception("Failed to {$action} service: " . $db->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Fetch existing services
try {
    $services = get_services();
} catch (Exception $e) {
    $error_message = 'Failed to load services: ' . $e->getMessage();
    $services = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Services</h1>
            <div>
                <?php if ($editing_service): ?>
                    <a href="services.php" class="btn btn-secondary me-2">Cancel Edit</a>
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

        <!-- Add/Edit Service Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h3><?php echo $editing_service ? 'Edit' : 'Add New'; ?> Service</h3>
                <form method="POST" novalidate>
                    <?php if ($editing_service): ?>
                        <input type="hidden" name="service_id" value="<?php echo $editing_service['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Service Title *</label>
                            <input type="text" name="title" class="form-control" required 
                                   value="<?php echo htmlspecialchars($editing_service['title'] ?? $_POST['title'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Icon (Font Awesome class) *</label>
                            <input type="text" name="icon" class="form-control" required
                                   placeholder="e.g., fas fa-pen-fancy"
                                   value="<?php echo htmlspecialchars($editing_service['icon'] ?? $_POST['icon'] ?? ''); ?>">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description *</label>
                        <textarea name="description" class="form-control" rows="3" required><?php echo htmlspecialchars($editing_service['description'] ?? $_POST['description'] ?? ''); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $editing_service ? 'Update' : 'Add'; ?> Service</button>
                    <?php if ($editing_service): ?>
                        <a href="services.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Existing Services -->
        <h3 class="mb-3">Existing Services</h3>
        <?php if (empty($services)): ?>
            <div class="alert alert-info">No services found. Add your first service above!</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($services as $service): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <i class="<?php echo htmlspecialchars($service['icon']); ?> fa-2x mb-3"></i>
                                    <h5 class="card-title"><?php echo htmlspecialchars($service['title']); ?></h5>
                                </div>
                                <div>
                                    <a href="?edit_id=<?php echo $service['id']; ?>" class="btn btn-primary btn-sm me-1">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <form method="POST" style="display: inline;" 
                                          onsubmit="return confirm('Are you sure you want to delete this service? This action cannot be undone.');">
                                        <input type="hidden" name="delete_id" value="<?php echo $service['id']; ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                            <p class="card-text"><?php echo htmlspecialchars($service['description']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview Font Awesome icons when entering the icon class
        document.querySelector('input[name="icon"]').addEventListener('input', function(e) {
            const iconPreview = document.getElementById('icon-preview') || document.createElement('div');
            iconPreview.id = 'icon-preview';
            iconPreview.className = 'mt-2';
            iconPreview.innerHTML = `<i class="${e.target.value} fa-2x"></i>`;
            
            if (!document.getElementById('icon-preview')) {
                e.target.parentNode.appendChild(iconPreview);
            }
        });
    </script>
</body>
</html>