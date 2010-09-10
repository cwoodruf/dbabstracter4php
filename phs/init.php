<?php
require_once('phs/phsdb.php');
require_once('phs/phsdb-schema.php');
require_once('db/abstract-mysql.php');
require_once('db/abstract-common.php');
foreach ($schema as $table => $fields) {
	require_once("phs/models/$table.php");
}

