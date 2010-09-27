<?php
require_once('lib/init.php');

$actions = explode("/", $_REQUEST['action']);
$controller = $actions[0];
if (!Check::isvar($controller,false)) $controller = DEFCONTROLLER;

# avoid situations where we repeatedly go back to log in form when we are already logged in
if ($_SESSION['login'] and !strcasecmp($controller,LOGINCONTROLLER)) {
	$controller = DEFCONTROLLER;
}

require_once("controllers/$controller.php");
$context = new $controller($actions);

# if we are logging in remember our controller
# but go back to the loginform controller
if ($context->flag('login')) {

	$context->flag('controller',$controller);
	$controller = LOGINCONTROLLER;
	$context = new $controller($context->actions);

}

$context->execute();

