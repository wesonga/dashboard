<?php
// edit_case.php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the case ID from the URL parameter
    $case_id = $_GET['id'];

    // Get the form data
    $title = $_POST['title'];
    $overview = $_POST['overview'];
    $symptoms = $_POST['symptoms'];

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

    // Prepare the update query
    $sql = "UPDATE `case` SET title = '$title', overview = '$overview', symptoms = '$symptoms' WHERE id = $case_id";

    // Execute the update query
    if ($conn->query($sql) === TRUE) {
        // Redirect back to the cases.php page after updating the case
        header("Location: cases.php");
        exit();
    } else {
        echo "Error updating case: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form is not submitted, retrieve the case data from the database and populate the form fields
    if (isset($_GET['id'])) {
        // Get the case ID from the URL parameter
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

        // Prepare the select query to get the case information
        $sql = "SELECT * FROM `case` WHERE id = $case_id";
        $result = $conn->query($sql);

        if ($result === false) {
            die("Error executing the query: " . $conn->error);
        }

        if ($result->num_rows > 0) {
            // Fetch the case information
            $case = $result->fetch_assoc();
            // Close the database connection
            $conn->close();
        } else {
            echo "No case found.";
            $conn->close();
            exit();
        }
    } else {
        echo "Case ID not provided.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Case</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Case</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $case['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="overview" class="form-label">Overview</label>
                <textarea class="form-control" id="overview" name="overview" rows="3" required><?php echo $case['overview']; ?></textarea>
            </div>
            <div class="mb-3">
                <label for="symptoms" class="form-label">Symptoms</label>
                <textarea class="form-control" id="symptoms" name="symptoms" rows="3" required><?php echo $case['symptoms']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
