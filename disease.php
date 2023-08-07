<?php
session_start();

// Check if the user is authenticated, otherwise redirect to login.php
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php
// diseases.php

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

// Query to select the specific fields from the "diseases" table
$sql = "SELECT id, title, subtitle, description FROM disease";
$result = $conn->query($sql);

// Check if the query was executed successfully
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

// Check if the "delete" parameter is passed in the URL
if (isset($_GET['delete'])) {
    $disease_id = $_GET['delete'];
    // Delete the disease from the "diseases" table
    $delete_sql = "DELETE FROM diseases WHERE id = $disease_id";
    $delete_result = $conn->query($delete_sql);
    if ($delete_result === false) {
        die("Error executing the delete query: " . $conn->error);
    }
    // Redirect back to the diseases.php page after deleting the disease
    header("Location: diseases.php");
    exit();
}

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Fetch all diseases and store them in an array
    $diseases = array();
    while ($row = $result->fetch_assoc()) {
        $diseases[] = $row;
    }
} else {
    // No diseases found
    $diseases = array();
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
			<li class="active">
				<a href="#">
					<i class='bx bx-add-to-queue' ></i>
					<span class="text">Diseases</span>
				</a>
			</li>
			<li >
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
            <h1>Diseases</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Diseases</a>
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
        <h2>Diseases</h2>
        <?php if (count($diseases) > 0): ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Subtitle</th>
                        <th>Description</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($diseases as $disease): ?>
                        <tr>
                            <td><?php echo $disease['id']; ?></td>
                            <td><?php echo $disease['title']; ?></td>
                            <td><?php echo $disease['subtitle']; ?></td>
                            <td><?php echo $disease['description']; ?></td>
                            <td>
                                <!-- Edit button with a link to edit_disease.php -->
                                <a href="edit_disease.php?id=<?php echo $disease['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            </td>
                            <td>
                                <!-- Delete button with a link to delete_disease.php -->
                                <a href="delete_disease.php?id=<?php echo $disease['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this disease?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No diseases found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Your custom script -->
     <script src="script.js"></script>

     <script>
        // Function to print the contents of the table (excluding last two columns) with CSS styling
        function printTable() {
            // Clone the table and remove the last two columns
            var table = document.querySelector('table');
            var tempTable = table.cloneNode(true);
            var lastColumn = tempTable.rows[0].cells.length - 1;
            for (var i = 0; i < tempTable.rows.length; i++) {
                tempTable.rows[i].deleteCell(lastColumn);
                tempTable.rows[i].deleteCell(lastColumn - 1);
            }

            var tableContent = tempTable.outerHTML;
            var printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Disease summary</title>');
            printWindow.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">'); // Add the link to your CSS file
            printWindow.document.write('</head><body>');
            printWindow.document.write(tableContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>
</html>
