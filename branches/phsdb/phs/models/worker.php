<?php
 class Worker extends Entity {
     function __construct() {
	 global $schema, $db;
	 parent::__construct($db,$schema['worker'],'worker');
     }
 }