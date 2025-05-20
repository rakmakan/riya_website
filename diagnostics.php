<?php
// Set error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Website Diagnostic Page</h1>";

// Check PHP version
echo "<h2>PHP Environment</h2>";
echo "PHP Version: " . phpversion() . "<br>";

// Check for SQLite support
echo "<h2>SQLite Support</h2>";
if (extension_loaded('sqlite3')) {
    echo "SQLite3 extension is loaded. ✅<br>";
} else {
    echo "SQLite3 extension is NOT loaded. ❌<br>";
}

// Check database file and directory permissions
echo "<h2>File System Checks</h2>";
$db_path = $_SERVER['DOCUMENT_ROOT'] . '/database';
$db_file = $db_path . '/portfolio.db';

echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Database directory path: " . $db_path . "<br>";
echo "Database file path: " . $db_file . "<br>";

if (file_exists($db_path)) {
    echo "Database directory exists. ✅<br>";
    echo "Directory permissions: " . substr(sprintf('%o', fileperms($db_path)), -4) . "<br>";
    echo "Directory writable: " . (is_writable($db_path) ? "Yes ✅" : "No ❌") . "<br>";
} else {
    echo "Database directory does not exist. ❌<br>";
}

if (file_exists($db_file)) {
    echo "Database file exists. ✅<br>";
    echo "File permissions: " . substr(sprintf('%o', fileperms($db_file)), -4) . "<br>";
    echo "File readable: " . (is_readable($db_file) ? "Yes ✅" : "No ❌") . "<br>";
    echo "File writable: " . (is_writable($db_file) ? "Yes ✅" : "No ❌") . "<br>";
} else {
    echo "Database file does not exist. ❌<br>";
}

// Try to connect to the database
echo "<h2>Database Connection Test</h2>";
try {
    $db = new SQLite3($db_file);
    echo "Successfully connected to the database. ✅<br>";
    echo "SQLite version: " . $db->querySingle('SELECT sqlite_version()') . "<br>";
    
    // Check if tables exist
    $result = $db->query("SELECT name FROM sqlite_master WHERE type='table'");
    echo "Database tables:<br>";
    $tables_found = false;
    while ($table = $result->fetchArray(SQLITE3_ASSOC)) {
        echo "- " . $table['name'] . "<br>";
        $tables_found = true;
    }
    if (!$tables_found) {
        echo "No tables found in the database. ❌<br>";
    }
    
    $db->close();
} catch (Exception $e) {
    echo "Failed to connect to the database: " . $e->getMessage() . " ❌<br>";
}

// Check include paths
echo "<h2>Include Path Configuration</h2>";
echo "Current include_path: " . get_include_path() . "<br>";

// Test loading a view file
echo "<h2>File Include Test</h2>";
try {
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/header.php';
    echo "Successfully included header.php ✅<br>";
} catch (Exception $e) {
    echo "Failed to include header.php: " . $e->getMessage() . " ❌<br>";
}

echo "<h2>Recent PHP Errors</h2>";
$error_log = $_SERVER['DOCUMENT_ROOT'] . '/php_errorlog';
if (file_exists($error_log) && is_readable($error_log)) {
    echo "<pre>" . htmlspecialchars(file_get_contents($error_log, false, null, -4096)) . "</pre>";
} else {
    echo "Error log file not found or not readable.<br>";
}

echo "<h2>Server Information</h2>";
echo "SERVER_SOFTWARE: " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "SCRIPT_FILENAME: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . "<br>";
echo "REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "<br>";
?>