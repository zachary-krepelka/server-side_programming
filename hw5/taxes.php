<?php

// FILENAME: taxes.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, March 31st, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// UPDATED: Thursday, April 4th, 2024 at 5:41 AM
// PATH: /var/www/html/taxes.php

/*******************************************************************************

This file is part of an assignment for my server-side programming class at Saint
Francis University.  I reproduce the assignment's instructions below to provide
context for the reader.

	Write a PHP website that calculates the following items:

		* Federal Withholding
		* State Withholding
		* Total Deductions
		* Net Pay

	You shall hard code the following items into variables in order to do
	the calculations.

		* Employee Name
		* Hours worked in a week
		* Hourly pay rate
		* Federal tax withholding rate
		* State tax withholding rate

	Below is textual output that you can use in order to test whether your
	math was done correctly.

		Employee Name: Kevin Slonka
		Hours Worked: 40.0
		Pay Rate: $54.50
		Gross Pay: $2180.00
		Deductions:
			Federal Withholding (24.5%): $534.10
			State Withholding (5.5%): $119.90
			Total Deduction: $654.00
		Net Pay: $1526.00

	Output:

		* Your web page must show the output in the form of an HTML
		  table with an appropriate number of rows and columns so that
		  the data is easily readable.

		* Tell the user in what federal tax bracket they fall.
		  Use the 2024 brackets.

	Add the PHP file to your repo and submit your repo URL.

*******************************************************************************/

class Employee {

	private static $taxBrackets = array(

		'single-filer' => [

			"0.10" => [       0,    11_000 ],
			"0.12" => [  11_001,    44_725 ],
			"0.22" => [  44_726,    95_375 ],
			"0.24" => [  95_376,   182_100 ],
			"0.32" => [ 182_101,   231_250 ],
			"0.35" => [ 231_251,   578_125 ],
			"0.37" => [ 578_126,       INF ],
		],

		'married-filing-jointy' => [

			"0.10" => [       0,    22_000 ],
			"0.12" => [  22_001,    89_450 ],
			"0.22" => [  89_451,   190_750 ],
			"0.24" => [ 190_751,   364_200 ],
			"0.32" => [ 364_201,   462_500 ],
			"0.35" => [ 462_501,   693_750 ],
			"0.37" => [ 693,751,       INF ],
		],

		'married-filing-separately' => [

			"0.10" => [       0,    11_000 ],
			"0.12" => [  11_001,    44_725 ],
			"0.22" => [  44_726,    95_375 ],
			"0.24" => [  95_376,   182_100 ],
			"0.32" => [ 182_101,   231_250 ],
			"0.35" => [ 231_251,   346_875 ],
			"0.37" => [ 346_876,       INF ],
		],

		'head-of-household' => [

			"0.10" => [       0,    11_000 ],
			"0.12" => [  11_001,    44_725 ],
			"0.22" => [  44_726,    95_375 ],
			"0.24" => [  95_376,   182_100 ],
			"0.32" => [ 182_101,   231_250 ],
			"0.35" => [ 231_251,   346_875 ],
			"0.37" => [ 346_876,       INF ],
		],
	);

	private static $periods = array(

		'daily'        =>  1/7,
		'weekly'       =>  1,
		'monthly'      =>  3.345,
		'quarterly'    =>  13,
		'semi-annual'  =>  26,
		'annual'       =>  52,

		# https://www.google.com/search?q=how+many+weeks+in+a+month

	);

	private $name, $state, $filingStatus, $hourlyWage, $hoursPerWeek;

	function __construct(

			$name,
			$state,
			$filingStatus,
			$hourlyWage,
			$hoursPerWeek
		) {

		$this->name          =  $name;
		$this->state         =  $state;
		$this->filingStatus  =  $filingStatus;
		$this->hourlyWage    =  $hourlyWage;
		$this->hoursPerWeek  =  $hoursPerWeek;

	}

	private function getName() {

		return $this->name;
	}

	private function getHourlyWage() {

		return $this->hourlyWage;
	}

