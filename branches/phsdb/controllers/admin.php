<?php
class Admin extends Controller {
	public function __construct() {
		parent::__construct(__CLASS__);
	}
	public function execute($actions) {
		parent::execute($actions);
		View::display('admin');
	}
}

