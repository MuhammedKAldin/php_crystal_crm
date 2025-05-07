<?php
// Start the session
session_start();

// Include the database configuration file
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get email and password from the POST request
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!$email || !$password) {
        echo "<script>alert('Please provide both email and password.'); window.history.back();</script>";
        exit;
    }

    // Assuming your Database class provides a `getConnection()` method that returns a PDO connection
    $database = new Database();
    $pdo = $database->getConnection();

    // Check if the database connection is successful
    if ($pdo === null) {
        echo "<script>alert('Database connection failed. Please try again later.'); window.history.back();</script>";
        exit;
    }

    try {
        // Query to check if the user exists in the 'owner' table with the provided email
        $query = "SELECT * FROM owner WHERE email = :email LIMIT 1";

        // Prepare the statement
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':email', $email);

        // Execute the query
        if ($stmt->execute()) {
            // Fetch the user
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify if the user exists and the password matches
            if ($user && password_verify($password, $user['password'])) {
                // Passwords match, proceed with login
                $_SESSION['user_logged_in'] = true;
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_id'] = $user['id'];
                
                // Regenerate session ID for security
                session_regenerate_id(true);
                
                header("Location: index.php");
                exit;
            } else {
                // Wrong credentials
                echo "<script>alert('Invalid email or password. Please try again.'); window.history.back();</script>";
            }
        } else {
            // Error executing the query
            echo "<script>alert('An error occurred. Please try again later.'); window.history.back();</script>";
        }
    } catch (PDOException $e) {
        // Log the error (in a production environment)
        error_log("Login error: " . $e->getMessage());
        echo "<script>alert('An error occurred. Please try again later.'); window.history.back();</script>";
    }
}
