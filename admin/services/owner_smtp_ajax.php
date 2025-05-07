<?php
// Display PHP errors for debugging (remove in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once '../../config/database.php';

header('Content-Type: application/json');

// Database connection
$database = new Database();
$db = $database->getConnection();

$response = ['success' => false];

// Check if the database connection is successful
if ($db === null) {
    $response['error'] = 'Database connection failed';
    echo json_encode($response);
    exit;
}

// Check if POST request contains required fields
$host = htmlspecialchars($_POST['host']);
$port = htmlspecialchars($_POST['port']);
$username = htmlspecialchars($_POST['username']);
$password = htmlspecialchars($_POST['password']);
$setfrom = htmlspecialchars($_POST['setfrom']);
$replyto = htmlspecialchars($_POST['replyto']);

// Insert or update data into the owner_smtp table
$query = "UPDATE owner_smtp SET host = :host, port = :port, username = :username, password = :password, setfrom = :setfrom, replyto = :replyto WHERE id = 1";
$stmt = $db->prepare($query);

// Bind parameters
$stmt->bindParam(':host', $host);
$stmt->bindParam(':port', $port);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':setfrom', $setfrom);
$stmt->bindParam(':replyto', $replyto);

// Execute and check if successful
try {
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        // Capture execution errors
        $response['error'] = 'Failed to execute the query';
        $errorInfo = $stmt->errorInfo();
        $response['sql_error'] = $errorInfo[2]; // Get the SQL error message
    }
} catch (PDOException $e) {
    // Catch any database-related exceptions
    $response['error'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>
