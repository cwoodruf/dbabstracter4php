<?php
 class Files extends Entity {
     function __construct() {
	 global $schema, $db;
	 parent::__construct($db,$schema['files'],'files');
     }
 }