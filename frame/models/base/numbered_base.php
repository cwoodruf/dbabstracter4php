<?php
# automatically generated by makeclasses.php

class NumberedEntity extends Entity {
	function __construct() {
		parent::__construct(
			FrametestDB::$db, 
			# $this->schema: for building forms among other things
			array ( 
				'numbered_id' => array ( 'type' => 'int', 'size' => 11, 'key' => true, 'auto' => 1, ), 
				'notes' => array ( 'type' => 'text', ), 
				'email' => array ( 'type' => 'varchar', 'size' => 128, ), 
				'created' => array ( 'type' => 'datetime', ), 
			),
			'numbered'
		);
	}

}
