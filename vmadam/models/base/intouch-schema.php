<?php
$schema = array();

$dbhost = 'localhost';
$dbname = 'intouch';

$schema['clients'] = array(
	'id' => array( 'type' => 'int', 'size' => 11, 'key' => true, 'auto' => 1, ),
	'status' => array( 'type' => 'enum', 'opts' => array('active','inactive','deleted'), ),
	'name' => array( 'type' => 'varchar', 'size' => 64, ),
	'email' => array( 'type' => 'varchar', 'size' => 64, ),
	'notes' => array( 'type' => 'text', ),
	'created' => array( 'type' => 'datetime', ),
	'modified' => array( 'type' => 'timestamp', ),
	'callbackwait' => array( 'type' => 'int', 'size' => 11, ),
);

$schema['files'] = array(
	'clientid' => array( 'type' => 'int', 'size' => 11, ),
	'callerid' => array( 'type' => 'varchar', 'size' => 32, ),
	'filename' => array( 'type' => 'text', 'key' => true, ),
	'created' => array( 'type' => 'datetime', ),
	'modified' => array( 'type' => 'timestamp', ),
	'callbackts' => array( 'type' => 'double', ),
	'iscallback' => array( 'type' => 'int', 'size' => 11, ),
);

$schema['phones'] = array(
	'PRIMARY KEY' => array('phone' => '', 'taken' => '', ),
	'phone' => array( 'type' => 'varchar', 'size' => 32, ),
	'clientid' => array( 'type' => 'int', 'size' => 11, ),
	'taken' => array( 'type' => 'datetime', ),
	'returned' => array( 'type' => 'datetime', ),
);

