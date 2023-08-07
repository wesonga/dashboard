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

// Query to get the total number of cases
$sql = "SELECT COUNT(*) as total_cases FROM `case`"; // Make sure to use backticks around the table name "case"
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCases = $row['total_cases'];
} else {
    $totalCases = 0;
}

// Close the database connection
$conn->close();

// Return the total number of cases as JSON response
header("Content-Type: application/json");
echo json_encode(array('total_cases' => $totalCases));
?>
