<?php

// FILENAME: final.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 28th, 2024
// ABOUT: the final exam for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/hw8.php

/*******************************************************************************

This file is part of the final exam for my server-side programming class at
Saint Francis University.  I reproduce the assignment's instructions below to
provide context for the reader.

	Create a PHP website to meet the following requirements.

	 1) Look of the website (font sizes, etc.) shall be at least as distinct
	    as in the provided screenshots.

	 2) Only 3 files shall be used for the website:

		* final.php (contains all code for the project)

		* final_logout.php (contains only the code to destroy the
		  session and redirect to main page)

		* auth.db (contain the tab delimited user/password combinations)

	 3) Initial page access (and any unauthenticated page access) shall
	   present the logon form

 	 4) All pages shall have the CPSC222 Final Exam header and footer as
	   shown in the screenshots

	 5) Authentication shall be accomplished via reading the auth.db file

	 6) Upon successful authentication, users shall be presented with the
	    Dashboard that:

		* Welcomes their username

		* Provides the ability to logout

		* Lists the three reports that can be run (user list, group
		  list, syslog)

	 7) Unsuccessful authentication shall present the user with an error
	    message

	 8) Reports shall be access via a GET variable named 'page'

	 9) Invalid 'page' accesses shall present the user with an error message

	10) The User List report shall present the contents of /etc/passwd in a
	    table

	11) The Group List report shall present the contents of /etc/group in a
	    table

	12) The Syslog report shall present the contents of /var/log/syslog in a
	    table

	Extra credit: Only store password hashes in the auth.db file instead of
	plain-text passwords

	Extra credit: Add a hidden page (with some clever way to access it) that
	is an "about the author" page.  Add a photo of you and a paragraph about
	your interests and what you'd like to do after college.  Add a note to
	your submission that you have done this so I know to look for it.

	Add your 3 files to your repo and submit your repo URL

*******************************************************************************/

/* To provide file access to /var/log/syslog:
 *
 * https://stackoverflow.com/q/7771586
 *
 * <?php echo exec('whoami'); ?>
 *
 * ls -l /var/log/syslog
 *
 * sudo usermod -a -G adm www-data
 *
 * sudo reboot
 */

session_start();

$footer = date("Y-m-d h:i:s A");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$un = sanitize($_POST['username']);

	$login_success = validate($un, sanitize($_POST['password']));

	if ($login_success) $_SESSION['username'] = $un;

} // if

if (isset($_SESSION['username'])) {

	echo <<<_END
	<html>
		<style>
			table, th, td {
				border: 1px solid;
			}
		</style>
		<head>
			<title>CPSC222 Final Exam</title>
		</head>
		<body>
			<h1>CPSC222 Final Exam</h1>
			<h2>
				Welcome, {$_SESSION['username']}!
				(<a href="final_logout.php">Log Out</a>)
			</h2>
	_END;

	if (isset($_GET['page'])) {

		$page = intval($_GET['page']);

		echo <<<_END
				<p><a href="{$_SERVER['PHP_SELF']}">
				&lt;&nbsp;Back to Dashboard<a/></p>
		_END;

		renderPage($page);

	} else {

		echo <<<_END

			<p> Dashboard:
			<ul>
				<li><a href="?page=1">User list</a></li>
				<li><a href="?page=2">Group list</a></li>
				<li><a href="?page=3">Syslog</a></li>
			</ul>
			</p>
		_END;

	} // if

	echo <<<_END
			<hr><footer>$footer</footer>
		</body>
	</html>
	_END;

	exit();

} // if

function validate($candidate_username, $candidate_password) {

	$fh = fopen('auth.db', "r") or die("Failed to read the database.");

	while($line = fgets($fh)) {

		if(!feof($fh)) {

			list($username, $password) = explode("\t", trim($line));

			if (
				$candidate_username === $username &&
				$candidate_password === $password
			) {

				fclose($fh); return true;

			} // if

		} // if

	} // while

	fclose($fh); return false;

} // func

