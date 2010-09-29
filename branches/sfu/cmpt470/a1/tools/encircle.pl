#!/usr/bin/perl
# purpose of this script is to find words from the photographicdictionary 
# and surround them with html tags for displaying images to match the words
open WPW, "wordpics_words" or die "can't open wordpics_words: $!";
while (<WPW>) {
	chomp;
	push @pats, ucfirst($_);
	push @pats, $_;
}
$pat = join '|', @pats;
@pats = ();
$pat = qr/\b($pat)(ed|ing|ly|)\b/;

while (<>) {
	if (s{$pat}{<span class="picturedef \L$1">$1$2</span>\n}g) {
		print STDERR;
	}
	print;
}
