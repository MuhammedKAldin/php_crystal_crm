<?php
require_once __DIR__ . '/../config/database.php';

$database = new Database();
$pdo = $database->getConnection();

if ($pdo === null) {
    die("Database connection failed.\n");
}

// Array of migration files in order
$migrations = [
    '001_create_owner_table.sql',
    '002_create_applications_table.sql',
    '003_create_owner_smtp_table.sql'
];

foreach ($migrations as $migration) {
    echo "Running migration: $migration\n";
    
    // Read the SQL file
    $sql = file_get_contents(__DIR__ . '/' . $migration);
    
    try {
        // Execute the SQL
        $pdo->exec($sql);
        echo "Migration $migration completed successfully.\n";
    } catch (PDOException $e) {
        echo "Error running migration $migration: " . $e->getMessage() . "\n";
    }
}

echo "\nAll migrations completed.\n"; 