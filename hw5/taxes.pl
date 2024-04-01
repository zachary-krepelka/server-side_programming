#!/usr/bin/env perl

# FILENAME: taxes.pl
# AUTHOR: Zachary Krepelka
# DATE: Sunday, March 31st, 2024
# ABOUT: a homework assignment for my server-side programming class
# ORIGIN: https://github.com/zachary-krepelka/server-side_programming.git

=begin comment

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

This Perl script is not formally part of the assignment.
I wrote it as an intitial exercise to collect my thoughts.

=end comment

=cut

use strict;
use warnings;
use feature qw( say );

my $employee        =  "Kevin Slonka" ;
my $hours_per_week  =  40             ;
my $hourly_wage     =  54.5           ;

my $gross_annual_income = $hourly_wage * $hours_per_week * 52;

my $federal_tax_withholding_rate;
my $state_tax_withholding_rate = 0.0307;

my %tax_bracket = (

	0.10 => [       0,    11_000 ],
	0.12 => [  11_001,    44_725 ],
	0.22 => [  44_726,    95_375 ],
	0.24 => [  95_376,   182_100 ],
	0.32 => [ 182_101,   231_250 ],
	0.35 => [ 231_251,   578_125 ],
	0.37 => [ 578_126, 1_000_000 ],

);

for my $rate (keys %tax_bracket) {

	my ($lower, $upper) = @{$tax_bracket{$rate}};

	if ($lower <= $gross_annual_income <= $upper) {

		$federal_tax_withholding_rate = $rate;
	}
}

my $federal_withholding = $gross_annual_income * $federal_tax_withholding_rate;
my $state_withholding   = $gross_annual_income * $state_tax_withholding_rate;
my $total_withholding   = $state_withholding + $federal_withholding;
my $net_annual_income   = $gross_annual_income - $total_withholding;

#################################### OUTPUT ####################################

say "Employee Name: $employee";

printf "Hours Worked: %.1f\n", $hours_per_week;
printf "Pay Rate: \$%.2f\n",   $hourly_wage;
printf "Gross Pay: \$%.2f\n",  $gross_annual_income / 52;

say "Deductions:";

printf "\tFederal Withholding (%.1f%%): \$%.2f\n",

	$federal_tax_withholding_rate * 100,
	$federal_withholding / 52;

printf "\tState Withholding (%.1f%%): \$%.2f\n",

	$state_tax_withholding_rate * 100,
	$state_withholding / 52;

printf "\tTotal Deduction: \$%.2f\n", $total_withholding / 52;

printf "Net Pay: \$%.2f\n", $net_annual_income / 52;

# https://taxfoundation.org/location/pennsylvania
# https://www.irs.gov/filing/federal-income-tax-rates-and-brackets
