<?php
// delete_user.php

// Connect to your database (replace the placeholders with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "Password";
$dbname = "ubuntu-kwanzaa";
$port = 3306;


// Check if the request has a valid user ID
if (isset($_POST['id'])) {
    $userId = $_POST['id'];

    // Create a connection to the database
    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to delete the user with the specified ID
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // User deleted successfully
        $stmt->close();
        $conn->close();
        http_response_code(200); // Return HTTP status 200 for success
        exit();
    } else {
        // Error occurred during deletion
        $stmt->close();
        $conn->close();
        http_response_code(500); // Return HTTP status 500 for server error
        exit();
    }
} else {
    // Invalid request, no user ID provided
    http_response_code(400); // Return HTTP status 400 for bad request
    exit();
}
