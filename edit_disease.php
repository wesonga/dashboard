<?php
// edit_disease.php

// Check if the disease ID is provided as a parameter in the URL
if (isset($_GET['id'])) {
    $disease_id = $_GET['id'];

    // Process the form data when the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

        // Get the updated values from the form
        $title = $_POST['title'];
        $subtitle = $_POST['subtitle'];
        $description = $_POST['description'];

        // Update the disease in the "diseases" table using prepared statement
        $stmt = $conn->prepare("UPDATE disease SET title = ?, subtitle = ?, description = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $subtitle, $description, $disease_id);

        if ($stmt->execute()) {
            // Success, redirect back to the diseases.php page after updating the disease
            header("Location: disease.php");
            exit();
        } else {
            // Error executing the update query
            die("Error executing the update query: " . $stmt->error);
        }

        // Close the prepared statement
        $stmt->close();

        // Close the database connection
        $conn->close();
    }

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

    // Query to select the specific disease from the "diseases" table
    $sql = "SELECT id, title, subtitle, description FROM disease WHERE id = $disease_id";
    $result = $conn->query($sql);

    // Check if the query was executed successfully
    if ($result === false) {
        die("Error executing the query: " . $conn->error);
    }

    // Check if there is a row returned
    if ($result->num_rows > 0) {
        // Fetch the disease data
        $disease = $result->fetch_assoc();
    } else {
        // No disease found with the given ID, redirect back to the diseases.php page
        header("Location: diseases.php");
        exit();
    }

    // Close the database connection
    $conn->close();
} else {
    // If the disease ID is not provided, redirect back to the diseases.php page
    header("Location: diseases.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Disease</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Edit Disease</h2>
        <form method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo $disease['title']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="subtitle" class="form-label">Subtitle</label>
                <input type="text" class="form-control" id="subtitle" name="subtitle" value="<?php echo $disease['subtitle']; ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="4" required><?php echo $disease['description']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
