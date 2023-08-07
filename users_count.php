<?php
// Connect to your database (replace the placeholders with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "Password";
$dbname = "ubuntu-kwanzaa";
$port = 3306;
 

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to get the total number of users
$sql = "SELECT COUNT(*) as total_users FROM users";
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalUsers = $row['total_users'];
} else {
    $totalUsers = 0;
}

// Close the database connection
$conn->close();

// Return the total number of users as JSON response
header("Content-Type: application/json");
echo json_encode(array('total_users' => $totalUsers));
?>
