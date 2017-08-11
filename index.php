<?php
	// Connection to MySQL database quickfeed at address localhost with default username root and no password.
	$conn = mysqli_connect("localhost", "root", "", "quickfeed");

	// Checks and detects error connecting to database, and displays message if so.
	if (mysqli_connect_errno())
		echo "Failed to connect: " . mysqli_connect_errno();

	// Using connection variable, insert test user into table.
	//$query = mysqli_query($conn, "INSERT INTO test VALUES ('1', 'Matthew')");
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quickfeed - Welcome</title>
</head>
<body>
	<p>Quickfeed</p>
</body>
</html>