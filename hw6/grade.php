<?php

// FILENAME: grade.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 7th, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/grade.php

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

function computeLetterGrade($percentage) {

	$gradingScale = array(

		'F' => [  0,  59 ],
		'D' => [ 60,  69 ],
		'C' => [ 70,  79 ],
		'B' => [ 80,  89 ],
		'A' => [ 90, 100 ],

	);

	foreach($gradingScale as $mark => list($lower, $upper)) {

		if ($lower <= $percentage && $percentage <= $upper) {

			return $mark;
		}
	}
	return '?';
}
