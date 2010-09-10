<?php
 class Checkins extends Entity {
     function __construct() {
	 global $schema, $db;
	 parent::__construct($db,$schema['checkins'],'checkins');
     }
 }