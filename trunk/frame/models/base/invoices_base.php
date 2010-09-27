<?php
# automatically generated by makeclasses.php

class InvoicesEntity extends Entity {
	function __construct() {
		parent::__construct(
			LifelineDB::$db, 
			# $this->schema: for building forms among other things
			array ( 
				'invoice' => array ( 'type' => 'int', 'size' => 11, 'key' => true, ), 
				'created' => array ( 'type' => 'datetime', ), 
				'paidon' => array ( 'type' => 'datetime', ), 
				'months' => array ( 'type' => 'int', 'size' => 11, ), 
				'gst' => array ( 'type' => 'float', ), 
				'pst' => array ( 'type' => 'float', ), 
				'total' => array ( 'type' => 'float', ), 
				'notes' => array ( 'type' => 'mediumtext', ), 
				'vid' => array ( 'type' => 'int', 'size' => 11, ), 
				'login' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'modified' => array ( 'type' => 'datetime', ), 
				'trans' => array ( 'type' => 'varchar', 'size' => 32, ), 
			),
			'invoices'
		);
	}

}
