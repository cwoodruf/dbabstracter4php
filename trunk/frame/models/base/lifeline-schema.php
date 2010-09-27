<?php
$schema = array();

$dbhost = 'localhost';
$dbname = 'lifeline';

$schema['boxes'] = array(
	'box' => array( 'type' => 'varchar', 'size' => 32, 'key' => true, ),
	'name' => array( 'type' => 'varchar', 'size' => 64, ),
	'notes' => array( 'type' => 'varchar', 'size' => 255, ),
	'seccode' => array( 'type' => 'varchar', 'size' => 32, ),
	'email' => array( 'type' => 'varchar', 'size' => 64, ),
	'paidto' => array( 'type' => 'date', ),
	'inuse' => array( 'type' => 'int', 'size' => 11, ),
	'new_msgs' => array( 'type' => 'int', 'size' => 11, ),
	'reminder' => array( 'type' => 'int', 'size' => 11, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'login' => array( 'type' => 'varchar', 'size' => 64, ),
	'created' => array( 'type' => 'datetime', ),
	'trans' => array( 'type' => 'varchar', 'size' => 32, ),
	'llphone' => array( 'type' => 'varchar', 'size' => 32, ),
	'announcement' => array( 'type' => 'int', 'size' => 11, ),
	'canremove' => array( 'type' => 'int', 'size' => 11, ),
	'modified' => array( 'type' => 'timestamp', ),
);

$schema['calls'] = array(
	'PRIMARY KEY' => array('box' => '', 'action' => '', 'status' => '', 'message' => '', ),
	'box' => array( 'type' => 'varchar', 'size' => 32, ),
	'call_time' => array( 'type' => 'datetime', 'size' => 20, ),
	'action' => array( 'type' => 'varchar', 'size' => 32, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'message' => array( 'type' => 'text', ),
	'callerid' => array( 'type' => 'varchar', 'size' => 64, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'host' => array( 'type' => 'varchar', 'size' => 64, ),
	'callstart' => array( 'type' => 'double', ),
);

$schema['calls20100907'] = array(
	'PRIMARY KEY' => array('box' => '', 'action' => '', 'status' => '', 'message' => '', ),
	'box' => array( 'type' => 'varchar', 'size' => 32, ),
	'call_time' => array( 'type' => 'datetime', 'size' => 20, ),
	'action' => array( 'type' => 'varchar', 'size' => 32, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'message' => array( 'type' => 'text', ),
	'callerid' => array( 'type' => 'varchar', 'size' => 64, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'host' => array( 'type' => 'varchar', 'size' => 64, ),
	'callstart' => array( 'type' => 'double', ),
);

$schema['emailsignup'] = array(
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'email' => array( 'type' => 'varchar', 'size' => 128, 'key' => true, ),
	'perms' => array( 'type' => 'varchar', 'size' => 64, ),
	'id' => array( 'type' => 'varchar', 'size' => 32, ),
);

$schema['invoices'] = array(
	'invoice' => array( 'type' => 'int', 'size' => 11, 'key' => true, ),
	'created' => array( 'type' => 'datetime', ),
	'paidon' => array( 'type' => 'datetime', ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'gst' => array( 'type' => 'float', ),
	'pst' => array( 'type' => 'float', ),
	'total' => array( 'type' => 'float', ),
	'notes' => array( 'type' => 'mediumtext', ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'login' => array( 'type' => 'varchar', 'size' => 32, ),
	'modified' => array( 'type' => 'datetime', ),
	'trans' => array( 'type' => 'varchar', 'size' => 32, ),
);

$schema['loginlog'] = array(
	'login' => array( 'type' => 'varchar', 'size' => 64, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'attempted' => array( 'type' => 'datetime', ),
	'ip' => array( 'type' => 'varchar', 'size' => 32, ),
);

$schema['mailboxes'] = array(
	'transdate' => array( 'type' => 'datetime', 'size' => 20, ),
	'transaction' => array( 'type' => 'double', ),
	'vendor' => array( 'type' => 'varchar', 'size' => 64, ),
	'user' => array( 'type' => 'varchar', 'size' => 32, ),
	'amount' => array( 'type' => 'float', ),
	'notes' => array( 'type' => 'varchar', 'size' => 255, ),
	'name' => array( 'type' => 'varchar', 'size' => 64, ),
	'box' => array( 'type' => 'int', 'size' => 11, ),
);

$schema['messages'] = array(
	'message' => array( 'type' => 'varchar', 'size' => 255, 'key' => true, ),
	'box' => array( 'type' => 'varchar', 'size' => 32, ),
	'callerid' => array( 'type' => 'varchar', 'size' => 64, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'recorded' => array( 'type' => 'datetime', ),
);

$schema['monthstransfer'] = array(
	'transferred' => array( 'type' => 'datetime', ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'fromvid' => array( 'type' => 'int', 'size' => 11, ),
	'tovid' => array( 'type' => 'int', 'size' => 11, ),
	'login' => array( 'type' => 'varchar', 'size' => 64, ),
);

$schema['numrange'] = array(
	'i' => array( 'type' => 'int', 'size' => 11, ),
);

$schema['paycode'] = array(
	'code' => array( 'type' => 'varchar', 'size' => 32, 'key' => true, ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'created' => array( 'type' => 'datetime', ),
	'used' => array( 'type' => 'datetime', ),
	'box' => array( 'type' => 'varchar', 'size' => 16, ),
);

$schema['payments'] = array(
	'PRIMARY KEY' => array('box' => '', 'vid' => '', 'paidon' => '', 'login' => '', ),
	'box' => array( 'type' => 'varchar', 'size' => 32, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'paidon' => array( 'type' => 'datetime', ),
	'amount' => array( 'type' => 'float', ),
	'hst' => array( 'type' => 'float', ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'login' => array( 'type' => 'varchar', 'size' => 64, ),
	'notes' => array( 'type' => 'text', ),
	'ip' => array( 'type' => 'varchar', 'size' => 32, ),
);

$schema['payphones'] = array(
	'number' => array( 'type' => 'varchar', 'size' => 16, 'key' => true, ),
	'wherefrom' => array( 'type' => 'text', ),
	'notes' => array( 'type' => 'text', ),
);

$schema['sync_calls'] = array(
	'synctime' => array( 'type' => 'datetime', 'size' => 20, ),
);

$schema['transactions'] = array(
	'trans' => array( 'type' => 'varchar', 'size' => 128, 'key' => true, ),
	'time' => array( 'type' => 'timestamp', 'size' => 20, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'table_name' => array( 'type' => 'varchar', 'size' => 32, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'box' => array( 'type' => 'varchar', 'size' => 32, ),
);

$schema['updates'] = array(
	'box' => array( 'type' => 'varchar', 'size' => 32, ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'oldpaidto' => array( 'type' => 'date', ),
	'newpaidto' => array( 'type' => 'date', ),
	'paycode' => array( 'type' => 'varchar', 'size' => 32, ),
	'updated' => array( 'type' => 'timestamp', 'size' => 20, ),
	'login' => array( 'type' => 'varchar', 'size' => 32, ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'action' => array( 'type' => 'varchar', 'size' => 128, ),
	'app' => array( 'type' => 'varchar', 'size' => 128, ),
);

$schema['users'] = array(
	'login' => array( 'type' => 'varchar', 'size' => 64, 'key' => true, ),
	'password' => array( 'type' => 'varchar', 'size' => 64, ),
	'created' => array( 'type' => 'timestamp', ),
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'perms' => array( 'type' => 'varchar', 'size' => 128, ),
	'notes' => array( 'type' => 'varchar', 'size' => 255, ),
);

$schema['vendors'] = array(
	'vid' => array( 'type' => 'int', 'size' => 11, 'key' => true, ),
	'vendor' => array( 'type' => 'varchar', 'size' => 128, ),
	'created' => array( 'type' => 'timestamp', ),
	'parent' => array( 'type' => 'text', ),
	'address' => array( 'type' => 'varchar', 'size' => 128, ),
	'phone' => array( 'type' => 'varchar', 'size' => 128, ),
	'contact' => array( 'type' => 'varchar', 'size' => 128, ),
	'email' => array( 'type' => 'varchar', 'size' => 128, ),
	'fax' => array( 'type' => 'varchar', 'size' => 128, ),
	'gstexempt' => array( 'type' => 'int', 'size' => 11, ),
	'rate' => array( 'type' => 'float', ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'actual_months' => array( 'type' => 'int', 'size' => 11, ),
	'all_months' => array( 'type' => 'int', 'size' => 11, ),
	'pst_number' => array( 'type' => 'varchar', 'size' => 128, ),
	'gst_number' => array( 'type' => 'varchar', 'size' => 128, ),
	'credit_limit' => array( 'type' => 'int', 'size' => 11, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'notes' => array( 'type' => 'text', ),
	'llphone' => array( 'type' => 'varchar', 'size' => 32, ),
	'acctype' => array( 'type' => 'enum', ),
	'retail_prices' => array( 'type' => 'text', ),
);

$schema['vendors_20100615'] = array(
	'vid' => array( 'type' => 'int', 'size' => 11, ),
	'vendor' => array( 'type' => 'varchar', 'size' => 128, ),
	'created' => array( 'type' => 'timestamp', ),
	'parent' => array( 'type' => 'int', 'size' => 11, ),
	'address' => array( 'type' => 'varchar', 'size' => 128, ),
	'phone' => array( 'type' => 'varchar', 'size' => 128, ),
	'contact' => array( 'type' => 'varchar', 'size' => 128, ),
	'email' => array( 'type' => 'varchar', 'size' => 128, ),
	'fax' => array( 'type' => 'varchar', 'size' => 128, ),
	'gstexempt' => array( 'type' => 'int', 'size' => 11, ),
	'rate' => array( 'type' => 'float', ),
	'months' => array( 'type' => 'int', 'size' => 11, ),
	'all_months' => array( 'type' => 'int', 'size' => 11, ),
	'pst_number' => array( 'type' => 'varchar', 'size' => 128, ),
	'gst_number' => array( 'type' => 'varchar', 'size' => 128, ),
	'credit_limit' => array( 'type' => 'float', ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'notes' => array( 'type' => 'text', ),
);

$schema['voicemeupcalls'] = array(
	'unique_id' => array( 'type' => 'varchar', 'size' => 32, 'key' => true, ),
	'date' => array( 'type' => 'date', 'size' => 20, ),
	'time' => array( 'type' => 'time', 'size' => 20, ),
	'direction' => array( 'type' => 'varchar', 'size' => 32, ),
	'source' => array( 'type' => 'varchar', 'size' => 32, ),
	'destination' => array( 'type' => 'varchar', 'size' => 32, ),
	'client_peer_id' => array( 'type' => 'varchar', 'size' => 32, ),
	'country_id' => array( 'type' => 'varchar', 'size' => 32, ),
	'country' => array( 'type' => 'varchar', 'size' => 32, ),
	'state_id' => array( 'type' => 'varchar', 'size' => 32, ),
	'state' => array( 'type' => 'varchar', 'size' => 32, ),
	'district' => array( 'type' => 'varchar', 'size' => 32, ),
	'duration' => array( 'type' => 'varchar', 'size' => 32, ),
	'callerid_name' => array( 'type' => 'varchar', 'size' => 32, ),
	'callerid_number' => array( 'type' => 'varchar', 'size' => 32, ),
	'bindings' => array( 'type' => 'varchar', 'size' => 32, ),
	'status' => array( 'type' => 'varchar', 'size' => 32, ),
	'normalized' => array( 'type' => 'varchar', 'size' => 32, ),
	'billed_amount' => array( 'type' => 'varchar', 'size' => 32, ),
	'current_rate' => array( 'type' => 'varchar', 'size' => 32, ),
	'monthly_usage' => array( 'type' => 'varchar', 'size' => 32, ),
	'region' => array( 'type' => 'varchar', 'size' => 32, ),
	'billed_duration' => array( 'type' => 'int', 'size' => 11, ),
	'call_hash' => array( 'type' => 'varchar', 'size' => 32, ),
	'failure_code' => array( 'type' => 'int', 'size' => 11, ),
	'call_time' => array( 'type' => 'datetime', 'size' => 20, ),
);

