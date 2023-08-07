<?php
session_start();

// Check if the user is authenticated, otherwise redirect to login.php
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}
?>
<?php
// cases.php

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

// Query to select the specific columns from the "case" table (excluding "causes" column)
$sql = "SELECT id, title, overview, symptoms FROM `case`";
$result = $conn->query($sql);

// Check if the query was executed successfully
if ($result === false) {
    die("Error executing the query: " . $conn->error);
}

// Check if the "delete" parameter is passed in the URL
if (isset($_GET['delete'])) {
    $case_id = $_GET['delete'];
    // Delete the case from the "case" table
    $delete_sql = "DELETE FROM `case` WHERE id = $case_id";
    $delete_result = $conn->query($delete_sql);
    if ($delete_result === false) {
        die("Error executing the delete query: " . $conn->error);
    }
    // Redirect back to the cases.php page after deleting the case
    header("Location: cases.php");
    exit();
}

// Check if there are any rows returned
if ($result->num_rows > 0) {
    // Fetch all cases and store them in an array
    $cases = array();
    while ($row = $result->fetch_assoc()) {
        $cases[] = $row;
    }
} else {
    // No cases found
    $cases = array();
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
            <img src="img/logo.ico" alt="Image description" style="width: 32px; height: 32px;  margin-right: 10px; margin-left: 10px">
            <span class="text">Ubuntu Kwanzaa</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="#">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-group'></i>
                    <span class="text">Users</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-add-to-queue'></i>
                    <span class="text">Diseases</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class='bx bxs-phone-incoming'></i>
                    <span class="text">Emergency Calls</span>
                </a>
            </li>
            <li class="active">
                <a href="#">
                    <i class='bx bxs-ambulance'></i>
                    <span class="text">Cases</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bxs-log-out-circle'></i>
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
            <h1>Cases</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Cases</a>
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
        <?php if (count($cases) > 0) : ?>
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Overview</th>
                        <th>Symptoms</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cases as $case) : ?>
                        <tr>
                            <td><?php echo $case['id']; ?></td>
                            <td><?php echo $case['title']; ?></td>
                            <td><?php echo $case['overview']; ?></td>
                            <td><?php echo $case['symptoms']; ?></td>
                            <td>
                                <div style="display: flex; flex-direction: row;">
                                    <!-- Edit button with a link to edit_case.php -->
                                    <a href="edit_case.php?id=<?php echo $case['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                    <!-- Add some spacing between the buttons -->
                                    <span style="width: 10px;"></span>
                                    <!-- Delete button with a link to delete_case.php -->
                                    <a href="delete_case.php?id=<?php echo $case['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this case?')">Delete</a>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p>No cases found.</p>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Your custom script -->
    <script src="script.js"></script>
    <script>
        // Function to print the contents of the table (excluding last column) with CSS styling
        function printTable() {
            var table = document.querySelector('table');
            var clonedTable = table.cloneNode(true);
            var lastColumnIndex = clonedTable.rows[0].cells.length - 1;
            var rows = clonedTable.rows;

            for (var i = 0; i < rows.length; i++) {
                rows[i].deleteCell(lastColumnIndex);
            }

            var tableContent = clonedTable.outerHTML;
            var printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Cases summary</title>');
            printWindow.document.write(' <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">'); // Add the link to your CSS file
            printWindow.document.write('</head><body>');
            printWindow.document.write(tableContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>

</html>
