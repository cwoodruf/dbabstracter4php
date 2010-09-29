#!/usr/bin/perl -n
# purpose of this script is to generate the css for the word callouts
while (m#picturedef (\w+)#g) { $c{$1}++; } 

END { 
	foreach (sort keys %c) { 
		$i = substr($_,0,1);
		print <<CSS;
span.$_:hover:after {
        content: " " url(wordpics/$i/$_.jpg);
}
CSS
	} 
}
