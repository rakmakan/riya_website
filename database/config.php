<?php
// MySQL Database Configuration
$host = 'rakshitm.sg-host.com';
$port = 3306;
$username = 'uydaa4xtydxvf';
$password = 'Riyamakan@1994'; // IMPORTANT: Replace with your actual MySQL password
$database = 'db4wkbt5d2fpqq';

// Display error message if password hasn't been updated
if ($password === 'YOUR_MYSQL_PASSWORD_HERE') {
    die("Error: Please update the MySQL password in database/config.php before connecting");
}

// Connect to MySQL database
try {
    $db = new mysqli($host, $username, $password, $database, $port);
    
    // Check for connection errors
    if ($db->connect_error) {
        error_log("MySQL connection error: " . $db->connect_error);
        throw new Exception("Database connection failed: " . $db->connect_error);
    }
    
    // Set character set
    $db->set_charset('utf8mb4');
    
} catch (Exception $e) {
    error_log("MySQL connection error: " . $e->getMessage());
    
    // Create a fallback database class that gracefully handles connection issues
    class FallbackDB {
        private $error_message = "Database functionality is temporarily unavailable.";
        
        public function query($query) {
            error_log("Attempted to query but MySQL is unavailable: " . $query);
            return false;
        }
        
        public function prepare($query) {
            error_log("Attempted to prepare query but MySQL is unavailable: " . $query);
            return new FallbackStmt();
        }
        
        public function error() {
            return $this->error_message;
        }
    }
    
    class FallbackStmt {
        public function bind_param($types, ...$params) {
            return true;
        }
        
        public function execute() {
            return false;
        }
        
        public function get_result() {
            return new FallbackResult();
        }
    }
    
    class FallbackResult {
        public function fetch_assoc() {
            return false;
        }
        
        public function fetch_all(int $mode = MYSQLI_NUM) {
            return [];
        }
    }
    
    // Use the fallback database
    $db = new FallbackDB();
}

// Create tables if they don't exist
$db->query("CREATE TABLE IF NOT EXISTS content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    section VARCHAR(50),
    title TEXT,
    description TEXT,
    image_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$db->query("CREATE TABLE IF NOT EXISTS testimonials (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_name VARCHAR(100),
    client_position VARCHAR(100),
    review_text TEXT,
    rating INT,
    image_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$db->query("CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(100),
    logo_url TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$db->query("CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

$db->query("CREATE TABLE IF NOT EXISTS case_studies (
    id INT AUTO_INCREMENT PRIMARY KEY,
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
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");

// Update functions to work with MySQLi

function get_section_content($section) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM content WHERE section = ?');
    $stmt->bind_param('s', $section);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function get_testimonials() {
    global $db;
    $result = $db->query('SELECT * FROM testimonials ORDER BY created_at DESC LIMIT 3');
    $testimonials = [];
    while ($row = $result->fetch_assoc()) {
        $testimonials[] = $row;
    }
    return $testimonials;
}

function get_clients() {
    global $db;
    $result = $db->query('SELECT * FROM clients ORDER BY created_at DESC');
    $clients = [];
    while ($row = $result->fetch_assoc()) {
        $clients[] = $row;
    }
    return $clients;
}

function save_message($name, $email, $message) {
    global $db;
    $stmt = $db->prepare('INSERT INTO messages (name, email, message) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $name, $email, $message);
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
    while ($row = $result->fetch_assoc()) {
        $cases[] = $row;
    }
    return $cases;
}

function get_case_study($slug) {
    global $db;
    $stmt = $db->prepare('SELECT * FROM case_studies WHERE slug = ?');
    $stmt->bind_param('s', $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>