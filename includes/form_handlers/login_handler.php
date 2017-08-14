<?php
	// If log in button has been clicked, begin handling the form.
	if (isset($_POST['login_button']))
	{
		// Makes sure email address is in the correct format.
		$email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL);

		// Stores email data into a session variable.
		$_SESSION['login_email'] = $email;

		// Checks if entered password matches the one in database.
		$checkDatabaseQuery = mysqli_query($conn, "SELECT * FROM users where email = '$email'");

		// If the number of rows returned by the database query is 1, meaning the email matches the one in the database, then continue verifying their info.
		if (mysqli_num_rows($checkDatabaseQuery) == 1)
		{
			// Allows us to access the columns of the row returned by this query as indices in an array.
			$row = mysqli_fetch_array($checkDatabaseQuery);

			// Grabs and stores the encrypted password in the database.
			$password = $row['password'];

			// Verifies that the password entered by the user is the plaintext equivalent of the encrypted one in the database.
			if (password_verify($_POST['login_password'], $password))
			{
				// Grabs and stores the username in the database.
				$username = $row['username'];
				
				// Handles if the user has closed their account, re-open it.
				$userClosedQuery = mysqli_query($conn, "SELECT * FROM users WHERE email ='$email' AND user_closed = 'yes'");
				
				// If the number of rows returned by the query is 1,
				if (mysqli_num_rows($userClosedQuery) == 1)
					// If the user's account was closed and they log in again, their account will be reopened.
					$reopenAccount = mysqli_query($conn, "UPDATE users SET user_closed = 'no' WHERE email = '$email'");

				// Stores username data into a session variable.
				$_SESSION['username'] = $username;

				// Redirects page to index.php after log-in has completed.
				header("Location: index.php");
				exit();
			}
			else
				array_push($errorArray, "The email address or password you've entered was incorrect.<br>");
		}
		// If the number of rows returned by the database query is anything but 1, meaning that the user should not log in.
		else
			array_push($errorArray, "The email address or password you've entered was incorrect.<br>");
	}
?>