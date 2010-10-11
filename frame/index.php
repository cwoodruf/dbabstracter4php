<?php
require_once('lib/init.php');

list($controller,$actions) = Controller::init();

# if we are logging in remember our state
# but go back to the loginform controller
if ($_SESSION['flags']['login']) {

	$_SESSION['request'] = $_REQUEST;
	$controller = LOGINCONTROLLER;
	$context = new $controller();

}

require_once(Controller::path($controller));
$context = new $controller($actions);
$context->execute();

