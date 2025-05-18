<?php
require_once '../database/config.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: index.php');
    exit;
}

// Handle client submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['company_name'])) {
        $stmt = $db->prepare('INSERT INTO clients (company_name, logo_url) VALUES (:name, :logo)');
        $stmt->bindValue(':name', $_POST['company_name'], SQLITE3_TEXT);
        $stmt->bindValue(':logo', $_POST['logo_url'], SQLITE3_TEXT);
        $stmt->execute();
    }
}

$clients = get_clients();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Clients</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Manage Clients</h1>
            <a href="index.php" class="btn btn-secondary">Back to Dashboard</a>
        </div>

        <!-- Add New Client -->
        <div class="card mb-4">
            <div class="card-body">
                <h3>Add New Client</h3>
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company_name" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Logo URL</label>
                            <input type="text" name="logo_url" class="form-control" required>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Client</button>
                </form>
            </div>
        </div>

        <!-- Existing Clients -->
        <h3 class="mb-3">Existing Clients</h3>
        <div class="row">
            <?php foreach ($clients as $client): ?>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="<?php echo htmlspecialchars($client['logo_url']); ?>" 
                             alt="<?php echo htmlspecialchars($client['company_name']); ?>" 
                             class="img-fluid mb-3" style="max-height: 100px;">
                        <h5 class="card-title"><?php echo htmlspecialchars($client['company_name']); ?></h5>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>