<?php
	// If log in button has been clicked, begin handling the form.
	if (isset($_POST['login_button']))
	{
		// Makes sure email address is in the correct format.
		$email = filter_var($_POST['login_email'], FILTER_SANITIZE_EMAIL);

		// Stores email data into a session variable.
		$_SESSION['login_email'] = $email;
		// Stores and encrypts password.
		$password = md5($_POST['login_password']);
		// Checks if entered password matches the one in database.
		$checkDatabaseQuery = mysqli_query($conn, "SELECT * FROM users where email = '$email' AND password = '$password'");
		// Count the number of rows returned by the checkDatabaseQuery query.
		$checkLoginQuery = mysqli_num_rows($checkDatabaseQuery);

		// If the number of rows returned by the database query is 1, meaning that the user should log in.
		if ($checkLoginQuery == 1)
		{
			// Allows us to access the results returned by this query in an array.
			$row = mysqli_fetch_array($checkDatabaseQuery);
			// Stores the username at that row in a variable.
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
		// If the number of rows returned by the database query is anything but 1, meaning that the user should not log in.
		else
		{
			array_push($errorArray, "The email address or password you've entered was incorrect.<br>");
		}
	}
?>