function sanitize($str) {

	return trim(preg_replace('/[^-a-zA-Z0-9]+/', '', $str));

} // func

function readDSV($fname, $delim = ',') {

	// BREAKS THE SINGLE-RESPONSIBILITY PRINCIPLE

	// I didn't realize that syslog wasn't a DSV.  I didn't even bother to
	// look. I just assumed that it was like the others.  It's too late to
	// rethink things now.  Here is a half-baked fix.

	$customLogic = $fname === '/var/log/syslog';

	$AoA = array();

	$fh = fopen($fname, "r") or die("Failed to open DSV file.");

	while($line = fgets($fh))

		if(!feof($fh))

			$AoA[] =
			$customLogic ?
			processSyslogLine($line) :
			explode($delim, trim($line));

	fclose($fh); return $AoA;

} // func

function processSyslogLine($line) {

	// Disclaimer: error prone, needs more thought.

	// It doesn't look like there's any nice pattern, so let's painstakingly
	// chip out the different components one by one with regex.

	// #1 MESSAGE

		// Split after the first occurrence of a closing square bracket
		// using a zero-width look-behind assertion.

		$arr = preg_split('/(?<=])/', $line, 2);

		// Parallel assignment gives an error here and nowhere else?
		// Must mean that my assumptions are wrong.
		// Warning: Undefined array key 1

		$everythingElse = $arr[0];
		$message        = $arr[1] ?? ""; // null coalescing operator

	// #2 DATE

		list($date, $everythingElse) =

		// Split on the first occurrence of a space preceded by a digit
		// character and succeeded by a non-digit character.

		preg_split('/(?<=[0-9]) (?=[^0-9])/', $everythingElse, 2);

		// Assumes that the hostname does not start with a digit.
		// Retrospectively, this is a bad assumption.

	// #3 HOSTNAME & PID

		list($hostname, $processID) = explode(' ', $everythingElse, 2);

	return array($date, $hostname, $processID, $message);

} // func

function tabularizeArrayOfArrays($AoA, $headers = NULL, $indents = 0) {

	$i = str_repeat("\t", $indents);

	$printRow = function($row, $tag = "td") use ($i) {

		echo "$i\t<tr>\n";

		foreach($row as $col) {

			$col = htmlentities($col);

			echo "$i\t\t<$tag>$col</$tag>\n";

		} // foreach

		echo "$i\t</tr>\n";

	}; // func

	echo "\n$i<table>\n";

	if ($headers) $printRow($headers, $tag = "th");

	foreach($AoA as $row) $printRow($row);

	echo "$i</table>\n";

} // func

function renderPage($num, $indents = 0) {

	$pages = array(

		[
			'title'    => 'User list',
			'filename' => '/etc/passwd',
			'headers'  => [

				'Username',
				'Password',
				'UID',
				'GID',
				'Display Name',
				'Home Directory',
				'Default Shell',
			],
		], [
			'title'    => 'Group list',
			'filename' => '/etc/group',
			'headers'  => [

				'Group Name',
				'Password',
				'GID',
				'Members',
			],
		], [
			'title'    => 'Syslog',
			'filename' => '/var/log/syslog',
			'headers'  => [

				'Date',
				'Hostname',
				'Application[PID]',
				'Message',
			],
		],
	);

	if (!array_key_exists($num - 1, $pages)) {

		echo "Invalid page.";

		return;

	} //method

	$properties = $pages[$num - 1];

	echo
		"\n",
		str_repeat("\t", $indents),
		"<h3>{$properties['title']}</h3>";

	tabularizeArrayOfArrays(

		readDSV($properties['filename'], ':'),

		$properties['headers'], $indents);

} // func
?>
<html>
	<head>
		<title>CPSC222 Final Exam</title>
	</head>
	<body>
		<h1>CPSC222 Final Exam</h1>
		<?php
			if (isset($login_success) && !$login_success)

				echo "<p>Invalid login...</p>\n";
		?>
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
		<hr><footer><?php echo $footer; ?></footer>
	</body>
</html>
