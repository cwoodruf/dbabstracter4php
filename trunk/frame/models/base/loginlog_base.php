<?php
# automatically generated by makeclasses.php

class LoginlogEntity extends Entity {
	function __construct() {
		parent::__construct(
			LifelineDB::$db, 
			# $this->schema: for building forms among other things
			array ( 
				'login' => array ( 'type' => 'varchar', 'size' => 64, ), 
				'status' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'attempted' => array ( 'type' => 'datetime', ), 
				'ip' => array ( 'type' => 'varchar', 'size' => 32, ), 
			),
			'loginlog'
		);
	}

}