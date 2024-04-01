#!/usr/bin/env perl

# FILENAME: taxes.pl
# AUTHOR: Zachary Krepelka
# DATE: Sunday, March 31st, 2024
# ABOUT: a homework assignment

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

################################################################################

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
