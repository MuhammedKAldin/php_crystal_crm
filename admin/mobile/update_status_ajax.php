<?php
include_once '../../config/database.php';

$database = new Database();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $status_ar = $_POST['status_ar'];
    $status_en = $_POST['status_en'];
    $status = $_POST['status']; // Integer status

    // Update the database
    $query = "UPDATE applications SET status = :status WHERE id = :id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update the database']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request']);
}
?>
