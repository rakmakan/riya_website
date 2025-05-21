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
$editing_client = null;

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Handle edit mode
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['edit_id'])) {
    try {
        $stmt = $db->prepare('SELECT * FROM clients WHERE id = ?');
        $stmt->bind_param('i', $_GET['edit_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $editing_client = $result->fetch_assoc();
        $stmt->close();
    } catch (Exception $e) {
        $error_message = 'Failed to load client for editing: ' . $e->getMessage();
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    try {
        $stmt = $db->prepare('DELETE FROM clients WHERE id = ?');
        $stmt->bind_param('i', $_POST['delete_id']);
        
        if ($stmt->execute()) {
            $success_message = 'Client deleted successfully!';
        } else {
            throw new Exception('Failed to delete client: ' . $db->error);
        }
        
        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Handle client submissions (both add and edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['company_name'])) {
    try {
        // Validate required fields
        if (empty($_POST['company_name']) || empty($_POST['logo_url'])) {
            throw new Exception('Please fill in all required fields');
        }

        if (isset($_POST['client_id'])) {
            // Update existing client
            $stmt = $db->prepare('UPDATE clients SET company_name = ?, logo_url = ? WHERE id = ?');
            $stmt->bind_param('ssi', 
                $_POST['company_name'],
                $_POST['logo_url'],
                $_POST['client_id']
            );
            $action = 'updated';
        } else {
            // Insert new client
            $stmt = $db->prepare('INSERT INTO clients (company_name, logo_url) VALUES (?, ?)');
            $stmt->bind_param('ss', 
                $_POST['company_name'],
                $_POST['logo_url']
            );
            $action = 'added';
        }

        // Execute the statement
        $result = $stmt->execute();

        if ($result) {
            $success_message = "Client {$action} successfully!";
            // Clear editing state after successful update
            if ($action === 'updated') {
                header('Location: clients.php');
                exit;
            }
        } else {
            throw new Exception("Failed to {$action} client: " . $db->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}

// Fetch existing clients
try {
    $clients = get_clients();
} catch (Exception $e) {
    $error_message = 'Failed to load clients: ' . $e->getMessage();
    $clients = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Clients</h1>
            <div>
                <?php if ($editing_client): ?>
                    <a href="clients.php" class="btn btn-secondary me-2">Cancel Edit</a>
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

        <!-- Add/Edit Client Form -->
        <div class="card mb-4">
            <div class="card-body">
                <h3><?php echo $editing_client ? 'Edit' : 'Add New'; ?> Client</h3>
                <form method="POST" novalidate>
                    <?php if ($editing_client): ?>
                        <input type="hidden" name="client_id" value="<?php echo $editing_client['id']; ?>">
                    <?php endif; ?>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name *</label>
                            <input type="text" name="company_name" class="form-control" required 
                                   value="<?php echo htmlspecialchars($editing_client['company_name'] ?? $_POST['company_name'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo URL *</label>
                            <input type="text" name="logo_url" class="form-control" required
                                   value="<?php echo htmlspecialchars($editing_client['logo_url'] ?? $_POST['logo_url'] ?? ''); ?>">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary"><?php echo $editing_client ? 'Update' : 'Add'; ?> Client</button>
                    <?php if ($editing_client): ?>
                        <a href="clients.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <!-- Existing Clients -->
        <h3 class="mb-3">Existing Clients</h3>
        <?php if (empty($clients)): ?>
            <div class="alert alert-info">No clients found. Add your first client above!</div>
        <?php else: ?>
            <div class="row">
                <?php foreach ($clients as $client): ?>
                <div class="col-md-3 mb-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="<?php echo htmlspecialchars($client['logo_url']); ?>" 
                                 alt="<?php echo htmlspecialchars($client['company_name']); ?>" 
                                 class="img-fluid mb-3" 
                                 style="max-height: 100px;">
                            <h5 class="card-title"><?php echo htmlspecialchars($client['company_name']); ?></h5>
                            <div class="mt-2">
                                <a href="?edit_id=<?php echo $client['id']; ?>" class="btn btn-primary btn-sm me-1">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <form method="POST" style="display: inline;" 
                                      onsubmit="return confirm('Are you sure you want to delete this client? This action cannot be undone.');">
                                    <input type="hidden" name="delete_id" value="<?php echo $client['id']; ?>">
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
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