#!/usr/bin/perl
# this script is part of the intouch program demo for PHS
# associates a phone's client with a message
# should be run right after message is recorded
# depends on the database being accurate for validity
use InTouchDemo;
use strict;
my $callerid = shift;
my $msg = shift;
my $iscallback = shift;
InTouch::db_save_msg_owner($callerid,$msg,$iscallback);

