<?php
	// Imports code that handles the connection to MySQL database, sessions, and time zone.
	require 'config/config.php';

	// This if-else block prevents the user from being able to access the site unless he or she is logged in.
	// If the user is logged in, store their username in a variable.
	if (isset($_SESSION['username']))
	{
		// The username of the user currently logged in.
		$userLoggedIn = $_SESSION['username'];
		// Queries to the database all the users with the username that the logged-in user has.
		$userDetailsQuery = mysqli_query($conn, "SELECT * FROM users WHERE username = '$userLoggedIn'");
		// Stores the columns in the MySQL table as indices in an array.
		$user = mysqli_fetch_array($userDetailsQuery);
	}
	// If it is not set, send the user back to the register page.
	else
		header("Location: register.php");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quickfeed - Welcome</title>
	<!-- Loads jQuery in the web page. -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Adds Bootstrap JS scripts to the page. -->
	<script src="assets/js/bootstrap.js"></script>

	<!-- Links Font Awesome CSS stylesheet to the page. -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Links Bootstrap CSS stylesheet to the page. -->
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
	<!-- Links CSS stylesheet for index page. -->
	<link rel="stylesheet" type="text/css" href="assets/css/index_stylesheet.css">
</head>
<body>
	<!-- Div that contains the nav bar that spans the top of the page and the buttons on it. -->
	<div class="nav_bar">
		<div class="logo">
			<a href="index.php">Quickfeed</a>
		</div>

		<!-- Collection of icons on the nav bar for the user to click on. -->
		<nav>
			<a href="#">
				<?php
					echo $user['first_name'];
				?>
			</a>
			<a href="#"><i class="fa fa-home fa-lg"></i></a>
			<a href="#"><i class="fa fa-envelope fa-lg"></i></a>
			<a href="#"><i class="fa fa-bell-o fa-lg"></i></a>
			<a href="#"><i class="fa fa-users fa-lg"></i></a>
			<a href="#"><i class="fa fa-cog fa-lg"></i></a>
		</nav>
	</div>