#!/usr/bin/perl
# purpose of this script is to comb messages looking for ones that haven't been associated 
# with a client
# if a message has not been associated with a client then save it with the unknown client
use File::Find;
use InTouchDemo;
use strict;

# get all the files we know about
my $get = $InTouch::db->prepare(
	"select * from files where filename like '%.gsm'"
);
$get->execute or die $get->errstr;
my %files;
while (my $row = $get->fetchrow_hashref) {
	$files{$row->{filename}} = {%$row};
}
$get->finish;

# now do our search
finddepth(\&wanted, $InTouch::basedir);

# analyze search results
sub wanted {
	return if defined $files{$File::Find::name};
	return unless m#(\d+|unknown)-(\d+)#;
	my ($callerid,$time) = ($1,$2);
	my ($clientid, $taken, $returned);
	if ($callerid eq 'unknown') {
		$clientid = $InTouch::UNKNOWN;;
	} else {
		my $clients = $InTouch::db->selectrow_arrayref(
			"select clientid,taken,returned ".
			"from phones where phone = '$callerid' ".
			"and unix_timestamp(taken) <= $time ".
			"and (returned is null or unix_timestamp(returned) >= $time) ".
			"order by taken desc limit 1"
		);
		if (ref $clients eq 'ARRAY') {
			($clientid, $taken, $returned) = @$clients;
		}
		$clientid = $InTouch::UNKNOWN unless defined $clientid;
		my $ins = $InTouch::db->prepare(
			"insert into files (clientid,callerid,filename,created) values (?,?,?,?) "
		);
		my @date = localtime($time);
		my $created = sprintf(
			"%04d-%02d-%02d %02d:%02d:%02d", 
			$date[5] + 1900,
			$date[4] + 1,
			@date[3,2,1,0]
		);
		print "saving $File::Find::name with $clientid date $created\n";
		$ins->execute($clientid,$callerid,$File::Find::name,$created) or warn $ins->errstr;
	}	
}

