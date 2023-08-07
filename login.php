<?php
session_start();

// Check if the user is already authenticated, redirect to index.php
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
	header("Location: index.php");
	exit();
}

// Check if the login form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
	$username = $_POST["username"];
	$password = $_POST["password"];

	// Hard-coded admin credentials (replace these with your desired credentials)
	$adminUsername = "admin";
	$adminPassword = "password";

	if ($username === $adminUsername && $password === $adminPassword) {
		// Successful login, set the session and redirect to index.php
		$_SESSION['authenticated'] = true;
		header("Location: index.php");
		exit();
	} else {
		// Invalid credentials, display an error message or perform any necessary action
		$error = "Invalid credentials. Please try again.";
	}
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

	<title>Login - Ubuntu Kwanzaa</title>
</head>

<body>
	<section class="vh-100" style="background-color: #0C0C1E;">
		<div class="container py-5 h-100">
			<div class="row d-flex justify-content-center align-items-center h-100">
				<div class="col col-xl-10">
					<div class="card" style="border-radius: 1rem;">
						<div class="row g-0">
							<div class="col-md-6 col-lg-5 d-none d-md-block">
								<img src="img/logo.png" alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem; max-height: 100%; max-width: 100%;" />
							</div>
							<div class="col-md-6 col-lg-7 d-flex align-items-center">
								<div class="card-body p-4 p-lg-5 text-black">

									<form action="login.php" method="post">

										<div class="d-flex align-items-center mb-3 pb-1">
											<i class="fas fa-cubes fa-2x me-3" style="color: #ff6219;"></i>
											<span class="h1 fw-bold mb-0">Ubuntu Kwanzaa</span>
										</div>

										<h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Welcome to the Admin Dashboard</h5>

										<div class="form-outline mb-4">
											<input type="text" id="username" name="username" class="form-control form-control-lg" required />
											<label for="username" class="form-label">Username</label>
										</div>

										<div class="form-outline mb-4">
											<input type="password" id="password" name="password" class="form-control form-control-lg" required />
											<label class="form-label" for="password">Password</label>
										</div>

										<div class="pt-1 mb-4">
											<button class="btn btn-dark btn-lg btn-block" type="submit">Login</button>
										</div>
									</form>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

</html>