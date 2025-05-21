<?php
// Database Migration Script: SQLite to MySQL
// This script will transfer all data from the existing SQLite database to the new MySQL database

// Set maximum execution time to 5 minutes to avoid timeout during migration
ini_set('max_execution_time', 300);

// Step 1: Connect to the SQLite database
$sqlite_db_file = $_SERVER['DOCUMENT_ROOT'] . '/database/portfolio.db';

if (!file_exists($sqlite_db_file)) {
    die("Error: SQLite database file not found at: $sqlite_db_file");
}

try {
    $sqlite = new SQLite3($sqlite_db_file);
} catch (Exception $e) {
    die("Error connecting to SQLite database: " . $e->getMessage());
}

// Step 2: Connect to the MySQL database
$mysql_host = 'rakshitm.sg-host.com';
$mysql_port = 3306;
$mysql_username = 'uydaa4xtydxvf';
$mysql_password = 'Riyamakan@1994'; // IMPORTANT: Replace with your actual MySQL password
$mysql_database = 'db4wkbt5d2fpqq';

// Display error message if password hasn't been updated
if ($mysql_password === 'YOUR_MYSQL_PASSWORD_HERE') {
    die("Error: Please update the MySQL password in database/migrate_to_mysql.php before running migration");
}

try {
    $mysql = new mysqli($mysql_host, $mysql_username, $mysql_password, $mysql_database, $mysql_port);
    
    if ($mysql->connect_error) {
        throw new Exception("MySQL connection failed: " . $mysql->connect_error);
    }
    
    $mysql->set_charset('utf8mb4');
} catch (Exception $e) {
    die("Error connecting to MySQL database: " . $e->getMessage());
}

// Function to migrate a table
function migrate_table($table_name, $sqlite, $mysql) {
    echo "Migrating table: $table_name<br>";
    
    // Get data from SQLite
    $result = $sqlite->query("SELECT * FROM $table_name");
    
    if (!$result) {
        echo "- Warning: No data found in SQLite table $table_name<br>";
        return;
    }
    
    $rows = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $rows[] = $row;
    }
    
    if (empty($rows)) {
        echo "- No data to migrate for table $table_name<br>";
        return;
    }
    
    echo "- Found " . count($rows) . " records to migrate<br>";
    
    // Start transaction for better performance
    $mysql->begin_transaction();
    
    try {
        foreach ($rows as $row) {
            // Build INSERT query
            $columns = array_keys($row);
            $values = array_values($row);
            
            // Prepare placeholders for the values
            $placeholders = array_fill(0, count($values), '?');
            
            // Prepare the SQL statement
            $sql = "INSERT INTO $table_name (" . implode(', ', $columns) . ") VALUES (" . implode(', ', $placeholders) . ")";
            $stmt = $mysql->prepare($sql);
            
            if (!$stmt) {
                throw new Exception("MySQL prepare error: " . $mysql->error . " for query: $sql");
            }
            
            // Dynamically bind parameters based on their types
            $types = '';
            $bind_params = [];
            
            foreach ($values as $value) {
                if (is_int($value)) {
                    $types .= 'i'; // integer
                } elseif (is_float($value)) {
                    $types .= 'd'; // double
                } else {
                    $types .= 's'; // string
                }
                $bind_params[] = $value;
            }
            
            // Add types as first parameter
            array_unshift($bind_params, $types);
            
            // Use reflection to bind parameters dynamically
            if (!empty($bind_params)) {
                $ref_stmt = new ReflectionClass($stmt);
                $ref_method = $ref_stmt->getMethod('bind_param');
                $ref_method->invokeArgs($stmt, $bind_params);
            }
            
            // Execute the statement
            if (!$stmt->execute()) {
                throw new Exception("MySQL execute error: " . $stmt->error);
            }
            
            $stmt->close();
        }
        
        $mysql->commit();
        echo "- Successfully migrated table $table_name<br>";
    } catch (Exception $e) {
        $mysql->rollback();
        echo "- Error migrating table $table_name: " . $e->getMessage() . "<br>";
    }
}

// Step 3: Migrate each table
echo "<h2>Starting Database Migration</h2>";

$tables = ['content', 'testimonials', 'clients', 'messages', 'case_studies'];

foreach ($tables as $table) {
    migrate_table($table, $sqlite, $mysql);
    echo "<hr>";
}

// Step 4: Close connections
$sqlite->close();
$mysql->close();

echo "<h2>Migration Complete</h2>";
echo "<p>Please check both databases to ensure all data was transferred correctly.</p>";
echo "<p><a href='../index.php'>Return to homepage</a></p>";
?>