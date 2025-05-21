<?php
// MySQL Connection Test Script
// This script helps test your MySQL connection and provides detailed error information

// Display all possible PHP errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h1>MySQL Connection Test</h1>";

// Connection details
$host = 'rakshitm.sg-host.com';
$port = 3306;
$username = 'uydaa4xtydxvf';
$password = 'Riyamakan@1994'; // Enter your password here for testing
$database = 'db4wkbt5d2fpqq';

echo "<h2>Connection Details</h2>";
echo "<ul>";
echo "<li>Host: $host</li>";
echo "<li>Port: $port</li>";
echo "<li>Username: $username</li>";
echo "<li>Password: " . (empty($password) ? "<strong style='color:red'>NOT PROVIDED</strong>" : "Provided") . "</li>";
echo "<li>Database: $database</li>";
echo "</ul>";

// Test if mysqli extension is loaded
echo "<h2>PHP MySQL Extension Check</h2>";
if (extension_loaded('mysqli')) {
    echo "<p style='color:green'>✓ MySQLi extension is loaded</p>";
} else {
    echo "<p style='color:red'>✗ MySQLi extension is NOT loaded. Please enable it in your PHP configuration.</p>";
}

// Print client info
echo "<h2>MySQL Client Info</h2>";
echo "<p>" . mysqli_get_client_info() . "</p>";

// Check if password is provided
if (empty($password)) {
    echo "<h2>Connection Result</h2>";
    echo "<p style='color:red'>✗ No password provided. Please add your password to the script.</p>";
    exit;
}

// Test the connection
echo "<h2>Connection Test</h2>";
try {
    $start_time = microtime(true);
    $mysqli = new mysqli($host, $username, $password, $database, $port);
    $end_time = microtime(true);
    
    if ($mysqli->connect_errno) {
        echo "<p style='color:red'>✗ Connection failed: " . $mysqli->connect_error . "</p>";
        
        // Check for common errors and provide suggestions
        if (strpos($mysqli->connect_error, "Access denied") !== false) {
            echo "<p><strong>Possible issues:</strong></p>";
            echo "<ul>";
            echo "<li>Incorrect password</li>";
            echo "<li>User '$username' doesn't have permission to access this database</li>";
            echo "<li>User '$username' might not be allowed to connect from your current IP address</li>";
            echo "</ul>";
            echo "<p><strong>Suggestions:</strong></p>";
            echo "<ul>";
            echo "<li>Double-check your password</li>";
            echo "<li>Contact SiteGround support to verify account permissions</li>";
            echo "<li>Check if remote MySQL connections are enabled for your hosting plan</li>";
            echo "</ul>";
        }
    } else {
        $connection_time = number_format(($end_time - $start_time) * 1000, 2);
        echo "<p style='color:green'>✓ Connection successful! (Time: {$connection_time}ms)</p>";
        
        // Test creating a table
        echo "<h2>Database Operations Test</h2>";
        
        // Test table creation
        $result = $mysqli->query("CREATE TABLE IF NOT EXISTS connection_test (
            id INT AUTO_INCREMENT PRIMARY KEY,
            test_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        
        if ($result) {
            echo "<p style='color:green'>✓ Table creation successful</p>";
            
            // Test insertion
            $insert_result = $mysqli->query("INSERT INTO connection_test (id) VALUES (NULL)");
            if ($insert_result) {
                echo "<p style='color:green'>✓ Data insertion successful</p>";
                
                // Test selection
                $select_result = $mysqli->query("SELECT * FROM connection_test ORDER BY test_date DESC LIMIT 5");
                if ($select_result) {
                    echo "<p style='color:green'>✓ Data selection successful</p>";
                    
                    echo "<h3>Last 5 connection tests:</h3>";
                    echo "<table border='1' cellpadding='5'>";
                    echo "<tr><th>ID</th><th>Test Date</th></tr>";
                    
                    while ($row = $select_result->fetch_assoc()) {
                        echo "<tr><td>{$row['id']}</td><td>{$row['test_date']}</td></tr>";
                    }
                    
                    echo "</table>";
                } else {
                    echo "<p style='color:red'>✗ Data selection failed: " . $mysqli->error . "</p>";
                }
            } else {
                echo "<p style='color:red'>✗ Data insertion failed: " . $mysqli->error . "</p>";
            }
        } else {
            echo "<p style='color:red'>✗ Table creation failed: " . $mysqli->error . "</p>";
        }
        
        // Close the connection
        $mysqli->close();
    }
} catch (Exception $e) {
    echo "<p style='color:red'>✗ Exception: " . $e->getMessage() . "</p>";
}

echo "<h2>Next Steps</h2>";
echo "<ol>";
echo "<li>If the connection test was successful, update the password in <code>config.php</code> and <code>migrate_to_mysql.php</code></li>";
echo "<li>If the test failed, review the error messages above and correct the connection parameters</li>";
echo "<li>Once the connection is working, run <a href='migrate_to_mysql.php'>the migration script</a> to transfer your data</li>";
echo "</ol>";
?>