<?php
# example schema file used by dbabstracter
# these constants are defined elsewhere - preferably a location invisible to outsiders
$DRDAT = array(
	'host' => DRDAT_DBHOST,
	'login' => DRDAT_DBLOGIN,
	'pw' => DRDAT_DBPW,
	'db' => DRDAT_DB,
);


/**
 * the $tables array describes each table in the db in an abstract way
 * and is used by other objects to allow us to abstract how we work with data
 * the fields other than 'key' are ignored by dbabstracter but can be useful 
 * for automatically checking input or generating forms and are left in 
 * as a sort of serving suggestion
 * 
 * TODO: create tool for generating this file from a database schema
 */

$tables = array();

# example entity:
$tables['participant'] = array(
  'participant_id' => array( 'type' => 'int', 'size' => 11, 'key' => true ),
  'firstname' => array( 'type' => 'varchar', 'size' => 64 ),
  'lastname' => array( 'type' => 'varchar', 'size' => 64 ),
  'phone' => array( 'type' => 'varchar', 'size' => 32 ),
  'email' => array( 'type' => 'varchar', 'size' => 128 ),
  'password' => array( 'type' => 'varchar', 'size' => 64 ),
);

$tables['study'] = array(
  'study_id' => array( 'type' => 'int', size => 11, 'key' => true ),
  'startdate' => array( 'type' => 'date', size => 20 ),
  'enddate' => array( 'type' => 'date', size => 20 ),
}

# example relation
# associates participants to a study
$tables['enrollment'] = array(
  'PRIMARY KEY' => array('participant_id','study_id'),
  'participant_id' => array( 'type' => 'int', 'size' => 11 ),
  'study_id' => array( 'type' => 'int', 'size' => 11 ),
  'enrolled' => array( 'type' => 'datetime', 'size' => 20 ),
);

