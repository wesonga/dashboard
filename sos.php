<?php
session_start();

// Check if the user is authenticated, otherwise redirect to login.php
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php
// sos.php

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

// Query to select the specific columns from the "sos" table with a join to get patient's name
$sql = "SELECT sos.id, users.name AS patient_name, sos.rescuers_num, sos.closest_rescuer_location, sos.arrived_rescuers_num, sos.time_sos, sos.time_first_arrival FROM sos
        INNER JOIN users ON sos.patient_id = users.id";
$result = $conn->query($sql);

// Check if the query was executed successfully
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Fetch all SOS records and store them in an array
    $sos_records = array();
    while ($row = $result->fetch_assoc()) {
        $sos_records[] = $row;
    }
} else {
    // No SOS records found
    $sos_records = array();
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">
    <section id="sidebar">
    <a href="#" class="brand">
			<!-- <i class='bx bxs-smile'></i> -->
			<img src="img/logo.ico" alt="Image description"  style="width: 32px; height: 32px;  margin-right: 10px; margin-left: 10px">
			<span class="text">Ubuntu Kwanzaa</span>
		</a>
		<ul class="side-menu top">
			<li >
				<a href="#">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-group' ></i>
					<span class="text">Users</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bx-add-to-queue' ></i>
					<span class="text">Diseases</span>
				</a>
			</li>
			<li class="active">
				<a href="#">
					<i class='bx bxs-phone-incoming' ></i>
					<span class="text">Emergency Calls</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-ambulance' ></i>
					<span class="text">Cases</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="logout.php" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
    </section>
    
    <section id="content">
        <!-- NAVBAR -->
        <nav>
			<i class='bx bx-menu'></i>
			<!-- <a href="#" class="nav-link">Categories</a> -->
			<form action="#">
				<div class="form-input">
					<!-- <input type="search" placeholder="Search..."> -->
					<button type="submit" class="text"><i class='bx bxs-smile'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			
		</nav>
        <!-- NAVBAR -->
        <title>SOS</title>

</head>
<main>
<div class="head-title">
        <div class="left">
            <h1>Emergency Calls</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Emergency Calls</a>
                </li>
            </ul>
        </div>
        <a href="#" class="btn-download" onclick="printTable()">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Download PDF</span>
        </a>
    </div>
    </main>

<body>
    

    <div class="container mt-4">
    
        <?php if (count($sos_records) > 0) : ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Number of Rescuers</th>
                        <th>Closest Rescuer Location(Coordinates)</th>
                        <th>Arrived Rescuers Number</th>
                        <th>Time of Distress</th>
                        <th>Time of First Arrival</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($sos_records as $sos) : ?>
                        <tr>
                            <td><?php echo $sos['id']; ?></td>
                            <td><?php echo $sos['patient_name']; ?></td>
                            <td><?php echo $sos['rescuers_num']; ?></td>
                            <td><?php echo $sos['closest_rescuer_location']; ?></td>
                            <td><?php echo $sos['arrived_rescuers_num']; ?></td>
                            <td><?php echo $sos['time_sos']; ?></td>
                            <td><?php echo $sos['time_first_arrival']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No SOS records found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Your custom script -->
    <script src="script.js"></script>
    <script>
        // Function to print the contents of the table with CSS styling
        function printTable() {
            var tableContent = document.querySelector('table').outerHTML;
            var printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Emergency cases summary</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">'); // Add the link to your CSS file
            printWindow.document.write('</head><body>');
            printWindow.document.write(tableContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
        
    </script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2wE10soWmWXt-LZlPC3pU7V5bcGWOpTs&callback=initMap" async defer></script>


</body>

</html>
