<?php

// FILENAME: birthday.php
// AUTHOR: Zachary Krepelka
// DATE: Monday, April 22nd, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/birthday.php

/*******************************************************************************

This file is part of an assignment for my server-side programming class at Saint
Francis University.  I reproduce the assignment's instructions below to provide
context for the reader.

	Create a PHP webpage that users can enter their birthdate and get the
	output formatted as shown in the screenshot below.  Once the user
	receives their "pretty" output they can click a hyperlink to receive
	their birthdate in ISO format.

	Requirements:

		* The form must POST
		* The form must NOT show on subsequent pages
		* The ISO hyperlink must use a GET request
		* All user input must be sanitized to prevent exploits

	Screenshots:

	* First:
		 _                    _
		|_)o.__|_|_  _| _.   |__ ._._ _  _._|__|_ _ ._
		|_)||  |_| |(_|(_|\/ |(_)| | | |(_| |_ |_(/_|
				  /
		+------------------------------------------------------+
		|    Month    | Day  |  Year   | Hour | Minute | AM/PM |
		| ------------+------+---------+------+--------+-------|
		| February \/ | 4 \/ | 2024 \/ | 5 \/ | 2 \/   | PM \/ |
		| ------------+------+---------+------+--------+-------|
		|                    +-----------+                     |
		|                    |Format Date|                     |
		|                    +-----------+                     |
		+------------------------------------------------------+

	* Second:
		 _                    _
		|_)o.__|_|_  _| _.   |__ ._._ _  _._|__|_ _ ._
		|_)||  |_| |(_|(_|\/ |(_)| | | |(_| |_ |_(/_|
				  /
		Sunday, February 4th, 2023 - 5:02pm

		Show date in ISO format
		-----------------------

	* Third:
		 _                    _
		|_)o.__|_|_  _| _.   |__ ._._ _  _._|__|_ _ ._
		|_)||  |_| |(_|(_|\/ |(_)| | | |(_| |_ |_(/_|
				  /
		2024-02-04 17:02:00

*******************************************************************************/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	$month    = intval($_POST['month']);
	$day      = intval($_POST['day']);
	$year     = intval($_POST['year']);
	$hour     = intval($_POST['hour']);
	$minute   = intval($_POST['minute']);
	$meridiem = intval($_POST['meridiem']);

	$format   = 'l, F j<\s\u\p>S</\s\u\p>, Y - h:i A';
	$birthday = mktime($hour, $minute, 0, $month, $day, $year);
	$response = date($format, $birthday);
	$link     = "<a href='?birthday=$birthday'>Show date in ISO format</a>";

} else if (isset($_GET['birthday'])) {

	$format   = 'Y-m-d H:i:s'; // $format = DATE_ISO8601;
	$birthday = intval($_GET['birthday']);
	$response = date($format, $birthday);

} // fi

function HeredocIndentor($indents, $heredoc) {

	$indentation = str_repeat("\t", $indents);

	echo preg_replace('/(^|\R)/', "$1$indentation", $heredoc) . "\n";

} // func

function makeOption($value, $content, $current, $indents = 0) {

	$opt = str_repeat("\t", $indents) . "<option ";

	if ($value == $current)

		$opt .= 'selected="selected" ';

	$opt .= "value=$value>$content</option>\n";

	echo $opt;

} // func

function makeSelection($type, $indents = 0) {

	$indentation = str_repeat("\t", $indents);

	echo $indentation . "<select name= \"$type\">\n";

	switch($type) {

	case 'month':

		$months = array(

			 1 => 'January',
			 2 => 'February',
			 3 => 'March',
			 4 => 'April',
			 5 => 'May',
			 6 => 'June',
			 7 => 'July',
			 8 => 'August',
			 9 => 'September',
			10 => 'October',
			11 => 'November',
			12 => 'December'

		);

		foreach ($months as $num => $name)

			makeOption($num, $name, date('m'), $indents + 1);

		break;

	case 'day':

		for ($i = 1; $i <= 31; $i++)

			makeOption($i, $i, date('d'), $indents + 1);

		break;

	case 'year':

		$thisYear = date("Y");

		// The year can range from 1901 to 2038 with PHP 5.1.0+ on
		// 32-bit signed systems.

		for ($i = $thisYear; $i >= 1901; $i--)

			makeOption($i, $i, $thisYear, $indents + 1);

		break;

	case 'hour':

		for ($i = 1; $i <= 12; $i++)

			makeOption($i, $i, date('h'), $indents + 1);

		break;

	case 'minute':

		for($i = 0; $i <= 59; $i++)

			makeOption($i, $i, date('i'), $indents + 1);

		break;

	case 'meridiem':

		foreach(array('AM', 'PM') as $meridiem)

			makeOption(
				$meridiem,
				$meridiem,
				date('A'),
				$indents + 1
			);

		break;

	} // switch

	echo $indentation . "<select>\n";

} // func

function makeForm($indents = 0) {

	$indentation = str_repeat("\t", $indents);

	HeredocIndentor($indents, <<<_END
	<form method="post" action="{$_SERVER['PHP_SELF']}">
		<table border=1>
			<tr>
				<th>Month</th>
				<th>Day</th>
				<th>Year</th>
				<th>Hour</th>
				<th>Minute</th>
				<th>AM/PM</th>
			</tr>
			<tr>
	_END);

	$types = array(

		'month',
		'day',
		'year',
		'hour',
		'minute',
		'meridiem',
	);

	foreach($types as $type) {

		echo $indentation . "\t\t\t<td>\n";

		makeSelection($type, $indents + 4);

		echo $indentation . "\t\t\t</td>\n";

	} // for

	HeredocIndentor($indents, <<<_END
			</tr>
			<tr>
				<td colspan=6 align=center>
					<input
						type="submit"
						value="Format Date">
				</td>
			</tr>
		</table>
	</form>
	_END);
} // func
?>
<html>
	<head>
		<title>
			Birthday Formatter
		</title>
	</head>
	<body>
		<h1>Birthday Formatter</h1>
<?php

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		echo "\t\t<p>$response</p>\n\t\t<p>$link</p>\n";

	} else if (isset($_GET['birthday'])) {

		echo "\t\t<p>$response</p>\n";

	} else {

		makeForm(2);

	} // if
?>
	</body>
</html>
