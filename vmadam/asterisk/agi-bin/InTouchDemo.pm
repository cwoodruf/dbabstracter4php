package InTouch;
# purpose of this package is to define some common elements for 
# lifeline agi applications see /etc/asterisk/lifeline.conf
# this is a grossly oversimplified demo for the PHS intouch program
# it is meant to work in conjunction with it-listen.pl and etc/asterisk/intouchdemo.conf
use Data::Dumper;
use DBI;
use Asterisk::AGI;
use Fcntl qw/LOCK_EX/;
use File::Copy;
use Time::Local qw/timelocal_nocheck/;
use strict;

# auto flush
$| = 1;

our $min_msg_size = 6000; # for gsm and a 2 second timeout 
our $MINDURATION = 2; # seconds

our $apache_user = 'asterisk';
our ($basedir,$logdir,$log,$error_log);

# prompt files for play_msg_count
our $no_msgs = 'll-en-nomsgs';
our $you_have = 'vm-youhave';
our $messages = 'vm-messages';
our $message = 'vm-message';
our $digits = '1234567890*#';

our $agi;
our $in;
if ($0 =~ m{agi(?:-bin)/it-\w+\.pl$}) {
	$agi = Asterisk::AGI->new;
	%{$in} = $agi->ReadParse;
} else {
	$agi = InTouch::FakeAGI->new;
}
our $basedir = $agi->get_variable('msgdir') || '/usr/local/asterisk/intouch-msgs';
our $dir = $basedir;
our $rectype = "gsm";
our $msgdir = $basedir;
our $msgs;
our $UNKNOWN = 0;

# defined in etc/asterisk/extensions.conf
our $dbhost = $agi->get_variable('dbhost');
our $dbport = $agi->get_variable('dbport');
our $dbuser = $agi->get_variable('dbuser');
our $dbpass = $agi->get_variable('dbpass');
do "InTouchDB.pl"
our $db = DBI->connect("DBI:mysql:database=intouch;host=$dbhost;port=$dbport",$dbuser,$dbpass);

# this will only really work if its done right when the message is made
# as it just looks for the last person who had this phone
# otherwise you'll want to look at who had what phone when first 
# before associating the clientid with the callerid
sub db_save_msg_owner {
	my ($callerid,$msg,$callback) = @_;

	warn "invalid callerid $callerid in db_save_msg_owner!" and return if $callerid !~ /^\d+$/;
	return if $msg =~ /^\.\w+$/;
	warn "non-existent message $msg!" and return unless -f $msg;

	my $st = $db->prepare(
		"select clientid,callbackwait ".
		"from phones join clients on (phones.clientid=clients.id) ".
		"where phone=? order by taken desc limit 1"
	);
	$st->execute($callerid) or warn $st->errstr and return;
	my ($clientid,$callbackwait);
	if ($st->rows) {
		my $row = $st->fetch;
		($clientid, $callbackwait) = @$row;
		$st->finish;
	}

	$clientid = $UNKNOWN unless defined $clientid;

	my ($callbackts, $iscallback);
	if ($callback == 1) {
		$iscallback = 1;
	} else {
		$iscallback = 0;
		if ($callbackwait > 0) {
			$callbackts = time + $callbackwait * 60;
		}
	}
	
	my $ins = $db->prepare(
		"insert into files (filename,callerid,clientid,created,callbackts,iscallback) ".
		"values (?,?,?,now(),?,?)"
	);
	$ins->execute($msg,$callerid,$clientid,$callbackts,$iscallback) or warn $ins->errstr;
}

# when we delete a message we only change the file name
# so we need to update the file names referred to in the files table
sub db_rename_msg {
	my ($msg,$newname) = @_;
	if (-f $newname) {
		$db->do("update files set filename='$newname' where filename='$msg'");
	} else {
		warn "could not find file $newname, aborting rename!";
	}
}

