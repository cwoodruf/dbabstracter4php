<?php
class Workers extends Controller {
	public function __construct() {
		parent::__construct(__CLASS__);
	}

	public function execute($actions) {
		parent::execute($actions);
		$this->table = 'worker';
		if (Check::digits($worker_id = $_REQUEST['worker_id'])) {
			$workers = new Worker;
			$this->input = $workers->getone($worker_id);
		}
		View::display('workers.tpl');
	}
}

