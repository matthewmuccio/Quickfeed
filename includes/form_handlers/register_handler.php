<?php
	// Declaring constant variables for readability.
	$NAME_MAX_LENGTH = 25;
	$NAME_MIN_LENGTH = 2;
	$PASSWORD_MAX_LENGTH = 30;
	$PASSWORD_MIN_LENGTH = 8;

	// Declaring variables to store user data and prevent errors.
	$firstName = "";
	$lastName = "";
	$email = "";
	$emailConfirm = "";
	$password = "";
	$passwordConfirm = "";
	$signUpDate = "";
	$errorArray = array();

	// If register button has been clicked, begin handling the form.
	if (isset($_POST['register_button']))
	{
		// Stores what was sent into the firstName input in the register form, and remove its HTML tags and any spaces.
		// Makes first letter of name uppercase and rest of name lowercase.
		// Stores firstName data into a session variable.
		$firstName = strip_tags($_POST['register_firstName']);
		$firstName = str_replace(' ', '', $firstName);
		$firstName = ucfirst(strtolower($firstName));
		$_SESSION['register_firstName'] = $firstName;

		// Same for lastName.
		$lastName = strip_tags($_POST['register_lastName']);
		$lastName = str_replace(' ', '', $lastName);
		$lastName = ucfirst(strtolower($lastName));
		$_SESSION['register_lastName'] = $lastName;

		// Same for email, except do not capitalize first letter.
		$email = strip_tags($_POST['register_email']);
		$email = str_replace(' ', '', $email);
		$email = strtolower($email);
		$_SESSION['register_email'] = $email;

		// Same for emailConfirm.
		$emailConfirm = strip_tags($_POST['register_emailConfirm']);
		$emailConfirm = str_replace(' ', '', $emailConfirm);
		$emailConfirm = strtolower($emailConfirm);
		$_SESSION['register_emailConfirm'] = $emailConfirm;

		// Stores what was sent into the password and passwordConfirm inputs in the register form, and remove their HTML tags.
		$password = strip_tags($_POST['register_password']);
		$passwordConfirm = strip_tags($_POST['register_passwordConfirm']);

		// Stores the registration date as the current date.
		$date = date("Y-m-d");

		// Checks if the entered email addresses match.
		if ($email == $emailConfirm)
		{
			// Checks if email is in valid format (contains @ and .something).
			if (filter_var($email, FILTER_VALIDATE_EMAIL))
			{
				// 
				$email = filter_var($email, FILTER_VALIDATE_EMAIL);

				// Validates/checks if email has already been used in database.
				$checkEmailQuery = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");

				// Count the number of rows returned by the checkEmailQuery query.
				$numRowsReturned = mysqli_num_rows($checkEmailQuery);

				// If rows are returned by that query, the email is in use.
				if ($numRowsReturned > 0)
					array_push($errorArray, "Email address has already been used.<br>");
			}
			else
				array_push($errorArray, "Invalid email address format.<br>");
		}
		else
			array_push($errorArray, "Email addresses do not match.<br>");

		// Validates/checks if first name is appropriate length.
		if (strlen($firstName) > $NAME_MAX_LENGTH || strlen($firstName) < $NAME_MIN_LENGTH)
			array_push($errorArray, "First name must be between 2-25 characters.<br>");

		// Validates/checks if last name is appropriate length.
		if (strlen($lastName) > $NAME_MAX_LENGTH || strlen($lastName) < $NAME_MIN_LENGTH)
			array_push($errorArray, "Last name must be between 2-25 characters.<br>");

		// Validates/checks if passwords match.
		if ($password != $passwordConfirm)
			array_push($errorArray, "Passwords do not match.<br>");
		else
		{
			// If the plaintext password (no strip tags) contains < or >, tell the user they cannot do so. This prevents a password with tags being used completely.
			if (strpos($_POST['register_password'], '<') || strpos($_POST['register_password'], '>'))
				array_push($errorArray, "Passwords can only contain certain characters. Please try again.<br>");
			// Checks if the password is appropriate (only contains letters and/or numbers).
			if (preg_match('/[^A-Za-z0-9!\"#$%\'()*+,-\.\/:;=?@\[\\\\\]\^_`{|}~]/', $password))
				array_push($errorArray, "Passwords can only contain certain characters. Please try again.<br>");
		}

		// Validates/checks if password is appropriate length.
		if (strlen($password) > $PASSWORD_MAX_LENGTH || strlen($password) < $PASSWORD_MIN_LENGTH)
			array_push($errorArray, "Password must be between 8-30 characters.<br>");

		// Handles inserting values into database.
		// If errorArray is empty, meaning there are no errors present.
		if (empty($errorArray))
		{
			// Stores and encrypts password before sending to database.
			$password = password_hash($_POST['register_password'], PASSWORD_DEFAULT, ['cost' => 12]);

			// Generate username by concatenating first and last name.
			$username = strtolower($firstName . "." . $lastName);

			// Checks if someone else already has that username by querying to the database.
			$checkUsernameQuery = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
			
			// Loops through the database checking for the number of users (rows) with the current username.
			// Stops looping when username variable is an available username.
			// If username exists, increment i.
			$i = 0;
			while (mysqli_num_rows($checkUsernameQuery) != 0)
			{
				// Stores the base username to be incremented (first.last).
				$baseUsername = strtolower($firstName . "." . $lastName);
				// Increment i by 1 each time the condition is true.
				$i++;
				// Continue to add i to the base username until it is unique.
				$username = $baseUsername . $i;
				// Checks if the new username is unique in the database, otherwise continue to loop.
				$checkUsernameQuery = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
			}

			// Default random profile picture assignment.
			// Selects random number between 1 and 2 (only two options).
			$rand = rand(1, 2);

			// Depending on random number, gives the user a default profile picture.
			if ($rand == 1)
				$profilePicture = "assets/images/profile_pictures/defaults/profile_green.png";
			else
				$profilePicture = "assets/images/profile_pictures/defaults/profile_blue.png";

			// Sends user's values to database.
			$query = mysqli_query($conn, "INSERT INTO users VALUES ('', '$firstName', '$lastName', '$username', '$email', '$password', '$date', '$profilePicture', '0', '0', 'no', ',')");

			// Alert user that their account has been created successfully after validating and sending data.
			array_push($errorArray, "<span style='color: green;'>Account created successfully.</span><br>");
			
			// Clear session variables after the user's data has been validated and sent to the database.
			$_SESSION['register_firstName'] = "";
			$_SESSION['register_lastName'] = "";
			$_SESSION['register_email'] = "";
			$_SESSION['register_emailConfirm'] = "";
		}
	}
?>