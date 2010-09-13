<?php
class Workers extends Controller {
	public $worker_id;
	public $workers;

	public function __construct() {
		parent::__construct(__CLASS__);
	}

	public function execute($actions) {
		parent::execute($actions);
		$this->table = 'worker';
		if (Check::digits($worker_id = $_REQUEST['worker_id'])) {
			$this->worker_id = $worker_id;
			$this->workers = new Worker;
			$this->input = $this->workers->getone($this->worker_id);
		}

		$step = $_REQUEST['step'] ? $_REQUEST['step'] : $actions[0];
		switch ($step) {
			case 'save': 
				$this->save(); 
			break;
			case 'search':
				$this->search();
			break;
		}

		View::display('workers.tpl');
	}

	public function search() {
		View::assign('terms',htmlentities($_REQUEST['terms']));

		$this->workers = new Worker;
		$results = $this->workers->search($_REQUEST['terms']);

		if (!$this->workers->err()) View::assign('results',$results);
		else View::assign('errors',$this->workers->err());
	}

	public function save() {
		if (!isset($this->workers)) $this->workers = new Worker;

		foreach ($this->workers->schema as $field => $fdata) {
			if ($fdata['key']) {
				$key = $_REQUEST[$field];
			}
			if ($fdata['required'] and !$_REQUEST[$field]) {
				$saveerr .= "Missing $field<br>\n";
			}
			$fields[$field] = trim($_REQUEST[$field]);
		}

		if ($saveerr) {
			View::assign('errors',$saveerr);
			return;
		}

		if (isset($this->worker_id)) {
			$this->workers->upd($key,$fields);
		} else {
			$this->workers->ins($fields);
			if (!$this->workers->err()) 
				$this->worker_id = $this->workers->getid();
		}

		if ($this->workers->err()) {
			View::assign('errors',$this->workers->err());
			return;
		}
		$this->input = $this->workers->getone($this->worker_id);
	}
}

