<?php
// delete_case.php

// Check if the "id" parameter is passed in the URL
if (isset($_GET['id'])) {
    $case_id = $_GET['id'];

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

    // Query to delete the case from the "case" table based on the ID
    $sql = "DELETE FROM `case` WHERE id = $case_id";
    $result = $conn->query($sql);

    // Check if the delete operation was successful
    if ($result === true) {
        // Close the database connection
        $conn->close();
        // Redirect back to cases.php after deleting the case
        header("Location: cases.php");
        exit();
    } else {
        // Error deleting the case, redirect back to cases.php
        header("Location: cases.php");
        exit();
    }
} else {
    // "id" parameter not passed, redirect back to cases.php
    header("Location: cases.php");
    exit();
}
?>
