<?php
require_once('.settings.php');

# change these in .settings.php if you want another page to be home

# debug output
if (!defined('QUIET')) {
	if (file_exists('DEBUG')) define('QUIET',false);
}

# default page to show if we don't know what visitor wants to do
if (!defined('DEFCONTROLLER')) define('DEFCONTROLLER','home');
# object that manages password retrieval
if (!defined('LOGINMODEL')) define('LOGINMODEL','LoginsBase');
# object that manages login forms
if (!defined('LOGINCONTROLLER')) define('LOGINCONTROLLER','Loginform');

require_once('db/abstract-mysql.php');
require_once('db/abstract-common.php');
require_once('db/check.php');
require_once('views/init.php');
require_once('lib/controller.php');
require_once('lib/pw.php');
require_once('lib/login.php');

function __autoload($class) {
	# changes typeable file names to camel case class names
	$class = preg_replace('#(?:^|_)(.)#e',"strtoupper($1)",$class);

	if (preg_match('#(.*)(?:Relation|Entity)$#',$class,$m)) {
		$path = "models/base/".strtolower($m[1]).'_base.php';
		require_once($path);
		return;

	} else if (preg_match('#(.*)DB$#',$class,$m)) {
		$path = "models/base/".strtolower($m[1]).'_db.php';
		require_once($path);
		return;
	} 

	foreach (array('models','controllers') as $dir) {
		$path = "$dir/".strtolower($class).'.php';
		@include_once($path);
	}
}
