<?php
	// Imports code that handles the connection to MySQL database, sessions, and time zone.
	require 'config/config.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quickfeed - Welcome</title>
</head>
<body>
	<h1>Welcome to Quickfeed!</h1>

	<?php

		echo md5("Maroons74");
		echo "<br>";
		echo password_hash("Maroons74", PASSWORD_DEFAULT, ['cost' => 12]);

	?>
</body>
</html>