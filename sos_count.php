<?php
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

// Query to get the total number of SOS requests
$sql = "SELECT COUNT(*) as total_sos FROM sos";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalSOS = $row['total_sos'];
} else {
    $totalSOS = 0;
}

// Close the database connection
$conn->close();

// Return the total number of SOS requests as JSON response
header("Content-Type: application/json");
echo json_encode(array('total_sos' => $totalSOS));
?>
