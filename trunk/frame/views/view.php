<?php
require_once('views/smarty/Smarty.class.php');

# base view class
class View {
	const DEFROWS = 5;
	const DEFCOLS = 60;
	const DEFSIZE = 50;
	const MAXSIZE = 60;
	public static $smarty;
	public static $css;
	public static $js;
	public static $tplext;

	public static function init($ext='tpl') {
		$smarty = new Smarty();
		$smarty->template_dir = 'views/templates';
		$smarty->compile_dir = 'views/templates_c';
		$smarty->cache_dir = 'views/cache';
		$smarty->plugins_dir[] = 'views/plugins';
		self::$smarty = $smarty;
		self::$tplext = $ext;
	}
	
	public static function assign($name,$value) {
		return self::$smarty->assign($name,$value);
	}

	public static function display($tpl) {
		self::fixname($tpl);
		return self::$smarty->display($tpl);
	}
	
	public static function fetch($tpl) {
		self::fixname($tpl);
		return self::$smarty->fetch($tpl);
	}

	public static function fixname(&$tpl) {
		if (preg_match("#\.$tplext#",$tpl)) return;
		$tpl .= ".".self::$tplext;
	}

	public static function addCSS($css) {
		if (!@filetype($css)) $css = "views/css/$css";
		if (!@filetype($css)) return;
		self::$css .= "<link rel=stylesheet type=text/css href=\"$css\">\n";
	}

	public static function addJS($js) {
		if (!@filetype($js)) $js = "views/js/$js";
		if (!@filetype($js)) return;
		self::$js .= "<script type=text/javascript src=\"$js\" ></script>\n";
	}
}

