<?php
// Define database file path with absolute path for server compatibility
$db_file = $_SERVER['DOCUMENT_ROOT'] . '/database/portfolio.db';

// Check if database directory is writable
$db_dir = dirname($db_file);
if (!is_writable($db_dir)) {
    error_log("Database directory is not writable: $db_dir");
    // Try to set permissions (this may not work depending on server configuration)
    @chmod($db_dir, 0755);
}

// Error handling for SQLite connection
try {
    $db = new SQLite3($db_file);
    $db->busyTimeout(5000); // Set timeout for busy database
    // Enable error logging to help debug issues
    $db->exec('PRAGMA journal_mode = WAL;'); // Use Write-Ahead Logging for better concurrency
} catch (Exception $e) {
    error_log("SQLite connection error: " . $e->getMessage());
    // Fail gracefully instead of showing errors to users
    // You might want to display a maintenance message here in production
}

// Create tables if they don't exist
$db->exec("CREATE TABLE IF NOT EXISTS content (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    section VARCHAR(50),
    title TEXT,
    description TEXT,
    image_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS testimonials (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    client_name VARCHAR(100),
    client_position VARCHAR(100),
    review_text TEXT,
    rating INTEGER,
    image_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS clients (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    company_name VARCHAR(100),
    logo_url TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS messages (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

$db->exec("CREATE TABLE IF NOT EXISTS case_studies (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(200),
    slug VARCHAR(200),
    summary TEXT,
    description TEXT,
    client VARCHAR(100),
    services TEXT,
    date_completed DATE,
    featured_image TEXT,
    gallery TEXT,
    challenges TEXT,
    solutions TEXT,
    results TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

function get_section_content($section) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM content WHERE section = :section');
    $stmt->bindValue(':section', $section, SQLITE3_TEXT);
    return $stmt->execute()->fetchArray(SQLITE3_ASSOC);
}

function get_testimonials() {
    global $db;
    $result = $db->query('SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3');
    $testimonials = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $testimonials[] = $row;
    }
    return $testimonials;
}

function get_clients() {
    global $db;
    $result = $db->query('SELECT * FROM clients ORDER BY created_at DESC');
    $clients = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $clients[] = $row;
    }
    return $clients;
}

function save_message($name, $email, $message) {
    global $db;
    $stmt = $db->prepare('INSERT INTO messages (name, email, message) VALUES (:name, :email, :message)');
    $stmt->bindValue(':name', $name, SQLITE3_TEXT);
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $stmt->bindValue(':message', $message, SQLITE3_TEXT);
    return $stmt->execute();
}

function get_case_studies($limit = null) {
    global $db;
    $query = 'SELECT * FROM case_studies ORDER BY date_completed DESC';
    if ($limit) {
        $query .= ' LIMIT ' . $limit;
    }
    $result = $db->query($query);
    $cases = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $cases[] = $row;
    }
    return $cases;
}

function get_case_study($slug) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM case_studies WHERE slug = :slug');
    $stmt->bindValue(':slug', $slug, SQLITE3_TEXT);
    return $stmt->execute()->fetchArray(SQLITE3_ASSOC);
}
?>