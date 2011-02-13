#!/usr/bin/perl
# purpose of this script is to play messages for the PHS intouch demo
# adapted from Lifeline 
use InTouchDemo;
use strict;
=filter out

from lifeline's ansrvar.h

       {sNOMSGS, "No messages message.", nomsgs, nomsgs_cmplt, "NOMSGS.VOX", 0, 0},//13
       {sNEWMSGS, "New messages message.", nomsgs, nomsgs_cmplt, "NEWMSGS.VOX", 0, 0},//13
       {sLASTMSG, "Last message message.", lastmsg, lastmsg_cmplt, "LASTMSG.VOX", 0, 0},//14
       {sDELETEDMSG, "Message deleted message.", lastmsg, deletedmsg_cmplt, "DELMSG.VOX", 0, 0},//15
       {sWASDELETED, "Message had been deleted message.", lastmsg, wasdeleted_cmplt, "WASDEL.VOX", 0, 0},//15
       {sRESTOREDMSG, "Message restored message.", lastmsg, lastmsg_cmplt, "RESTMSG.VOX", 0, 0},//16
       {sDELETE, "Deleting messages.", delall, delall_cmplt, "DELETE.VOX", 0, 0},//17
       {sRESTORE, "Restoring messages.", delall, delall_cmplt, "RESTORE.VOX", 0, 0},//18
       {sDATEINTRO, "Message recorded on...", dateintro, dateintro_cmplt, "MSGREC.VOX", 0, 0},//19

=cut

my $prompt = 'll-en-listen';
my $no_msgs = 'll-en-nomsgs';
my $last_msg = 'll-en-lastmsg';
my $was_del = 'll-en-wasdel';
my $del_msg = 'll-en-delmsg';
my $restore_msg = 'll-en-restmsg';
my $del_all = 'll-en-delete';
my $restore_all = 'll-en-restore';
my $msg_rec = 'll-en-msgrec';
my $msg_from = 'vm-from-phonenumber';
my $extplay = 'll-en-extplay';
my $digits = '1234567890*#';

InTouch::load_msgs();
InTouch::play_msg_count or exit;

my $a = $InTouch::agi;
my $callback_app;

# what to do on hang up / exit
$SIG{HUP} = \&clean_up;
END { InTouch::clean_up_msgs; }
sub clean_up {
	InTouch::clean_up_msgs;
}

# start with the first message
PLAY:
while ((my $ascii = &play(InTouch::curr_msg,$callback_app)) >= 0) {
	MENU:
	if ($ascii <= 0) {
		$ascii = $a->stream_file($prompt,$digits);
		exit if $ascii <= 0;
	}
	$callback_app = undef;
	my $d = chr($ascii);
	$ascii = 0;
	if    ($d eq '1') { InTouch::inc_msg; } 
	elsif ($d eq '2') { InTouch::dec_msg; }
	elsif ($d eq '3') { }
	elsif ($d eq '4') { InTouch::first_msg; }
	elsif ($d eq '5') { InTouch::last_msg; }
	elsif ($d eq '*') { last PLAY; }
	elsif ($d eq '#') { $ascii = &msg_date(InTouch::curr_msg); goto MENU; }
	elsif ($d eq '7') { 
		InTouch::del_msg; 
		if (InTouch::curr_msg->{deleted}) {
			$ascii = $a->stream_file($del_msg,$digits); 
		} else {
			$ascii = $a->stream_file($restore_msg,$digits);
		}
		goto MENU; 
	} elsif ($d eq '9') { 
		InTouch::del_all(InTouch::curr_msg->{deleted}); 
		if (InTouch::curr_msg->{deleted}) {
			$ascii = $a->stream_file($del_all,$digits);
		} else {
			$ascii = $a->stream_file($restore_all,$digits);
		}
		goto MENU; 
	} else { goto MENU; }
}

sub play {
	my ($msg,$cb) = @_;
	exit unless defined $msg;
	my $k;
	$k = $a->stream_file($was_del,$digits) if $msg->{deleted};
	return $k if $k;
	my $mfile = "$msg->{msg}.$InTouch::rectype";
	my $deleted = "$msg->{msg}.deleted.$InTouch::rectype";
	# note, any message file could disappear mid-play for any reason
	# this is just an attempt at being polite in a multiuser environment
	$a->exec('WAIT',1);
	if (-f $mfile) { 
		# everything is ok
		if (defined $cb) {
			$cb->[1] = "$msg->{msg}|$cb->[1]";
			$k = $a->exec(@$cb);
		} else {
			$k = $a->stream_file($msg->{msg},$digits);
		}
	} elsif (-f $deleted) { 
		# somebody else deleted this message while you were on the phone 
		$k = $a->stream_file($was_del,$digits) if $msg->{deleted};
		return $k if $k;
		$deleted =~ s/\.$InTouch::rectype$//;
		if (defined $cb) {
			$cb->[1] = "$deleted|$cb->[1]";
			$k = $a->exec(@$cb);
		} else {
			$k = $a->stream_file($deleted,$digits);
		}
	} else { 
		# should probably have a prompt here - the message is completely gone in this case
		return $k; 
	}
	return $k if $k;
	$k = $a->stream_file($last_msg,$digits) if $msg->{last};
	$k;
}

# say the message envelope information
sub msg_date {
	my ($msg) = @_;
	return unless defined $msg;
	my $digit;
	$digit = $a->stream_file($msg_rec,$digits);
	return $digit if $digit;
	my $msg_epoch = ($msg->{msg}=~m#^.*/.*-(\d+)#)[0];
	$digit = $a->say_date($msg_epoch,$digits);
	return $digit if $digit;
	$a->exec("Wait","1");
	$digit = $a->say_time($msg_epoch,$digits);
	return $digit if $digit;

	return unless $msg->{msg} =~ m#.*/(\d+)-#;
	my $phone = $1;
	if (length($phone) > 0) { 
		$digit = $a->stream_file($msg_from,$digits);
		return $digit if $digit;
		$digit = $a->say_digits($phone,$digits); 
		return $digit if $digit;
	}
}

