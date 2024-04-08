<?php

// FILENAME: student.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 7th, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/student.php

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

		$item ="\n$i\t\t\t\t\t<li>%1s - %d %2s</li>";

		foreach($this->getCourseGrades() as $course => $numericGrade) {

			$list .= sprintf(
					$item,
					$course,
					$numericGrade,
					computeLetterGrade($numericGrade));

		}

		$list .= "\n$i\t\t\t\t</ul>\n$i\t\t\t";

		print $start;
		printf($row, 'Name', $this->getFormattedName());
		printf($row, 'Student ID', $this->getID());
		printf($row, 'Grades', $list);
		print $end;

	}
}
