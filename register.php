<?php
	// Imports code that handles the connection to MySQL database, sessions, and time zone.
	require 'config/config.php';
	// Imports code that handles the account registration form.
	require 'includes/form_handlers/register_handler.php';
	// Imports code that handles the login form.
	require 'includes/form_handlers/login_handler.php';
?>

<!DOCTYPE html>
<html>
<head>
	<title>Quickfeed - Register</title>
	<!-- Links stylesheet for register form. -->
	<link rel="stylesheet" type="text/css" href="assets/css/register_stylesheet.css">
	<!-- Loads jQuery in the web page. -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Loads the jQuery script that handles hiding and showing login and register forms. -->
	<script src="assets/js/register.js"></script>
</head>
<body>
	<!-- Handles when the user clicks enter on the register form. -->
	<?php
		if (isset($_POST['register_button']))
		{
			echo '
				<script>
					$(document).ready(function()
					{
						$("#login_form").hide();
						$("#register_form").show();
					});
				</script>
			';
		}
	?>

	<!-- Div that wraps login and registration form. -->
	<div class="wrapper">
		<!-- Div that contains the login box. -->
		<div class="login_box">
			<!-- Div that contains the header of the login box. -->
			<div class="login_header">
				<h1>Quickfeed</h1>
				Log In or Register today!
			</div>
			<!-- Div that contains the login form. -->
			<div id="login_form">
				<!-- Creating Quickfeed login form -->
				<form action="register.php" method="POST">
					<!-- Email address input -->
					<input type="email" name="login_email" placeholder="Email address" value="<?php
						if (isset($_SESSION['login_email']))
							echo $_SESSION['login_email'];
					?>" required>
					<br>

					<!-- Password input -->
					<input type="password" name="login_password" placeholder="Password" required>
					<br
>					<?php
						// Checks if the incorrect email or password is in the error array, and if so echo it.
						if (in_array("The email address or password you've entered was incorrect.<br>", $errorArray))
							echo "The email address or password you've entered was incorrect.<br>";
					?>

					<!-- Log In button -->
					<input type="submit" name="login_button" value="Log In">
					<br>

					<!-- "Register here" link -->
					<a href="#" id="register_link" class="register_link">New user? Register here!</a>
				</form>
			</div>
			<!-- Div that contains the register form. -->
			<div id="register_form">
				<!-- Creating Quickfeed user account registration form -->
				<form action="register.php" method="POST">
					<!-- First name input -->
					<input type="text" name="register_firstName" placeholder="First name" value="<?php
						if (isset($_SESSION['register_firstName']))
							echo $_SESSION['register_firstName'];
					?>" required>
					<br>
					<!-- Displays first name error from errorArray. -->
					<?php
						if (in_array("First name must be between 2-25 characters.<br>", $errorArray))
							echo "First name must be between 2-25 characters.<br>";
					?>
					
					<!-- Last name input -->
					<input type="text" name="register_lastName" placeholder="Last name" value="<?php
						if (isset($_SESSION['register_lastName']))
							echo $_SESSION['register_lastName'];
					?>" required>
					<br>
					<!-- Displays last name error from errorArray. -->
					<?php
						if (in_array("Last name must be between 2-25 characters.<br>", $errorArray))
							echo "Last name must be between 2-25 characters.<br>";
					?>

					<!-- Email address input -->
					<input type="text" name="register_email" placeholder="Email address" value="<?php
						if (isset($_SESSION['register_email']))
							echo $_SESSION['register_email'];
					?>" required>
					<br>
					<!-- Confirm email address input -->
					<input type="text" name="register_emailConfirm" placeholder="Confirm email address" value="<?php
						if (isset($_SESSION['register_emailConfirm']))
							echo $_SESSION['register_emailConfirm'];
					?>" required>
					<br>
					<!-- Displays email error from errorArray. -->
					<?php
						if (in_array("Email address has already been used.<br>", $errorArray))
							echo "Email address has already been used.<br>";
						else if (in_array("Invalid email address format.<br>", $errorArray))
							echo "Invalid email address format.<br>";
						else if (in_array("Email addresses do not match.<br>", $errorArray))
							echo "Email addresses do not match.<br>";
					?>

					<!-- Password input -->
					<input type="password" name="register_password" placeholder="Password" required>
					<br>
					<!-- Confirm password input -->
					<input type="password" name="register_passwordConfirm" placeholder="Confirm password" required>
					<br>
					<!-- Displays password error from errorArray. -->
					<?php
						if (in_array("Passwords do not match.<br>", $errorArray))
							echo "Passwords do not match.<br>";
						else if (in_array("Passwords can only contain certain characters. Please try again.<br>", $errorArray))
							echo "Passwords can only contain certain characters. Please try again.<br>";
						else if (in_array("Password must be between 8-30 characters.<br>", $errorArray))
							echo "Password must be between 8-30 characters.<br>";
					?>

					<!-- Register Account button -->
					<input type="submit" name="register_button" value="Register Account">
					<br>
					<!-- Alert user that their account has been created successfully after they click the Register Account button. -->
					<?php
						if (in_array("<span style='color: green;'>Account created successfully.</span><br>", $errorArray))
							echo "<span style='color: green;'>Account created successfully.</span><br>";
					?>

					<!-- "Log in here" link -->
					<a href="#" id="login_link" class="login_link">Have an account? Log in here!</a>
				</form>
			</div>
		</div>
	</div>
</body>
</html>