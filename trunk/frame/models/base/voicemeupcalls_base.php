<?php
# automatically generated by makeclasses.php

class VoicemeupcallsEntity extends Entity {
	function __construct() {
		parent::__construct(
			LifelineDB::$db, 
			# $this->schema: for building forms among other things
			array ( 
				'unique_id' => array ( 'type' => 'varchar', 'size' => 32, 'key' => true, ), 
				'date' => array ( 'type' => 'date', 'size' => 20, ), 
				'time' => array ( 'type' => 'time', 'size' => 20, ), 
				'direction' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'source' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'destination' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'client_peer_id' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'country_id' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'country' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'state_id' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'state' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'district' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'duration' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'callerid_name' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'callerid_number' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'bindings' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'status' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'normalized' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'billed_amount' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'current_rate' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'monthly_usage' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'region' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'billed_duration' => array ( 'type' => 'int', 'size' => 11, ), 
				'call_hash' => array ( 'type' => 'varchar', 'size' => 32, ), 
				'failure_code' => array ( 'type' => 'int', 'size' => 11, ), 
				'call_time' => array ( 'type' => 'datetime', 'size' => 20, ), 
			),
			'voicemeupcalls'
		);
	}

}