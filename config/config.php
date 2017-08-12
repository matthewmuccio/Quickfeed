<?php
	// Turns on output buffering. PHP is loaded to a browser in sections, this saves the PHP data when the page is loaded and it will pass all the PHP code to the browser at once.
	ob_start();

	// Starts a session, which allows us to store data from form inside a session variable when a user makes a mistake.
	session_start();

	// Connection to MySQL database quickfeed at address localhost with default username root and no password.
	$conn = mysqli_connect("localhost", "root", "", "quickfeed");

	// Checks and detects error connecting to database, and displays message if so.
	if (mysqli_connect_errno())
		echo "Failed to connect: " . mysqli_connect_errno();

	// Saves timezone for future use.
	$timezone = date_default_timezone_set("America/New_York");
?>