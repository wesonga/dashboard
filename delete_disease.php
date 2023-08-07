<?php
// delete_disease.php

// Check if the disease ID is provided as a parameter in the URL
if (isset($_GET['id'])) {
    $disease_id = $_GET['id'];

    // Connect to your database (replace the placeholders with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ubuntu-kwanzaa";
    $port = 3307; 

    $conn = new mysqli($servername, $username, $password, $dbname, $port);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Delete the disease from the "diseases" table
    $delete_sql = "DELETE FROM disease WHERE id = $disease_id";
    $delete_result = $conn->query($delete_sql);
    if ($delete_result === false) {
        die("Error executing the delete query: " . $conn->error);
    }

    // Close the database connection
    $conn->close();

    // Redirect back to the diseases.php page after deleting the disease
    header("Location: disease.php");
    exit();
} else {
    // If the disease ID is not provided, redirect back to the diseases.php page
    header("Location: disease.php");
    exit();
}
?>
