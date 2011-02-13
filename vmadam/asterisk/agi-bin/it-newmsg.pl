#!/usr/bin/perl
# sanitize the message name and make a directory for it
use strict;
use File::Path;
use InTouchDemo;

my $caller = shift;
$caller =~ s/\D//g;
if (!length($caller)) { $caller = 'unknown'; }

my $epoch = shift;
$epoch = time unless $epoch =~ m/^\d+$/;

my $dir = "$InTouch::dir/$caller";
mkpath($dir) or die "can't make $dir!" unless -d $dir;

$InTouch::agi->set_variable('newmsg', "$dir/$caller-$epoch");

