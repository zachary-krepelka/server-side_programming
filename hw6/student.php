<?php

// FILENAME: student.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 7th, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/student.php

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

require_once "grade.php";

class student {

	private $firstName, $lastName, $identification, $courseGrades;

	function getFirstName() {

		return $this->firstName;
	}

	function setFirstName($firstName) {

		$this->firstName = $firstName;
	}

	function getLastName() {

		return $this->lastName;
	}

	function setLastName($lastName) {

		$this->lastName = $lastName;
	}

	function getFormattedName() {

		return $this->getLastName() . ', ' . $this->getFirstName();
	}

	function getID() {

		return $this->identification;
	}

	function setID($identification) {

		$this->identification = $identification;
	}

	function getCourseGrades() {

		return $this->courseGrades;
	}

	function setCourseGrades($courseGrades) {

		if (is_array($courseGrades)) {

			$this->courseGrades = $courseGrades;
		}
	}

	function __construct($firstName, $lastName, $id, $courseGrades) {

		$this->setFirstName($firstName);
		$this->setLastName($lastName);
		$this->setID($id);
		$this->setCourseGrades($courseGrades);
	}

	function generateReport($indentCount) {

		$i = str_repeat("\t", $indentCount);

		$start =
			"\n$i<p>"                .
			"\n$i\t<table border=1>" ;

		$row =
			"\n$i\t\t<tr>"                                   .
			"\n$i\t\t\t<td align=\"center\"><b>%1s</b></td>" .
			"\n$i\t\t\t<td>%2s</td>"                         .
			"\n$i\t\t</tr>"                                  ;

		$end =
			"\n$i\t<table>" .
			"\n$i<p>"       ;

		$list = "\n$i\t\t\t\t<ul>";

		$item = "\n$i\t\t\t\t\t<li>%1s - %d %2s</li>";

		foreach($this->getCourseGrades() as $course => $numericGrade) {

			$list .= sprintf(
					$item,
					$course,
					$numericGrade,
					computeLetterGrade($numericGrade));

		}

		$list .= "\n$i\t\t\t\t</ul>\n$i\t\t\t";

		print $start;

		printf( $row , 'Name'       , $this->getFormattedName() );
		printf( $row , 'Student ID' , $this->getID()            );
		printf( $row , 'Grades'     , $list                     );

		print $end;

	}
}
