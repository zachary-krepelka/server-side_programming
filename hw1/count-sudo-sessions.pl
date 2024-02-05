#!/usr/bin/env perl

# FILENAME: count-sudo-sessions.pl
# AUTHOR: Zachary Krepelka
# DATE: Monday, January 15th, 2024

open my $fh, '<', '/var/log/auth.log' or die $1;

my $log = do { local $/; <$fh> };

close $fh;

my $sudo_session_count = () = $log =~ m/session opened for user root/g;

	# We put the regex match into
	# list context and then into
	# scalar context to get the
	# number of matches.

print $sudo_session_count;
