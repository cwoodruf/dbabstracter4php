#!/usr/bin/perl
# purpose of this script is to do a callback for messages
# from the intouch files table where the callbackts is set
use InTouchDemo;
use strict;
# where to put .call file to get asterisk to initiate a call
my $astspool = '/usr/local/asterisk/var/spool/asterisk/outgoing';
my $astchannel = 'SIP/voicemeup-trunk'; # how to call out
my $calllimit = 4; # max calls to make at any one time

my $getmsgs = $InTouch::db->prepare(
	"select distinct callerid from files ".
	"where callbackts > 0 and callbackts <= unix_timestamp() ".
	"order by created limit $calllimit"
);
my $clearmsgs = $InTouch::db->prepare(
	"update files set callbackts=0 where callerid=? and callbackts <> 0 "
);

$getmsgs->execute or die $getmsgs->errstr;
while (my $row = $getmsgs->fetchrow_hashref) {
	warn "no phone number!" unless $row->{callerid} =~ /^\d{10,}$/;
	$clearmsgs->execute($row->{callerid}) or die $clearmsgs->errmsg;
	my $spoolfile = "$astspool/$row->{callerid}.call";
	print scalar(localtime),": calling $row->{callerid}\n";
	open CALL, "> $spoolfile" or die "can't make spoolfile: $!";
	print CALL <<AST;
Channel: $astchannel/$row->{callerid}
CallerID: $row->{callerid} <$row->{callerid}>
Context: intouch-callback
Extension: s
Priority: 1
AST
	close CALL;
}

