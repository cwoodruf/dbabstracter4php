<?php
# base controller class
class Controller {
	public $name;
	public $actions; # array with first action removed
	public $action; # string 
	public $input;

	public function __construct($name=__CLASS__) {
		View::assign('this',$this);
		$this->name = $name;
	}

	public function execute($actions) {
		if (empty($actions[0])) $actions[0] = 'default';
		$this->actions = $actions;
	}
	
	public function input($field=null) {
		if (!is_array($this->input)) return;
		if (isset($this->input[$field])) return $this->input[$field];
		return $this->input;
	}

	public function css() {
		return View::$css;
	}

	public function js() {
		return View::$js;
	}
	
	public function title($title=null) {
		if (!empty($title)) $this->title = $title;
		if (!isset($this->title)) return $this->name;
		return $this->title;
	}
}

