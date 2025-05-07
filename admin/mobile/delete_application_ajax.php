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

$response = ['success' => false]; // Default response

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Make sure the id is an integer

    // Prepare and execute the delete query
    $query = "DELETE FROM applications WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    try {
        if ($stmt->execute()) {
            $response['success'] = true; // Set success flag to true
            $response['message'] = 'Record deleted successfully';
        } else {
            $response['error'] = 'Failed to delete record'; // Error executing query
        }
    } catch (PDOException $e) {
        $response['error'] = 'Query error: ' . $e->getMessage(); // Catch and report any PDO errors
    }
} else {
    $response['error'] = 'ID not set'; // Return error if id is not set
}

echo json_encode($response); // Return JSON response