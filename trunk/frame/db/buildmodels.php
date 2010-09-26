#!/usr/local/bin/php
<?php
print "run both mysql2schema.pl and makeclasses.php to build out classes for a database\n";

$modeldir = $argv[1];
if (empty($modeldir)) die("need a model directory!\n");

$db = $argv[2];
if (empty($db)) die("need name of datbase!\n");

$thistable = $arg[3];
# this arg can be empty

if (!file_exists($modeldir)) mkdir($modeldir,0777,true);
$schemafile = "$modeldir/$db-schema.php";

print "mysql user: ";
if (($stdin = fopen('php://stdin','r')) !== false) {
	$myuser = fgets($stdin,255);
	$myuser = preg_replace('#[\n\r]#','',trim($myuser));
	print "mysql login ";
	shell_exec("mysqldump -u$myuser -p --opt --no-data $db | perl db/mysql2schema.pl > $schemafile");
	print "wrote table info to $schemafile\n";
	# by default makeclasses.php won't overwrite an existing directory
	$force = true;
	require("db/makeclasses.php");
} else {
	die("can't get standard input");
}

