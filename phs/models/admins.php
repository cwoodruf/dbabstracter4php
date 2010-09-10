<?php
 class Admins extends Entity {
     function __construct() {
	 global $schema, $db;
	 parent::__construct($db,$schema['admins'],'admins');
     }
 }

function admin_login($login) {
	$a = new Admins;
	return $a->getone($login);
}

