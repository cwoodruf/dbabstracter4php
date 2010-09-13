<?php
define('SMARTY_DIR',dirname(__FILE__).'/smarty/');
require_once('view.php');
View::init();
View::addCSS('main.css');
View::addJS('jquery.js');

