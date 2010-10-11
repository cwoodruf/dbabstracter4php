<?php
define('DBLOGIN','cal');
define('DBPW','d834hWRY');

require_once('db/abstract-mysql.php');
require_once('db/abstract-common.php');

function __autoload($class) {
	if (preg_match('#(.*)(?:Relation|Entity)$#',$class,$m)) {
		$path = "models/".strtolower($m[1]).'_base.php';
		require_once($path);
		return;
	} else if (preg_match('#(.*)DB$#',$class,$m)) {
		$path = "models/".strtolower($m[1]).'_db.php';
		require_once($path);
		return;
	} 

	foreach (array('models','controllers') as $dir) {
		$path = "$dir/".strtolower($class).'.php';
		@include_once($path);
	}
}