sub dialplan_export {
	$agi->set_variable('mydir',$dir);
	$agi->set_variable('mymsgdir',$msgdir); 
	$agi->set_variable('rectype',$rectype);
}

# routines for finding messages to play
sub load_msgs {
	$msgs->{list} = ();
	my $count = 0;
	# using glob because readdir wasn't returning an ordered list
	# using reverse to get newest messages first
	my $globpat = "$msgdir/*/[0-9]*-*[0-9].$rectype";
	foreach (reverse glob($globpat)) {
		s/\.$rectype$//;
		$msgs->{list}->[$count]->{msg} = $_;
		$msgs->{list}->[$count]->{deleted} = 0;
		$msgs->{list}->[$count]->{last} = 0;
		$count++;
	}
	$msgs->{last} = $count - 1;
	$msgs->{list}->[$count-1]->{last} = 1 if $count;
}

sub inc_msg {
	if (defined $msgs->{list}) { 
		if ($msgs->{curr} < $msgs->{last}) {
			$msgs->{curr}++;
		} else {
			$msgs->{curr} = 0;
		}
	} else {
		load_msgs;
		$msgs->{curr} = 0;
	}
}

sub dec_msg {
	if (defined $msgs->{list}) { 
		if ($msgs->{curr} > 0) {
			$msgs->{curr}--;
		} elsif (scalar @{$msgs->{list}}) {
			$msgs->{curr} = $msgs->{last};
		} else {
			$msgs->{curr} = 0;
		}
	} else {
		load_msgs;
		$msgs->{curr} = 0;
	}
}

sub first_msg {
	load_msgs unless defined $msgs->{list};
	$msgs->{curr} = 0;
}

sub last_msg {
	load_msgs unless defined $msgs->{list};
	my $count = scalar @{$msgs->{list}};
	$msgs->{curr} = $count ? $count-1 : 0;
}

sub curr_msg {
	load_msgs and $msgs->{curr} = 0 unless defined $msgs->{list};
	$msgs->{curr} = 0 unless defined $msgs->{curr};
	if (scalar @{$msgs->{list}}) {
		return $msgs->{list}->[$msgs->{curr}];
	}
	return;
}

sub del_msg {
	curr_msg->{deleted} = curr_msg->{deleted} ? 0 : 1;
}

# when deleting/restoring all use a reference value as a starting point
# you don't want to end up in a situation where half the messages are deleted
# or restored as a result of this operation
sub del_all {
	my $ref_val = shift;
	if (defined $ref_val) {
		if ($ref_val) {
			foreach (@{$msgs->{list}}) { $_->{deleted} = 0; }
		} else {
			foreach (@{$msgs->{list}}) { $_->{deleted} = 1; }
		}
	}
}

sub clean_up_msgs {
	foreach (@{$msgs->{list}}) {
		if ($_->{deleted} and $_->{msg} ne '') {
			my $mname = $_->{msg}.".".$rectype;
			my $dname = $_->{msg}.".deleted.".$rectype;
			unlink $dname if -f $dname;
			if (-f $mname) {
				move $mname, $dname or print STDERR "$mname -> $dname: $!" and next;
				db_rename_msg($mname,$dname);
			}
		}
	}
}

sub play_msg_count {
	# only tell caller when they have no messages
	my $quiet = shift;
	load_msgs() unless defined $msgs->{list};
	my $a = $agi;
	my $count = scalar @{$msgs->{list}} if defined $msgs->{list};
	unless ($count) {
		$a->stream_file($no_msgs);
	} else {
		unless ($quiet) {
			$a->stream_file($you_have);
			$a->say_number($count);
			my $m = $count != 1 ? $messages : $message;
			$a->stream_file($m);
		}
	}
	$count;
}

package InTouch::FakeAGI;

sub new {
	my $class = shift;
	my $me = {@_};
	bless ($me, $class);
}

sub set_variable {
}

sub get_variable {
}

1;

