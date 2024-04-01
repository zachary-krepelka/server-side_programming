<?php

// FILENAME: taxes.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, March 31st, 2024
// ABOUT: a homework assignment for my server-side programming class
// ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git
// PATH: /var/www/html/taxes.php

$employee        =  "Kevin Slonka" ;
$hours_per_week  =  40             ;
$hourly_wage     =  54.5           ;

$gross_annual_income = $hourly_wage * $hours_per_week * 52;

$tax_bracket = array (

	"0.10" => [       0,    11_000 ],
	"0.12" => [  11_001,    44_725 ],
	"0.22" => [  44_726,    95_375 ],
	"0.24" => [  95_376,   182_100 ],
	"0.32" => [ 182_101,   231_250 ],
	"0.35" => [ 231_251,   578_125 ],
	"0.37" => [ 578_126,       INF ],

);

foreach ($tax_bracket as $rate => $range) {

	list($lower, $upper) = $range;

	if ($lower <= $gross_annual_income && $gross_annual_income <= $upper) {

		$federal_tax_withholding_rate = $rate;

		$employee_bracket = $range;

	}

}

$state_tax_withholding_rate = 0.0307;

$federal_withholding = $gross_annual_income * $federal_tax_withholding_rate;
$state_withholding   = $gross_annual_income * $state_tax_withholding_rate;
$total_withholding   = $state_withholding + $federal_withholding;
$net_annual_income   = $gross_annual_income - $total_withholding;

?>

<html>

	<head>

		<title>Taxes</title>

		<style>
			table, tr, td {
				border: 1px solid black;
				border-collapse: collapse;
			}
		</style>

	</head>

	<body> <div align="center">

		<h2>Server-side Programming Homework #5</h2>

		<p><?php echo

			"$employee falls in the tax bracket ranging from $" .
			number_format($employee_bracket[0]) . ' to $' .
			number_format($employee_bracket[1]) . '.';

		?></p>

		<p> <table>

			<caption>EMPLOYEE INFORMATION</caption>

			<tr>
				<td>Employee Name</td>

				<td align="right"><?php
					echo $employee;
				?></td>
			</tr>

			<tr>
				<td>Hours Worked</td>

				<td align="right"><?php
				printf("%.1f",
				$hours_per_week);
				?></td>
			</tr>

			<tr>
				<td>Pay Rate</td>

				<td align="right"><?php
				printf("$%.2f",
				$hourly_wage);
				?></td>
			</tr>

			<tr>
				<td>Gross Pay</td>

				<td align="right"><?php
				printf("$%.2f",
				$gross_annual_income / 52);
				?></td>
			</tr>

		</table> </p>

		<p> <table>

			<caption>TAX DEDUCTIONS</caption>

			<tr>
				<td>Federal Withholding</td>

				<td align="right">
				<?php
					printf("%.1f%%",
					$federal_tax_withholding_rate * 100);
				?></td>

				<td align="right">
				<?php
					printf("$%.2f",
					$federal_withholding / 52);
				?></td>
			</tr>

			<tr>
				<td>State Withholding</td>

				<td align="right">
				<?php
					printf("%.1f%%",
					$state_tax_withholding_rate * 100);
				?></td>

				<td align="right">
				<?php
					printf("$%.2f",
					$state_withholding / 52);
				?></td>
			</tr>

			<tr>
				<td>Total Deduction</td>

				<td align="right">n/a</td>

				<td align="right">
				<?php
					printf("$%.2f",
					$total_withholding / 52);
				?></td>
			</tr>

			<tr>
				<td>Net Pay</td>

				<td align="right">n/a</td>

				<td align="right">
				<?php
					printf("$%.2f",
					$net_annual_income / 52);
				?></td>
			</tr>

		</table>
		</p>
	</div>
	</body>
</html>
