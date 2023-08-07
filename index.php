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

	<!-- Font Awesome -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css' rel='stylesheet'>

	<!-- Link to your CSS file for screen and print media -->
    <link rel="stylesheet" href="style.css" media="screen,print">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="style.css">

	<title>Ubuntu Kwanzaa</title>
	<style>
        
        /* Add your CSS styles for the marker labels here */
        .marker-label {
            background-color: green;
            color: white;
            padding: 5px;
            border-radius: 4px;
            font-weight: bold;
            position: absolute;
            bottom: 60%;
            left: 50%;
            transform: translateX(-50%);
        }
    </style>

</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<!-- <i class='bx bxs-smile'></i> -->
			<img src="img/logo.ico" alt="Image description" style="width: 32px; height: 32px;  margin-right: 10px; margin-left: 10px">
			<span class="text">Ubuntu Kwanzaa</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
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
			<li>
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
	<!-- SIDEBAR -->



	<!-- CONTENT -->
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

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				<a href="#" class="btn-download" onclick="printMainContent()">
					<i class='bx bxs-cloud-download'></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

			<ul class="box-info">
				<li>
					<i class='bx bxs-user-detail'></i>
					<span style="color: green;" class="text" id="totalUsers">
						Loading...
					</span>
				</li>
				<li>
					<i class="bx bxs-ambulance ambulance-animation"></i>
					<span style="color: orange;" class="text" id="totalCases">Loading...</span>

				</li>
				<li>
					<i class='bx bxs-phone-call phone-animation'></i>
					<span class="text" style="color: RED;" id="totalSOS">Loading...</span>
				</li>
			</ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Map View of Emergency Cases</h3>
					</div>
					<div id="map" style="height: 400px; width: 100%;"></div>

				</div>

			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	<script src="script.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA2wE10soWmWXt-LZlPC3pU7V5bcGWOpTs&callback=initMap" async defer></script>
	<script>
        // Initialize the map with markers for patient locations
        function initMap() {
            var mapOptions = {
                center: { lat: -0.604520, lng: 30.649109 }, // Set the default center to Mbarara
                zoom: 15 // Adjust the initial zoom level as needed
            };

            var map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // Fetch the patient locations from the server using AJAX
            fetch('get_patient_locations.php')
                .then(response => response.json())
                .then(patientLocations => {
                    // Loop through the patient locations and add markers to the map
                    for (var i = 0; i < patientLocations.length; i++) {
                        var latLng = { lat: patientLocations[i].lat, lng: patientLocations[i].lng };
                        var marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            label: {
                                text: patientLocations[i].name, // Use patient_name as the marker label
                                className: 'marker-label', // Apply the marker label CSS class
                            } // Use patient_name as the marker label
							
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching patient locations:', error);
                });
        }
    </script>
	<script>
		// Function to fetch total number of users and update the span element
		function getTotalUsers() {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var response = JSON.parse(xhr.responseText);
					var totalUsers = response.total_users;
					document.getElementById('totalUsers').innerHTML = totalUsers + '<br>Users';
				}
			};
			xhr.open('GET', 'users_count.php', true);
			xhr.send();
		}

		// Call the function to fetch and update the total number of users
		getTotalUsers();
	</script>
	<script>
		// Function to fetch total number of cases and update the span element
		function getTotalCases() {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var response = JSON.parse(xhr.responseText);
					var totalCases = response.total_cases;
					document.getElementById('totalCases').innerHTML = totalCases + '<br>Cases';
				}
			};
			xhr.open('GET', 'cases_count.php', true);
			xhr.send();
		}

		// Call the function to fetch and update the total number of cases
		getTotalCases();
	</script>
	<script>
		// Function to fetch total number of SOS requests and update the span element
		function getTotalSOS() {
			var xhr = new XMLHttpRequest();
			xhr.onreadystatechange = function() {
				if (xhr.readyState === 4 && xhr.status === 200) {
					var response = JSON.parse(xhr.responseText);
					var totalSOS = response.total_sos;
					document.getElementById('totalSOS').innerHTML = totalSOS + '<br><span style="color: red;">Emergency Calls</span>';
				}
			};
			xhr.open('GET', 'sos_count.php', true);
			xhr.send();
		}

		// Call the function to fetch and update the total number of SOS requests
		getTotalSOS();
	</script>
	<script>
        // Function to print the contents of the main tag with CSS styling
        function printMainContent() {
            var mainContent = document.querySelector('main').innerHTML;
            var printWindow = window.open('', '_blank', 'width=800,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><head><title>Dashboard</title>');
            printWindow.document.write('<link rel="stylesheet" href="style.css" media="screen,print">'); // Add the link to your CSS file
			printWindow.document.write('<link href="https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css" rel="stylesheet">'); 
            printWindow.document.write('</head><body>');
            printWindow.document.write(mainContent);
            printWindow.document.write('</body></html>');
            printWindow.document.close();
            printWindow.print();
        }
    </script>
</body>

</html>