<!--
	FILENAME: hw6.php
	AUTHOR: Zachary Krepelka
	DATE: Sunday, April 7th, 2024
	ABOUT: a homework assignment for my server-side programming class
	ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
	PATH: /var/www/html/hw6.php
-->
<html>
	<head>
		<title>Homework #6</title>
	</head>
	<body>
		<h1>Server-side Programming Homework #6</h1>
		<?php

			require_once "student.php";

			$students = array(

				new student('Kevin', 'Slonka', 1001, array(

					'CPSC222' => 98,
					'CPSC111' => 76,
					'CPSC333' => 82,

				)),

				new student('Joe', 'Schmoe', 1005, array(

					'CPSC122' => 88,
					'CPSC411' => 46,
					'CPSC323' => 72,

				)),

				new student('Stewie', 'Griffin', 1009, array(

					'CPSC244' => 68,
					'CPSC116' => 96,
					'CPSC345' => 82,

				)),

			);

			for($i = 0; $i < count($students); $i++) {

				$students[$i]->generateReport(3);
			}

		?>
	</body>
</html>
