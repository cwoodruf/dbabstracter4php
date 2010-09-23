#!/usr/bin/perl
# purpose of this script is to read stdin and print it out 
while (<>) {
	chomp;
	print "---------\n";
	print join "\n", split;
	print "\n---------\n";
}
