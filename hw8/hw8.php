<?php

// FILENAME: hw8.php
// AUTHOR: Zachary Krepelka
// DATE: Tuesday, April 23rd, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/hw8.php

/*******************************************************************************

This file is part of an assignment for my server-side programming class at Saint
Francis University.  I reproduce the assignment's instructions below to provide
context for the reader.

	Create a simple webpage that allows a user to login with the credentials
	"admin" and "password".  Present an error message if authentication
	fails.  Upon login, show a welcome message and a link to logout.

	Requirements:

		* The login form must ONLY show when the user is logged out

		* User input must be cleaned by a custom function utilizing
		  preg_replace()

		* Add the PHP files to your repo and submit your repo URL

The URLs in the provided screenshots indicated that we should use only one file.

*******************************************************************************/

session_start();

if (isset($_GET['logout'])) {

	$_SESSION = array();
	session_destroy();
	header('Location: ' . $_SERVER['PHP_SELF']);

} // if

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$un = sanitize($_POST['username']);
	$pw = sanitize($_POST['password']);

	if (validate($un, $pw)) {

		$_SESSION['username'] = $un;
		$_SESSION['password'] = $pw;

	} else echo "Invalid login...";

} // if

if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

	echo <<<_END
	<html>
		<head>
			<title>{$_SESSION['username']}'s Profile</title>
		</head>
		<body>
			<h1>Hello, {$_SESSION['username']}</h1>
			<a href="?logout">Logout</a>
		</body>
	</html>
	_END;
	exit();

} // if

function validate($username, $password) {

	return $username === 'admin' && $password == 'password';

} // func

function sanitize($str) {

	// Only lowercase, alphanumeric chars allowed.

	return preg_replace('/[^a-z0-9]+/', '', strtolower($str));

} // func

?>
<html>
	<head>
		<title>Login</title>
	</head>
	<body>
		<form
			method="POST"
			action="<?php echo $_SERVER['PHP_SELF'];?>">
			<table>
				<tr>
					<td>
						<label for="un">
							Username:
						</label>
					</td>
					<td>
						<input
							id="un"
							name="username"
							type="text">
					</td>
				</tr>
				<tr>
					<td>
						<label for="pw">
							Password:
						</label>
					</td>
					<td>
						<input
							id="pw"
							name="password"
							type="password">
					</td>
				</tr>
				<tr>
					<td>
						<input
						type="submit"
						value="Login">
					</td>
				</tr>
			</table>
		</form>
	</body>
</html>