	private function getHoursWorked($period) {

		return $this->hoursPerWeek * self::$periods[$period];
	}

	private function getGrossIncome($period) {

		return $this->getHourlyWage() * $this->getHoursWorked($period);

	}

	private function getStateTaxWithholdingRate() {

		switch($this->state) {

			case 'PA':
				return 0.0307;
			default:
				return NAN;
		}
	}

	private function getFederalTaxWithholdingRate() {

		$income = $this->getGrossIncome('annual');

		foreach(self::$taxBrackets[$this->filingStatus]
					as $rate => list($lower, $upper)) {

			if ($lower <= $income && $income <= $upper) {

				return $rate;
			}
		}
		return NAN;
	}

	private function getTaxBracket() {

		$money = fn($num) => '$' . number_format($num, 2);

		$income = $this->getGrossIncome('annual');

		foreach(self::$taxBrackets[$this->filingStatus]
					as $rate => list($lower, $upper)) {

			if ($lower <= $income && $income <= $upper) {

				return
					$this->name                  .
					' falls in the '             .
					$this->filingStatus          .
					' tax bracket ranging from ' .
					$money($lower) . ' to '      .
					$money($upper) . '.'         ;
			}
		}
		return "";
	}

	private function getWithholdingRate() {

		return
			$this->getStateTaxWithholdingRate() +
			$this->getFederalTaxWithholdingRate();
	}

	public function generateTaxReport($period, $indentCount) {

		$money   = fn($num)  => '$' . number_format($num, 2);
		$percent = fn($rate) => sprintf("%.1f%%", $rate * 100);
		$time    = fn($num)  => number_format($num, 1);

		$i = str_repeat("\t", $indentCount);

		$start =

			"\n$i<p>"                        .
			"\n$i\t<table>"                  .
			"\n$i\t\t<caption>%1s</caption>" ;

		$end =
			"\n$i\t</table>" .
			"\n$i</p>"       ;

		$pairs = array(
		'Employee Name'   => $this->getName(),
		'Hourly Pay Rate' => $money($this->getHourlyWage()),
		'Hours Worked'    => $time($this->getHoursWorked($period)),
		'Gross Pay'       => $money($this->getGrossIncome($period)),
		);

		$rates = array(
		'Federal Withholding' => $this->getFederalTaxWithholdingRate(),
		'State Withholding'   => $this->getStateTaxWithholdingRate(),
		'Total Deduction'     => $this->getWithholdingRate(),
		'Net Pay'             => 1 - $this->getWithholdingRate(),
		);

		echo "<p>" . $this->getTaxBracket() . "</p>";

		printf($start, 'EMPLOYEE INFORMATION');

		foreach ($pairs as $key => $value) {

			printf(
			"\n$i\t\t<tr>"                           .
			"\n$i\t\t\t<td>%1s</td>"                 .
			"\n$i\t\t\t<td align=\"right\">%2s</td>" .
			"\n$i\t\t</tr>"                          ,
			$key, $value);

		}

		print $end;

		printf($start, 'TAX DEDUCTIONS');

		foreach ($rates as $name => $rate) {

			printf(
			"\n$i\t\t<tr>"                           .
			"\n$i\t\t\t<td>%1s</td>"                 .
			"\n$i\t\t\t<td align=\"right\">%2s</td>" .
			"\n$i\t\t\t<td align=\"right\">%3s</td>" .
			"\n$i\t\t</tr>"                          ,

			$name,
			$percent($rate),
			$money($rate * $this->getGrossIncome($period)));
		}

		print $end . "\n";
	}
}
?>
<html>
	<head>
		<style>
		table, tr, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
		</style>
	</head>
	<body>
		<div align="center">
			<h2>Server-side Programming Homework #5</h2>
			<?php

$professor = new Employee('Kevin Slonka', 'PA', 'married-filing-jointy', 54.5, 40);
$professor->generateTaxReport('weekly', 3);

			?>
		</div>
	</body>
</html>
