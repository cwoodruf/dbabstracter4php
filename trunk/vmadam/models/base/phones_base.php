<?php
# automatically generated by makeclasses.php

class PhonesRelation extends Relation {
	function __construct() {
		parent::__construct(
			IntouchDB::$db, 
			# $this->schema: for building forms among other things
			array (
			  'PRIMARY KEY' => 
			  array (
			    'phone' => '',
			    'taken' => '',
			  ),
			  'phone' => 
			  array (
			    'type' => 'varchar',
			    'size' => 32,
			  ),
			  'clientid' => 
			  array (
			    'type' => 'int',
			    'size' => 11,
			  ),
			  'taken' => 
			  array (
			    'type' => 'datetime',
			  ),
			  'returned' => 
			  array (
			    'type' => 'datetime',
			  ),
			),
			'phones'
		);
	}

}