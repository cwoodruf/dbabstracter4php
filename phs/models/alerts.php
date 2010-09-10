<?php
 class Alerts extends Entity {
     function __construct() {
	 global $schema, $db;
	 parent::__construct($db,$schema['alerts'],'alerts');
     }
 }