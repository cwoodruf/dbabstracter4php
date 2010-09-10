<?php
require_once('view/init.php');
require_once('phs/init.php');
require_once('pw/auth.php');
require_once('db/check.php');
require_once('controller.php');

$actions = explode("/", $_REQUEST['action']);
$action = array_shift($actions);

if ($action == 'logout') delete_login();
$ldata = login_response('redirect.php',$_SERVER['PHP_SELF'],'admin_login');

if (!preg_match('#^\w+$#',$action)) $controller = 'home';
else $controller = $action;

require_once("controllers/$controller.php");

# change typeable file names to camel case class names
$class = preg_replace('#(?:^|_)(.)#e',"strtoupper($1)",$controller);
eval("\$context = new $class;");

$context->action = htmlentities($_REQUEST['action']);
$context->execute($actions);

