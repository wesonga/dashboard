<?php
// Connect to your database (replace the placeholders with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ubuntu-kwanzaa";
$port = 3307;// Replace with your database port number

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select patient_location and patient_id from sos table
$sql = "SELECT sos.patient_location, sos.patient_id, users.name AS patient_name FROM sos
        INNER JOIN users ON sos.patient_id = users.id";
$result = $conn->query($sql);

// Fetch the patient_location and patient_name data from the database
$patientLocations = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $location = explode(',', $row['patient_location']);
        $latitude = floatval($location[0]);
        $longitude = floatval($location[1]);
        $patientLocations[] = array(
            'lat' => $latitude,
            'lng' => $longitude,
            'name' => $row['patient_name']
        );
    }
}

// Close the database connection
$conn->close();

// Convert the array to JSON format and send the response
header("Content-Type: application/json");
echo json_encode($patientLocations);
?>