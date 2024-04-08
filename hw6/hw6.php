<?php

// FILENAME: hw6.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 7th, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/hw6.php

/*******************************************************************************

This file is part of an assignment for my server-side programming class at Saint
Francis University.  I reproduce the assignment's instructions below to provide
context for the reader.

	Create an array of 3 student objects and print them to the screen.

	Student object:

		* Must be a PHP class

		* Must contain the first name, last name, student ID, and an
		  associative array of 3 courses (keys) and their numeric grades
		  (values)

		* Initialization of the student object must be done using the
		  constructor, which calls the individual setters

	Output:

		* Each student gets his own table

		* Name must be formatted LAST, FIRST

		* Course output must be done in a single table cell as a
		  bulleted list

			* CPSC222 - 95% A

		* Letter grade calculation must be done by a function separate
		  from the student class

	Requirements:

		* Student class must be in a separate file

		* All class attributes must be private

		* Letter grade function must be in a separate file

		* Printing the students array must be done using a
		  numerically-indexed FOR loop

		* Printing the courses array must be done using a FOR EACH loop

	Example:

		+------------+------------------+
		|    Name    | Slonka, Kevin    |
		+------------+------------------+
		| Student ID | 1001             |
		+------------+------------------+
		|            | * CPSCxxx - 98 A |
		|   Grades   | * CPSCxxx - 76 C |
		|            | * CPSCxxx - 82 B |
		+------------+------------------+

		+------------+------------------+
		|    Name    | Schmoe, Joe      |
		+------------+------------------+
		| Student ID | 1005             |
		+------------+------------------+
		|            | * CPSCxxx - 88 B |
		|   Grades   | * CPSCxxx - 46 F |
		|            | * CPSCxxx - 72 C |
		+------------+------------------+

		+------------+------------------+
		|    Name    | Griffin, Stewie  |
		+------------+------------------+
		| Student ID | 1009             |
		+------------+------------------+
		|            | * CPSCxxx - 68 D |
		|   Grades   | * CPSCxxx - 96 A |
		|            | * CPSCxxx - 82 B |
		+------------+------------------+

*******************************************************************************/
?>
<html>
	<head>
		<title>Homework #6</title>
	</head>
	<body>
		<h1>Server-side Programming Homework #6</h1> <?php

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

			$students[$i]->generateReport(2);
		}

	?>

	</body>
</html>
