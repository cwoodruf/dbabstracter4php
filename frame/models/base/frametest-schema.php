<?php
$schema = array();

$dbhost = 'localhost';
$dbname = 'frametest';

$schema['numbered'] = array(
	'numbered_id' => array( 'type' => 'int', 'size' => 11, 'key' => true, 'auto' => 1, ),
	'notes' => array( 'type' => 'text', ),
	'email' => array( 'type' => 'varchar', 'size' => 128, ),
	'created' => array( 'type' => 'datetime', ),
);

$schema['user'] = array(
	'email' => array( 'type' => 'varchar', 'size' => 128, 'key' => true, ),
	'password' => array( 'type' => 'varchar', 'size' => 64, ),
	'perms' => array( 'type' => 'varchar', 'size' => 64, ),
);

$schema['viewers'] = array(
	'PRIMARY KEY' => array('email' => '', 'numbered_id' => 'numbered', ),
	'email' => array( 'type' => 'varchar', 'size' => 128, ),
	'numbered_id' => array( 'type' => 'int', 'size' => 11, ),
);

