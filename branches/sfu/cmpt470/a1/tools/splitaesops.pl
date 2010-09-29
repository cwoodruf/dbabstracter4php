#!/usr/bin/perl -n
# purpose of this script is to split up a file of collected fables from aesop
# and save the titles as links to the files
if (m#<h2>([A-Z ]+)</h2>#) { 
	$title = $1; 
	($file=$title) =~ s/([A-Z]+)/lc($1)/eg; 
	$file =~ s/ +/_/g; 
	print "<a href=\"fables/$file.html\">$title</a><br>\n"; 
} 

if (/<hr>/) { 
	$lines =~ s/\r//g;
	open FABLE, "> aesops/fables/$file.html" 
		and print FABLE <<HTML or die $!; 
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en-us" xml:lang="en-us" xmlns="http://www.w3.org/1999/xhtml"><head>
<title>$title</title>
<link rel="stylesheet" type="text/css" href="css/aesops.css">
</head>
<body>
<div class="story">
$lines
</div>
</body>
</html>
HTML
	undef $lines; 
} else {
	$lines .= $_; 
}
