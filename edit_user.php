<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <?php
    // Connect to your database (replace the placeholders with your actual database credentials)
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ubuntu-kwanzaa";
    $port = 3307;

    // Check if the request has a valid user ID
    if (isset($_GET['id'])) {
        $userId = $_GET['id'];

        // Create a connection to the database
        $conn = new mysqli($servername, $username, $password, $dbname, $port);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and execute the SQL query to fetch the user with the specified ID
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // User found, fetch user data
            $user = $result->fetch_assoc();

            // Check if the form is submitted (after user edits and submits the data)
            if (isset($_POST['submit'])) {
                // Get the edited data from the form fields
                $name = $_POST['name'];
                $birthDate = $_POST['birth_date'];
                $height = $_POST['height'];
                $weight = $_POST['weight'];
                $bloodType = $_POST['blood_type'];
                $allergies = $_POST['allergies'];
                $medications = $_POST['medications'];
                $medicalNotes = $_POST['medical_notes'];
                $diseases = $_POST['diseases'];

                // Prepare and execute the SQL query to update the user data in the database
                $sql = "UPDATE users SET name=?, birth_date=?, height=?, weight=?, blood_type=?, allergies=?, medications=?, medical_notes=?, diseases=? WHERE id=?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "sssssssssi",
                    $name,
                    $birthDate,
                    $height,
                    $weight,
                    $bloodType,
                    $allergies,
                    $medications,
                    $medicalNotes,
                    $diseases,
                    $userId
                );

                if ($stmt->execute()) {
                    // User data updated successfully
                    header("Location: users.php"); // Redirect to the users page after successful update
                    exit();
                } else {
                    // Error occurred during update
                    echo "Error updating user data: " . $stmt->error;
                }
            }

            // Close the database connection
            $stmt->close();
            $conn->close();

            // Display the form with the user data for editing
            ?>
            <div class="container mt-4">
                <h2>Edit User</h2>
                <form method="post">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $user['name']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="birth_date">Birth Date:</label>
                        <input type="date" class="form-control" id="birth_date" name="birth_date" value="<?php echo $user['birth_date']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="height">Height:</label>
                        <input type="number" class="form-control" id="height" name="height" value="<?php echo $user['height']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="weight">Weight:</label>
                        <input type="number" class="form-control" id="weight" name="weight" value="<?php echo $user['weight']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="blood_type">Blood Type:</label>
                        <input type="text" class="form-control" id="blood_type" name="blood_type" value="<?php echo $user['blood_type']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="allergies">Allergies:</label>
                        <input type="text" class="form-control" id="allergies" name="allergies" value="<?php echo $user['allergies']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="medications">Medications:</label>
                        <input type="text" class="form-control" id="medications" name="medications" value="<?php echo $user['medications']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="medical_notes">Medical Notes:</label>
                        <input type="text" class="form-control" id="medical_notes" name="medical_notes" value="<?php echo $user['medical_notes']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="diseases">Diseases:</label>
                        <input type="text" class="form-control" id="diseases" name="diseases" value="<?php echo $user['diseases']; ?>" required>
                    </div>
                  
                    <button style="margin-top: 10px;" type="submit" name="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
            <?php
        } else {
            // User not found
            $stmt->close();
            $conn->close();
            echo "User not found.";
        }
    } else {
        // Invalid request, no user ID provided
        echo "Invalid request.";
    }
    ?>

    <!-- Bootstrap JS (optional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
