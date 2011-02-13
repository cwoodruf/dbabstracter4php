<?php
define('FRAMEDIR','/usr/local/asterisk/html/frame');
set_include_path(get_include_path() . PATH_SEPARATOR . FRAMEDIR);
require_once('lib/init.php');
View::addCSS('global.css');
View::addCSS('menu.css');

list($controller,$actions) = Controller::init();

require_once(Controller::path($controller));
$context = new $controller($actions);
$context->execute();

