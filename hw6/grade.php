<?php

// FILENAME: grade.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, April 7th, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/grade.php

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
