<?php
session_start();

// Check if the user is authenticated, otherwise redirect to login.php
if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit();
}
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
			<li class="active">
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
            <h1>Users</h1>
            <ul class="breadcrumb">
                <li>
                    <a href="#">Dashboard</a>
                </li>
                <li><i class='bx bx-chevron-right'></i></li>
                <li>
                    <a class="active" href="#">Users</a>
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

    // Query to select all users from the "users" table
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);

    // Check if there are any rows returned
    if ($result->num_rows > 0) {
        ?>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Birth Date</th>
                            <th>Height</th>
                            <th>Weight</th>
                            <th>Blood Type</th>
                            <th>Allergies</th>
                            <th>Medications</th>
                            <th>Medical Notes</th>
                            <th>Diseases</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['name'] . '</td>';
                            echo '<td>' . $row['birth_date'] . '</td>';
                            echo '<td>' . $row['height'] . '</td>';
                            echo '<td>' . $row['weight'] . '</td>';
                            echo '<td>' . $row['blood_type'] . '</td>';
                            echo '<td>' . $row['allergies'] . '</td>';
                            echo '<td>' . $row['medications'] . '</td>';
                            echo '<td>' . $row['medical_notes'] . '</td>';
                            echo '<td>' . $row['diseases'] . '</td>';
                            echo '<td>';
                            echo '<div style="display: flex; flex-direction: row;">';
                            echo '<button class="btn btn-primary btn-sm" onclick="editUser(' . $row['id'] . ')">Edit</button>';
                            echo '<span style="width: 10px;"></span>';
                            echo '<button class="btn btn-danger btn-sm" onclick="deleteUser(' . $row['id'] . ')">Delete</button>';
                            echo '</div>';
                            echo '</td>';
                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php
    } else {
        echo "No users found.";
    }

    $conn->close();
    ?>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <!-- Your custom script -->
     <script src="script.js"></script>
    <!-- JavaScript for edit and delete functions using AJAX -->
    <script>
        function editUser(userId) {
            // Redirect to the edit page with the user ID
            window.location.href = 'edit_user.php?id=' + userId;
        }

        function deleteUser(userId) {
            if (confirm('Are you sure you want to delete this user?')) {
                // Send an AJAX request to the PHP script that handles the delete operation
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4) {
                        if (xhr.status === 200) {
                            // Refresh the table after successful deletion
                            location.reload();
                        } else {
                            console.error('Error deleting user:', xhr.status, xhr.statusText);
                        }
                    }
                };
                xhr.open('POST', 'delete_user.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + userId);
            }
        }
    </script>
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
            printWindow.document.write('<html><head><title>Users summary</title>');
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
