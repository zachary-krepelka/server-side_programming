<?php

// FILENAME: taxes.php
// AUTHOR: Zachary Krepelka
// DATE: Sunday, March 31st, 2024
// ABOUT: a homework assignment
// PATH: /var/www/html/taxes.php

$employee        =  "Kevin Slonka" ;
$hours_per_week  =  40             ;
$hourly_wage     =  54.5           ;

$gross_annual_income = $hourly_wage * $hours_per_week * 52;

$tax_bracket = array (

	"0.10" => array(       0,    11_000 ),
	"0.12" => array(  11_001,    44_725 ),
	"0.22" => array(  44_726,    95_375 ),
	"0.24" => array(  95_376,   182_100 ),
	"0.32" => array( 182_101,   231_250 ),
	"0.35" => array( 231_251,   578_125 ),
	"0.37" => array( 578_126, 1_000_000 )

);

foreach ($tax_bracket as $rate => $range) {

	list($lower, $upper) = $range;

	if ($lower <= $gross_annual_income && $gross_annual_income <= $upper) {

		$federal_tax_withholding_rate = $rate;

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
		table {
			display:inline-table;
		}
		table, tr, td {
			border: 1px solid black;
			border-collapse: collapse;
		}
	</style>
</head>

<body>
	<table>

		<caption>EMPLOYEE INFORMATION</caption>

		<!-- Filling out info verbatim to get started -->

		<tr>
			<td>Employee Name</td>
			<td>Kevin Slonka</td>
		</tr>

		<tr>
			<td>Hours Worked</td>
			<td>40.0</td>
		</tr>

		<tr>
			<td>Pay Rate</td>
			<td>$54.50</td>
		</tr>

		<tr>
			<td>Gross Pay</td>
			<td>$4180.00</td>
		</tr>

	</table>

	<table>

		<caption>DEDUCTIONS</caption>

		<!-- Filling out info verbatim to get started -->

		<tr>
			<td>Federal Withholding</td>
			<td>24.5%</td>
			<td>$534.10</td>
		</tr>

		<tr>
			<td>State Withholding</td>
			<td>5.5%</td>
			<td>$119.90</td>
		</tr>

		<tr>
			<td>Total Deduction</td>
			<td></td>
			<td>$654.00</td>
		</tr>

		<tr>
			<td>Net Pay</td>
			<td></td>
			<td>$1526.00</td>
		</tr>

	</table>

</body>

</html>
